<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateGuestTokenLength extends Migration
{
    public function up()
    {
        // Modify the guest_token field to allow longer tokens
        $this->forge->modifyColumn('guests', [
            'guest_token' => [
                'name'       => 'guest_token',
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        // Revert the guest_token field back to original length
        $this->forge->modifyColumn('guests', [
            'guest_token' => [
                'name'       => 'guest_token',
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
        ]);
    }
}
