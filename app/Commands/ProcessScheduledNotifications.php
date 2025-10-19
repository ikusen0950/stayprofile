<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\NotificationModel;
use App\Models\LogModel;

class ProcessScheduledNotifications extends BaseCommand
{
    protected $group       = 'Notifications';
    protected $name        = 'notifications:process-scheduled';
    protected $description = 'Process and send scheduled notifications that are due';

    public function run(array $params)
    {
        helper('fcm');
        
        $notificationModel = new NotificationModel();
        $logModel = new LogModel();
        
        CLI::write('🔍 Checking for scheduled notifications...', 'yellow');
        
        // Get scheduled notifications that are due
        $scheduledNotifications = $notificationModel
            ->where('status_id', 27) // Assuming 27 is the status for scheduled notifications
            ->where('scheduled_at <=', date('Y-m-d H:i:s'))
            ->where('scheduled_at IS NOT NULL')
            ->findAll();
        
        if (empty($scheduledNotifications)) {
            CLI::write('✅ No scheduled notifications due at this time.', 'green');
            return;
        }
        
        CLI::write('📤 Found ' . count($scheduledNotifications) . ' scheduled notifications to process...', 'blue');
        
        $sentCount = 0;
        $failedCount = 0;
        
        foreach ($scheduledNotifications as $notification) {
            try {
                // Get user's device token
                $userModel = new \Myth\Auth\Models\UserModel();
                $user = $userModel->find($notification['user_id']);
                
                if (!$user || empty($user->device_token)) {
                    CLI::write("⚠️  User {$notification['user_id']} has no device token, skipping...", 'yellow');
                    
                    // Update notification status to failed
                    $notificationModel->update($notification['id'], [
                        'status_id' => 28, // Failed status
                        'sent_at' => date('Y-m-d H:i:s'),
                        'error_message' => 'No device token available'
                    ]);
                    
                    $failedCount++;
                    continue;
                }
                
                // Send FCM notification
                $fcmResult = send_fcm_push(
                    $user->device_token,
                    $notification['title'],
                    $notification['body'],
                    $notification['url'] ?? null,
                    $notification['user_id'],
                    $notification['id']
                );
                
                if ($fcmResult['status'] === 'success') {
                    // Update notification status to sent
                    $notificationModel->update($notification['id'], [
                        'status_id' => 29, // Sent status
                        'sent_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    $sentCount++;
                    CLI::write("✅ Sent notification #{$notification['id']} to user {$notification['user_id']}", 'green');
                    
                    // Log success
                    $logModel->insert([
                        'user_id' => $notification['user_id'],
                        'status_id' => 29,
                        'module_id' => 6,
                        'action' => "Scheduled notification sent: {$notification['title']}"
                    ]);
                    
                } else {
                    // Update notification status to failed
                    $notificationModel->update($notification['id'], [
                        'status_id' => 28, // Failed status
                        'sent_at' => date('Y-m-d H:i:s'),
                        'error_message' => $fcmResult['message'] ?? 'Unknown FCM error'
                    ]);
                    
                    $failedCount++;
                    CLI::write("❌ Failed to send notification #{$notification['id']}: " . ($fcmResult['message'] ?? 'Unknown error'), 'red');
                    
                    // Log failure
                    $logModel->insert([
                        'user_id' => $notification['user_id'],
                        'status_id' => 28,
                        'module_id' => 6,
                        'action' => "Scheduled notification failed: {$notification['title']} - " . ($fcmResult['message'] ?? 'Unknown error')
                    ]);
                }
                
            } catch (\Exception $e) {
                // Update notification status to failed
                $notificationModel->update($notification['id'], [
                    'status_id' => 28, // Failed status
                    'sent_at' => date('Y-m-d H:i:s'),
                    'error_message' => $e->getMessage()
                ]);
                
                $failedCount++;
                CLI::write("❌ Exception processing notification #{$notification['id']}: " . $e->getMessage(), 'red');
                
                // Log exception
                $logModel->insert([
                    'user_id' => $notification['user_id'] ?? 0,
                    'status_id' => 28,
                    'module_id' => 6,
                    'action' => "Scheduled notification exception: {$notification['title']} - " . $e->getMessage()
                ]);
            }
        }
        
        CLI::write('', 'white');
        CLI::write('📊 Processing Summary:', 'blue');
        CLI::write("✅ Sent: {$sentCount}", 'green');
        CLI::write("❌ Failed: {$failedCount}", 'red');
        CLI::write("📤 Total Processed: " . ($sentCount + $failedCount), 'yellow');
        CLI::write('', 'white');
        
        if ($sentCount > 0) {
            CLI::write('🎉 Scheduled notifications processing completed successfully!', 'green');
        } elseif ($failedCount > 0) {
            CLI::write('⚠️  Some notifications failed to send. Check logs for details.', 'yellow');
        }
    }
}