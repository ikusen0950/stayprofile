<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AddScheduledNotificationFields extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:add-scheduled-fields';
    protected $description = 'Add scheduled notification fields to notifications table';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        CLI::write('🔧 Adding scheduled notification fields to notifications table...', 'yellow');
        
        try {
            // Check if columns already exist
            $fieldsToAdd = [
                'scheduled_at' => "ALTER TABLE notifications ADD COLUMN scheduled_at DATETIME NULL AFTER created_at",
                'sent_at' => "ALTER TABLE notifications ADD COLUMN sent_at DATETIME NULL AFTER scheduled_at", 
                'error_message' => "ALTER TABLE notifications ADD COLUMN error_message TEXT NULL AFTER sent_at"
            ];
            
            $existingColumns = $db->getFieldNames('notifications');
            
            foreach ($fieldsToAdd as $field => $sql) {
                if (!in_array($field, $existingColumns)) {
                    $db->query($sql);
                    CLI::write("✅ Added column: {$field}", 'green');
                } else {
                    CLI::write("⚠️  Column {$field} already exists, skipping...", 'yellow');
                }
            }
            
            // Add index for scheduled_at for better performance
            $indexes = $db->query("SHOW INDEX FROM notifications WHERE Key_name = 'idx_scheduled_at'")->getResult();
            if (empty($indexes)) {
                $db->query("ALTER TABLE notifications ADD INDEX idx_scheduled_at (scheduled_at)");
                CLI::write("✅ Added index on scheduled_at", 'green');
            } else {
                CLI::write("⚠️  Index on scheduled_at already exists, skipping...", 'yellow');
            }
            
            CLI::write('', 'white');
            CLI::write('🎉 Scheduled notification fields added successfully!', 'green');
            CLI::write('', 'white');
            CLI::write('📝 You can now:', 'blue');
            CLI::write('   • Schedule notifications for future delivery', 'white');
            CLI::write('   • Track when notifications were sent', 'white');
            CLI::write('   • Store error messages for failed notifications', 'white');
            CLI::write('', 'white');
            CLI::write('⏰ To process scheduled notifications, run:', 'blue');
            CLI::write('   php spark notifications:process-scheduled', 'cyan');
            CLI::write('', 'white');
            CLI::write('🔄 Consider setting up a cron job to run this command every minute:', 'yellow');
            CLI::write('   * * * * * cd /path/to/your/app && php spark notifications:process-scheduled', 'white');
            
        } catch (\Exception $e) {
            CLI::write('❌ Error: ' . $e->getMessage(), 'red');
            return;
        }
    }
}