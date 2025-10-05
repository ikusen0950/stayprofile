<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHousesTable extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
                'null' => true,
                'comment' => 'Hex color code for the house'
            ],
            'status_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 1,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('name');
        $this->forge->addKey('status_id');
        $this->forge->addKey('created_by');
        $this->forge->addKey('updated_by');
        
        $this->forge->createTable('houses');
        
        // Add foreign key constraints
        $this->forge->addForeignKey('status_id', 'status', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('updated_by', 'users', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('houses');
    }
}
