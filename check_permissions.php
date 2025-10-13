<?php
require_once 'vendor/autoload.php';

use Config\Database;

// Connect to database
$db = Database::connect();

// Check for authorization-related permissions
echo "=== Authorization Related Permissions ===\n";
$query = $db->query("SELECT * FROM auth_permissions WHERE name LIKE '%authorization%' OR name LIKE '%sequence%'");
$results = $query->getResultArray();

if (empty($results)) {
    echo "No authorization/sequence permissions found!\n\n";
} else {
    foreach ($results as $row) {
        echo "ID: {$row['id']}, Name: {$row['name']}, Description: {$row['description']}\n";
    }
    echo "\n";
}

// Check for status permissions (to compare)
echo "=== Status Related Permissions ===\n";
$query = $db->query("SELECT * FROM auth_permissions WHERE name LIKE '%status%'");
$results = $query->getResultArray();

foreach ($results as $row) {
    echo "ID: {$row['id']}, Name: {$row['name']}, Description: {$row['description']}\n";
}
echo "\n";

// Check what groups current user has (if we can determine it)
echo "=== All Permissions (first 20) ===\n";
$query = $db->query("SELECT * FROM auth_permissions LIMIT 20");
$results = $query->getResultArray();

foreach ($results as $row) {
    echo "ID: {$row['id']}, Name: {$row['name']}, Description: {$row['description']}\n";
}
?>