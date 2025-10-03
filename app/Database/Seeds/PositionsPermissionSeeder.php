<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PositionsPermissionSeeder extends Seeder
{
    public function run()
    {
        // Define permissions for positions module
        $permissions = [
            [
                'name' => 'positions.view',
                'description' => 'Can view positions'
            ],
            [
                'name' => 'positions.create',
                'description' => 'Can create new positions'
            ],
            [
                'name' => 'positions.edit',
                'description' => 'Can edit existing positions'
            ],
            [
                'name' => 'positions.delete',
                'description' => 'Can delete positions'
            ]
        ];

        // Insert permissions
        foreach ($permissions as $permission) {
            $this->db->table('auth_permissions')->insert($permission);
        }

        echo "Positions permissions created successfully!" . PHP_EOL;
        
        // Get admin role ID
        $adminRole = $this->db->table('auth_groups')->where('name', 'admin')->get()->getRowArray();
        
        if ($adminRole) {
            // Get the permission IDs
            $permissionIds = $this->db->table('auth_permissions')
                ->whereIn('name', array_column($permissions, 'name'))
                ->get()->getResultArray();
            
            // Assign all permissions to admin role
            foreach ($permissionIds as $permission) {
                $this->db->table('auth_groups_permissions')->insert([
                    'group_id' => $adminRole['id'],
                    'permission_id' => $permission['id']
                ]);
            }
            
            echo "Positions permissions assigned to admin role!" . PHP_EOL;
        }
    }
}
