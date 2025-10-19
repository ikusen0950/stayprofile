<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class NotificationPermissionsSummary extends BaseCommand
{
    protected $group = 'Notifications';
    protected $name = 'notifications:permissions-summary';
    protected $description = 'Show summary of notification permissions and group assignments';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        CLI::write('=== NOTIFICATION PERMISSIONS SUMMARY ===', 'yellow');
        CLI::newLine();
        
        // Get all notification permissions
        $permissions = $db->table('auth_permissions')
            ->like('name', 'notifications.', 'after')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();
            
        if (empty($permissions)) {
            CLI::error('No notification permissions found!');
            return;
        }
        
        CLI::write('📋 AVAILABLE PERMISSIONS:', 'green');
        CLI::write('------------------------', 'white');
        
        foreach ($permissions as $permission) {
            CLI::write("• {$permission['name']}", 'cyan');
            CLI::write("  └─ {$permission['description']}", 'white');
        }
        
        CLI::newLine();
        
        // Get group assignments
        CLI::write('👥 GROUP ASSIGNMENTS:', 'green');
        CLI::write('--------------------', 'white');
        
        $groupAssignments = $db->table('auth_groups_permissions gp')
            ->select('g.name as group_name, p.name as permission_name, p.description')
            ->join('auth_groups g', 'g.id = gp.group_id')
            ->join('auth_permissions p', 'p.id = gp.permission_id')
            ->like('p.name', 'notifications.', 'after')
            ->orderBy('g.name, p.name')
            ->get()
            ->getResultArray();
            
        $currentGroup = '';
        foreach ($groupAssignments as $assignment) {
            if ($currentGroup !== $assignment['group_name']) {
                $currentGroup = $assignment['group_name'];
                CLI::newLine();
                CLI::write("🔐 {$currentGroup}:", 'yellow');
            }
            CLI::write("  ✓ {$assignment['permission_name']}", 'green');
        }
        
        CLI::newLine();
        CLI::write('📊 STATISTICS:', 'green');
        CLI::write('-------------', 'white');
        CLI::write('Total notification permissions: ' . count($permissions), 'cyan');
        CLI::write('Total group assignments: ' . count($groupAssignments), 'cyan');
        
        // Usage examples
        CLI::newLine();
        CLI::write('🔧 USAGE IN CONTROLLERS:', 'green');
        CLI::write('------------------------', 'white');
        CLI::write("has_permission('notifications.view')    - View notifications", 'white');
        CLI::write("has_permission('notifications.create')  - Create notifications", 'white');
        CLI::write("has_permission('notifications.edit')    - Edit notifications", 'white');
        CLI::write("has_permission('notifications.delete')  - Delete notifications", 'white');
        CLI::write("has_permission('notifications.send')    - Send push notifications", 'white');
        CLI::write("has_permission('notifications.manage')  - Manage FCM tokens", 'white');
        CLI::write("has_permission('notifications.admin')   - Full admin access", 'white');
        
        CLI::newLine();
    }
}