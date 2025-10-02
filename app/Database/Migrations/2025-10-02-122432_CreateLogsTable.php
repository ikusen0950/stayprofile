<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateLogsTable extends Migration
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
            'status_id' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'unsigned'   => true,
                'default'    => 1,
                'comment'    => '1=Active, 2=Inactive, 3=Warning, 4=Error, 5=Critical',
            ],
            'action' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'comment'    => 'Action performed (create, update, delete, etc.)',
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'User who performed the action (NULL for system actions)',
            ],
            'logged_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'comment' => 'When the action was logged',
            ],
        ]);

        // Add primary key
        $this->forge->addKey('id', true);
        
        // Add indexes for better performance
        $this->forge->addKey('status_id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('logged_at');
        $this->forge->addKey(['status_id', 'logged_at']); // Composite index for filtering
        
        // Create the table
        $this->forge->createTable('logs', true);

        // Add foreign key constraints (optional, uncomment if you want strict referential integrity)
        /*
        $this->db->query('ALTER TABLE logs ADD CONSTRAINT fk_logs_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE');
        $this->db->query('ALTER TABLE logs ADD CONSTRAINT fk_logs_status_id FOREIGN KEY (status_id) REFERENCES status(id) ON DELETE RESTRICT ON UPDATE CASCADE');
        */
    }

    public function down()
    {
        // Drop foreign key constraints first (if they were created)
        /*
        $this->db->query('ALTER TABLE logs DROP FOREIGN KEY fk_logs_user_id');
        $this->db->query('ALTER TABLE logs DROP FOREIGN KEY fk_logs_status_id');
        */
        
        // Drop the table
        $this->forge->dropTable('logs', true);
    }
}
