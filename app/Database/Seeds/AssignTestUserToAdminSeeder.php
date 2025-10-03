<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AssignTestUserToAdminSeeder extends Seeder
{
    public function run()
    {
        // Get testuser
        $testUser = $this->db->table('users')
                            ->where('username', 'testuser')
                            ->get()
                            ->getRow();

        // Get admin group
        $adminGroup = $this->db->table('auth_groups')
                              ->where('name', 'admin')
                              ->get()
                              ->getRow();

        if ($testUser && $adminGroup) {
            // Check if assignment already exists
            $existing = $this->db->table('auth_groups_users')
                                ->where('user_id', $testUser->id)
                                ->where('group_id', $adminGroup->id)
                                ->get()
                                ->getRow();

            if (!$existing) {
                // Remove from user group first
                $this->db->table('auth_groups_users')
                         ->where('user_id', $testUser->id)
                         ->delete();

                // Add to admin group
                $this->db->table('auth_groups_users')->insert([
                    'user_id' => $testUser->id,
                    'group_id' => $adminGroup->id
                ]);
                echo "Assigned testuser to admin group\n";
            } else {
                echo "testuser already assigned to admin group\n";
            }
        } else {
            echo "testuser or admin group not found!\n";
        }

        echo "testuser admin assignment completed!\n";
    }
}