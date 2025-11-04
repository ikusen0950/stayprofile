<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsActiveToQuestionOptions extends Migration
{
    public function up()
    {
        $this->forge->addColumn('question_options', [
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => false,
                'after' => 'sort_order'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('question_options', 'is_active');
    }
}
