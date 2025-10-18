<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Models\UserModel;

class DeviceController extends ResourceController
{
    protected $format = 'json';
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Register or update device token for push notifications
     * 
     * @return ResponseInterface
     */
    public function registerToken()
    {
        try {
            // Get user ID from authentication
            $userId = user_id();
            
            if (!$userId) {
                log_message('error', 'Device token registration: User not authenticated');
                return $this->failUnauthorized('User not authenticated');
            }

            // Get input data
            $json = $this->request->getJSON();
            $deviceToken = $json->device_token ?? $this->request->getPost('device_token');
            $platform = $json->platform ?? $this->request->getPost('platform'); // 'ios', 'android', or 'web'

            // Log incoming request
            log_message('info', "Device token registration attempt for user {$userId}, platform: " . ($platform ?? 'unknown'));

            // Validate device token
            if (empty($deviceToken)) {
                log_message('error', 'Device token registration: Token is empty');
                return $this->fail('Device token is required', 400);
            }

            // Get the user's current device token to check if it's the same
            $currentUser = $this->userModel->find($userId);
            if (!$currentUser) {
                log_message('error', "Device token registration: User {$userId} not found");
                return $this->failNotFound('User not found');
            }

            // Check if the token is the same as the current one
            if ($currentUser->device_token === $deviceToken) {
                log_message('info', "Device token for user {$userId} is already up to date");
                return $this->respond([
                    'success' => true,
                    'message' => 'Device token is already registered',
                    'data' => [
                        'user_id' => $userId,
                        'platform' => $platform ?? 'unknown',
                        'registered_at' => $currentUser->updated_at
                    ]
                ], 200);
            }

            // Update user's device token - force update even if data is "same"
            $db = \Config\Database::connect();
            $updated = $db->table('users')
                ->where('id', $userId)
                ->update([
                    'device_token' => $deviceToken,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            if ($updated) {
                // Log the device registration
                log_message('info', "Device token registered successfully for user {$userId} on platform: " . ($platform ?? 'unknown'));

                return $this->respond([
                    'success' => true,
                    'message' => 'Device token registered successfully',
                    'data' => [
                        'user_id' => $userId,
                        'platform' => $platform ?? 'unknown',
                        'registered_at' => date('Y-m-d H:i:s')
                    ]
                ], 200);
            } else {
                log_message('error', "Failed to update device token for user {$userId}");
                return $this->fail('Failed to register device token', 500);
            }

        } catch (\Exception $e) {
            log_message('error', 'Device token registration exception: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return $this->fail('An error occurred while registering device token: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove device token (on logout or uninstall)
     * 
     * @return ResponseInterface
     */
    public function removeToken()
    {
        try {
            $userId = user_id();
            
            if (!$userId) {
                return $this->failUnauthorized('User not authenticated');
            }

            // Clear device token
            $updated = $this->userModel->update($userId, [
                'device_token' => null,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if ($updated) {
                log_message('info', "Device token removed for user {$userId}");

                return $this->respond([
                    'success' => true,
                    'message' => 'Device token removed successfully'
                ], 200);
            } else {
                return $this->fail('Failed to remove device token', 500);
            }

        } catch (\Exception $e) {
            log_message('error', 'Device token removal error: ' . $e->getMessage());
            return $this->fail('An error occurred while removing device token', 500);
        }
    }

    /**
     * Get device token status
     * 
     * @return ResponseInterface
     */
    public function tokenStatus()
    {
        try {
            $userId = user_id();
            
            if (!$userId) {
                return $this->failUnauthorized('User not authenticated');
            }

            $user = $this->userModel->find($userId);

            return $this->respond([
                'success' => true,
                'data' => [
                    'has_token' => !empty($user->device_token),
                    'registered' => !empty($user->device_token)
                ]
            ], 200);

        } catch (\Exception $e) {
            log_message('error', 'Device token status error: ' . $e->getMessage());
            return $this->fail('An error occurred while checking token status', 500);
        }
    }
}
