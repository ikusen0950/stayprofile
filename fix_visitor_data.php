<?php
// Fix visitor data inconsistencies
require_once 'vendor/autoload.php';

try {
    // Get database connection using CodeIgniter config
    $config = new \Config\Database();
    $db = \CodeIgniter\Database\Config::connect($config->default);
    
    echo "<h2>Data Fix Suggestions</h2>";
    
    // Show SQL commands to fix the issues
    echo "<h3>SQL Commands to Fix Data Inconsistencies:</h3>";
    
    echo "<h4>Option 1: Fix users who have islander_no but are marked as type=2 (visitors)</h4>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-left: 3px solid #007cba;'>";
    echo "-- Change users with islander_no to be type=1 (islanders)\n";
    echo "UPDATE users \n";
    echo "SET type = 1 \n";
    echo "WHERE islander_no IS NOT NULL \n";
    echo "  AND islander_no != '' \n";
    echo "  AND type = 2;\n";
    echo "</pre>";
    
    echo "<h4>Option 2: Remove islander_no from users marked as type=2 (visitors)</h4>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-left: 3px solid #007cba;'>";
    echo "-- Clear islander_no for users marked as visitors\n";
    echo "UPDATE users \n";
    echo "SET islander_no = NULL \n";
    echo "WHERE type = 2 \n";
    echo "  AND islander_no IS NOT NULL \n";
    echo "  AND islander_no != '';\n";
    echo "</pre>";
    
    echo "<h4>Option 3: Fix duplicate 'Elias Hammes' records (if they exist)</h4>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-left: 3px solid #007cba;'>";
    echo "-- Find duplicate Elias Hammes records\n";
    echo "SELECT id, full_name, type, status_id, islander_no \n";
    echo "FROM users \n";
    echo "WHERE full_name = 'Elias Hammes' \n";
    echo "ORDER BY id;\n\n";
    echo "-- If duplicates exist, soft delete the unwanted ones\n";
    echo "-- UPDATE users SET deleted_at = NOW() WHERE id = [unwanted_id];\n";
    echo "</pre>";
    
    echo "<h4>Option 4: Complete data cleanup (recommended)</h4>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-left: 3px solid #007cba;'>";
    echo "-- Step 1: Set all users with islander_no to type=1 (islanders)\n";
    echo "UPDATE users \n";
    echo "SET type = 1 \n";
    echo "WHERE islander_no IS NOT NULL AND islander_no != '';\n\n";
    echo "-- Step 2: Set all users without islander_no to type=2 (visitors)\n";
    echo "UPDATE users \n";
    echo "SET type = 2 \n";
    echo "WHERE (islander_no IS NULL OR islander_no = '');\n";
    echo "</pre>";
    
    // Show current problematic records
    echo "<h3>Current Problematic Records to Review:</h3>";
    
    // Check for type=2 users with islander_no
    $problemQuery = $db->query("
        SELECT id, full_name, type, status_id, islander_no, id_pp_wp_no
        FROM users 
        WHERE type = 2 
        AND islander_no IS NOT NULL 
        AND islander_no != ''
        AND deleted_at IS NULL
        ORDER BY full_name ASC
    ");
    $problems = $problemQuery->getResultArray();
    
    if (!empty($problems)) {
        echo "<h4>Users marked as visitors (type=2) but have islander_no:</h4>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Type</th><th>Status</th><th>Islander No</th><th>Action Needed</th></tr>";
        
        foreach ($problems as $problem) {
            echo "<tr>";
            echo "<td>{$problem['id']}</td>";
            echo "<td>{$problem['full_name']}</td>";
            echo "<td>{$problem['type']}</td>";
            echo "<td>{$problem['status_id']}</td>";
            echo "<td>{$problem['islander_no']}</td>";
            echo "<td style='background: #ffeeee;'>Should be type=1 OR remove islander_no</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: green;'>✓ No users with type=2 and islander_no found.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; }
h2, h3, h4 { color: #333; }
table { margin: 10px 0; }
th { background: #f0f0f0; padding: 8px; }
td { padding: 6px; }
pre { font-size: 12px; }
</style>