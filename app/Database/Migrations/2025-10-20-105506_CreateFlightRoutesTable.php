<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFlightRoutesTable extends Migration
{
    public function up()
    {
        // If the table already exists, skip creation to make this migration idempotent
        if ($this->db->tableExists('flight_routes')) {
            return;
        }

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
            'status_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true,
                'default' => 1, // Default to active status
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
        $this->forge->addKey('created_by');
        $this->forge->addKey('updated_by');
        $this->forge->addKey('status_id');
    // Add foreign key constraints before creating the table so they are included
    // in the create statement where supported by the DB driver
    $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'CASCADE');
    $this->forge->addForeignKey('updated_by', 'users', 'id', 'SET NULL', 'CASCADE');
    $this->forge->addForeignKey('status_id', 'status', 'id', 'SET NULL', 'CASCADE');

    $this->forge->createTable('flight_routes', true);
    }

    public function down()
    {
        $this->forge->dropTable('flight_routes');
    }
}
