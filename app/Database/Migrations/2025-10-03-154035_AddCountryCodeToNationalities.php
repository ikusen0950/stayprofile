<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCountryCodeToNationalities extends Migration
{
    public function up()
    {
        $this->forge->addColumn('nationalities', [
            'country_code' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
                'null' => true,
                'after' => 'name'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('nationalities', 'country_code');
    }
}
