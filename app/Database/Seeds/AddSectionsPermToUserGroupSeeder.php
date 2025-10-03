<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddSectionsPermToUserGroupSeeder extends Seeder
{
    public function run()
    {
        // Get user group
        $userGroup = $this->db->table('auth_groups')
                             ->where('name', 'user')
                             ->get()
                             ->getRow();

        if ($userGroup) {
            // Get sections.view permission
            $sectionsViewPerm = $this->db->table('auth_permissions')
                                        ->where('name', 'sections.view')
                                        ->get()
                                        ->getRow();

            if ($sectionsViewPerm) {
                // Check if assignment already exists
                $existing = $this->db->table('auth_groups_permissions')
                                    ->where('group_id', $userGroup->id)
                                    ->where('permission_id', $sectionsViewPerm->id)
                                    ->get()
                                    ->getRow();

                if (!$existing) {
                    $this->db->table('auth_groups_permissions')->insert([
                        'group_id' => $userGroup->id,
                        'permission_id' => $sectionsViewPerm->id
                    ]);
                    echo "Assigned sections.view permission to user group\n";
                } else {
                    echo "sections.view permission already assigned to user group\n";
                }
            } else {
                echo "sections.view permission not found!\n";
            }
        } else {
            echo "User group not found!\n";
        }

        echo "User group sections permission setup completed!\n";
    }
}