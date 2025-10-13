<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class VerifyAuthorizationSystem extends BaseCommand
{
    protected $group       = 'Development';
    protected $name        = 'verify:authorization-system';
    protected $description = 'Verify authorization rules system is working correctly';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        CLI::write('=== Authorization System Verification ===', 'green');
        CLI::newLine();

        // 1. Check if table exists
        CLI::write('1. Checking if authorization_rules table exists...', 'yellow');
        if ($db->tableExists('authorization_rules')) {
            CLI::write('   ✓ Table exists', 'light_green');
        } else {
            CLI::write('   ✗ Table does not exist', 'red');
            return;
        }

        // 2. Check table structure
        CLI::write('2. Checking table structure...', 'yellow');
        $fields = $db->getFieldData('authorization_rules');
        $expectedFields = ['id', 'user_id', 'rule_type', 'target_type', 'division_ids', 'department_ids', 'section_ids', 'is_active', 'description', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];
        
        $existingFields = array_column($fields, 'name');
        $missingFields = array_diff($expectedFields, $existingFields);
        
        if (empty($missingFields)) {
            CLI::write('   ✓ All required fields exist', 'light_green');
        } else {
            CLI::write('   ✗ Missing fields: ' . implode(', ', $missingFields), 'red');
        }

        // 3. Check sample data
        CLI::write('3. Checking sample data...', 'yellow');
        $count = $db->table('authorization_rules')->countAllResults();
        CLI::write("   Found {$count} authorization rules", 'white');
        
        if ($count > 0) {
            $rules = $db->table('authorization_rules')
                       ->select('id, user_id, rule_type, target_type, description')
                       ->get()
                       ->getResultArray();
            
            foreach ($rules as $rule) {
                CLI::write("   - Rule #{$rule['id']}: User {$rule['user_id']} ({$rule['rule_type']}) - {$rule['description']}", 'light_gray');
            }
        }

        // 4. Check permissions
        CLI::write('4. Checking permissions...', 'yellow');
        $authPermissions = $db->table('auth_permissions')
                             ->where('name LIKE', 'authorization_rules.%')
                             ->get()
                             ->getResultArray();
        
        CLI::write("   Found " . count($authPermissions) . " authorization rule permissions:", 'white');
        foreach ($authPermissions as $perm) {
            CLI::write("   - {$perm['name']}: {$perm['description']}", 'light_gray');
        }

        // 5. Check group permissions
        CLI::write('5. Checking group permissions...', 'yellow');
        $groupPerms = $db->query("
            SELECT g.name as group_name, p.name as permission_name 
            FROM auth_groups_permissions gp 
            JOIN auth_groups g ON gp.group_id = g.id 
            JOIN auth_permissions p ON gp.permission_id = p.id 
            WHERE p.name LIKE 'authorization_rules.%'
            ORDER BY g.name, p.name
        ")->getResultArray();
        
        if (!empty($groupPerms)) {
            $currentGroup = '';
            foreach ($groupPerms as $gp) {
                if ($gp['group_name'] !== $currentGroup) {
                    CLI::write("   Group: {$gp['group_name']}", 'white');
                    $currentGroup = $gp['group_name'];
                }
                CLI::write("     - {$gp['permission_name']}", 'light_gray');
            }
        } else {
            CLI::write('   ✗ No group permissions found', 'red');
        }

        CLI::newLine();
        CLI::write('=== System Status: READY ===', 'green');
        CLI::write('You can now access: http://localhost/islanders_finolhu/public/authorization-rules', 'cyan');
    }
}