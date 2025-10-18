<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    protected $auth;

    public function __construct()
    {
        $this->auth = service('authentication');
    }

    public function index()
    {
        // Check if user is logged in
        if (!$this->auth->check()) {
            return redirect()->to('/login');
        }

        $user = $this->auth->user();
        
        // Check if user needs to change password
        if ($user->password_changed == 1) {
            return redirect()->to('/change-password');
        }
        
        $data = [
            'title' => 'Dashboard',
            'user' => $user,
            'session_id' => session()->session_id,
            'session_data' => session()->get(),
            'session_expiry_days' => config('Session')->expiration / (24 * 60 * 60), // Convert seconds to days
            'show_agreement_modal' => $user->has_accepted_agreement == 1, // Show modal if agreement has been accepted
            'show_notification_prompt' => empty($user->device_token) // Show notification prompt if no device token
        ];

        return view('dashboard/index', $data);
    }

    public function testSession()
    {
        $session = session();
        
        // Set a test value
        $session->set('test_value', 'Hello from database session!');
        $session->set('test_time', date('Y-m-d H:i:s'));
        
        $data = [
            'session_id' => $session->session_id,
            'session_driver' => config('Session')->driver,
            'session_expiry' => config('Session')->expiration,
            'session_table' => config('Session')->savePath,
            'test_value' => $session->get('test_value'),
            'test_time' => $session->get('test_time'),
            'all_session_data' => $session->get()
        ];
        
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function acceptAgreement()
    {
        // Check if user is logged in
        if (!$this->auth->check()) {
            return redirect()->to('/login');
        }

        $user = $this->auth->user();
        
        // Update the user's agreement status
        $userModel = model('UserModel');
        $result = $userModel->update($user->id, ['has_accepted_agreement' => 0]);
        
        if ($result) {
            // Log agreement acceptance
            $this->logAgreementAcceptance($user);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Agreement accepted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update agreement status.'
            ]);
        }
    }

    public function resetMyAgreement()
    {
        // Check if user is logged in
        if (!$this->auth->check()) {
            return redirect()->to('/login');
        }

        $user = $this->auth->user();
        $userModel = model('UserModel');
        $result = $userModel->update($user->id, ['has_accepted_agreement' => 1]);
        
        if ($result) {
            session()->setFlashdata('message', 'Your agreement status has been reset. You will see the agreement modal on next page load.');
            return redirect()->to('/dashboard');
        } else {
            session()->setFlashdata('error', 'Failed to reset agreement status.');
            return redirect()->to('/dashboard');
        }
    }

    public function changePassword()
    {
        // Check if user is logged in
        if (!$this->auth->check()) {
            return redirect()->to('/login');
        }

        return view('Auth/change_password');
    }

    public function updatePassword()
    {
        // Check if user is logged in
        if (!$this->auth->check()) {
            return redirect()->to('/login');
        }

        $user = $this->auth->user();
        $userModel = model('UserModel');
        
        // Validation rules (removed current_password requirement)
        $rules = [
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $newPassword = $this->request->getPost('password');

        try {
            // Update password using the User entity's setPassword method (Myth Auth compatible)
            $user->setPassword($newPassword);
            $user->password_changed = 0; // Reset password_changed flag
            $user->force_pass_reset = 0;
            
            $result = $userModel->save($user);

            if ($result) {
                // Log password change
                $this->logPasswordChange($user);
                
                // Log success for debugging
                log_message('info', 'Password changed successfully for user ID: ' . $user->id);
                session()->setFlashdata('message', 'Password changed successfully! You can now continue using the system.');
                return redirect()->to('/dashboard');
            } else {
                // Log the model errors for debugging
                $errors = $userModel->errors();
                log_message('error', 'Failed to save password change for user ID: ' . $user->id . '. Errors: ' . print_r($errors, true));
                return redirect()->back()->withInput()->with('error', 'Failed to update password. Validation errors: ' . implode(', ', $errors));
            }
        } catch (\Exception $e) {
            // Log any exceptions
            log_message('error', 'Exception during password change for user ID: ' . $user->id . '. Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update password. Error: ' . $e->getMessage());
        }
    }

    public function resetPasswordFlag()
    {
        // Check if user is logged in
        if (!$this->auth->check()) {
            return redirect()->to('/login');
        }

        $user = $this->auth->user();
        $userModel = model('UserModel');
        $result = $userModel->update($user->id, ['password_changed' => 1]);
        
        if ($result) {
            session()->setFlashdata('message', 'Password change flag has been reset. You will be prompted to change your password on next login.');
            return redirect()->to('/dashboard');
        } else {
            session()->setFlashdata('error', 'Failed to reset password flag.');
            return redirect()->to('/dashboard');
        }
    }

    /**
     * Log password change activity
     */
    protected function logPasswordChange($user)
    {
        try {
            // Get browser and device information
            $agent = $this->request->getUserAgent();
            $browser = $agent->getBrowser();
            $version = $agent->getVersion();
            $platform = $agent->getPlatform();
            $ipAddress = $this->request->getIPAddress();

            // Create detailed log message
            $logMessage = sprintf(
                "%s - %s has changed their password!\nIP Address: %s\nBrowser: %s\nVersion: %s\nPlatform: %s\nUser Agent: %s",
                $user->islander_no ?? $user->username,
                $user->full_name ?? $user->username,
                $ipAddress,
                $browser,
                $version,
                $platform,
                (string) $agent
            );

            // Load the LogModel
            $logModel = new \App\Models\LogModel();

            // Insert the log entry
            $result = $logModel->insert([
                'status_id' => 11, // Password Changed status
                'module_id' => 1,  // System module
                'action' => $logMessage,
                'user_id' => $user->id,
                'logged_at' => date('Y-m-d H:i:s')
            ]);

            if ($result) {
                log_message('info', 'Password change logged successfully for user: ' . ($user->islander_no ?? $user->username));
            } else {
                $errors = $logModel->errors();
                log_message('error', 'Failed to log password change. Validation errors: ' . json_encode($errors));
            }

        } catch (\Exception $e) {
            log_message('error', 'Exception in password change logging: ' . $e->getMessage());
        }
    }

    /**
     * Log agreement acceptance activity
     */
    protected function logAgreementAcceptance($user)
    {
        try {
            // Get browser and device information
            $agent = $this->request->getUserAgent();
            $browser = $agent->getBrowser();
            $version = $agent->getVersion();
            $platform = $agent->getPlatform();
            $ipAddress = $this->request->getIPAddress();

            // Create detailed log message
            $logMessage = sprintf(
                "%s - %s has accepted the user agreement!\nIP Address: %s\nBrowser: %s\nVersion: %s\nPlatform: %s\nUser Agent: %s",
                $user->islander_no ?? $user->username,
                $user->full_name ?? $user->username,
                $ipAddress,
                $browser,
                $version,
                $platform,
                (string) $agent
            );

            // Load the LogModel
            $logModel = new \App\Models\LogModel();

            // Insert the log entry
            $result = $logModel->insert([
                'status_id' => 12, // Agreement Accepted status
                'module_id' => 1,  // System module
                'action' => $logMessage,
                'user_id' => $user->id,
                'logged_at' => date('Y-m-d H:i:s')
            ]);

            if ($result) {
                log_message('info', 'Agreement acceptance logged successfully for user: ' . ($user->islander_no ?? $user->username));
            } else {
                $errors = $logModel->errors();
                log_message('error', 'Failed to log agreement acceptance. Validation errors: ' . json_encode($errors));
            }

        } catch (\Exception $e) {
            log_message('error', 'Exception in agreement acceptance logging: ' . $e->getMessage());
        }
    }
}