<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\status_model;
use App\Models\notifications_model;

class Notification extends BaseController
{
    protected $notification;

    public function __construct()
    {
        $this->notification = new notifications_model();
    }

    public function index()
    {
        $userId = user()->id;
        // From Myth:Auth

        $notifications = $this->notification
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();

        return view('notification/index', ['notifications' => $notifications]);
    }

    public function markAsRead()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getJSON()->id;
            $notificationModel = new \App\Models\notifications_model();
            $notificationModel->update($id, ['status_id' => 26]);
            // Assuming 26 is the ID for 'read' status
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setStatusCode(403);
    }

    public function markAsReadAndRedirect($id)
    {
        $notificationModel = new \App\Models\notifications_model();
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
        // Check for logged-in user using Myth:Auth
        $user = user()->id ?? NULL;

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        // Read raw body
        $body = $this->request->getBody();
        log_message('debug', 'Raw request body: ' . $body);
        // Log body for debugging

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
                'raw' => $body // helpful for debugging
            ])->setStatusCode(400);
        }

        $token = $data['token'];

        // Save the token to the database
        $userModel = model(\App\Models\users_model::class);
        $userModel->update($user, ['device_token' => $token]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Token saved',
            'user_id' => $user,
            'token' => $token
        ]);
    }

    public function testPush()
    {
        helper('fcm');

        $deviceToken = user()->device_token ?? null;

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