<?php
// Execute the data fix for visitor/islander type inconsistencies
require_once 'vendor/autoload.php';

try {
    // Get database connection using CodeIgniter config
    $config = new \Config\Database();
    $db = \CodeIgniter\Database\Config::connect($config->default);
    
    echo "<h2>Fixing Data Inconsistencies</h2>";
    
    // First, let's see what we're about to fix
    echo "<h3>Step 1: Checking current problematic records...</h3>";
    
    $problemQuery = $db->query("
        SELECT id, full_name, type, status_id, islander_no
        FROM users 
        WHERE type = 2 
        AND islander_no IS NOT NULL 
        AND islander_no != ''
        AND deleted_at IS NULL
        ORDER BY full_name ASC
    ");
    $problems = $problemQuery->getResultArray();
    
    if (!empty($problems)) {
        echo "<p style='color: orange;'>Found " . count($problems) . " users marked as visitors (type=2) but with islander_no:</p>";
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Current Type</th><th>Status</th><th>Islander No</th></tr>";
        
        foreach ($problems as $problem) {
            echo "<tr>";
            echo "<td>{$problem['id']}</td>";
            echo "<td>{$problem['full_name']}</td>";
            echo "<td>{$problem['type']} (visitor)</td>";
            echo "<td>{$problem['status_id']}</td>";
            echo "<td>{$problem['islander_no']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Now execute the fix
        echo "<h3>Step 2: Executing the fix...</h3>";
        echo "<p>Running SQL: <code>UPDATE users SET type = 1 WHERE islander_no IS NOT NULL AND islander_no != '' AND type = 2;</code></p>";
        
        $fixQuery = $db->query("
            UPDATE users 
            SET type = 1 
            WHERE islander_no IS NOT NULL 
            AND islander_no != '' 
            AND type = 2
        ");
        
        if ($fixQuery) {
            $affectedRows = $db->affectedRows();
            echo "<p style='color: green; font-weight: bold;'>✓ SUCCESS: Fixed {$affectedRows} records</p>";
            echo "<p>These users have been changed from type=2 (visitors) to type=1 (islanders) because they have islander numbers.</p>";
            
            // Verify the fix
            echo "<h3>Step 3: Verifying the fix...</h3>";
            $verifyQuery = $db->query("
                SELECT id, full_name, type, status_id, islander_no
                FROM users 
                WHERE type = 2 
                AND islander_no IS NOT NULL 
                AND islander_no != ''
                AND deleted_at IS NULL
                ORDER BY full_name ASC
            ");
            $stillProblems = $verifyQuery->getResultArray();
            
            if (empty($stillProblems)) {
                echo "<p style='color: green; font-weight: bold;'>✓ VERIFIED: No more users with type=2 and islander_no found!</p>";
                
                // Show current visitor count
                $visitorCountQuery = $db->query("
                    SELECT COUNT(*) as count 
                    FROM users 
                    WHERE type = 2 
                    AND status_id = 7 
                    AND deleted_at IS NULL
                ");
                $visitorCount = $visitorCountQuery->getRowArray();
                
                echo "<p>Current active visitors (type=2, status_id=7): <strong>{$visitorCount['count']}</strong></p>";
                
                // Show current islander count
                $islanderCountQuery = $db->query("
                    SELECT COUNT(*) as count 
                    FROM users 
                    WHERE type = 1 
                    AND status_id = 7 
                    AND deleted_at IS NULL
                ");
                $islanderCount = $islanderCountQuery->getRowArray();
                
                echo "<p>Current active islanders (type=1, status_id=7): <strong>{$islanderCount['count']}</strong></p>";
                
            } else {
                echo "<p style='color: red;'>⚠ Still found " . count($stillProblems) . " problematic records after fix.</p>";
            }
            
        } else {
            echo "<p style='color: red;'>✗ ERROR: Failed to execute the fix query</p>";
        }
        
    } else {
        echo "<p style='color: green;'>✓ No problematic records found. Data is already consistent!</p>";
        
        // Show current counts anyway
        $visitorCountQuery = $db->query("
            SELECT COUNT(*) as count 
            FROM users 
            WHERE type = 2 
            AND status_id = 7 
            AND deleted_at IS NULL
        ");
        $visitorCount = $visitorCountQuery->getRowArray();
        
        echo "<p>Current active visitors (type=2, status_id=7): <strong>{$visitorCount['count']}</strong></p>";
        
        $islanderCountQuery = $db->query("
            SELECT COUNT(*) as count 
            FROM users 
            WHERE type = 1 
            AND status_id = 7 
            AND deleted_at IS NULL
        ");
        $islanderCount = $islanderCountQuery->getRowArray();
        
        echo "<p>Current active islanders (type=1, status_id=7): <strong>{$islanderCount['count']}</strong></p>";
    }
    
    echo "<h3>Step 4: Testing visitor dropdown query...</h3>";
    
    // Test the exact visitor query from VisitorModel
    $testVisitorQuery = $db->query("
        SELECT u.id, 
               CONCAT(COALESCE(u.id_pp_wp_no, ''), ' - ', u.full_name) as display_name,
               u.full_name,
               u.id_pp_wp_no,
               u.type,
               u.status_id
        FROM users u 
        WHERE u.type = 2 
        AND u.status_id = 7 
        AND u.deleted_at IS NULL
        GROUP BY u.id, u.full_name, u.id_pp_wp_no, u.type, u.status_id
        ORDER BY u.full_name ASC
    ");
    $testVisitors = $testVisitorQuery->getResultArray();
    
    echo "<p>Visitor dropdown will now show <strong>" . count($testVisitors) . "</strong> records:</p>";
    
    if (!empty($testVisitors)) {
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Display Name</th><th>Type</th><th>Status</th></tr>";
        foreach ($testVisitors as $visitor) {
            echo "<tr>";
            echo "<td>{$visitor['id']}</td>";
            echo "<td>{$visitor['display_name']}</td>";
            echo "<td>{$visitor['type']}</td>";
            echo "<td>{$visitor['status_id']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<hr>";
    echo "<p style='color: blue; font-weight: bold;'>🎉 Data fix completed! Your visitor dropdown should now work correctly without duplicates.</p>";
    echo "<p>You can now test the exit pass modal - the Islander/Visitor dropdowns should show the correct users.</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace:</p><pre>" . $e->getTraceAsString() . "</pre>";
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; max-width: 1000px; }
h2, h3 { color: #333; border-bottom: 2px solid #007cba; padding-bottom: 5px; }
table { width: 100%; margin: 10px 0; }
th { background: #f0f0f0; padding: 8px; text-align: left; }
td { padding: 6px; border-bottom: 1px solid #ddd; }
tr:nth-child(even) { background: #f9f9f9; }
code { background: #f5f5f5; padding: 2px 4px; border-radius: 3px; }
hr { margin: 20px 0; border: 1px solid #ddd; }
</style>