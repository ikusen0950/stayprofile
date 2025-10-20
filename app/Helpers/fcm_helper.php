<?php

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

// Define constants for statuses
define( 'STATUS_APPROVE_FCM', '14' );
define( 'STATUS_REJECT_FCM', '15' );
define( 'STATUS_BOOKED_FCM', '22' );
define( 'STATUS_MANAGER_NOTIFICATION_FCM', '13' );
define( 'USER_STATUS_ACTIVE_FCM', 7 );
// Define constant for Assistant Manager Role ID if available
define( 'ROLE_ASSISTANT_MANAGER_ID_FCM', 5 );
// Replace with actual ID

function send_fcm_push( $token, $title, $body, $click_action = null, $user_id = null, $notification_id = null )
 {
    $serviceAccountPath = WRITEPATH . '../app/Config/firebase_service_account.json';
    $projectId = 'islanders-app---finolhu';

    $accessToken = get_firebase_access_token( $serviceAccountPath );
    if ( !$accessToken ) {
        return [ 'status' => 'error', 'message' => 'Failed to generate access token' ];
    }

    $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

    $message = [
        'message' => [
            'token' => $token,
            'notification' => [
                'title' => $title,
                'body'  => $body,
            ],
            'apns' => [
                'headers' => [
                    'apns-priority' => '10',
                ],
                'payload' => [
                    'aps' => [
                        'alert' => [
                            'title' => $title,
                            'body'  => $body,
                        ],
                        'sound' => 'default',
                        'category' => 'NEW_MESSAGE'
                    ]
                ]
            ],
            'android' => [
                'notification' => [
                    'click_action' => 'FCM_PLUGIN_ACTIVITY',
                ]
            ],
            'data' => [
                'click_action' => 'FCM_PLUGIN_ACTIVITY',
                'url' => $click_action ?? '',
                'notification_id' => ( string ) $notification_id
            ]
        ]
    ];

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
    ];

    $ch = curl_init( $url );
    curl_setopt_array( $ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => json_encode( $message ),
    ] );

    $response = curl_exec( $ch );
    $error = curl_error( $ch );
    curl_close( $ch );

    if ( $error ) {
        return [ 'status' => 'error', 'message' => $error ];
    }

    $result = json_decode( $response, true );
    if ( isset( $result[ 'error' ] ) ) {
        return [ 'status' => 'error', 'message' => $result[ 'error' ][ 'message' ] ];
    }

    return [ 'status' => 'success', 'message' => 'Notification sent', 'response' => $result ];
}

function get_firebase_access_token( $path )
 {
    $jsonKey = json_decode( file_get_contents( $path ), true );
    $privateKey = $jsonKey[ 'private_key' ];
    $clientEmail = $jsonKey[ 'client_email' ];

    $jwtHeader = json_encode( [ 'alg' => 'RS256', 'typ' => 'JWT' ] );
    $now = time();
    $jwtClaim = json_encode( [
        'iss' => $clientEmail,
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        'aud' => 'https://oauth2.googleapis.com/token',
        'iat' => $now,
        'exp' => $now + 3600,
    ] );

    $base64UrlHeader = rtrim( strtr( base64_encode( $jwtHeader ), '+/', '-_' ), '=' );
    $base64UrlClaim = rtrim( strtr( base64_encode( $jwtClaim ), '+/', '-_' ), '=' );
    $data = $base64UrlHeader . '.' . $base64UrlClaim;

    openssl_sign( $data, $signature, $privateKey, 'sha256WithRSAEncryption' );
    $base64UrlSignature = rtrim( strtr( base64_encode( $signature ), '+/', '-_' ), '=' );
    $jwt = $data . '.' . $base64UrlSignature;

    // Request access token
    $ch = curl_init( 'https://oauth2.googleapis.com/token' );
    curl_setopt_array( $ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => http_build_query( [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ] )
    ] );

    $response = curl_exec( $ch );
    curl_close( $ch );

    $json = json_decode( $response, true );
    return $json[ 'access_token' ] ?? null;
}

