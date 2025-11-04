<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVillasTable extends Migration
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
            'villa_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'villa_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'capacity' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'status_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 1,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('villa_code');
        $this->forge->addKey('status_id');
        $this->forge->createTable('villas');
    }

    public function down()
    {
        $this->forge->dropTable('villas');
    }
}
