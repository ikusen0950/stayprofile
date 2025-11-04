<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AddVillaModule extends BaseCommand
{
    protected $group       = 'Villa';
    protected $name        = 'villa:add-module';
    protected $description = 'Add villa module to the modules table';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        try {
            // Check if villa module already exists
            $existingModule = $db->table('modules')
                ->where('LOWER(name)', 'villas')
                ->get()
                ->getRowArray();
            
            if ($existingModule) {
                CLI::write("Villa module already exists with ID: " . $existingModule['id'], 'yellow');
                CLI::write("Name: " . $existingModule['name']);
                CLI::write("Status ID: " . $existingModule['status_id']);
                return;
            }

            // Get an active status ID (assuming 1 is active)
            $activeStatus = $db->table('status')
                ->where('LOWER(name)', 'active')
                ->orWhere('id', 1)
                ->get()
                ->getRowArray();
            
            $statusId = $activeStatus ? $activeStatus['id'] : 1;
            
            // Insert the villa module
            $moduleData = [
                'name' => 'Villas',
                'status_id' => $statusId,
                'description' => 'Villa management module for tracking accommodation facilities',
                'created_by' => 1, // Assuming admin user ID is 1
                'created_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $result = $db->table('modules')->insert($moduleData);
            
            if ($result) {
                $insertId = $db->insertID();
                CLI::write("Successfully created villa module with ID: " . $insertId, 'green');
                
                // Now check for villas permissions in auth_groups_permissions
                $villaPerms = ['villas.view', 'villas.create', 'villas.edit', 'villas.delete'];
                
                CLI::write("Checking for villa permissions...", 'yellow');
                
                foreach ($villaPerms as $perm) {
                    $existingPerm = $db->table('auth_permissions')
                        ->where('name', $perm)
                        ->get()
                        ->getRowArray();
                    
                    if (!$existingPerm) {
                        $permData = [
                            'name' => $perm,
                            'description' => ucfirst(str_replace('.', ' ', $perm)) . ' permission'
                        ];
                        
                        $permResult = $db->table('auth_permissions')->insert($permData);
                        if ($permResult) {
                            CLI::write("Created permission: " . $perm, 'green');
                        }
                    } else {
                        CLI::write("Permission already exists: " . $perm, 'yellow');
                    }
                }
                
                CLI::write("Villa module setup completed!", 'green');
                CLI::write("Please update VillasController.php line 96 to use module_id: " . $insertId, 'cyan');
            } else {
                CLI::write("Failed to create villa module", 'red');
                print_r($db->error());
            }

        } catch (\Exception $e) {
            CLI::write("Error: " . $e->getMessage(), 'red');
        }
    }
}