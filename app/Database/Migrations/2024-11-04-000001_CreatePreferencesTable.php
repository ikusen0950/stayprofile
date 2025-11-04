<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePreferencesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'guest_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'question_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'answer_text' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'answer_values_json' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'followup_text' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addForeignKey('guest_id', 'guests', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('question_id', 'questions', 'id', 'CASCADE', 'CASCADE');
        
        // Add unique constraint to prevent duplicate entries for same guest and question
        $this->forge->addUniqueKey(['guest_id', 'question_id']);
        
        // Add indexes for better performance
        $this->forge->addKey('guest_id');
        $this->forge->addKey('question_id');
        
        $this->forge->createTable('preferences');
    }

    public function down()
    {
        $this->forge->dropTable('preferences');
    }
}