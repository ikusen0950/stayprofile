<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AssignAdminToAdminGroupSeeder extends Seeder
{
    public function run()
    {
        // Get admin user (ID: 1)
        $adminUser = $this->db->table('users')->where('id', 1)->get()->getRow();
        
        if ($adminUser) {
            echo "Found admin user: {$adminUser->username}\n";
            
            // Get admin group (ID: 1)
            $adminGroup = $this->db->table('auth_groups')->where('name', 'admin')->get()->getRow();
            
            if ($adminGroup) {
                echo "Found admin group: {$adminGroup->name}\n";
                
                // Check if user is already in admin group
                $existing = $this->db->table('auth_groups_users')
                                    ->where('user_id', $adminUser->id)
                                    ->where('group_id', $adminGroup->id)
                                    ->get()
                                    ->getRow();
                
                if (!$existing) {
                    // Assign admin user to admin group
                    $this->db->table('auth_groups_users')->insert([
                        'user_id' => $adminUser->id,
                        'group_id' => $adminGroup->id
                    ]);
                    echo "Assigned admin user to admin group!\n";
                } else {
                    echo "Admin user is already in admin group!\n";
                }
            } else {
                echo "Admin group not found!\n";
            }
        } else {
            echo "Admin user not found!\n";
        }
        
        echo "Admin group assignment completed!\n";
    }
}