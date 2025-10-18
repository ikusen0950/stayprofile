<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StatusModel;
use App\Models\NotificationModel;

class Notification extends BaseController
{
    protected $notification;

    public function __construct()
    {
        $this->notification = new NotificationModel();
    }

    public function index()
    {
        $userId = user()->id;
        // From Myth:Auth

        $notifications = $this->notification
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('notification/index', ['notifications' => $notifications]);
    }
 public function markAsRead()
 {
        if ( $this->request->isAJAX() ) {
            $id = $this->request->getJSON()->id;
            $notificationModel = new \App\Models\notifications_model();
            $notificationModel->update( $id, [ 'status_id' => 26 ] );
            // Assuming 26 is the ID for 'read' status
            return $this->response->setJSON( [ 'status' => 'success' ] );
        }
        return $this->response->setStatusCode( 403 );
    }

    public function markAsReadAndRedirect( $id )
 {
        $notificationModel = new \App\Models\notifications_model();
        $notification = $notificationModel->find( $id );

        if ( !$notification || $notification[ 'user_id' ] !== user()->id ) {
            return redirect()->to( '/notifications' )->with( 'error', 'Invalid notification' );
        }

        // Mark as read
        $notificationModel->update( $id, [ 'status_id' => 26 ] );

        // Redirect to the actual content
        return redirect()->to( base_url( $notification[ 'url' ] ) );
    }

    public function saveToken()
 {
        // Check for logged-in user using Myth:Auth
        $user = user()->id ?? NULL;

        if ( !$user ) {
            return $this->response->setJSON( [
                'status' => 'error',
                'message' => 'Unauthorized'
            ] )->setStatusCode( 401 );
        }

        // Read raw body
        $body = $this->request->getBody();
        log_message( 'debug', 'Raw request body: ' . $body );
        // Log body for debugging

        if ( empty( $body ) ) {
            return $this->response->setJSON( [
                'status' => 'error',
                'message' => 'Empty request body'
            ] )->setStatusCode( 400 );
        }

        $data = json_decode( $body, true );

        if ( !is_array( $data ) || !isset( $data[ 'token' ] ) ) {
            return $this->response->setJSON( [
                'status' => 'error',
                'message' => 'Invalid or missing JSON token',
                'raw' => $body // helpful for debugging
            ] )->setStatusCode( 400 );
        }

        $token = $data[ 'token' ];

        // Save the token to the database
        $userModel = model( \App\Models\UserModel::class );
        
        // Log before update
        log_message( 'debug', 'Attempting to update user ' . $user . ' with token: ' . substr($token, 0, 20) . '...' );
        
        $updateResult = $userModel->update( $user, [ 'device_token' => $token ] );
        
        // Log the update result for debugging
        log_message( 'debug', 'Token update result: ' . ($updateResult ? 'success' : 'failed') . ' for user ' . $user );
        
        // Check if update was successful
        if (!$updateResult) {
            // Get validation errors if any
            $errors = $userModel->errors();
            log_message( 'error', 'Token update failed. Errors: ' . json_encode($errors) );
            
            return $this->response->setJSON( [
                'status' => 'error',
                'message' => 'Failed to save token to database',
                'errors' => $errors,
                'user_id' => $user
            ] )->setStatusCode( 500 );
        }
        
        // Verify the token was actually saved by reading it back
        $updatedUser = $userModel->find($user);
        $savedToken = $updatedUser ? $updatedUser->device_token : null;
        
        log_message( 'debug', 'Verification - saved token: ' . ($savedToken ? substr($savedToken, 0, 20) . '...' : 'null') );

        return $this->response->setJSON( [
            'status' => 'success',
            'message' => 'Token saved',
            'user_id' => $user,
            'token' => substr($token, 0, 20) . '...', // Only show first 20 chars for security
            'verified' => $savedToken === $token ? 'yes' : 'no',
            'saved_token_preview' => $savedToken ? substr($savedToken, 0, 20) . '...' : 'null'
        ] );
    }

    public function testPush()
    {
        helper('fcm');

        $userObj = user();
        $deviceToken = $userObj ? $userObj->device_token : null;

        if (!$deviceToken) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Device token not found for user.'
            ]);
        }

        // This should be the internal or external deep link you want to open
        $url = 'authorizations';

        // Use your existing FCM helper function with correct parameters
        $result = send_fcm_push(
            $deviceToken,                    // token
            'Islanders App 🚀',            // title
            'Test push notification from API', // body
            $url,                           // click_action
            $userObj->id,                   // user_id
            null                            // notification_id (will be auto-generated)
        );

        return $this->response->setJSON($result);
    }

    public function testPushSimple()
    {
        helper('fcm');

        // Test with a dummy token (replace with actual token for real testing)
        $testToken = 'dummy_token_for_testing';
        
        // Test the FCM helper function
        $result = send_fcm_push(
            $testToken,                        // token
            'Test Notification 🚀',          // title
            'This is a test from the API',   // body
            'authorizations',                // click_action
            999,                             // user_id (dummy)
            null                             // notification_id
        );

        return $this->response->setJSON([
            'message' => 'FCM test completed',
            'fcm_result' => $result,
            'kreait_firebase_installed' => class_exists('Kreait\\Firebase\\Factory'),
            'service_account_exists' => file_exists(APPPATH . 'Config/firebase_service_account.json')
        ]);
    }

}