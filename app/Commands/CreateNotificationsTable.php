<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateNotificationsTable extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:create-notifications';
    protected $description = 'Creates the notifications table directly';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        CLI::write('Creating notifications table...', 'yellow');

        // Drop table if exists (to start fresh)
        $db->query("DROP TABLE IF EXISTS notifications");
        CLI::write('Dropped existing table if any', 'blue');

        // Create the notifications table
        $sql = "CREATE TABLE notifications (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id INT(11) UNSIGNED NOT NULL,
            title VARCHAR(255) NOT NULL,
            body TEXT NULL,
            url VARCHAR(500) NULL,
            status_id INT(11) UNSIGNED NOT NULL DEFAULT 1,
            created_at DATETIME NULL,
            PRIMARY KEY (id),
            CONSTRAINT notifications_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT notifications_status_id_foreign FOREIGN KEY (status_id) REFERENCES status(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";

        try {
            $db->query($sql);
            CLI::write('✓ Notifications table created successfully!', 'green');
            
            // Now update the migrations table to mark this migration as run
            // First get the max batch number
            $batchResult = $db->query("SELECT COALESCE(MAX(batch), 0) as max_batch FROM migrations");
            $maxBatch = $batchResult->getRow()->max_batch + 1;
            
            $migrationSql = "INSERT INTO migrations (version, class, `group`, namespace, time, batch) 
                             VALUES ('2025-10-18-054347', 'App\\\\Database\\\\Migrations\\\\CreateNotificationsTable', 'default', 'App', " . time() . ", {$maxBatch})";
            
            $db->query($migrationSql);
            CLI::write('✓ Migration tracking updated!', 'green');
            
        } catch (\Exception $e) {
            CLI::write('✗ Error: ' . $e->getMessage(), 'red');
            return;
        }

        // Verify the table was created
        $result = $db->query("SHOW TABLES LIKE 'notifications'");
        if ($result->getNumRows() > 0) {
            CLI::write('✓ Notifications table exists in database', 'green');
            
            // Show table structure
            $structure = $db->query("DESCRIBE notifications");
            CLI::write("\nTable structure:", 'yellow');
            foreach ($structure->getResultArray() as $column) {
                CLI::write("  - {$column['Field']} ({$column['Type']})", 'blue');
            }
        } else {
            CLI::write('✗ Notifications table was not created', 'red');
        }
    }
}
