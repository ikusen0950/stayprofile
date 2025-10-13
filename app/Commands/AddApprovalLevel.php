<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AddApprovalLevel extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'app:add-approval-level';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Add approval_level column to authorization_rules table';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'app:add-approval-level';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $db = \Config\Database::connect();

        try {
            // Check if the authorization_rules table exists
            $tableExists = $db->query("SHOW TABLES LIKE 'authorization_rules'")->getRow();
            
            if (!$tableExists) {
                CLI::error('authorization_rules table does not exist yet. Creating it first...');
                
                // Create the authorization_rules table first
                $createTableSQL = "
                CREATE TABLE `authorization_rules` (
                    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `user_id` INT(11) UNSIGNED NOT NULL,
                    `rule_type` ENUM('all','division','department','section') NOT NULL DEFAULT 'all',
                    `target_type` ENUM('islanders','visitors','both') NOT NULL DEFAULT 'both',
                    `approval_level` ENUM('level_1', 'level_2', 'level_3', 'no_approval') DEFAULT 'no_approval' NOT NULL,
                    `division_ids` JSON NULL,
                    `department_ids` JSON NULL,
                    `section_ids` JSON NULL,
                    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
                    `description` TEXT NULL,
                    `created_by` INT(11) UNSIGNED NULL,
                    `created_at` DATETIME NULL,
                    `updated_by` INT(11) UNSIGNED NULL,
                    `updated_at` DATETIME NULL,
                    `deleted_at` DATETIME NULL,
                    PRIMARY KEY (`id`),
                    INDEX `idx_user_id` (`user_id`),
                    INDEX `idx_rule_type` (`rule_type`),
                    INDEX `idx_target_type` (`target_type`),
                    INDEX `idx_approval_level` (`approval_level`),
                    INDEX `idx_is_active` (`is_active`),
                    INDEX `idx_deleted_at` (`deleted_at`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
                ";
                
                $db->query($createTableSQL);
                CLI::write('authorization_rules table created with approval_level column.', 'green');
                
            } else {
                // Check if approval_level column already exists
                $columnExists = $db->query("SHOW COLUMNS FROM authorization_rules LIKE 'approval_level'")->getRow();
                
                if (!$columnExists) {
                    // Add the approval_level column
                    $addColumnSQL = "ALTER TABLE authorization_rules ADD COLUMN approval_level ENUM('level_1', 'level_2', 'level_3', 'no_approval') DEFAULT 'no_approval' NOT NULL AFTER target_type";
                    $db->query($addColumnSQL);
                    CLI::write('approval_level column added successfully to authorization_rules table.', 'green');
                } else {
                    CLI::write('approval_level column already exists in authorization_rules table.', 'yellow');
                }
            }
            
            // Verify the column was added
            $columns = $db->query("SHOW COLUMNS FROM authorization_rules")->getResultArray();
            CLI::newLine();
            CLI::write('Current authorization_rules table structure:', 'light_blue');
            foreach ($columns as $column) {
                CLI::write('- ' . $column['Field'] . ' (' . $column['Type'] . ')', 'white');
            }
            
        } catch (\Exception $e) {
            CLI::error('Error: ' . $e->getMessage());
        }
    }
}
