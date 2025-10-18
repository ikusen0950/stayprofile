<?php

use App\Libraries\FirebaseNotificationService;

if (!function_exists('send_push_notification')) {
    /**
     * Send push notification to a user
     * 
     * @param int $userId User ID to send notification to
     * @param string $title Notification title
     * @param string $body Notification body
     * @param array $data Additional data payload
     * @return array Result of the notification send
     */
    function send_push_notification($userId, $title, $body, $data = [])
    {
        try {
            $firebase = new FirebaseNotificationService();
            return $firebase->sendToUser($userId, $title, $body, $data);
        } catch (\Exception $e) {
            log_message('error', 'Push notification helper error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}

if (!function_exists('send_push_notification_to_multiple')) {
    /**
     * Send push notification to multiple users
     * 
     * @param array $userIds Array of user IDs
     * @param string $title Notification title
     * @param string $body Notification body
     * @param array $data Additional data payload
     * @return array Result of the notification send
     */
    function send_push_notification_to_multiple($userIds, $title, $body, $data = [])
    {
        try {
            $firebase = new FirebaseNotificationService();
            return $firebase->sendToUsers($userIds, $title, $body, $data);
        } catch (\Exception $e) {
            log_message('error', 'Push notification helper error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}

if (!function_exists('send_push_to_device')) {
    /**
     * Send push notification directly to a device token
     * 
     * @param string $deviceToken FCM device token
     * @param string $title Notification title
     * @param string $body Notification body
     * @param array $data Additional data payload
     * @return array Result of the notification send
     */
    function send_push_to_device($deviceToken, $title, $body, $data = [])
    {
        try {
            $firebase = new FirebaseNotificationService();
            return $firebase->sendToDevice($deviceToken, $title, $body, $data);
        } catch (\Exception $e) {
            log_message('error', 'Push notification helper error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
