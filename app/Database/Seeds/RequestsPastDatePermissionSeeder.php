<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RequestsPastDatePermissionSeeder extends Seeder
{
    public function run()
    {
        // Insert the past date permission
        $permission = [
            'name' => 'requests.create_past_date',
            'description' => 'Create requests with past dates (departure/arrival)'
        ];

        // Check if permission already exists
        $existing = $this->db->table('auth_permissions')->where('name', $permission['name'])->get()->getRow();
        
        if (!$existing) {
            $this->db->table('auth_permissions')->insert($permission);
            echo "Permission '{$permission['name']}' created.\n";
        } else {
            echo "Permission '{$permission['name']}' already exists.\n";
        }

        // Assign permission to admin-level groups (they can create past date requests)  
        $groupPermissions = [
            'admin' => ['requests.create_past_date'],
            'manager' => ['requests.create_past_date'],
            'Administrator' => ['requests.create_past_date'],
            'Manager' => ['requests.create_past_date']
        ];

        foreach ($groupPermissions as $groupName => $perms) {
            $group = $this->db->table('auth_groups')->where('name', $groupName)->get()->getRow();
            
            if ($group) {
                foreach ($perms as $permName) {
                    $permission = $this->db->table('auth_permissions')->where('name', $permName)->get()->getRow();
                    
                    if ($permission) {
                        // Check if group-permission assignment already exists
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
                            echo "Assigned '{$permName}' permission to '{$groupName}' group.\n";
                        } else {
                            echo "Permission '{$permName}' already assigned to '{$groupName}' group.\n";
                        }
                    }
                }
            } else {
                echo "Group '{$groupName}' not found.\n";
            }
        }
    }
}