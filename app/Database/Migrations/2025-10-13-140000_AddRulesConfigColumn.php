<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRulesConfigColumn extends Migration
{
    public function up()
    {
        // Skip if column already exists
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('authorization_rules');
        if (in_array('rules_config', $fields)) {
            return;
        }

        $this->forge->addColumn('authorization_rules', [
            'rules_config' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'JSON configuration for multiple rules in single record'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('authorization_rules', 'rules_config');
    }
}