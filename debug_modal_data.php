<?php
// Debug modal data
require_once 'vendor/autoload.php';
require_once 'app/Config/Services.php';

// Load CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

// Get database connection
$db = \Config\Database::connect();

echo "<h2>Debug Modal Data</h2>";

// Check islanders (users with islander_no and status_id = 7)
echo "<h3>Islanders (status_id = 7):</h3>";
$islandersQuery = $db->query("
    SELECT id, full_name, islander_no, status_id 
    FROM users 
    WHERE status_id = 7 
    AND islander_no IS NOT NULL 
    AND islander_no != '' 
    AND deleted_at IS NULL
    ORDER BY full_name
");
$islanders = $islandersQuery->getResultArray();
echo "Count: " . count($islanders) . "<br>";
foreach ($islanders as $islander) {
    echo "- {$islander['full_name']} ({$islander['islander_no']}) - Status: {$islander['status_id']}<br>";
}

echo "<h3>Visitors (status_id = 7):</h3>";
$visitorsQuery = $db->query("
    SELECT id, full_name, islander_no, status_id 
    FROM users 
    WHERE status_id = 7 
    AND (islander_no IS NULL OR islander_no = '') 
    AND deleted_at IS NULL
    ORDER BY full_name
");
$visitors = $visitorsQuery->getResultArray();
echo "Count: " . count($visitors) . "<br>";
foreach ($visitors as $visitor) {
    echo "- {$visitor['full_name']} - Status: {$visitor['status_id']}<br>";
}

echo "<h3>Leave Reasons (status_id = 1):</h3>";
$leavesQuery = $db->query("
    SELECT l.id, l.name, l.status_id 
    FROM leaves l
    JOIN status s ON s.id = l.status_id
    WHERE l.status_id = 1
    ORDER BY l.name
");
$leaves = $leavesQuery->getResultArray();
echo "Count: " . count($leaves) . "<br>";
foreach ($leaves as $leave) {
    echo "- {$leave['name']} - Status: {$leave['status_id']}<br>";
}

echo "<h3>All Statuses:</h3>";
$statusQuery = $db->query("SELECT * FROM status ORDER BY id");
$statuses = $statusQuery->getResultArray();
foreach ($statuses as $status) {
    echo "- ID: {$status['id']}, Name: {$status['name']}<br>";
}
?>