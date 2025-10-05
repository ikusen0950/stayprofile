<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IslandersModuleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name' => 'Islanders',
            'description' => 'Islander management module for tracking islander operations and activities',
            'created_by' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Insert the module
        $this->db->table('modules')->insert($data);
        
        echo "Islanders module added successfully.\n";
    }
}
