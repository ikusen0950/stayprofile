<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InsertNationalityDeleteLog extends Seeder
{
    public function run()
    {
        $data = [
            'status_id'  => 5, // Deleted status
            'module_id'  => 10, // Nationality module
            'action'     => 'Nationality Deleted #251 - dada',
            'user_id'    => 1, // Admin user
            'logged_at'  => date('Y-m-d H:i:s')
        ];

        // Insert the log entry
        $this->db->table('logs')->insert($data);
        
        echo "Nationality delete log inserted successfully!\n";
    }
}