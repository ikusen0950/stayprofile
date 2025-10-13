<?php
// Final comprehensive fix for Elias Hammes and all data inconsistencies
require_once 'vendor/autoload.php';

try {
    $config = new \Config\Database();
    $db = \CodeIgniter\Database\Config::connect($config->default);
    
    echo "<h2>Comprehensive Data Fix - Final Solution</h2>";
    
    // Step 1: Find all current issues
    echo "<h3>Step 1: Identifying all data inconsistencies</h3>";
    
    // Find all Elias Hammes records
    $eliasQuery = $db->query("
        SELECT id, full_name, type, status_id, islander_no, id_pp_wp_no, deleted_at
        FROM users 
        WHERE full_name = 'Elias Hammes'
        ORDER BY type ASC, id ASC
    ");
    $eliasRecords = $eliasQuery->getResultArray();
    
    echo "<h4>All Elias Hammes records:</h4>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Type</th><th>Status</th><th>Islander No</th><th>ID/PP/WP No</th><th>Deleted</th><th>Action Plan</th></tr>";
    
    $activeElias = [];
    $toDelete = [];
    $toConvert = [];
    
    foreach ($eliasRecords as $record) {
        $deletedStatus = $record['deleted_at'] ? 'YES' : 'NO';
        $bgColor = '';
        $action = '';
        
        if (!$record['deleted_at']) { // Only active records
            if ($record['type'] == 1) {
                $bgColor = 'background: #eeffee;';
                $action = 'KEEP - Correct islander';
                $activeElias[] = $record;
            } else if ($record['type'] == 2) {
                $bgColor = 'background: #ffeeee;';
                if (empty($activeElias)) {
                    $action = 'CONVERT to type=1 (Islander)';
                    $toConvert[] = $record['id'];
                } else {
                    $action = 'DELETE - Duplicate visitor';
                    $toDelete[] = $record['id'];
                }
            }
        }
        
        echo "<tr style='{$bgColor}'>";
        echo "<td>{$record['id']}</td>";
        echo "<td>{$record['full_name']}</td>";
        echo "<td>{$record['type']}</td>";
        echo "<td>{$record['status_id']}</td>";
        echo "<td>{$record['islander_no']}</td>";
        echo "<td>{$record['id_pp_wp_no']}</td>";
        echo "<td>{$deletedStatus}</td>";
        echo "<td>{$action}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Step 2: Execute fixes
    echo "<h3>Step 2: Executing fixes</h3>";
    
    $totalFixed = 0;
    
    // Delete duplicate visitors
    if (!empty($toDelete)) {
        $deleteIds = implode(',', $toDelete);
        $deleteQuery = $db->query("UPDATE users SET deleted_at = NOW() WHERE id IN ({$deleteIds})");
        if ($deleteQuery) {
            $deleted = $db->affectedRows();
            echo "<p style='color: green;'>✓ Soft-deleted {$deleted} duplicate Elias Hammes visitor record(s)</p>";
            $totalFixed += $deleted;
        }
    }
    
    // Convert visitors to islanders if no islander exists
    if (!empty($toConvert)) {
        $convertIds = implode(',', $toConvert);
        $convertQuery = $db->query("UPDATE users SET type = 1 WHERE id IN ({$convertIds})");
        if ($convertQuery) {
            $converted = $db->affectedRows();
            echo "<p style='color: green;'>✓ Converted {$converted} Elias Hammes visitor record(s) to islander(s)</p>";
            $totalFixed += $converted;
        }
    }
    
    // Step 3: Fix any remaining type=2 users with islander_no
    echo "<h3>Step 3: Fixing remaining type=2 users with islander_no</h3>";
    
    $remainingQuery = $db->query("
        SELECT id, full_name, islander_no
        FROM users 
        WHERE type = 2 
        AND islander_no IS NOT NULL 
        AND islander_no != ''
        AND deleted_at IS NULL
    ");
    $remaining = $remainingQuery->getResultArray();
    
    if (!empty($remaining)) {
        echo "<p style='color: orange;'>Found " . count($remaining) . " other users with type=2 but having islander_no:</p>";
        echo "<ul>";
        foreach ($remaining as $user) {
            echo "<li>{$user['full_name']} (ID: {$user['id']}, Islander No: {$user['islander_no']})</li>";
        }
        echo "</ul>";
        
        $fixRemainingQuery = $db->query("
            UPDATE users 
            SET type = 1 
            WHERE type = 2 
            AND islander_no IS NOT NULL 
            AND islander_no != ''
            AND deleted_at IS NULL
        ");
        
        if ($fixRemainingQuery) {
            $fixedRemaining = $db->affectedRows();
            echo "<p style='color: green;'>✓ Fixed {$fixedRemaining} additional users with type=2 but islander_no</p>";
            $totalFixed += $fixedRemaining;
        }
    } else {
        echo "<p style='color: green;'>✓ No other type=2 users with islander_no found</p>";
    }
    
    // Step 4: Final verification
    echo "<h3>Step 4: Final verification</h3>";
    
    // Check for any remaining Elias with type=2
    $finalCheck = $db->query("
        SELECT COUNT(*) as count 
        FROM users 
        WHERE full_name = 'Elias Hammes' 
        AND type = 2 
        AND deleted_at IS NULL
    ");
    $finalCount = $finalCheck->getRowArray();
    
    if ($finalCount['count'] == 0) {
        echo "<p style='color: green; font-weight: bold; font-size: 18px;'>🎉 SUCCESS: No more Elias Hammes with type=2!</p>";
    } else {
        echo "<p style='color: red; font-weight: bold;'>⚠ Still found {$finalCount['count']} Elias Hammes with type=2</p>";
    }
    
    // Test the visitor dropdown query
    $testQuery = $db->query("
        SELECT u.id, CONCAT(COALESCE(u.id_pp_wp_no, ''), ' - ', u.full_name) as display_name
        FROM users u 
        WHERE u.type = 2 
        AND u.status_id = 7 
        AND u.deleted_at IS NULL
        AND u.id_pp_wp_no IS NOT NULL 
        AND u.id_pp_wp_no != ''
        AND u.full_name LIKE '%Elias%'
        ORDER BY u.full_name ASC
    ");
    $testResults = $testQuery->getResultArray();
    
    if (empty($testResults)) {
        echo "<p style='color: green; font-weight: bold;'>✓ Visitor dropdown query returns no Elias records!</p>";
    } else {
        echo "<p style='color: red;'>⚠ Visitor dropdown still shows Elias:</p>";
        foreach ($testResults as $result) {
            echo "<p>- {$result['display_name']} (ID: {$result['id']})</p>";
        }
    }
    
    echo "<hr>";
    echo "<p style='color: blue; font-weight: bold; font-size: 16px;'>📊 SUMMARY: Fixed {$totalFixed} total records</p>";
    echo "<p>Now test your exit pass modal - the duplicate Elias Hammes issue should be completely resolved!</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; max-width: 1200px; }
h2, h3, h4 { color: #333; border-bottom: 2px solid #007cba; padding-bottom: 5px; }
table { width: 100%; margin: 10px 0; }
th { background: #f0f0f0; padding: 8px; text-align: left; }
td { padding: 6px; border-bottom: 1px solid #ddd; }
hr { margin: 20px 0; border: 1px solid #ddd; }
ul { margin: 10px 0; }
li { margin: 5px 0; }
</style>