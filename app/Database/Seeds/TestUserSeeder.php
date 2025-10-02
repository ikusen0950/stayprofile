<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'testuser',
            'email' => 'testuser@finolhu.com',
            'password_hash' => password_hash('testpassword', PASSWORD_DEFAULT),
            'active' => 1,
            'status' => 'active',
            'has_accepted_agreement' => 0, // This user hasn't accepted the agreement
            'full_name' => 'Test User',
            'islander_no' => '10002',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Check if user already exists
        $builder = $this->db->table('users');
        $existingUser = $builder->where('email', $data['email'])->get()->getRow();
        
        if (!$existingUser) {
            $builder->insert($data);
            echo "Test user created successfully!\n";
            echo "Email: testuser@finolhu.com\n";
            echo "Password: testpassword\n";
            echo "Agreement Status: Not Accepted (will show modal)\n";
        } else {
            echo "Test user already exists!\n";
        }
    }
}
