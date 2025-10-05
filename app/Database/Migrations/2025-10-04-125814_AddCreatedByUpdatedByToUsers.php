<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCreatedByUpdatedByToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'ID of user who created this record'
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'ID of user who last updated this record'
            ]
        ]);

        // Add foreign key constraints
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('updated_by', 'users', 'id', 'SET NULL', 'SET NULL');
    }

    public function down()
    {
        // Drop foreign keys first
        $this->forge->dropForeignKey('users', 'users_created_by_foreign');
        $this->forge->dropForeignKey('users', 'users_updated_by_foreign');
        
        // Then drop columns
        $this->forge->dropColumn('users', ['created_by', 'updated_by']);
    }
}
