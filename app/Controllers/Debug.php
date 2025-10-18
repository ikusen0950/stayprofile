<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Debug extends BaseController
{
    public function testTokenSave()
    {
        // Only allow in development
        if (ENVIRONMENT !== 'development') {
            return $this->response->setStatusCode(404);
        }
        
        // Check if user is logged in
        $userId = user()->id ?? null;
        
        if (!$userId) {
            return $this->response->setJSON([
                'error' => 'No user logged in',
                'suggestion' => 'Please login first'
            ]);
        }
        
        // Test token
        $testToken = 'test_token_' . date('YmdHis') . '_' . $userId;
        
        // Save to database
        $userModel = model(\App\Models\UserModel::class);
        $result = $userModel->update($userId, ['device_token' => $testToken]);
        
        // Read back to verify
        $user = $userModel->find($userId);
        $savedToken = $user ? $user->device_token : null;
        
        return $this->response->setJSON([
            'user_id' => $userId,
            'test_token' => $testToken,
            'update_result' => $result ? 'success' : 'failed',
            'saved_token' => $savedToken,
            'verification' => $savedToken === $testToken ? 'MATCH' : 'MISMATCH',
            'user_data' => [
                'username' => $user->username ?? 'unknown',
                'email' => $user->email ?? 'unknown',
                'device_token' => $user->device_token ?? 'null'
            ]
        ]);
    }
    
    public function checkCurrentUser()
    {
        // Only allow in development
        if (ENVIRONMENT !== 'development') {
            return $this->response->setStatusCode(404);
        }
        
        $user = user();
        
        if (!$user) {
            return $this->response->setJSON([
                'logged_in' => false,
                'message' => 'No user session found'
            ]);
        }
        
        return $this->response->setJSON([
            'logged_in' => true,
            'user_id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'device_token' => $user->device_token ?? 'null',
            'has_accepted_agreement' => $user->has_accepted_agreement ?? false
        ]);
    }
}