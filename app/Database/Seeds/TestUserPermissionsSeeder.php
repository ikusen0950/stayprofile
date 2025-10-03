<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestUserPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create a test user with limited permissions
        $userData = [
            'status_id' => 7, // Active status
            'islander_no' => '10002',
            'full_name' => 'Test User Limited',
            'id_pp_wp_no' => 'T10002',
            'division_id' => 1,
            'department_id' => 1,
            'section_id' => 1,
            'position_id' => 1,
            'on_leave_status' => 0,
            'nationality' => '',
            'date_of_joining' => '',
            'date_of_birth' => '',
            'company' => '',
            'house_id' => null,
            'departed_date' => null,
            'arrival_date' => null,
            'gender_id' => null,
            'image' => '',
            'cover_image' => '',
            'password_changed' => 0,
            'type' => 0,
            'type_description' => 'Regular User',
            'out_of_office' => 0,
            'has_accepted_agreement' => 0,
            'device_token' => '',
            'last_seen' => null,
            'email' => 'testuser@finolhu.com',
            'username' => 'testuser',
            'password_hash' => '$2y$10$Ri5JjT/nPr6FJH7d8R1A.u1X4k8mC.zzp8qNhGPvQKvX5MJ.rJ8K6', // password: 123456
            'reset_hash' => null,
            'reset_at' => null,
            'reset_expires' => null,
            'activate_hash' => null,
            'status' => null,
            'status_message' => null,
            'active' => 1,
            'force_pass_reset' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => null
        ];

        // Insert test user
        $testUserId = $this->db->table('users')->insert($userData);
        
        if (!$testUserId) {
            // Try to get existing user
            $existingUser = $this->db->table('users')->where('username', 'testuser')->get()->getRow();
            if ($existingUser) {
                $testUserId = $existingUser->id;
            }
        } else {
            $testUserId = $this->db->insertID();
        }

        if ($testUserId) {
            // Get the 'user' group (view only permissions)
            $userGroup = $this->db->table('auth_groups')->where('name', 'user')->get()->getRow();
            
            if ($userGroup) {
                // Check if relationship already exists
                $existing = $this->db->table('auth_groups_users')
                    ->where('user_id', $testUserId)
                    ->where('group_id', $userGroup->id)
                    ->get()->getRow();

                if (!$existing) {
                    $this->db->table('auth_groups_users')->insert([
                        'user_id' => $testUserId,
                        'group_id' => $userGroup->id
                    ]);
                }
            }

            echo "Test user 'testuser' created with limited permissions (view only)!\n";
            echo "Login credentials: testuser / 123456\n";
        } else {
            echo "Failed to create test user.\n";
        }
    }
}