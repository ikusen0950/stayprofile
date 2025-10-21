<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransferCurrentDatePermissionSeeder extends Seeder
{
    public function run()
    {
        // Insert the transfer current date permission
        $permission = [
            'name' => 'requests.create_transfer_current_date',
            'description' => 'Create transfer requests with current date as departure date (bypasses 3-day advance requirement)'
        ];

        // Check if permission already exists
        $existing = $this->db->table('auth_permissions')->where('name', $permission['name'])->get()->getRow();
        
        if (!$existing) {
            $this->db->table('auth_permissions')->insert($permission);
            echo "Permission '{$permission['name']}' created.\n";
        } else {
            echo "Permission '{$permission['name']}' already exists.\n";
        }

        // Assign permission to admin-level groups (they can create transfer requests for current date)  
        $groupPermissions = [
            'admin' => ['requests.create_transfer_current_date'],
            'manager' => ['requests.create_transfer_current_date'],
            'Administrator' => ['requests.create_transfer_current_date'],
            'Manager' => ['requests.create_transfer_current_date']
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