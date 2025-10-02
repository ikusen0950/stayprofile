<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run()
    {
        // First clear existing data
        $this->db->table('status')->truncate();
        
        $data = [
            [
                'name' => 'Active',
                'module_id' => 1, // User Management
                'color' => '#50cd89',
                'description' => 'Active status for items that are currently in use',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Inactive',
                'module_id' => 1, // User Management
                'color' => '#a1a5b7',
                'description' => 'Inactive status for items that are not currently in use',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Pending',
                'module_id' => 2, // Inventory Management
                'color' => '#ffc700',
                'description' => 'Pending status for items awaiting approval or processing',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Approved',
                'module_id' => 3, // Task Management
                'color' => '#009ef7',
                'description' => 'Approved status for items that have been verified and accepted',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Rejected',
                'module_id' => 3, // Task Management
                'color' => '#f1416c',
                'description' => 'Rejected status for items that have been declined or denied',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'On Hold',
                'module_id' => 4, // Financial Management
                'color' => '#7239ea',
                'description' => 'On hold status for items that are temporarily suspended',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'In Progress',
                'module_id' => 3, // Task Management
                'color' => '#17a2b8',
                'description' => 'Status for items currently being worked on',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Completed',
                'module_id' => 3, // Task Management
                'color' => '#28a745',
                'description' => 'Status for items that have been completed successfully',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert sample data
        $this->db->table('status')->insertBatch($data);
    }
}
