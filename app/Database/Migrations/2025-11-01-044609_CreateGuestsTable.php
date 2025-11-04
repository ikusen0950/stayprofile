<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGuestsTable extends Migration
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
            'villa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'arrival_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'departure_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'arrival_to_here' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'departure_from_here' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'inclusive' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'guest_type' => [
                'type'       => 'ENUM',
                'constraint' => ['adult', 'child', 'infant', 'vip', 'other'],
                'default'    => 'adult',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['invited', 'pending', 'submitted', 'checked_in', 'checked_out', 'canceled'],
                'default'    => 'pending',
            ],
            'guest_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'reservation_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('villa_id');
        $this->forge->addKey('guest_token');
        $this->forge->addKey('reservation_code');
        $this->forge->addKey('status');
        $this->forge->addKey('guest_type');
        $this->forge->createTable('guests');
    }

    public function down()
    {
        $this->forge->dropTable('guests');
    }
}
