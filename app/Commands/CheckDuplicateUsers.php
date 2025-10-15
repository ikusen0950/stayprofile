<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CheckDuplicateUsers extends BaseCommand
{
    protected $group       = 'App';
    protected $name        = 'app:check-duplicate-users';
    protected $description = 'Check for duplicate user_ids in authorization_rules';
    protected $usage       = 'app:check-duplicate-users';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        try {
            CLI::write('Checking for duplicate user_ids...', 'yellow');
            
            // Check for duplicates
            $result = $db->query("
                SELECT user_id, COUNT(*) as count 
                FROM authorization_rules 
                WHERE deleted_at IS NULL 
                GROUP BY user_id 
                HAVING count > 1
                ORDER BY count DESC
            ");
            
            $duplicates = $result->getResultArray();
            
            if (empty($duplicates)) {
                CLI::write('No duplicate user_ids found!', 'green');
                
                // Check if unique constraint exists
                $indexes = $db->query("SHOW INDEX FROM authorization_rules WHERE Column_name = 'user_id' AND Non_unique = 0");
                if ($indexes->getNumRows() > 0) {
                    CLI::write('Unique constraint already exists on user_id', 'green');
                } else {
                    CLI::write('Adding unique constraint to user_id...', 'yellow');
                    try {
                        $db->query("ALTER TABLE authorization_rules ADD CONSTRAINT uk_authorization_rules_user_id UNIQUE (user_id)");
                        CLI::write('Unique constraint added successfully!', 'green');
                    } catch (\Exception $e) {
                        CLI::write('Failed to add unique constraint: ' . $e->getMessage(), 'red');
                    }
                }
            } else {
                CLI::write('Found duplicate user_ids:', 'red');
                foreach ($duplicates as $duplicate) {
                    CLI::write("User ID {$duplicate['user_id']}: {$duplicate['count']} records", 'white');
                }
                
                CLI::write('You need to resolve duplicates before adding unique constraint.', 'yellow');
                CLI::write('Options:', 'white');
                CLI::write('1. Delete old records and keep the latest', 'white');
                CLI::write('2. Merge multiple records into single multi-rule record', 'white');
            }
            
        } catch (\Exception $e) {
            CLI::write('Error: ' . $e->getMessage(), 'red');
        }
    }
}