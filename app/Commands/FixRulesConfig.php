<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class FixRulesConfig extends BaseCommand
{
    protected $group       = 'App';
    protected $name        = 'app:fix-rules-config';
    protected $description = 'Fix rules_config column issue';
    protected $usage       = 'app:fix-rules-config';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        try {
            CLI::write('Checking current table structure...', 'yellow');
            
            // Get current columns
            $fields = $db->getFieldData('authorization_rules');
            $columnNames = [];
            foreach ($fields as $field) {
                $columnNames[] = $field->name;
                CLI::write("Column: {$field->name} ({$field->type})", 'white');
            }
            
            if (!in_array('rules_config', $columnNames)) {
                CLI::write('Adding rules_config column...', 'yellow');
                
                // Try different approaches to add the column
                $sqls = [
                    "ALTER TABLE authorization_rules ADD rules_config LONGTEXT NULL",
                    "ALTER TABLE authorization_rules ADD rules_config TEXT NULL",
                    "ALTER TABLE authorization_rules ADD COLUMN rules_config TEXT NULL"
                ];
                
                foreach ($sqls as $sql) {
                    try {
                        CLI::write("Trying: {$sql}", 'white');
                        $result = $db->query($sql);
                        if ($result) {
                            CLI::write('Success!', 'green');
                            break;
                        }
                    } catch (\Exception $e) {
                        CLI::write("Failed: " . $e->getMessage(), 'red');
                    }
                }
                
            } else {
                CLI::write('Column rules_config already exists!', 'green');
            }
            
            // Final check
            CLI::write('Final table structure:', 'yellow');
            $finalFields = $db->getFieldData('authorization_rules');
            foreach ($finalFields as $field) {
                CLI::write("Column: {$field->name} ({$field->type})", 'white');
            }
            
        } catch (\Exception $e) {
            CLI::write('Error: ' . $e->getMessage(), 'red');
        }
    }
}