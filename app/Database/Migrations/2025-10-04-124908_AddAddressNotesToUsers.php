<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAddressNotesToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'address' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'User address'
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Additional notes about the user'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['address', 'notes']);
    }
}
