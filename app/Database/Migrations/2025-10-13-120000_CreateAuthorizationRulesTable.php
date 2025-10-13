<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuthorizationRulesTable extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'User who has this authorization rule'
            ],
            'rule_type' => [
                'type'       => 'ENUM',
                'constraint' => ['all', 'division', 'department', 'section'],
                'default'    => 'division',
                'comment'    => 'Type of authorization: all (admin), division, department, or section'
            ],
            'target_type' => [
                'type'       => 'ENUM',
                'constraint' => ['islanders', 'visitors', 'both'],
                'default'    => 'both',
                'comment'    => 'What type of users this rule applies to'
            ],
            'division_ids' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'JSON array of division IDs user can access (for division/department rules)'
            ],
            'department_ids' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'JSON array of department IDs user can access (for department rules)'
            ],
            'section_ids' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'JSON array of section IDs user can access (for section rules)'
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => '1 = active, 0 = inactive'
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'Optional description of this authorization rule'
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'updated_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('rule_type');
        $this->forge->addKey('target_type');
        $this->forge->addKey('is_active');
        $this->forge->addKey('deleted_at');

        // Foreign key constraints
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('updated_by', 'users', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('authorization_rules');
        
        // Insert sample data
        $this->insertSampleData();
    }

    public function down()
    {
        $this->forge->dropTable('authorization_rules');
    }
    
    private function insertSampleData()
    {
        $data = [
            [
                'user_id' => 1,
                'rule_type' => 'all',
                'target_type' => 'both',
                'division_ids' => null,
                'department_ids' => null,
                'section_ids' => null,
                'is_active' => 1,
                'description' => 'Administrator - can see all users',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1
            ],
            [
                'user_id' => 2,
                'rule_type' => 'division',
                'target_type' => 'both',
                'division_ids' => json_encode([1]),
                'department_ids' => null,
                'section_ids' => null,
                'is_active' => 1,
                'description' => 'Division 1 Manager - can see all users in division 1',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1
            ],
            [
                'user_id' => 3,
                'rule_type' => 'department',
                'target_type' => 'both',
                'division_ids' => null,
                'department_ids' => json_encode([1, 3, 4]),
                'section_ids' => null,
                'is_active' => 1,
                'description' => 'Multi-department Manager - can see users in departments 1, 3, and 4',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1
            ]
        ];
        
        $this->db->table('authorization_rules')->insertBatch($data);
    }
}