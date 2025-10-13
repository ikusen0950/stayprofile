<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class FixAuthorizationSampleData extends BaseCommand
{
    protected $group       = 'Development';
    protected $name        = 'fix:authorization-sample-data';
    protected $description = 'Insert correct sample data for authorization rules';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        CLI::write('Checking existing users...', 'green');
        
        // Get existing users
        $users = $db->table('users')->select('id, username')->get()->getResultArray();
        
        CLI::write('Available users:', 'yellow');
        foreach ($users as $user) {
            CLI::write("  ID: {$user['id']}, Username: {$user['username']}");
        }

        // Clear existing authorization rules first
        CLI::write('Clearing existing authorization rules...', 'green');
        $db->table('authorization_rules')->truncate();

        // Insert sample data with existing user IDs
        CLI::write('Inserting sample data...', 'green');
        
        $sampleData = [];
        
        // Add admin user rule (assuming user ID 1 exists - this is typically the admin)
        $sampleData[] = [
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
        ];

        // Add additional rules for existing users if any
        if (count($users) > 1) {
            foreach ($users as $index => $user) {
                if ($user['id'] == 1) continue; // Skip admin user
                
                if ($index == 1) {
                    // Second user gets division rule
                    $sampleData[] = [
                        'user_id' => $user['id'],
                        'rule_type' => 'division',
                        'target_type' => 'both',
                        'division_ids' => json_encode([1]),
                        'department_ids' => null,
                        'section_ids' => null,
                        'is_active' => 1,
                        'description' => "Division 1 Manager - can see all users in division 1 (User: {$user['username']})",
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => 1
                    ];
                } else if ($index == 2) {
                    // Third user gets department rule
                    $sampleData[] = [
                        'user_id' => $user['id'],
                        'rule_type' => 'department',
                        'target_type' => 'both',
                        'division_ids' => null,
                        'department_ids' => json_encode([1, 3, 4]),
                        'section_ids' => null,
                        'is_active' => 1,
                        'description' => "Multi-department Manager - can see users in departments 1, 3, and 4 (User: {$user['username']})",
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => 1
                    ];
                    break; // Only need 3 sample records
                }
            }
        }

        try {
            $db->table('authorization_rules')->insertBatch($sampleData);
            CLI::write('✓ Sample data inserted successfully!', 'light_green');
            
            CLI::newLine();
            CLI::write('Sample authorization rules created:', 'green');
            foreach ($sampleData as $rule) {
                CLI::write("  User ID {$rule['user_id']}: {$rule['description']}");
            }

        } catch (\Exception $e) {
            CLI::write('✗ Error inserting sample data: ' . $e->getMessage(), 'red');
        }
    }
}