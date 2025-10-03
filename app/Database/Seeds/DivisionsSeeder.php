<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DivisionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Human Resources',
                'description' => 'Manages employee relations, recruitment, training, and organizational development.',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Finance',
                'description' => 'Handles financial planning, budgeting, accounting, and financial reporting.',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Operations',
                'description' => 'Oversees daily business operations, processes, and service delivery.',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Information Technology',
                'description' => 'Manages technology infrastructure, systems development, and digital solutions.',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Marketing',
                'description' => 'Develops marketing strategies, brand management, and promotional activities.',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Guest Services',
                'description' => 'Provides exceptional customer service and manages guest experiences.',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Food & Beverage',
                'description' => 'Manages restaurant operations, menu planning, and beverage services.',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Housekeeping',
                'description' => 'Maintains cleanliness, sanitation, and aesthetic standards across facilities.',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Security',
                'description' => 'Ensures safety, security, and compliance with safety protocols.',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Maintenance',
                'description' => 'Handles facility maintenance, repairs, and technical support services.',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
        ];

        // Insert divisions data
        $this->db->table('divisions')->insertBatch($data);
        
        log_message('info', 'DivisionsSeeder: Successfully seeded ' . count($data) . ' divisions');
    }
}
