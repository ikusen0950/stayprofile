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
                return $this->failUnauthorized('User not authenticated');
            }

            // Get input data
            $json = $this->request->getJSON();
            $deviceToken = $json->device_token ?? $this->request->getPost('device_token');
            $platform = $json->platform ?? $this->request->getPost('platform'); // 'ios' or 'android'

            // Validate device token
            if (empty($deviceToken)) {
                return $this->fail('Device token is required', 400);
            }

            // Update user's device token
            $updated = $this->userModel->update($userId, [
                'device_token' => $deviceToken,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if ($updated) {
                // Log the device registration
                log_message('info', "Device token registered for user {$userId} on platform: " . ($platform ?? 'unknown'));

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
                return $this->fail('Failed to register device token', 500);
            }

        } catch (\Exception $e) {
            log_message('error', 'Device token registration error: ' . $e->getMessage());
            return $this->fail('An error occurred while registering device token', 500);
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
