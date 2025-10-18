<?php

namespace App\Libraries;

use Exception;

class FirebaseNotificationService
{
    private $projectId;
    private $serviceAccountPath;
    private $accessToken;
    private $tokenExpiry;

    public function __construct()
    {
        $this->projectId = 'islanders-app---finolhu';
        $this->serviceAccountPath = APPPATH . 'Config/firebase_service_account.json';
        
        if (!file_exists($this->serviceAccountPath)) {
            throw new Exception('Firebase service account file not found');
        }
    }

    /**
     * Get OAuth2 access token for Firebase Cloud Messaging
     * 
     * @return string
     */
    private function getAccessToken()
    {
        // Check if token is still valid
        if ($this->accessToken && $this->tokenExpiry && time() < $this->tokenExpiry) {
            return $this->accessToken;
        }

        $serviceAccount = json_decode(file_get_contents($this->serviceAccountPath), true);
        
        // Create JWT
        $now = time();
        $payload = [
            'iss' => $serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600
        ];

        // Encode header
        $header = json_encode(['alg' => 'RS256', 'typ' => 'JWT']);
        $base64UrlHeader = $this->base64UrlEncode($header);

        // Encode payload
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));

        // Create signature
        $signature = '';
        openssl_sign(
            $base64UrlHeader . '.' . $base64UrlPayload,
            $signature,
            $serviceAccount['private_key'],
            OPENSSL_ALGO_SHA256
        );
        $base64UrlSignature = $this->base64UrlEncode($signature);

        // Create JWT
        $jwt = $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;

        // Exchange JWT for access token
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ]));

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        
        if (isset($data['access_token'])) {
            $this->accessToken = $data['access_token'];
            $this->tokenExpiry = time() + ($data['expires_in'] ?? 3600) - 300; // 5 min buffer
            return $this->accessToken;
        }

        throw new Exception('Failed to get access token: ' . ($data['error'] ?? 'Unknown error'));
    }

    /**
     * Base64 URL encode
     * 
     * @param string $data
     * @return string
     */
    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Send push notification to a single device
     * 
     * @param string $deviceToken
     * @param string $title
     * @param string $body
     * @param array $data Additional data payload
     * @return bool|array
     */
    public function sendToDevice($deviceToken, $title, $body, $data = [])
    {
        try {
            $accessToken = $this->getAccessToken();
            
            $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";
            
            $notification = [
                'message' => [
                    'token' => $deviceToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body
                    ],
                    'android' => [
                        'priority' => 'high',
                        'notification' => [
                            'sound' => 'default',
                            'channel_id' => 'default'
                        ]
                    ],
                    'apns' => [
                        'payload' => [
                            'aps' => [
                                'sound' => 'default',
                                'badge' => 1
                            ]
                        ]
                    ]
                ]
            ];

            // Add data payload if provided
            if (!empty($data)) {
                $notification['message']['data'] = $data;
            }

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notification));

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);

            if ($httpCode === 200) {
                log_message('info', 'Push notification sent successfully to device: ' . substr($deviceToken, 0, 20) . '...');
                return [
                    'success' => true,
                    'message_id' => $result['name'] ?? null
                ];
            } else {
                log_message('error', 'Failed to send push notification: ' . $response);
                return [
                    'success' => false,
                    'error' => $result['error']['message'] ?? 'Unknown error'
                ];
            }

        } catch (Exception $e) {
            log_message('error', 'Push notification error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send push notification to multiple devices
     * 
     * @param array $deviceTokens
     * @param string $title
     * @param string $body
     * @param array $data Additional data payload
     * @return array
     */
    public function sendToMultipleDevices($deviceTokens, $title, $body, $data = [])
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        foreach ($deviceTokens as $token) {
            $result = $this->sendToDevice($token, $title, $body, $data);
            
            if ($result['success']) {
                $results['success']++;
            } else {
                $results['failed']++;
                $results['errors'][] = [
                    'token' => substr($token, 0, 20) . '...',
                    'error' => $result['error']
                ];
            }
        }

        return $results;
    }

    /**
     * Send notification to a user by user ID
     * 
     * @param int $userId
     * @param string $title
     * @param string $body
     * @param array $data Additional data payload
     * @return bool|array
     */
    public function sendToUser($userId, $title, $body, $data = [])
    {
        $userModel = new \Myth\Auth\Models\UserModel();
        $user = $userModel->find($userId);

        if (!$user || empty($user->device_token)) {
            return [
                'success' => false,
                'error' => 'User has no device token registered'
            ];
        }

        return $this->sendToDevice($user->device_token, $title, $body, $data);
    }

    /**
     * Send notification to multiple users by user IDs
     * 
     * @param array $userIds
     * @param string $title
     * @param string $body
     * @param array $data Additional data payload
     * @return array
     */
    public function sendToUsers($userIds, $title, $body, $data = [])
    {
        $userModel = new \Myth\Auth\Models\UserModel();
        $users = $userModel->whereIn('id', $userIds)
                          ->where('device_token IS NOT NULL')
                          ->findAll();

        $deviceTokens = array_column($users, 'device_token');

        if (empty($deviceTokens)) {
            return [
                'success' => 0,
                'failed' => 0,
                'errors' => ['No users with device tokens found']
            ];
        }

        return $this->sendToMultipleDevices($deviceTokens, $title, $body, $data);
    }
}
