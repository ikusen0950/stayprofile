<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Define the roles data exactly as requested
        $roles = [
            [
                'id' => 1,
                'name' => 'Administrator',
                'description' => 'System Administrator with full access to all features and settings'
            ],
            [
                'id' => 2,
                'name' => 'Islander',
                'description' => 'Regular islander with basic access to personal information and common features'
            ],
            [
                'id' => 3,
                'name' => 'Coordinator',
                'description' => 'Coordinates activities and manages basic operational tasks'
            ],
            [
                'id' => 4,
                'name' => 'Supervisor',
                'description' => 'Supervises operations and has elevated access to monitoring and reporting'
            ],
            [
                'id' => 5,
                'name' => 'Assistant Manager',
                'description' => 'Assists in management duties with access to departmental operations'
            ],
            [
                'id' => 6,
                'name' => 'Manager',
                'description' => 'Manager with comprehensive access to operational management features'
            ],
            [
                'id' => 7,
                'name' => 'Excom',
                'description' => 'Executive Committee member with strategic access and decision-making authority'
            ],
            [
                'id' => 8,
                'name' => 'Visitor',
                'description' => 'Temporary visitor with limited access to public information only'
            ]
        ];

        // Process each role
        foreach ($roles as $role) {
            // Check if role with this ID exists
            $existing = $this->db->table('auth_groups')
                                ->where('id', $role['id'])
                                ->get()
                                ->getRowArray();

            if ($existing) {
                // Update existing role
                $this->db->table('auth_groups')
                         ->where('id', $role['id'])
                         ->update([
                             'name' => $role['name'],
                             'description' => $role['description']
                         ]);
                echo "✓ Updated role ID {$role['id']}: {$role['name']}" . PHP_EOL;
            } else {
                // Insert new role
                $this->db->table('auth_groups')->insert($role);
                echo "✓ Created role ID {$role['id']}: {$role['name']}" . PHP_EOL;
            }
        }

        echo PHP_EOL . "Role seeding completed!" . PHP_EOL;
    }
}