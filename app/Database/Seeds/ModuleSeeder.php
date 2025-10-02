<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'status_id' => 1, // Active
                'name' => 'User Management',
                'description' => 'Module for managing users, roles, and permissions',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'status_id' => 1, // Active
                'name' => 'Inventory Management',
                'description' => 'Module for managing inventory, stock, and warehouses',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'status_id' => 1, // Active
                'name' => 'Task Management',
                'description' => 'Module for managing tasks, projects, and workflows',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'status_id' => 1, // Active
                'name' => 'Financial Management',
                'description' => 'Module for managing finances, budgets, and accounting',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'status_id' => 1, // Active
                'name' => 'Communication',
                'description' => 'Module for internal communications and messaging',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert sample data
        $this->db->table('modules')->insertBatch($data);
    }
}
