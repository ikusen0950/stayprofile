<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthorizationRulesPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Authorization Rules permissions
        $permissions = [
            [
                'name' => 'authorization_rules.create',
                'description' => 'Create new authorization rule entries'
            ],
            [
                'name' => 'authorization_rules.view',
                'description' => 'View authorization rule entries'
            ],
            [
                'name' => 'authorization_rules.edit',
                'description' => 'Edit existing authorization rule entries'
            ],
            [
                'name' => 'authorization_rules.delete',
                'description' => 'Delete authorization rule entries'
            ]
        ];

        foreach ($permissions as $permission) {
            // Check if permission already exists
            $existing = $this->db->table('auth_permissions')
                ->where('name', $permission['name'])
                ->get()
                ->getRow();

            if (!$existing) {
                $this->db->table('auth_permissions')->insert($permission);
                echo "Created permission: {$permission['name']}\n";
            } else {
                echo "Permission already exists: {$permission['name']}\n";
            }
        }

        // Assign permissions to groups
        $groupPermissions = [
            // Admin group gets all permissions
            'admin' => [
                'authorization_rules.create',
                'authorization_rules.view',
                'authorization_rules.edit',
                'authorization_rules.delete'
            ],
            // Manager group gets CRUD permissions
            'manager' => [
                'authorization_rules.create',
                'authorization_rules.view',
                'authorization_rules.edit',
                'authorization_rules.delete'
            ],
            // User group gets only view permissions
            'user' => [
                'authorization_rules.view'
            ]
        ];

        foreach ($groupPermissions as $groupName => $perms) {
            $group = $this->db->table('auth_groups')->where('name', $groupName)->get()->getRow();
            
            if ($group) {
                foreach ($perms as $permName) {
                    $permission = $this->db->table('auth_permissions')->where('name', $permName)->get()->getRow();
                    
                    if ($permission) {
                        // Check if group permission already exists
                        $existing = $this->db->table('auth_groups_permissions')
                            ->where('group_id', $group->id)
                            ->where('permission_id', $permission->id)
                            ->get()
                            ->getRow();

                        if (!$existing) {
                            $this->db->table('auth_groups_permissions')->insert([
                                'group_id' => $group->id,
                                'permission_id' => $permission->id
                            ]);
                            echo "Assigned permission '{$permName}' to group '{$groupName}'\n";
                        } else {
                            echo "Permission '{$permName}' already assigned to group '{$groupName}'\n";
                        }
                    } else {
                        echo "Permission '{$permName}' not found!\n";
                    }
                }
            } else {
                echo "Group '{$groupName}' not found!\n";
            }
        }

        echo "Authorization Rules permissions setup completed!\n";
    }
}