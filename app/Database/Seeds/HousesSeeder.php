<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HousesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Gryffindor',
                'description' => 'House of the brave, daring, nerve, and chivalry. Known for their courage and determination.',
                'color' => '#DC143C',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Hufflepuff',
                'description' => 'House of hard work, patience, loyalty, and fair play. Known for their dedication and loyalty.',
                'color' => '#FFD700',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Ravenclaw',
                'description' => 'House of intelligence, wit, learning, and wisdom. Known for their cleverness and creativity.',
                'color' => '#0E1A40',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Slytherin',
                'description' => 'House of ambition, cunning, leadership, and resourcefulness. Known for their determination and leadership.',
                'color' => '#1A472A',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Phoenix House',
                'description' => 'House of rebirth, renewal, and transformation. Known for their resilience and ability to rise from challenges.',
                'color' => '#FF4500',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Dragon House',
                'description' => 'House of power, strength, and protection. Known for their fierce loyalty and protective nature.',
                'color' => '#8B0000',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Eagle House',
                'description' => 'House of vision, freedom, and perspective. Known for their ability to see the bigger picture.',
                'color' => '#4169E1',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ],
            [
                'name' => 'Wolf House',
                'description' => 'House of teamwork, loyalty, and pack mentality. Known for their collaborative spirit.',
                'color' => '#696969',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1, // Admin user
            ]
        ];

        // Insert data into the houses table
        $this->db->table('houses')->insertBatch($data);
        
        echo "Houses seeder completed successfully.\n";
    }
}
