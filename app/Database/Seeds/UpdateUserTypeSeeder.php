<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateUserTypeSeeder extends Seeder
{
    public function run()
    {
        // Update test user to be an islander
        $this->db->table('users')
                 ->where('id', 3)
                 ->update([
                     'type' => 1,
                     'type_description' => 'Islander'
                 ]);

        echo "Updated user 3 to be an islander\n";
    }
}