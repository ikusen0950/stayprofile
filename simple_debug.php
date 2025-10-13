<?php
// Simple debug - just check what users exist
require_once 'vendor/autoload.php';

try {
    // Get database connection using CodeIgniter config
    $config = new \Config\Database();
    $db = \CodeIgniter\Database\Config::connect($config->default);
    
    echo "<h2>Simple User Debug</h2>";
    
    // Check all users
    echo "<h3>All Users (first 10):</h3>";
    $allUsersQuery = $db->query("SELECT id, full_name, islander_no, status_id FROM users WHERE deleted_at IS NULL LIMIT 10");
    $allUsers = $allUsersQuery->getResultArray();
    echo "Total users found: " . count($allUsers) . "<br><br>";
    
    foreach ($allUsers as $user) {
        $type = (!empty($user['islander_no'])) ? 'Islander' : 'Visitor';
        echo "- {$user['full_name']} ({$type}) - Status ID: {$user['status_id']} - Islander No: " . ($user['islander_no'] ?: 'None') . "<br>";
    }
    
    echo "<h3>Users by Status ID:</h3>";
    $statusCounts = $db->query("SELECT status_id, COUNT(*) as count FROM users WHERE deleted_at IS NULL GROUP BY status_id ORDER BY status_id")->getResultArray();
    foreach ($statusCounts as $count) {
        echo "- Status ID {$count['status_id']}: {$count['count']} users<br>";
    }
    
    echo "<h3>Leave Reasons:</h3>";
    $leaves = $db->query("SELECT id, name, status_id FROM leaves LIMIT 10")->getResultArray();
    echo "Leaves found: " . count($leaves) . "<br>";
    foreach ($leaves as $leave) {
        echo "- {$leave['name']} (Status: {$leave['status_id']})<br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>