<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRulesConfigColumn extends Migration
{
    public function up()
    {
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