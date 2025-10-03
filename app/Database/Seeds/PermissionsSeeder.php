<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Insert Groups
        $groups = [
            [
                'name' => 'admin',
                'description' => 'System Administrator - Full access to all features'
            ],
            [
                'name' => 'manager',
                'description' => 'Manager - Can create, edit, view, and delete content'
            ],
            [
                'name' => 'user',
                'description' => 'Regular User - Can view content only'
            ]
        ];

        foreach ($groups as $group) {
            $this->db->table('auth_groups')->insert($group);
        }

        // Insert Permissions
        $permissions = [
            // Status Permissions
            [
                'name' => 'status.create',
                'description' => 'Create new status entries'
            ],
            [
                'name' => 'status.view',
                'description' => 'View status entries'
            ],
            [
                'name' => 'status.edit',
                'description' => 'Edit existing status entries'
            ],
            [
                'name' => 'status.delete',
                'description' => 'Delete status entries'
            ],
            // Module Permissions
            [
                'name' => 'modules.create',
                'description' => 'Create new modules'
            ],
            [
                'name' => 'modules.view',
                'description' => 'View modules'
            ],
            [
                'name' => 'modules.edit',
                'description' => 'Edit existing modules'
            ],
            [
                'name' => 'modules.delete',
                'description' => 'Delete modules'
            ],
            // System Permissions
            [
                'name' => 'system.admin',
                'description' => 'Full system administration access'
            ]
        ];

        foreach ($permissions as $permission) {
            $this->db->table('auth_permissions')->insert($permission);
        }

        // Assign permissions to groups
        $groupPermissions = [
            // Admin group gets all permissions
            'admin' => [
                'status.create', 'status.view', 'status.edit', 'status.delete',
                'modules.create', 'modules.view', 'modules.edit', 'modules.delete',
                'system.admin'
            ],
            // Manager group gets CRUD permissions but not system admin
            'manager' => [
                'status.create', 'status.view', 'status.edit', 'status.delete',
                'modules.create', 'modules.view', 'modules.edit', 'modules.delete'
            ],
            // User group gets only view permissions
            'user' => [
                'status.view', 'modules.view'
            ]
        ];

        foreach ($groupPermissions as $groupName => $perms) {
            $group = $this->db->table('auth_groups')->where('name', $groupName)->get()->getRow();
            
            if ($group) {
                foreach ($perms as $permName) {
                    $permission = $this->db->table('auth_permissions')->where('name', $permName)->get()->getRow();
                    
                    if ($permission) {
                        $this->db->table('auth_groups_permissions')->insert([
                            'group_id' => $group->id,
                            'permission_id' => $permission->id
                        ]);
                    }
                }
            }
        }

        // Assign admin user to admin group
        $adminUser = $this->db->table('users')->where('username', 'admin')->get()->getRow();
        $adminGroup = $this->db->table('auth_groups')->where('name', 'admin')->get()->getRow();

        if ($adminUser && $adminGroup) {
            // Check if relationship already exists
            $existing = $this->db->table('auth_groups_users')
                ->where('user_id', $adminUser->id)
                ->where('group_id', $adminGroup->id)
                ->get()->getRow();

            if (!$existing) {
                $this->db->table('auth_groups_users')->insert([
                    'user_id' => $adminUser->id,
                    'group_id' => $adminGroup->id
                ]);
            }
        }

        echo "Permissions, groups, and user assignments created successfully!\n";
    }
}