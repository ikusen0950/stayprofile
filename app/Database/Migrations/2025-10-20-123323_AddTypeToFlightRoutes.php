<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTypeToFlightRoutes extends Migration
{
    public function up()
    {
        // Check if column already exists to make migration idempotent
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('flight_routes');
        if (in_array('type', $fields)) {
            return;
        }

        $this->forge->addColumn('flight_routes', [
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'description',
                'comment' => 'Type of flight route (e.g., domestic, international, charter)'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('flight_routes', 'type');
    }
}
