<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddNationalitiesPermToUserGroupSeeder extends Seeder
{
    public function run()
    {
        // Get user group
        $userGroup = $this->db->table('auth_groups')
                             ->where('name', 'user')
                             ->get()
                             ->getRow();

        if ($userGroup) {
            // Get nationalities.view permission
            $nationalitiesViewPerm = $this->db->table('auth_permissions')
                                        ->where('name', 'nationalities.view')
                                        ->get()
                                        ->getRow();

            if ($nationalitiesViewPerm) {
                // Check if assignment already exists
                $existing = $this->db->table('auth_groups_permissions')
                                    ->where('group_id', $userGroup->id)
                                    ->where('permission_id', $nationalitiesViewPerm->id)
                                    ->get()
                                    ->getRow();

                if (!$existing) {
                    $this->db->table('auth_groups_permissions')->insert([
                        'group_id' => $userGroup->id,
                        'permission_id' => $nationalitiesViewPerm->id
                    ]);
                    echo "Assigned nationalities.view permission to user group\n";
                } else {
                    echo "nationalities.view permission already assigned to user group\n";
                }
            } else {
                echo "nationalities.view permission not found!\n";
            }
        } else {
            echo "User group not found!\n";
        }

        echo "User group nationalities permission setup completed!\n";
    }
}