function fcmNotificationExitPass( $division_id, $department_id, $section_id, $status, $user, $request_uid )
 {
    if ( empty( $request_uid ) ) {
        log_message( 'error', 'Request UID is required.' );
        return false;
    }

    $requestModel = new \App\Models\RequestModel();
    $usersModel = new \App\Models\UserModel();
    $roleModel = new \App\Models\RoleModel();
    $authorizationModel = new \App\Models\AuthorizationRuleModel();

    $request = $requestModel->where( 'id', $request_uid )->first();
    if ( !$request ) return false;

    $islander = $usersModel->where( 'id', $user )
    ->where( 'status_id', USER_STATUS_ACTIVE_FCM )
    ->first();
    if ( !$islander ) return false;

    $user_id = $islander->id ?? null;
    $islanderFullName = $islander->full_name;
    $fcmToken = $islander->device_token ?? null;
    $clickUrl = 'requests' ;

    if ( !$fcmToken ) {
        log_message( 'error', "No FCM token found for user ID $user." );
        return false;
    }

    // Status: Approved
    if ( $status == STATUS_APPROVE_FCM ) {
        $title = '✅ Exit Pass Request Approved';
        $body = "Dear $islanderFullName, your exit pass request (#$request_uid) has been approved.";
        // send_fcm_push( $fcmToken, $title, $body, $clickUrl );

        // ✅ Save to database for each manager
        $notificationModel = new \App\Models\NotificationModel();
        $notification_id = $notificationModel->insert( [
            'user_id'    => $user_id,
            'title'      => $title,
            'body'       => $body,
            'url'        => $clickUrl,
            'status_id'  => 27,
            'created_at' => date( 'Y-m-d H:i:s' ),
        ], true );
        // `true` returns insert ID

        send_fcm_push( $fcmToken, $title, $body, "notification/read/{$notification_id}", $user_id, $notification_id );

    }

    // Status: Rejected
    if ( $status == STATUS_REJECT_FCM ) {
        $title = '❌ Exit Pass Request Rejected';
        $body = "Dear $islanderFullName, your exit pass request (#$request_uid) has been rejected. Please contact your department.";
        // send_fcm_push( $fcmToken, $title, $body, $clickUrl );

        // ✅ Save to database for each manager
        $notificationModel = new \App\Models\NotificationModel();
        $notification_id = $notificationModel->insert( [
            'user_id'    => $user_id,
            'title'      => $title,
            'body'       => $body,
            'url'        => $clickUrl,
            'status_id'  => 27,
            'created_at' => date( 'Y-m-d H:i:s' ),
        ], true );
        // `true` returns insert ID

        send_fcm_push( $fcmToken, $title, $body, "notification/read/{$notification_id}", $user_id, $notification_id );
    }

    // Notify Managers
    if ( $status == STATUS_MANAGER_NOTIFICATION_FCM || $status == 13 ) {
        $userRole = $roleModel->find( $islander->role_id );
        $isAssistantManager = strcasecmp( $userRole[ 'name' ] ?? '', 'Assistant Manager' ) === 0;

        // Get managers who can approve requests for the requester's department/division/section
        $managers = $authorizationModel->groupStart()
        ->like( 'division_ids', (string)$division_id )
        ->orLike( 'department_ids', (string)$department_id )
        ->orLike( 'section_ids', (string)$section_id )
        ->groupEnd()
        ->where( 'can_request', 0 ) // Only managers (can_request = 0 means they are managers)
        ->where( 'is_active', 1 ) // Only active rules
        ->findAll();

        // foreach ( $managers as $manager ) {
        //     if ( $isAssistantManager && $manager[ 'user_id' ] == $user ) continue;

        //     $managerDetails = $usersModel->find( $manager[ 'user_id' ] );
        //     if ( !$managerDetails || empty( $managerDetails[ 'device_token' ] ) ) continue;

        //     $managerToken = $managerDetails[ 'device_token' ];
        //     $title = '📌 Exit Pass Awaiting for Approval';
        //     $body = "You have a pending exit pass request ($request_uid) from $islanderFullName awaiting for your approval.";
        //     $clickUrl = 'authorizations';
        //     send_fcm_push( $managerToken, $title, $body, $clickUrl );
        // }

        foreach ( $managers as $manager ) {
            // Skip if this manager is the same person who created the request
            // Assistant managers cannot approve their own requests - must be done by administrator, executive committee, or manager
            if ( $manager[ 'user_id' ] == $user ) continue;

            $managerDetails = $usersModel->find( $manager[ 'user_id' ] );
            if ( !$managerDetails || empty( $managerDetails->device_token ) ) continue;

            $managerToken = $managerDetails->device_token;
            $title = '📌 Exit Pass Awaiting for Approval';
            $body = "You have a pending exit pass request ($request_uid) from $islanderFullName awaiting your approval.";
            $clickUrl = 'authorizations';

            // 🔔 Send FCM
            // send_fcm_push( $managerToken, $title, $body, $clickUrl );

            // ✅ Save to database for each manager
            $notificationModel = new \App\Models\NotificationModel();
            $notification_id = $notificationModel->insert( [
                'user_id'    => $manager[ 'user_id' ],
                'title'      => $title,
                'body'       => $body,
                'url'        => $clickUrl,
                'status_id'  => 27,
                'created_at' => date( 'Y-m-d H:i:s' ),
            ], true );
            // `true` returns insert ID

            send_fcm_push( $managerToken, $title, $body, "notification/read/{$notification_id}", $manager[ 'user_id' ], $notification_id );
        }

    }

    // ✅ Save to database
    // if ( $user ) {
    //     $notificationModel = new \App\Models\NotificationModel();
    //     $notificationModel->insert( [
    //         'user_id' => $user,
    //         'title'   => $title,
    //         'body'    => $body,
    //         'url'     => $clickUrl ?? '',
    //         'status_id'  => 27,
    //         'created_at' => date( 'Y-m-d H:i:s' ),
    // ] );
    // }

    return true;
}

