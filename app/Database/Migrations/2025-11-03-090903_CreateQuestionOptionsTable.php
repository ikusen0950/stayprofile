<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuestionOptionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'question_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'label' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('question_id', 'questions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addKey(['question_id', 'sort_order']);
        $this->forge->createTable('question_options');
    }

    public function down()
    {
        $this->forge->dropTable('question_options');
    }
}
