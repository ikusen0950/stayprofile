<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HousesModuleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'status_id' => 1,
            'name' => 'Houses',
            'description' => 'Module for managing houses with color functionality',
            'created_by' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Insert the houses module
        $this->db->table('modules')->insert($data);
        
        echo "Houses module seeder completed successfully.\n";
    }
}
