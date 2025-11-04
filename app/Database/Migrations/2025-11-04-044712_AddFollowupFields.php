<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFollowupFields extends Migration
{
    public function up()
    {
        // Add fields to question_options table
        $this->forge->addColumn('question_options', [
            'has_followup' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Whether selecting this option triggers a follow-up question'
            ],
            'followup_label' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'comment' => 'Label for the follow-up text input field'
            ],
            'followup_placeholder' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'comment' => 'Placeholder text for the follow-up input field'
            ],
            'followup_required' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Whether the follow-up field is required when shown'
            ]
        ]);
    }

    public function down()
    {
        // Remove the added fields
        $this->forge->dropColumn('question_options', [
            'has_followup',
            'followup_label', 
            'followup_placeholder',
            'followup_required'
        ]);
    }
}
