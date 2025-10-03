<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SectionsPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Insert sections permissions
        $permissions = [
            [
                'name' => 'sections.view',
                'description' => 'View sections'
            ],
            [
                'name' => 'sections.create',
                'description' => 'Create sections'
            ],
            [
                'name' => 'sections.edit',
                'description' => 'Edit sections'
            ],
            [
                'name' => 'sections.delete',
                'description' => 'Delete sections'
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

        // Get admin role ID
        $adminRole = $this->db->table('auth_groups')
                             ->where('name', 'admin')
                             ->get()
                             ->getRow();

        if ($adminRole) {
            // Get the sections permissions we just created
            $permissionIds = $this->db->table('auth_permissions')
                                     ->whereIn('name', ['sections.view', 'sections.create', 'sections.edit', 'sections.delete'])
                                     ->get()
                                     ->getResultArray();

            foreach ($permissionIds as $permission) {
                // Check if permission is already assigned to admin role
                $existing = $this->db->table('auth_groups_permissions')
                                    ->where('group_id', $adminRole->id)
                                    ->where('permission_id', $permission['id'])
                                    ->get()
                                    ->getRow();

                if (!$existing) {
                    $this->db->table('auth_groups_permissions')->insert([
                        'group_id' => $adminRole->id,
                        'permission_id' => $permission['id']
                    ]);
                    echo "Assigned {$permission['name']} to admin role\n";
                } else {
                    echo "Permission {$permission['name']} already assigned to admin role\n";
                }
            }
        } else {
            echo "Admin role not found!\n";
        }

        echo "Sections permissions setup completed!\n";
    }
}