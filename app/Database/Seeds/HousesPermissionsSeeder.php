<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HousesPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'name' => 'houses.view',
                'description' => 'View houses list and details',
            ],
            [
                'name' => 'houses.create',
                'description' => 'Create new houses',
            ],
            [
                'name' => 'houses.edit',
                'description' => 'Edit existing houses',
            ],
            [
                'name' => 'houses.delete',
                'description' => 'Delete houses',
            ],
        ];

        // Insert permissions into the auth_permissions table
        $this->db->table('auth_permissions')->insertBatch($permissions);
        
        echo "Houses permissions seeder completed successfully.\n";
    }
}
