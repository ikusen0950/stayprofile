<?php

if (!function_exists('send_fcm_push')) {
    /**
     * Send FCM push notification
     * 
     * @param string $deviceToken FCM device token
     * @param string $title Notification title
     * @param string $body Notification body  
     * @param string $url Click action URL
     * @return array Response from FCM
     */
    function send_fcm_push($deviceToken, $title, $body, $url = null) {
        // This is a simple placeholder for FCM functionality
        // In your working app, implement actual FCM sending logic here
        
        log_message('info', 'FCM Push requested: ' . $title . ' to token: ' . substr($deviceToken, 0, 20) . '...');
        
        return [
            'status' => 'success',
            'message' => 'FCM helper called (implement actual FCM sending logic)',
            'token' => substr($deviceToken, 0, 20) . '...',
            'title' => $title,
            'body' => $body,
            'url' => $url
        ];
    }
}