<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyLogsActionFieldToText extends Migration
{
    public function up()
    {
        // Modify the action field to TEXT to allow longer log entries
        $this->forge->modifyColumn('logs', [
            'action' => [
                'type'       => 'TEXT',
                'null'       => false,
                'comment'    => 'Action performed with detailed information',
            ]
        ]);
    }

    public function down()
    {
        // Revert back to VARCHAR(255) - Note: this might truncate data if entries are longer
        $this->forge->modifyColumn('logs', [
            'action' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'comment'    => 'Action performed (create, update, delete, etc.)',
            ]
        ]);
    }
}
