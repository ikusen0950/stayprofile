<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NotificationPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'name' => 'notifications.create',
                'description' => 'Create new notifications'
            ],
            [
                'name' => 'notifications.view',
                'description' => 'View notifications'
            ],
            [
                'name' => 'notifications.edit',
                'description' => 'Edit existing notifications'
            ],
            [
                'name' => 'notifications.delete',
                'description' => 'Delete notifications'
            ],
            [
                'name' => 'notifications.send',
                'description' => 'Send push notifications'
            ],
            [
                'name' => 'notifications.manage',
                'description' => 'Manage notification settings and tokens'
            ],
            [
                'name' => 'notifications.admin',
                'description' => 'Full notification system administration'
            ]
        ];

        // Check if permissions already exist to avoid duplicates
        foreach ($permissions as $permission) {
            $existing = $this->db->table('auth_permissions')
                ->where('name', $permission['name'])
                ->get()
                ->getRow();
                
            if (!$existing) {
                $this->db->table('auth_permissions')->insert($permission);
                echo "Added permission: {$permission['name']}\n";
            } else {
                echo "Permission already exists: {$permission['name']}\n";
            }
        }
    }
}