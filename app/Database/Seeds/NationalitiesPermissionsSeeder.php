<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NationalitiesPermissionsSeeder extends Seeder
{
    public function run()
    {
        // First, let's get the permissions table data
        $permissionsData = [
            [
                'name' => 'nationalities.view',
                'description' => 'View nationalities'
            ],
            [
                'name' => 'nationalities.create',
                'description' => 'Create new nationalities'
            ],
            [
                'name' => 'nationalities.edit',
                'description' => 'Edit existing nationalities'
            ],
            [
                'name' => 'nationalities.delete',
                'description' => 'Delete nationalities'
            ]
        ];

        // Insert permissions if they don't exist
        foreach ($permissionsData as $permission) {
            $existing = $this->db->table('auth_permissions')
                                ->where('name', $permission['name'])
                                ->get()
                                ->getRowArray();
            
            if (!$existing) {
                $this->db->table('auth_permissions')->insert($permission);
                log_message('info', 'NationalitiesPermissionsSeeder: Created permission ' . $permission['name']);
            } else {
                log_message('info', 'NationalitiesPermissionsSeeder: Permission ' . $permission['name'] . ' already exists');
            }
        }

        // Get admin and manager groups
        $adminGroup = $this->db->table('auth_groups')->where('name', 'admin')->get()->getRowArray();
        $managerGroup = $this->db->table('auth_groups')->where('name', 'manager')->get()->getRowArray();

        if ($adminGroup) {
            // Assign all nationalities permissions to admin group
            foreach ($permissionsData as $permission) {
                $permissionRecord = $this->db->table('auth_permissions')
                                            ->where('name', $permission['name'])
                                            ->get()
                                            ->getRowArray();
                
                if ($permissionRecord) {
                    // Check if permission is already assigned to admin group
                    $existing = $this->db->table('auth_groups_permissions')
                                        ->where('group_id', $adminGroup['id'])
                                        ->where('permission_id', $permissionRecord['id'])
                                        ->get()
                                        ->getRowArray();
                    
                    if (!$existing) {
                        $this->db->table('auth_groups_permissions')->insert([
                            'group_id' => $adminGroup['id'],
                            'permission_id' => $permissionRecord['id']
                        ]);
                        log_message('info', 'NationalitiesPermissionsSeeder: Assigned ' . $permission['name'] . ' to admin group');
                    }
                }
            }
        }

        if ($managerGroup) {
            // Assign all nationalities permissions to manager group
            foreach ($permissionsData as $permission) {
                $permissionRecord = $this->db->table('auth_permissions')
                                            ->where('name', $permission['name'])
                                            ->get()
                                            ->getRowArray();
                
                if ($permissionRecord) {
                    // Check if permission is already assigned to manager group
                    $existing = $this->db->table('auth_groups_permissions')
                                        ->where('group_id', $managerGroup['id'])
                                        ->where('permission_id', $permissionRecord['id'])
                                        ->get()
                                        ->getRowArray();
                    
                    if (!$existing) {
                        $this->db->table('auth_groups_permissions')->insert([
                            'group_id' => $managerGroup['id'],
                            'permission_id' => $permissionRecord['id']
                        ]);
                        log_message('info', 'NationalitiesPermissionsSeeder: Assigned ' . $permission['name'] . ' to manager group');
                    }
                }
            }
        }

        log_message('info', 'NationalitiesPermissionsSeeder: Completed successfully');
    }
}