<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusModule extends Migration
{
    public function up()
    {
        // Insert Status module if it doesn't exist
        $builder = $this->db->table('modules');
        
        // Check if Status module already exists
        $existing = $builder->where('name', 'Status')->get()->getRowArray();
        
        if (!$existing) {
            $builder->insert([
                'status_id' => 1,
                'name' => 'Status',
                'description' => 'Status Management Module',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function down()
    {
        // Remove Status module
        $this->db->table('modules')->where('name', 'Status')->delete();
    }
}
