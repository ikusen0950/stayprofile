<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class FixAuthorizationPermissions extends BaseCommand
{
    protected $group       = 'Development';
    protected $name        = 'fix:authorization-permissions';
    protected $description = 'Fix authorization permissions for proper groups';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        // Assign permissions to groups
        $groupPermissions = [
            // Administrator group gets all permissions
            'Administrator' => [
                'authorization_rules.create',
                'authorization_rules.view',
                'authorization_rules.edit',
                'authorization_rules.delete'
            ],
            // Manager group gets all permissions
            'Manager' => [
                'authorization_rules.create',
                'authorization_rules.view',
                'authorization_rules.edit',
                'authorization_rules.delete'
            ],
            // Assistant Manager gets view and create
            'Assistant Manager' => [
                'authorization_rules.create',
                'authorization_rules.view',
                'authorization_rules.edit'
            ],
            // Excom gets view and create
            'Excom' => [
                'authorization_rules.create',
                'authorization_rules.view',
                'authorization_rules.edit'
            ],
            // Supervisor gets view
            'Supervisor' => [
                'authorization_rules.view'
            ],
            // Coordinator gets view
            'Coordinator' => [
                'authorization_rules.view'
            ]
        ];

        foreach ($groupPermissions as $groupName => $perms) {
            $group = $db->table('auth_groups')->where('name', $groupName)->get()->getRow();
            
            if ($group) {
                CLI::write("Processing group: {$groupName}", 'green');
                
                foreach ($perms as $permName) {
                    $permission = $db->table('auth_permissions')->where('name', $permName)->get()->getRow();
                    
                    if ($permission) {
                        // Check if group permission already exists
                        $existing = $db->table('auth_groups_permissions')
                            ->where('group_id', $group->id)
                            ->where('permission_id', $permission->id)
                            ->get()
                            ->getRow();

                        if (!$existing) {
                            $db->table('auth_groups_permissions')->insert([
                                'group_id' => $group->id,
                                'permission_id' => $permission->id
                            ]);
                            CLI::write("  ✓ Assigned permission '{$permName}' to group '{$groupName}'", 'light_green');
                        } else {
                            CLI::write("  - Permission '{$permName}' already assigned to group '{$groupName}'", 'yellow');
                        }
                    } else {
                        CLI::write("  ✗ Permission '{$permName}' not found!", 'red');
                    }
                }
            } else {
                CLI::write("✗ Group '{$groupName}' not found!", 'red');
            }
        }

        CLI::newLine();
        CLI::write('Authorization Rules permissions assignment completed!', 'green');
    }
}