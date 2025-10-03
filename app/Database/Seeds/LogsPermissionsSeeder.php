<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LogsPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Insert Logs Permissions
        $permissions = [
            [
                'name' => 'logs.view',
                'description' => 'View system logs'
            ]
        ];

        foreach ($permissions as $permission) {
            // Check if permission already exists
            $existing = $this->db->table('auth_permissions')->where('name', $permission['name'])->get()->getRow();
            
            if (!$existing) {
                $this->db->table('auth_permissions')->insert($permission);
                echo "Permission '{$permission['name']}' created.\n";
            } else {
                echo "Permission '{$permission['name']}' already exists.\n";
            }
        }

        // Assign logs permission to admin and manager groups
        $groupPermissions = [
            'admin' => ['logs.view'],
            'manager' => ['logs.view']
        ];

        foreach ($groupPermissions as $groupName => $perms) {
            $group = $this->db->table('auth_groups')->where('name', $groupName)->get()->getRow();
            
            if ($group) {
                foreach ($perms as $permName) {
                    $permission = $this->db->table('auth_permissions')->where('name', $permName)->get()->getRow();
                    
                    if ($permission) {
                        // Check if relationship already exists
                        $existing = $this->db->table('auth_groups_permissions')
                            ->where('group_id', $group->id)
                            ->where('permission_id', $permission->id)
                            ->get()->getRow();

                        if (!$existing) {
                            $this->db->table('auth_groups_permissions')->insert([
                                'group_id' => $group->id,
                                'permission_id' => $permission->id
                            ]);
                            echo "Assigned '{$permName}' to '{$groupName}' group.\n";
                        }
                    }
                }
            }
        }

        echo "Logs permissions setup completed!\n";
    }
}