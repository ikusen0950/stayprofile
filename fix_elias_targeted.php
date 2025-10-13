<?php
// Targeted fix for Elias Hammes duplicate issue
require_once 'vendor/autoload.php';

try {
    // Get database connection using CodeIgniter config
    $config = new \Config\Database();
    $db = \CodeIgniter\Database\Config::connect($config->default);
    
    echo "<h2>Targeted Fix: Elias Hammes Issue</h2>";
    
    // Find all Elias Hammes records
    echo "<h3>Step 1: Current Elias Hammes records</h3>";
    $eliasQuery = $db->query("
        SELECT id, full_name, type, status_id, islander_no, id_pp_wp_no, deleted_at
        FROM users 
        WHERE full_name = 'Elias Hammes'
        ORDER BY id ASC
    ");
    $eliasRecords = $eliasQuery->getResultArray();
    
    if (!empty($eliasRecords)) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Type</th><th>Status</th><th>Islander No</th><th>ID/PP/WP No</th><th>Deleted</th><th>Action</th></tr>";
        
        $visitorEliasIds = [];
        $islanderEliasIds = [];
        
        foreach ($eliasRecords as $record) {
            $deletedStatus = $record['deleted_at'] ? 'YES' : 'NO';
            $bgColor = '';
            $action = '';
            
            if (!$record['deleted_at']) {
                if ($record['type'] == 2) {
                    $bgColor = 'background: #ffeeee;';
                    $action = 'WILL FIX: Change to Islander OR Delete';
                    $visitorEliasIds[] = $record['id'];
                } else if ($record['type'] == 1) {
                    $bgColor = 'background: #eeffee;';
                    $action = 'OK: Already Islander';
                    $islanderEliasIds[] = $record['id'];
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
        
        // Apply the fix
        if (!empty($visitorEliasIds)) {
            echo "<h3>Step 2: Applying Fix</h3>";
            echo "<p style='color: orange;'>Found " . count($visitorEliasIds) . " Elias Hammes records marked as visitors (type=2)</p>";
            
            // Option 1: Check if there's already an islander Elias, then delete the visitor
            if (!empty($islanderEliasIds)) {
                echo "<p>Since there's already an Elias Hammes as Islander (ID: " . implode(', ', $islanderEliasIds) . "), we'll soft-delete the visitor record(s).</p>";
                
                $idsToDelete = implode(',', $visitorEliasIds);
                $deleteQuery = $db->query("
                    UPDATE users 
                    SET deleted_at = NOW() 
                    WHERE id IN ({$idsToDelete})
                ");
                
                if ($deleteQuery) {
                    $affectedRows = $db->affectedRows();
                    echo "<p style='color: green; font-weight: bold;'>✓ SUCCESS: Soft-deleted {$affectedRows} visitor Elias Hammes record(s)</p>";
                } else {
                    echo "<p style='color: red;'>✗ ERROR: Failed to delete visitor records</p>";
                }
                
            } else {
                echo "<p>No Islander Elias found, converting visitor to islander.</p>";
                
                $idsToConvert = implode(',', $visitorEliasIds);
                $convertQuery = $db->query("
                    UPDATE users 
                    SET type = 1 
                    WHERE id IN ({$idsToConvert})
                ");
                
                if ($convertQuery) {
                    $affectedRows = $db->affectedRows();
                    echo "<p style='color: green; font-weight: bold;'>✓ SUCCESS: Converted {$affectedRows} Elias Hammes record(s) from visitor to islander</p>";
                } else {
                    echo "<p style='color: red;'>✗ ERROR: Failed to convert visitor records</p>";
                }
            }
            
        } else {
            echo "<h3>Step 2: No Fix Needed</h3>";
            echo "<p style='color: green;'>No Elias Hammes visitor records found that need fixing.</p>";
        }
        
    } else {
        echo "<p>No Elias Hammes records found in the database.</p>";
    }
    
    // Verify the fix
    echo "<h3>Step 3: Verification</h3>";
    
    $verifyQuery = $db->query("
        SELECT id, full_name, type, status_id, deleted_at
        FROM users 
        WHERE full_name = 'Elias Hammes'
        AND deleted_at IS NULL
        ORDER BY id ASC
    ");
    $verifyRecords = $verifyQuery->getResultArray();
    
    if (!empty($verifyRecords)) {
        echo "<p>Active Elias Hammes records after fix:</p>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Type</th><th>Status</th></tr>";
        
        foreach ($verifyRecords as $record) {
            $typeText = ($record['type'] == 1) ? '1 (Islander)' : '2 (Visitor)';
            $bgColor = ($record['type'] == 2) ? 'background: #ffeeee;' : 'background: #eeffee;';
            
            echo "<tr style='{$bgColor}'>";
            echo "<td>{$record['id']}</td>";
            echo "<td>{$record['full_name']}</td>";
            echo "<td>{$typeText}</td>";
            echo "<td>{$record['status_id']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: orange;'>No active Elias Hammes records found.</p>";
    }
    
    // Test visitor dropdown
    echo "<h3>Step 4: Testing Visitor Dropdown</h3>";
    
    $testQuery = $db->query("
        SELECT u.id, 
               CONCAT(COALESCE(u.id_pp_wp_no, ''), ' - ', u.full_name) as display_name
        FROM users u 
        WHERE u.type = 2 
        AND u.status_id = 7 
        AND u.deleted_at IS NULL
        AND u.full_name LIKE '%Elias%'
        ORDER BY u.full_name ASC
    ");
    $testResults = $testQuery->getResultArray();
    
    if (empty($testResults)) {
        echo "<p style='color: green; font-weight: bold;'>✓ SUCCESS: No Elias records in visitor dropdown!</p>";
        echo "<p>The duplicate issue should now be resolved.</p>";
    } else {
        echo "<p style='color: red;'>⚠ Still found Elias in visitor dropdown:</p>";
        foreach ($testResults as $result) {
            echo "<p>- {$result['display_name']} (ID: {$result['id']})</p>";
        }
    }
    
    echo "<hr>";
    echo "<p style='color: blue; font-weight: bold;'>🎉 Fix completed! Please test the exit pass modal now.</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; max-width: 1000px; }
h2, h3 { color: #333; border-bottom: 2px solid #007cba; padding-bottom: 5px; }
table { width: 100%; margin: 10px 0; }
th { background: #f0f0f0; padding: 8px; text-align: left; }
td { padding: 6px; border-bottom: 1px solid #ddd; }
hr { margin: 20px 0; border: 1px solid #ddd; }
</style>