<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeInclusiveToText extends Migration
{
    public function up()
    {
        // Change the inclusive field from TINYINT to TEXT
        $this->forge->modifyColumn('guests', [
            'inclusive' => [
                'name' => 'inclusive',
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        // Revert the inclusive field back to TINYINT
        $this->forge->modifyColumn('guests', [
            'inclusive' => [
                'name'       => 'inclusive',
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
        ]);
    }
}
