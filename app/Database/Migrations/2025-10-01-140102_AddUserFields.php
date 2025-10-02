<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserFields extends Migration
{
    public function up()
    {
        // Add new fields to users table
        $fields = [
            'status_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'id'
            ],
            'islander_no' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'status_id'
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'islander_no'
            ],
            'id_pp_wp_no' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'full_name'
            ],
            'division_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'id_pp_wp_no'
            ],
            'department_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'division_id'
            ],
            'section_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'department_id'
            ],
            'position_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'section_id'
            ],
            'on_leave_status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
                'after' => 'position_id'
            ],
            'nationality' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'on_leave_status'
            ],
            'date_of_joining' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'nationality'
            ],
            'date_of_birth' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'date_of_joining'
            ],
            'company' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'date_of_birth'
            ],
            'house_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'company'
            ],
            'departed_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'house_id'
            ],
            'arrival_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'departed_date'
            ],
            'gender_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'arrival_date'
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'gender_id'
            ],
            'cover_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'image'
            ],
            'password_changed' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
                'after' => 'cover_image'
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'password_changed'
            ],
            'type_description' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'type'
            ],
            'out_of_office' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
                'after' => 'type_description'
            ],
            'has_accepted_agreement' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
                'after' => 'out_of_office'
            ],
            'device_token' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'has_accepted_agreement'
            ],
            'last_seen' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'device_token'
            ]
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        // Remove the added fields
        $fields = [
            'status_id',
            'islander_no',
            'full_name',
            'id_pp_wp_no',
            'division_id',
            'department_id',
            'section_id',
            'position_id',
            'on_leave_status',
            'nationality',
            'date_of_joining',
            'date_of_birth',
            'company',
            'house_id',
            'departed_date',
            'arrival_date',
            'gender_id',
            'image',
            'cover_image',
            'password_changed',
            'type',
            'type_description',
            'out_of_office',
            'has_accepted_agreement',
            'device_token',
            'last_seen'
        ];

        $this->forge->dropColumn('users', $fields);
    }
}
