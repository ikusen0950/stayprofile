<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusIdToDivisionsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('divisions', [
            'status_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true,
                'default' => 1, // Default to active status
                'after' => 'description'
            ]
        ]);
        
        // Add foreign key constraint
        $this->forge->addForeignKey('status_id', 'status', 'id', 'CASCADE', 'SET NULL', 'divisions');
    }

    public function down()
    {
        // Drop foreign key first
        $this->forge->dropForeignKey('divisions', 'divisions_status_id_foreign');
        
        // Drop the column
        $this->forge->dropColumn('divisions', 'status_id');
    }
}
