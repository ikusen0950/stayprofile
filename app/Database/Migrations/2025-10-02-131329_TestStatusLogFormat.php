<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TestStatusLogFormat extends Migration
{
    public function up()
    {
        // Create a test status to demonstrate the new logging format
        $statusBuilder = $this->db->table('status');
        
        $statusData = [
            'name' => 'Test Log Format',
            'module_id' => 1, // System module
            'color' => '#28a745',
            'description' => 'This is a test status created to demonstrate the new structured logging format with detailed action information.',
            'created_by' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $statusBuilder->insert($statusData);
        $statusId = $this->db->insertID();
        
        // Now manually create a log entry with the new format to demonstrate
        $logBuilder = $this->db->table('logs');
        
        $actionText = "Status Created\n";
        $actionText .= "#: " . $statusId . "\n";
        $actionText .= "Module: System\n";
        $actionText .= "Name: Test Log Format\n";
        $actionText .= "Description:\n";
        $actionText .= "This is a test status created to demonstrate the new structured logging format with detailed action information.";
        
        $logData = [
            'status_id' => 1, // Success status
            'module_id' => 3, // Status module
            'action' => $actionText,
            'user_id' => 1,
            'logged_at' => date('Y-m-d H:i:s')
        ];
        
        $logBuilder->insert($logData);
    }

    public function down()
    {
        // Remove the test status and log entry
        $this->db->query("DELETE FROM logs WHERE action LIKE 'Status Created%#:%' AND module_id = 3 ORDER BY id DESC LIMIT 1");
        $this->db->query("DELETE FROM status WHERE name = 'Test Log Format' AND description LIKE '%demonstrate the new structured logging format%'");
    }
}
