<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CheckRulesConfig extends BaseCommand
{
    protected $group       = 'App';
    protected $name        = 'app:check-rules-config';
    protected $description = 'Check what is stored in rules_config field';
    protected $usage       = 'app:check-rules-config';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        try {
            CLI::write('Checking rules_config data...', 'yellow');
            
            // Get the latest records with rules_config
            $result = $db->query("SELECT id, user_id, rule_type, rules_config FROM authorization_rules WHERE rules_config IS NOT NULL ORDER BY id DESC LIMIT 3");
            $records = $result->getResultArray();
            
            foreach ($records as $record) {
                CLI::write("Record ID: {$record['id']}", 'white');
                CLI::write("User ID: {$record['user_id']}", 'white');
                CLI::write("Rule Type: {$record['rule_type']}", 'white');
                CLI::write("Rules Config:", 'white');
                
                // Pretty print the JSON
                $rulesConfig = json_decode($record['rules_config'], true);
                if ($rulesConfig) {
                    foreach ($rulesConfig as $index => $rule) {
                        CLI::write("  Rule " . ($index + 1) . ":", 'cyan');
                        CLI::write("    Rule Type: " . ($rule['rule_type'] ?? 'N/A'), 'white');
                        CLI::write("    Target Type: " . ($rule['target_type'] ?? 'N/A'), 'white');
                        CLI::write("    Approval Level: " . ($rule['approval_level'] ?? 'N/A'), 'white');
                        CLI::write("    Division IDs: " . json_encode($rule['division_ids'] ?? []), 'white');
                        CLI::write("    Department IDs: " . json_encode($rule['department_ids'] ?? []), 'white');
                        CLI::write("    Section IDs: " . json_encode($rule['section_ids'] ?? []), 'white');
                    }
                } else {
                    CLI::write("  Invalid JSON: " . $record['rules_config'], 'red');
                }
                CLI::write('---', 'white');
            }
            
        } catch (\Exception $e) {
            CLI::write('Error: ' . $e->getMessage(), 'red');
        }
    }
}