<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AddRulesConfigColumn extends BaseCommand
{
    protected $group       = 'App';
    protected $name        = 'app:add-rules-config';
    protected $description = 'Add rules_config column to authorization_rules table';
    protected $usage       = 'app:add-rules-config';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        try {
            // Check if column already exists
            $columns = $db->getFieldNames('authorization_rules');
            
            if (in_array('rules_config', $columns)) {
                CLI::write('Column rules_config already exists!', 'yellow');
                return;
            }
            
            // Add the rules_config column
            $sql = "ALTER TABLE authorization_rules ADD COLUMN rules_config JSON NULL COMMENT 'JSON configuration for multiple rules in single record'";
            
            CLI::write('Adding rules_config column to authorization_rules table...', 'yellow');
            
            if ($db->query($sql)) {
                CLI::write('Successfully added rules_config column!', 'green');
                
                // Verify the column was added
                $newColumns = $db->getFieldNames('authorization_rules');
                if (in_array('rules_config', $newColumns)) {
                    CLI::write('Column verified in table structure.', 'green');
                } else {
                    CLI::write('Warning: Column may not have been added properly.', 'red');
                }
            } else {
                CLI::write('Failed to add rules_config column.', 'red');
                CLI::write('SQL Error: ' . $db->error(), 'red');
            }
            
        } catch (\Exception $e) {
            CLI::write('Error: ' . $e->getMessage(), 'red');
        }
    }
}