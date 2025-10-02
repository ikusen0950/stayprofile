<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateAdminAgreementSeeder extends Seeder
{
    public function run()
    {
        // Update admin user to not have accepted agreement for testing
        $builder = $this->db->table('users');
        $result = $builder->where('username', 'admin')->update(['has_accepted_agreement' => 0]);
        
        if ($result) {
            echo "Admin user agreement status updated to 0 (will show modal on next login)\n";
        } else {
            echo "Failed to update admin user or user not found\n";
        }
    }
}
