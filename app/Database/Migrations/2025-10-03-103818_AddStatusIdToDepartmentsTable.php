<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusIdToDepartmentsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('departments', [
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
        $this->forge->addForeignKey('status_id', 'status', 'id', 'CASCADE', 'SET NULL', 'departments');
    }

    public function down()
    {
        // Drop foreign key first
        $this->forge->dropForeignKey('departments', 'departments_status_id_foreign');
        
        // Drop the column
        $this->forge->dropColumn('departments', 'status_id');
    }
}
