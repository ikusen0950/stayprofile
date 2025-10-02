<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddModuleIdToLogsTable extends Migration
{
    public function up()
    {
        // Add module_id field to logs table
        $fields = [
            'module_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'Module associated with this log entry',
                'after'      => 'status_id'
            ]
        ];
        
        $this->forge->addColumn('logs', $fields);
        
        // Add index for better performance
        $this->forge->addKey('module_id');
        
        // Optional: Add foreign key constraint (uncomment if you want strict referential integrity)
        /*
        $this->db->query('ALTER TABLE logs ADD CONSTRAINT fk_logs_module_id FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE SET NULL ON UPDATE CASCADE');
        */
    }

    public function down()
    {
        // Remove the index first
        $this->forge->dropKey('logs', 'module_id');
        
        // Remove foreign key constraint if it was added
        // $this->db->query('ALTER TABLE logs DROP FOREIGN KEY fk_logs_module_id');
        
        // Drop the module_id column
        $this->forge->dropColumn('logs', 'module_id');
    }
}
