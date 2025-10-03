<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FixUserGroupsSeeder extends Seeder
{
    public function run()
    {
        // Get admin user
        $adminUser = $this->db->table('users')
                             ->where('username', 'admin')
                             ->get()
                             ->getRow();

        // Get admin group
        $adminGroup = $this->db->table('auth_groups')
                              ->where('name', 'admin')
                              ->get()
                              ->getRow();

        if ($adminUser && $adminGroup) {
            // Check if assignment already exists
            $existing = $this->db->table('auth_groups_users')
                                ->where('user_id', $adminUser->id)
                                ->where('group_id', $adminGroup->id)
                                ->get()
                                ->getRow();

            if (!$existing) {
                $this->db->table('auth_groups_users')->insert([
                    'user_id' => $adminUser->id,
                    'group_id' => $adminGroup->id
                ]);
                echo "Assigned admin user to admin group\n";
            } else {
                echo "Admin user already assigned to admin group\n";
            }
        } else {
            echo "Admin user or admin group not found!\n";
        }

        // Display current user group assignments
        $assignments = $this->db->query("
            SELECT u.username, g.name as group_name 
            FROM users u 
            LEFT JOIN auth_groups_users agu ON u.id = agu.user_id 
            LEFT JOIN auth_groups g ON agu.group_id = g.id
        ")->getResultArray();

        echo "\nCurrent user group assignments:\n";
        foreach ($assignments as $assignment) {
            echo "User: {$assignment['username']} - Group: " . ($assignment['group_name'] ?? 'No group') . "\n";
        }

        echo "\nUser groups fix completed!\n";
    }
}