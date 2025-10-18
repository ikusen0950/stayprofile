<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Libraries\FirebaseNotificationService;
use Myth\Auth\Models\UserModel;

class TestPushNotification extends BaseCommand
{
    protected $group       = 'Notifications';
    protected $name        = 'notification:test';
    protected $description = 'Test sending a push notification to a user';

    public function run(array $params)
    {
        // Get user ID from command line
        $userId = CLI::prompt('Enter user ID to send test notification', null, 'required|numeric');

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            CLI::error('User not found!');
            return;
        }

        CLI::write("User found: {$user->username} ({$user->email})", 'green');

        if (empty($user->device_token)) {
            CLI::error('User does not have a device token registered!');
            CLI::write('The user needs to register their device token from the mobile app first.', 'yellow');
            return;
        }

        CLI::write('Device token found: ' . substr($user->device_token, 0, 30) . '...', 'blue');

        // Get notification details
        $title = CLI::prompt('Notification title', 'Test Notification from Islanders Finolhu');
        $body = CLI::prompt('Notification body', 'This is a test push notification. Hello from the backend!');

        CLI::newLine();
        CLI::write('Sending notification...', 'yellow');

        try {
            $firebase = new FirebaseNotificationService();
            $result = $firebase->sendToUser(
                $userId,
                $title,
                $body,
                [
                    'test' => 'true',
                    'timestamp' => date('Y-m-d H:i:s'),
                    'url' => '/dashboard'
                ]
            );

            CLI::newLine();
            
            if ($result['success']) {
                CLI::write('✓ Notification sent successfully!', 'green');
                if (isset($result['message_id'])) {
                    CLI::write('Message ID: ' . $result['message_id'], 'blue');
                }
            } else {
                CLI::error('✗ Failed to send notification');
                CLI::write('Error: ' . ($result['error'] ?? 'Unknown error'), 'red');
            }

        } catch (\Exception $e) {
            CLI::error('✗ Exception occurred: ' . $e->getMessage());
        }

        CLI::newLine();
    }
}
