<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateAuthorizationTable extends BaseCommand
{
    protected $group       = 'Development';
    protected $name        = 'create:authorization-table';
    protected $description = 'Create authorization_rules table manually';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        // Check if table already exists
        if ($db->tableExists('authorization_rules')) {
            CLI::write('Table authorization_rules already exists!', 'yellow');
            return;
        }

        CLI::write('Creating authorization_rules table...', 'green');

        try {
            // Create the table
            $sql = "CREATE TABLE `authorization_rules` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` INT(11) UNSIGNED NOT NULL COMMENT 'User who has this authorization rule',
                `rule_type` ENUM('all', 'division', 'department', 'section') NOT NULL DEFAULT 'division' COMMENT 'Type of authorization: all (admin), division, department, or section',
                `target_type` ENUM('islanders', 'visitors', 'both') NOT NULL DEFAULT 'both' COMMENT 'What type of users this rule applies to',
                `division_ids` TEXT NULL COMMENT 'JSON array of division IDs user can access (for division/department rules)',
                `department_ids` TEXT NULL COMMENT 'JSON array of department IDs user can access (for department rules)',
                `section_ids` TEXT NULL COMMENT 'JSON array of section IDs user can access (for section rules)',
                `is_active` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
                `description` TEXT NULL COMMENT 'Optional description of this authorization rule',
                `created_by` INT(11) UNSIGNED NULL,
                `updated_by` INT(11) UNSIGNED NULL,
                `created_at` DATETIME NULL,
                `updated_at` DATETIME NULL,
                `deleted_at` DATETIME NULL,
                PRIMARY KEY (`id`),
                KEY `idx_user_id` (`user_id`),
                KEY `idx_rule_type` (`rule_type`),
                KEY `idx_target_type` (`target_type`),
                KEY `idx_is_active` (`is_active`),
                KEY `idx_deleted_at` (`deleted_at`),
                CONSTRAINT `fk_authorization_rules_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_authorization_rules_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                CONSTRAINT `fk_authorization_rules_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

            $db->query($sql);
            CLI::write('✓ Table created successfully!', 'light_green');

            // Insert sample data
            CLI::write('Inserting sample data...', 'green');
            
            $sampleData = [
                [
                    'user_id' => 1,
                    'rule_type' => 'all',
                    'target_type' => 'both',
                    'division_ids' => null,
                    'department_ids' => null,
                    'section_ids' => null,
                    'is_active' => 1,
                    'description' => 'Administrator - can see all users',
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => 1
                ],
                [
                    'user_id' => 2,
                    'rule_type' => 'division',
                    'target_type' => 'both',
                    'division_ids' => json_encode([1]),
                    'department_ids' => null,
                    'section_ids' => null,
                    'is_active' => 1,
                    'description' => 'Division 1 Manager - can see all users in division 1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => 1
                ],
                [
                    'user_id' => 3,
                    'rule_type' => 'department',
                    'target_type' => 'both',
                    'division_ids' => null,
                    'department_ids' => json_encode([1, 3, 4]),
                    'section_ids' => null,
                    'is_active' => 1,
                    'description' => 'Multi-department Manager - can see users in departments 1, 3, and 4',
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => 1
                ]
            ];

            $db->table('authorization_rules')->insertBatch($sampleData);
            CLI::write('✓ Sample data inserted successfully!', 'light_green');

            CLI::newLine();
            CLI::write('Authorization rules table setup completed!', 'green');

        } catch (\Exception $e) {
            CLI::write('✗ Error creating table: ' . $e->getMessage(), 'red');
        }
    }
}