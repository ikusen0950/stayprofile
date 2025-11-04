<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AssignVillaPermissions extends BaseCommand
{
    protected $group       = 'Villa';
    protected $name        = 'villa:assign-permissions';
    protected $description = 'Assign villa permissions to admin group';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        try {
            // Get admin group (assuming it's group 1 or named 'admin')
            $adminGroup = $db->table('auth_groups')
                ->where('id', 1)
                ->orWhere('LOWER(name)', 'admin')
                ->get()
                ->getRowArray();
            
            if (!$adminGroup) {
                CLI::write("Admin group not found. Please check your auth_groups table.", 'red');
                return;
            }
            
            $groupId = $adminGroup['id'];
            CLI::write("Found admin group with ID: " . $groupId . " (Name: " . $adminGroup['name'] . ")", 'green');

            // Get villa permissions
            $villaPerms = ['villas.view', 'villas.create', 'villas.edit', 'villas.delete'];
            
            foreach ($villaPerms as $permName) {
                // Get permission ID
                $permission = $db->table('auth_permissions')
                    ->where('name', $permName)
                    ->get()
                    ->getRowArray();
                
                if (!$permission) {
                    CLI::write("Permission not found: " . $permName, 'red');
                    continue;
                }
                
                $permissionId = $permission['id'];
                
                // Check if assignment already exists
                $existingAssignment = $db->table('auth_groups_permissions')
                    ->where('group_id', $groupId)
                    ->where('permission_id', $permissionId)
                    ->get()
                    ->getRowArray();
                
                if ($existingAssignment) {
                    CLI::write("Permission already assigned: " . $permName, 'yellow');
                } else {
                    // Assign permission to group
                    $assignmentData = [
                        'group_id' => $groupId,
                        'permission_id' => $permissionId
                    ];
                    
                    $result = $db->table('auth_groups_permissions')->insert($assignmentData);
                    
                    if ($result) {
                        CLI::write("Assigned permission: " . $permName, 'green');
                    } else {
                        CLI::write("Failed to assign permission: " . $permName, 'red');
                    }
                }
            }
            
            CLI::write("Villa permissions assignment completed!", 'green');
            CLI::write("You should now be able to access /villas", 'cyan');

        } catch (\Exception $e) {
            CLI::write("Error: " . $e->getMessage(), 'red');
        }
    }
}