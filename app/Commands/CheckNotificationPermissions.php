<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CheckNotificationPermissions extends BaseCommand
{
    protected $group = 'Database';
    protected $name = 'permissions:check-notifications';
    protected $description = 'Check notification permissions in the database';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        // Get all notification permissions
        $permissions = $db->table('auth_permissions')
            ->like('name', 'notifications.', 'after')
            ->get()
            ->getResultArray();
            
        if (empty($permissions)) {
            CLI::error('No notification permissions found!');
            return;
        }
        
        CLI::write('Notification Permissions:', 'green');
        CLI::write('------------------------', 'green');
        
        foreach ($permissions as $permission) {
            CLI::write("ID: {$permission['id']} | Name: {$permission['name']} | Description: {$permission['description']}", 'white');
        }
        
        CLI::write('------------------------', 'green');
        CLI::write('Total notification permissions: ' . count($permissions), 'yellow');
    }
}