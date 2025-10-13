<?php
// Deep investigation of Elias Hammes duplicate issue
require_once 'vendor/autoload.php';

try {
    // Get database connection using CodeIgniter config
    $config = new \Config\Database();
    $db = \CodeIgniter\Database\Config::connect($config->default);
    
    echo "<h2>Deep Investigation: Elias Hammes Duplicate Issue</h2>";
    
    // 1. Find ALL Elias Hammes records
    echo "<h3>1. All 'Elias Hammes' records in users table:</h3>";
    $allElias = $db->query("
        SELECT id, full_name, type, status_id, islander_no, id_pp_wp_no, deleted_at, created_at
        FROM users 
        WHERE full_name LIKE '%Elias Hammes%'
        ORDER BY id ASC
    ");
    $eliasRecords = $allElias->getResultArray();
    
    if (!empty($eliasRecords)) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Full Name</th><th>Type</th><th>Status</th><th>Islander No</th><th>ID/PP/WP No</th><th>Deleted</th><th>Created</th></tr>";
        
        foreach ($eliasRecords as $record) {
            $deletedStatus = $record['deleted_at'] ? 'YES' : 'NO';
            $bgColor = $record['deleted_at'] ? 'background: #ffcccc;' : '';
            echo "<tr style='{$bgColor}'>";
            echo "<td>{$record['id']}</td>";
            echo "<td>{$record['full_name']}</td>";
            echo "<td>{$record['type']}</td>";
            echo "<td>{$record['status_id']}</td>";
            echo "<td>{$record['islander_no']}</td>";
            echo "<td>{$record['id_pp_wp_no']}</td>";
            echo "<td>{$deletedStatus}</td>";
            echo "<td>{$record['created_at']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No Elias Hammes records found!</p>";
    }
    
    // 2. Test the exact visitor query that's causing the issue
    echo "<h3>2. Exact visitor query results (what the dropdown sees):</h3>";
    
    $visitorQuery = $db->query("
        SELECT u.id, 
               CONCAT(COALESCE(u.id_pp_wp_no, ''), ' - ', u.full_name) as display_name,
               u.full_name,
               u.id_pp_wp_no,
               u.type,
               u.status_id,
               u.deleted_at
        FROM users u 
        WHERE u.type = 2 
        AND u.status_id = 7 
        AND u.deleted_at IS NULL
        AND u.full_name LIKE '%Elias%'
        ORDER BY u.full_name ASC
    ");
    $visitorResults = $visitorQuery->getResultArray();
    
    if (!empty($visitorResults)) {
        echo "<p style='color: red;'>Found " . count($visitorResults) . " Elias records in visitor query:</p>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Display Name</th><th>Full Name</th><th>Type</th><th>Status</th><th>ID/PP/WP No</th></tr>";
        
        foreach ($visitorResults as $result) {
            echo "<tr>";
            echo "<td>{$result['id']}</td>";
            echo "<td>{$result['display_name']}</td>";
            echo "<td>{$result['full_name']}</td>";
            echo "<td>{$result['type']}</td>";
            echo "<td>{$result['status_id']}</td>";
            echo "<td>{$result['id_pp_wp_no']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: green;'>No Elias records found in visitor query - this is correct!</p>";
    }
    
    // 3. Check if there are any records with same names but different IDs
    echo "<h3>3. Checking for duplicate names in type=2, status=7:</h3>";
    
    $duplicateCheck = $db->query("
        SELECT full_name, COUNT(*) as count, GROUP_CONCAT(id) as ids
        FROM users 
        WHERE type = 2 
        AND status_id = 7 
        AND deleted_at IS NULL
        GROUP BY full_name
        HAVING COUNT(*) > 1
        ORDER BY count DESC
    ");
    $duplicates = $duplicateCheck->getResultArray();
    
    if (!empty($duplicates)) {
        echo "<p style='color: red;'>Found duplicate names in visitors:</p>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'><th>Name</th><th>Count</th><th>User IDs</th></tr>";
        
        foreach ($duplicates as $dup) {
            echo "<tr>";
            echo "<td>{$dup['full_name']}</td>";
            echo "<td>{$dup['count']}</td>";
            echo "<td>{$dup['ids']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: green;'>No duplicate names found in visitors.</p>";
    }
    
    // 4. Check the VisitorModel query specifically
    echo "<h3>4. Testing VisitorModel getActiveVisitors() query:</h3>";
    
    // Simulate the exact query from VisitorModel
    $modelQuery = $db->query("
        SELECT u.id, 
               CONCAT(COALESCE(u.id_pp_wp_no, ''), ' - ', u.full_name) as display_name
        FROM users u 
        WHERE u.type = 2 
        AND u.status_id = 7 
        AND u.deleted_at IS NULL
        GROUP BY u.id, u.full_name, u.id_pp_wp_no
        ORDER BY u.full_name ASC
    ");
    $modelResults = $modelQuery->getResultArray();
    
    echo "<p>VisitorModel query returns " . count($modelResults) . " results:</p>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f0f0f0;'><th>User ID</th><th>Display Name</th></tr>";
    
    foreach ($modelResults as $result) {
        $highlight = (strpos($result['display_name'], 'Elias') !== false) ? 'background: #ffffcc;' : '';
        echo "<tr style='{$highlight}'>";
        echo "<td>{$result['id']}</td>";
        echo "<td>{$result['display_name']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 5. Show actual SQL to fix the issue
    echo "<h3>5. Recommended fix:</h3>";
    
    if (!empty($visitorResults)) {
        echo "<p style='color: red;'>PROBLEM: Elias Hammes is still showing as type=2 (visitor)</p>";
        echo "<p>Run this SQL to fix:</p>";
        echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
        echo "UPDATE users SET type = 1 WHERE full_name = 'Elias Hammes' AND type = 2;\n";
        echo "-- OR if you want to soft delete the visitor record:\n";
        echo "UPDATE users SET deleted_at = NOW() WHERE full_name = 'Elias Hammes' AND type = 2;\n";
        echo "</pre>";
    } else {
        echo "<p style='color: green;'>Data looks correct. The issue might be in the frontend/JavaScript.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; max-width: 1200px; }
h2, h3 { color: #333; border-bottom: 2px solid #007cba; padding-bottom: 5px; }
table { width: 100%; margin: 10px 0; }
th { background: #f0f0f0; padding: 8px; text-align: left; }
td { padding: 6px; border-bottom: 1px solid #ddd; }
tr:nth-child(even) { background: #f9f9f9; }
pre { font-size: 12px; border-radius: 4px; }
</style>