function fcmNotificationTransfer( $division_id, $department_id, $section_id, $status, $user, $request_uid )
 {
    if ( empty( $request_uid ) ) {
        log_message( 'error', 'Request UID is required.' );
        return false;
    }

    $requestModel = new \App\Models\RequestModel();
    $usersModel = new \App\Models\UserModel();
    $roleModel = new \App\Models\RoleModel();
    $authorizationModel = new \App\Models\AuthorizationRuleModel();

    $request = $requestModel->where( 'id', $request_uid )->first();
    if ( !$request ) return false;

    $islander = $usersModel->where( 'id', $user )
    ->where( 'status_id', USER_STATUS_ACTIVE_FCM )
    ->first();
    if ( !$islander ) return false;

    $user_id = $islander->id ?? null;
    $islanderFullName = $islander->full_name;
    $fcmToken = $islander->device_token ?? null;
    $clickUrl = 'requests';

    if ( !$fcmToken ) {
        log_message( 'error', "No FCM token found for user ID $user." );
        return false;
    }

    // Status: Approved
    if ( $status == STATUS_APPROVE_FCM ) {
        $title = '✅ Transfer Request Approved';
        $body  = "Dear $islanderFullName, your transfer request (#$request_uid) has been approved.";
        // send_fcm_push( $fcmToken, $title, $body, $clickUrl, $user );
        $notificationModel = new \App\Models\NotificationModel();
        $notification_id = $notificationModel->insert( [
            'user_id'    => $user_id,
            'title'      => $title,
            'body'       => $body,
            'url'        => $clickUrl,
            'status_id'  => 27,
            'created_at' => date( 'Y-m-d H:i:s' ),
        ], true );
        // `true` returns insert ID

        send_fcm_push( $fcmToken, $title, $body, "notification/read/{$notification_id}", $user_id, $notification_id );
    }

    // Status: Rejected
    if ( $status == STATUS_REJECT_FCM ) {
        $title = '❌ Transfer Request Rejected';
        $body  = "Dear $islanderFullName, your transfer request (#$request_uid) has been rejected. Please contact your department.";
        // send_fcm_push( $fcmToken, $title, $body, $clickUrl, $user );
        $notificationModel = new \App\Models\NotificationModel();
        $notification_id = $notificationModel->insert( [
            'user_id'    => $user_id,
            'title'      => $title,
            'body'       => $body,
            'url'        => $clickUrl,
            'status_id'  => 27,
            'created_at' => date( 'Y-m-d H:i:s' ),
        ], true );
        // `true` returns insert ID

        send_fcm_push( $fcmToken, $title, $body, "notification/read/{$notification_id}", $user_id, $notification_id );
    }

    // Notify Managers
    if ( $status == STATUS_MANAGER_NOTIFICATION_FCM || $status == 13 ) {
        $userRole = $roleModel->find( $islander->role_id );
        $isAssistantManager = strcasecmp( $userRole[ 'name' ] ?? '', 'Assistant Manager' ) === 0;

        // Find managers who have authorization for the REQUESTER's department/division/section
        // Example: User 25 (dept 17, section 2) → Find managers with dept 17 OR section 2 authorization
        $managers = $authorizationModel->groupStart()
        ->like( 'division_ids', (string)$division_id )
        ->orLike( 'department_ids', (string)$department_id )
        ->orLike( 'section_ids', (string)$section_id )
        ->groupEnd()
        ->where( 'can_request', 0 ) // Only managers (can_request = 0 means they are managers)
        ->where( 'is_active', 1 ) // Only active rules
        ->findAll();

        // foreach ( $managers as $manager ) {
        //     if ( $isAssistantManager && $manager[ 'user_id' ] == $user ) continue;

        //     $managerDetails = $usersModel->find( $manager[ 'user_id' ] );
        //     if ( !$managerDetails || empty( $managerDetails[ 'device_token' ] ) ) continue;

        //     $managerToken = $managerDetails[ 'device_token' ];
        //     $title = '📌 Transfer Awaiting for Approval';
        //     $body  = "You have a pending transfer request ($request_uid) from $islanderFullName awaiting for your approval.";
        //     $clickUrl = 'authorizations';

        //     send_fcm_push( $managerToken, $title, $body, $clickUrl, $manager[ 'user_id' ] );
        // }

        foreach ( $managers as $manager ) {
            // Skip if this manager is the same person who created the request
            // Assistant managers cannot approve their own requests - must be done by administrator, executive committee, or manager
            if ( $manager[ 'user_id' ] == $user ) continue;

            $managerDetails = $usersModel->find( $manager[ 'user_id' ] );
            if ( !$managerDetails || empty( $managerDetails->device_token ) ) continue;

            $managerToken = $managerDetails->device_token;
            $title = '📌 Transfer Awaiting for Approval';
            $body  = "You have a pending transfer request ($request_uid) from $islanderFullName awaiting for your approval.";
            $clickUrl = 'authorizations';

            // 🔔 Send FCM
            // send_fcm_push( $managerToken, $title, $body, $clickUrl );

            // ✅ Save to database for each manager
            $notificationModel = new \App\Models\NotificationModel();
            $notification_id = $notificationModel->insert( [
                'user_id'    => $manager[ 'user_id' ],
                'title'      => $title,
                'body'       => $body,
                'url'        => $clickUrl,
                'status_id'  => 27,
                'created_at' => date( 'Y-m-d H:i:s' ),
            ], true );
            // `true` returns insert ID

            send_fcm_push( $managerToken, $title, $body, "notification/read/{$notification_id}", $manager[ 'user_id' ], $notification_id );
        }

    }



    return true;
}