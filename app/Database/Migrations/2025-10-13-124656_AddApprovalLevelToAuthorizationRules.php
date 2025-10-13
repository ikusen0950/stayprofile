<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddApprovalLevelToAuthorizationRules extends Migration
{
    public function up()
    {
        $this->forge->addColumn('authorization_rules', [
            'approval_level' => [
                'type' => 'ENUM',
                'constraint' => ['level_1', 'level_2', 'level_3', 'no_approval'],
                'default' => 'no_approval',
                'null' => false,
                'after' => 'target_type',
                'comment' => 'Authorization approval level required'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('authorization_rules', 'approval_level');
    }
}
