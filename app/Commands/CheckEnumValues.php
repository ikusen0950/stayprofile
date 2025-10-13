<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CheckEnumValues extends BaseCommand
{
    protected $group       = 'App';
    protected $name        = 'app:check-enums';
    protected $description = 'Check and fix ENUM values for authorization_rules table';
    protected $usage       = 'app:check-enums';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        try {
            CLI::write('Checking ENUM values...', 'yellow');
            
            // Get column information including ENUM values
            $result = $db->query("SHOW COLUMNS FROM authorization_rules WHERE Field IN ('rule_type', 'target_type', 'approval_level')");
            $columns = $result->getResultArray();
            
            foreach ($columns as $column) {
                CLI::write("Column: {$column['Field']}", 'white');
                CLI::write("Type: {$column['Type']}", 'white');
                
                // Check if 'multiple' is in the ENUM values
                if (strpos($column['Type'], "'multiple'") === false) {
                    CLI::write("'multiple' not found in {$column['Field']} ENUM. Adding it...", 'yellow');
                    
                    // Extract current ENUM values and add 'multiple'
                    preg_match("/enum\(([^)]+)\)/", $column['Type'], $matches);
                    if (isset($matches[1])) {
                        $enumValues = $matches[1] . ",'multiple'";
                        $sql = "ALTER TABLE authorization_rules MODIFY COLUMN {$column['Field']} ENUM({$enumValues})";
                        
                        CLI::write("Executing: {$sql}", 'white');
                        
                        if ($db->query($sql)) {
                            CLI::write("Successfully updated {$column['Field']}", 'green');
                        } else {
                            CLI::write("Failed to update {$column['Field']}", 'red');
                        }
                    }
                } else {
                    CLI::write("'multiple' already exists in {$column['Field']}", 'green');
                }
                CLI::write('---', 'white');
            }
            
            // Final check
            CLI::write('Final ENUM values:', 'yellow');
            $finalResult = $db->query("SHOW COLUMNS FROM authorization_rules WHERE Field IN ('rule_type', 'target_type', 'approval_level')");
            $finalColumns = $finalResult->getResultArray();
            
            foreach ($finalColumns as $column) {
                CLI::write("{$column['Field']}: {$column['Type']}", 'white');
            }
            
        } catch (\Exception $e) {
            CLI::write('Error: ' . $e->getMessage(), 'red');
        }
    }
}