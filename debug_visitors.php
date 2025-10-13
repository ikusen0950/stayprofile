<?php
// Debug visitor data
require_once 'vendor/autoload.php';

try {
    // Get database connection using CodeIgniter config
    $config = new \Config\Database();
    $db = \CodeIgniter\Database\Config::connect($config->default);
    
    echo "<h2>Visitor Debug Analysis</h2>";
    
    // Check users by type
    echo "<h3>1. Users by Type:</h3>";
    $typeQuery = $db->query("SELECT type, COUNT(*) as count FROM users WHERE deleted_at IS NULL GROUP BY type ORDER BY type");
    $types = $typeQuery->getResultArray();
    foreach ($types as $type) {
        echo "- Type {$type['type']}: {$type['count']} users<br>";
    }
    
    // Check users without islander_no (potential visitors)
    echo "<h3>2. Users without islander_no (potential visitors):</h3>";
    $noIslanderQuery = $db->query("
        SELECT id, full_name, type, status_id, islander_no 
        FROM users 
        WHERE (islander_no IS NULL OR islander_no = '') 
        AND deleted_at IS NULL 
        ORDER BY type, full_name 
        LIMIT 10
    ");
    $noIslander = $noIslanderQuery->getResultArray();
    echo "Found: " . count($noIslander) . " users<br>";
    foreach ($noIslander as $user) {
        echo "- {$user['full_name']} (Type: {$user['type']}, Status: {$user['status_id']}, Islander No: " . ($user['islander_no'] ?: 'NULL') . ")<br>";
    }
    
    // Check specifically type=2 users
    echo "<h3>3. Users with type=2 (should be visitors):</h3>";
    $type2Query = $db->query("
        SELECT id, full_name, status_id, islander_no 
        FROM users 
        WHERE type = 2 
        AND deleted_at IS NULL 
        ORDER BY full_name 
        LIMIT 10
    ");
    $type2Users = $type2Query->getResultArray();
    echo "Found: " . count($type2Users) . " users<br>";
    foreach ($type2Users as $user) {
        echo "- {$user['full_name']} (Status: {$user['status_id']}, Islander No: " . ($user['islander_no'] ?: 'NULL') . ")<br>";
    }
    
    // Check status_id = 7 users
    echo "<h3>4. Users with status_id=7 (active users):</h3>";
    $activeQuery = $db->query("
        SELECT type, COUNT(*) as count 
        FROM users 
        WHERE status_id = 7 
        AND deleted_at IS NULL 
        GROUP BY type 
        ORDER BY type
    ");
    $activeUsers = $activeQuery->getResultArray();
    foreach ($activeUsers as $active) {
        echo "- Type {$active['type']} with status_id=7: {$active['count']} users<br>";
    }
    
    // Show all status IDs available
    echo "<h3>5. Available Status IDs:</h3>";
    $statusQuery = $db->query("SELECT DISTINCT status_id, COUNT(*) as count FROM users WHERE deleted_at IS NULL GROUP BY status_id ORDER BY status_id");
    $statuses = $statusQuery->getResultArray();
    foreach ($statuses as $status) {
        echo "- Status ID {$status['status_id']}: {$status['count']} users<br>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; }
h2 { color: #333; margin-top: 30px; }
h3 { color: #666; margin-top: 20px; }
</style>