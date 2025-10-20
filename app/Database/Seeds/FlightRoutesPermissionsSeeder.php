<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FlightRoutesPermissionsSeeder extends Seeder
{
    public function run()
    {
        // First, let's get the permissions table data
        $permissionsData = [
            [
                'name' => 'flight-routes.view',
                'description' => 'View flight routes'
            ],
            [
                'name' => 'flight-routes.create',
                'description' => 'Create new flight routes'
            ],
            [
                'name' => 'flight-routes.edit',
                'description' => 'Edit existing flight routes'
            ],
            [
                'name' => 'flight-routes.delete',
                'description' => 'Delete flight routes'
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
                log_message('info', 'FlightRoutesPermissionsSeeder: Created permission ' . $permission['name']);
            } else {
                log_message('info', 'FlightRoutesPermissionsSeeder: Permission ' . $permission['name'] . ' already exists');
            }
        }

        // Get Administrator and Manager groups
        $adminGroup = $this->db->table('auth_groups')->where('name', 'Administrator')->get()->getRowArray();
        $managerGroup = $this->db->table('auth_groups')->where('name', 'Manager')->get()->getRowArray();

        if ($adminGroup) {
            // Assign all flight-routes permissions to admin group
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
                        log_message('info', 'FlightRoutesPermissionsSeeder: Assigned ' . $permission['name'] . ' to Administrator group');
                    }
                }
            }
        }

        if ($managerGroup) {
            // Assign all flight-routes permissions to manager group
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
                        log_message('info', 'FlightRoutesPermissionsSeeder: Assigned ' . $permission['name'] . ' to Manager group');
                    }
                }
            }
        }

        log_message('info', 'FlightRoutesPermissionsSeeder: Completed successfully');
    }
}