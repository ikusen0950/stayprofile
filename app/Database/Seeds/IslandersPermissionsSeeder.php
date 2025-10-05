<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IslandersPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Insert islanders permissions
        $permissions = [
            [
                'name' => 'islanders.view',
                'description' => 'View islanders list and details',
            ],
            [
                'name' => 'islanders.create',
                'description' => 'Create new islanders',
            ],
            [
                'name' => 'islanders.edit',
                'description' => 'Edit existing islanders',
            ],
            [
                'name' => 'islanders.delete',
                'description' => 'Delete islanders',
            ],
        ];

        // Insert permissions (check if they exist first)
        foreach ($permissions as $permission) {
            $existing = $this->db->table('auth_permissions')->where('name', $permission['name'])->get()->getRow();
            if (!$existing) {
                $this->db->table('auth_permissions')->insert($permission);
                echo "Created permission: " . $permission['name'] . "\n";
            } else {
                echo "Permission already exists: " . $permission['name'] . "\n";
            }
        }

        // Get the permission IDs
        $permissions_data = [];
        $permissions_data['view'] = $this->db->table('auth_permissions')->where('name', 'islanders.view')->get()->getRow();
        $permissions_data['create'] = $this->db->table('auth_permissions')->where('name', 'islanders.create')->get()->getRow();
        $permissions_data['edit'] = $this->db->table('auth_permissions')->where('name', 'islanders.edit')->get()->getRow();
        $permissions_data['delete'] = $this->db->table('auth_permissions')->where('name', 'islanders.delete')->get()->getRow();

        if (!$permissions_data['view'] || !$permissions_data['create'] || !$permissions_data['edit'] || !$permissions_data['delete']) {
            echo "Error: Some permissions were not created properly\n";
            return;
        }

        // Assign permissions to admin group (group id 1)
        $groupPermissions = [
            ['group_id' => 1, 'permission_id' => $permissions_data['view']->id],
            ['group_id' => 1, 'permission_id' => $permissions_data['create']->id],
            ['group_id' => 1, 'permission_id' => $permissions_data['edit']->id],
            ['group_id' => 1, 'permission_id' => $permissions_data['delete']->id],
        ];

        foreach ($groupPermissions as $groupPermission) {
            $existing = $this->db->table('auth_groups_permissions')
                ->where('group_id', $groupPermission['group_id'])
                ->where('permission_id', $groupPermission['permission_id'])
                ->get()->getRow();
            
            if (!$existing) {
                $this->db->table('auth_groups_permissions')->insert($groupPermission);
                echo "Assigned permission ID " . $groupPermission['permission_id'] . " to admin group\n";
            } else {
                echo "Permission ID " . $groupPermission['permission_id'] . " already assigned to admin group\n";
            }
        }

        echo "Islanders permissions setup completed!\n";
    }
}
