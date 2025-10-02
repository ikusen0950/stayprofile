<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateLogsWithModuleIds extends Migration
{
    public function up()
    {
        // Update some log records with module_id values for testing
        
        // Set System module (id=1) for system-related logs
        $this->db->query("UPDATE logs SET module_id = 1 WHERE id IN (2, 3, 5, 7, 10)");
        
        // Set Logs module (id=0) for authentication and security logs
        $this->db->query("UPDATE logs SET module_id = 0 WHERE id IN (4, 6, 8, 9)");
    }

    public function down()
    {
        // Reset module_id values to NULL
        $this->db->query("UPDATE logs SET module_id = NULL WHERE id IN (2, 3, 4, 5, 6, 7, 8, 9, 10)");
    }
}
