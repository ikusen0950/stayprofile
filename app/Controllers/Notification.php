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
        if ($this->request->isAJAX()) {
            $id = $this->request->getJSON()->id;
            $notificationModel = new NotificationModel();
            $notificationModel->update($id, ['status_id' => 26]);
            // Assuming 26 is the ID for 'read' status
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setStatusCode(403);
    }

    public function markAsReadAndRedirect($id)
    {
        $notificationModel = new NotificationModel();
        $notification = $notificationModel->find($id);

        if (!$notification || $notification['user_id'] !== user()->id) {
            return redirect()->to('/notifications')->with('error', 'Invalid notification');
        }

        // Mark as read
        $notificationModel->update($id, ['status_id' => 26]);

        // Redirect to the actual content
        return redirect()->to(base_url($notification['url']));
    }

    public function saveToken()
    {
        try {
            // Check for logged-in user using Myth:Auth
            $userObj = user();
            $user = $userObj ? $userObj->id : null;

            if (!$user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Unauthorized - user not logged in'
                ])->setStatusCode(401);
            }

            // Read raw body
            $body = $this->request->getBody();
            log_message('debug', 'FCM Token Save - Raw request body: ' . $body);

            if (empty($body)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Empty request body'
                ])->setStatusCode(400);
            }

            $data = json_decode($body, true);

            if (!is_array($data) || !isset($data['token'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid or missing JSON token',
                    'received' => $body
                ])->setStatusCode(400);
            }

            $token = $data['token'];

            // Save the token to the database
            $userModel = model(\App\Models\UserModel::class);
            $result = $userModel->update($user, ['device_token' => $token]);

            if ($result) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Token saved successfully',
                    'user_id' => $user,
                    'token' => substr($token, 0, 20) . '...' // Truncated for security
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'Failed to save token to database'
                ])->setStatusCode(500);
            }

        } catch (\Exception $e) {
            log_message('error', 'FCM Token Save Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Internal server error: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
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
        // $url = 'https://demo-islander.finolhu.net/authorizations';
        $url = 'authorizations';

        $result = send_fcm_push(
            $deviceToken,
            'Islanders App 🚀',
            'Click to view authorizations',
            $url // passed as click_action
        );

        return $this->response->setJSON($result);
    }
}