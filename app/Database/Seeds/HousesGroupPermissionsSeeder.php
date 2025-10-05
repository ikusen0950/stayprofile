<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HousesGroupPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Get the houses permissions IDs
        $permissions = $this->db->table('auth_permissions')
            ->whereIn('name', ['houses.view', 'houses.create', 'houses.edit', 'houses.delete'])
            ->get()
            ->getResultArray();

        // Assign all houses permissions to admin group (group_id = 1)
        $groupPermissions = [];
        foreach ($permissions as $permission) {
            $groupPermissions[] = [
                'group_id' => 1, // admin group
                'permission_id' => $permission['id']
            ];
        }

        // Also assign view and create permissions to manager group (group_id = 2)
        $managerPermissions = [];
        foreach ($permissions as $permission) {
            if (in_array($permission['name'], ['houses.view', 'houses.create', 'houses.edit'])) {
                $managerPermissions[] = [
                    'group_id' => 2, // manager group
                    'permission_id' => $permission['id']
                ];
            }
        }

        // Assign view permission to user group (group_id = 3)
        $userPermissions = [];
        foreach ($permissions as $permission) {
            if ($permission['name'] === 'houses.view') {
                $userPermissions[] = [
                    'group_id' => 3, // user group
                    'permission_id' => $permission['id']
                ];
            }
        }

        // Insert all group permissions
        if (!empty($groupPermissions)) {
            $this->db->table('auth_groups_permissions')->insertBatch($groupPermissions);
        }
        if (!empty($managerPermissions)) {
            $this->db->table('auth_groups_permissions')->insertBatch($managerPermissions);
        }
        if (!empty($userPermissions)) {
            $this->db->table('auth_groups_permissions')->insertBatch($userPermissions);
        }

        echo "Houses group permissions seeder completed successfully.\n";
        echo "Admin: All houses permissions\n";
        echo "Manager: View, Create, Edit houses permissions\n";
        echo "User: View houses permission only\n";
    }
}
