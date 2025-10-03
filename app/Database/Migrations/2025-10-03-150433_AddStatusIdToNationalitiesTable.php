<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusIdToNationalitiesTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('nationalities', [
            'status_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 1,
                'after' => 'description',
            ],
        ]);
        
        // Add foreign key constraint to status table
        $this->forge->addForeignKey('status_id', 'status', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop foreign key first
        $this->forge->dropForeignKey('nationalities', 'nationalities_status_id_foreign');
        
        // Drop the column
        $this->forge->dropColumn('nationalities', 'status_id');
    }
}
