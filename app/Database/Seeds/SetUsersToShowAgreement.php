<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SetUsersToShowAgreement extends Seeder
{
    public function run()
    {
        // Update all users to have has_accepted_agreement = 1 (which now means show modal)
        $builder = $this->db->table('users');
        $result = $builder->update(['has_accepted_agreement' => 1]);
        
        if ($result) {
            echo "All users updated to show agreement modal (has_accepted_agreement = 1)\n";
        } else {
            echo "Failed to update users\n";
        }
    }
}
