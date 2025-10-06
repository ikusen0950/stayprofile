<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VisitorsPermissionsSeeder extends Seeder
{
    public function run()
    {
        // First, let's get the permissions table data
        $permissionsData = [
            [
                'name' => 'visitors.view',
                'description' => 'View visitors'
            ],
            [
                'name' => 'visitors.create',
                'description' => 'Create new visitors'
            ],
            [
                'name' => 'visitors.edit',
                'description' => 'Edit existing visitors'
            ],
            [
                'name' => 'visitors.delete',
                'description' => 'Delete visitors'
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
                log_message('info', 'VisitorsPermissionsSeeder: Created permission ' . $permission['name']);
            } else {
                log_message('info', 'VisitorsPermissionsSeeder: Permission ' . $permission['name'] . ' already exists');
            }
        }

        // Get admin and manager groups
        $adminGroup = $this->db->table('auth_groups')->where('name', 'admin')->get()->getRowArray();
        $managerGroup = $this->db->table('auth_groups')->where('name', 'manager')->get()->getRowArray();
        $userGroup = $this->db->table('auth_groups')->where('name', 'user')->get()->getRowArray();

        if ($adminGroup) {
            // Assign all visitors permissions to admin group
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
                        log_message('info', 'VisitorsPermissionsSeeder: Assigned ' . $permission['name'] . ' to admin group');
                    }
                }
            }
        }

        if ($managerGroup) {
            // Assign all visitors permissions to manager group
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
                        log_message('info', 'VisitorsPermissionsSeeder: Assigned ' . $permission['name'] . ' to manager group');
                    }
                }
            }
        }

        if ($userGroup) {
            // Assign limited visitors permissions to user group (view only by default)
            $userPermissions = ['visitors.view'];
            
            foreach ($userPermissions as $permissionName) {
                $permissionRecord = $this->db->table('auth_permissions')
                                            ->where('name', $permissionName)
                                            ->get()
                                            ->getRowArray();
                
                if ($permissionRecord) {
                    // Check if permission is already assigned to user group
                    $existing = $this->db->table('auth_groups_permissions')
                                        ->where('group_id', $userGroup['id'])
                                        ->where('permission_id', $permissionRecord['id'])
                                        ->get()
                                        ->getRowArray();
                    
                    if (!$existing) {
                        $this->db->table('auth_groups_permissions')->insert([
                            'group_id' => $userGroup['id'],
                            'permission_id' => $permissionRecord['id']
                        ]);
                        log_message('info', 'VisitorsPermissionsSeeder: Assigned ' . $permissionName . ' to user group');
                    }
                }
            }
        }

        log_message('info', 'VisitorsPermissionsSeeder: Completed successfully');
    }
}