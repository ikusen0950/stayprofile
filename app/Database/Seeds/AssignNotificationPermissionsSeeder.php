<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AssignNotificationPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Get Administrator group ID (should be 1)
        $adminGroup = $this->db->table('auth_groups')
            ->where('name', 'Administrator')
            ->get()
            ->getRow();
            
        if (!$adminGroup) {
            echo "Administrator group not found!\n";
            return;
        }
        
        // Get all notification permissions
        $notificationPermissions = $this->db->table('auth_permissions')
            ->like('name', 'notifications.', 'after')
            ->get()
            ->getResult();
            
        if (empty($notificationPermissions)) {
            echo "No notification permissions found!\n";
            return;
        }
        
        echo "Assigning notification permissions to Administrator group...\n";
        
        foreach ($notificationPermissions as $permission) {
            // Check if permission is already assigned
            $existing = $this->db->table('auth_groups_permissions')
                ->where('group_id', $adminGroup->id)
                ->where('permission_id', $permission->id)
                ->get()
                ->getRow();
                
            if (!$existing) {
                $this->db->table('auth_groups_permissions')->insert([
                    'group_id' => $adminGroup->id,
                    'permission_id' => $permission->id
                ]);
                echo "Assigned permission: {$permission->name} to Administrator group\n";
            } else {
                echo "Permission already assigned: {$permission->name}\n";
            }
        }
        
        echo "Notification permissions assignment completed!\n";
    }
}