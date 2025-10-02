<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LogSeeder extends Seeder
{
    public function run()
    {
        // First clear existing data
        $this->db->table('logs')->truncate();
        
        $data = [
            [
                'status_id' => 1, // Active
                'action' => 'User Login',
                'user_id' => 1,
                'logged_at' => date('Y-m-d H:i:s', strtotime('-5 minutes')),
            ],
            [
                'status_id' => 1, // Active
                'action' => 'Status Created',
                'user_id' => 1,
                'logged_at' => date('Y-m-d H:i:s', strtotime('-10 minutes')),
            ],
            [
                'status_id' => 1, // Active
                'action' => 'Module Updated',
                'user_id' => 1,
                'logged_at' => date('Y-m-d H:i:s', strtotime('-15 minutes')),
            ],
            [
                'status_id' => 3, // Warning
                'action' => 'Failed Login Attempt',
                'user_id' => null, // System log
                'logged_at' => date('Y-m-d H:i:s', strtotime('-20 minutes')),
            ],
            [
                'status_id' => 1, // Active
                'action' => 'Password Changed',
                'user_id' => 1,
                'logged_at' => date('Y-m-d H:i:s', strtotime('-30 minutes')),
            ],
            [
                'status_id' => 4, // Error
                'action' => 'Database Connection Failed',
                'user_id' => null, // System log
                'logged_at' => date('Y-m-d H:i:s', strtotime('-45 minutes')),
            ],
            [
                'status_id' => 1, // Active
                'action' => 'User Registration',
                'user_id' => 1,
                'logged_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            ],
            [
                'status_id' => 2, // Inactive
                'action' => 'Session Expired',
                'user_id' => 1,
                'logged_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            ],
            [
                'status_id' => 5, // Critical
                'action' => 'Security Breach Detected',
                'user_id' => null, // System log
                'logged_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
            ],
            [
                'status_id' => 1, // Active
                'action' => 'Data Export',
                'user_id' => 1,
                'logged_at' => date('Y-m-d H:i:s', strtotime('-4 hours')),
            ],
        ];

        // Insert sample data
        $this->db->table('logs')->insertBatch($data);
    }
}
