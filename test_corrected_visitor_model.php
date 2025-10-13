<?php
// Test the corrected VisitorModel getActiveVisitors method
require_once 'vendor/autoload.php';

try {
    // Load VisitorModel
    $visitorModel = new \App\Models\VisitorModel();
    
    echo "<h2>Testing Corrected VisitorModel::getActiveVisitors()</h2>";
    
    // Get the results
    $visitors = $visitorModel->getActiveVisitors();
    
    echo "<h3>Results:</h3>";
    echo "<p>Found <strong>" . count($visitors) . "</strong> active visitors</p>";
    
    if (!empty($visitors)) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'><th>User ID</th><th>Display Name</th></tr>";
        
        $eliasCount = 0;
        foreach ($visitors as $visitor) {
            $highlight = '';
            if (stripos($visitor['display_name'], 'elias') !== false) {
                $highlight = 'background: #ffffcc;';
                $eliasCount++;
            }
            
            echo "<tr style='{$highlight}'>";
            echo "<td>{$visitor['id']}</td>";
            echo "<td>{$visitor['display_name']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        if ($eliasCount > 0) {
            echo "<p style='color: red; font-weight: bold;'>⚠ Found {$eliasCount} Elias record(s) - this should be 0!</p>";
        } else {
            echo "<p style='color: green; font-weight: bold;'>✓ No Elias records found - perfect!</p>";
        }
        
    } else {
        echo "<p style='color: orange;'>No active visitors found.</p>";
        
        // Check if there are any visitors at all
        echo "<h3>Checking for any type=2 users...</h3>";
        $config = new \Config\Database();
        $db = \CodeIgniter\Database\Config::connect($config->default);
        
        $anyVisitors = $db->query("
            SELECT id, full_name, type, status_id, id_pp_wp_no, deleted_at
            FROM users 
            WHERE type = 2 
            ORDER BY full_name ASC 
            LIMIT 10
        ");
        $anyResults = $anyVisitors->getResultArray();
        
        if (!empty($anyResults)) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Status</th><th>ID/PP/WP No</th><th>Deleted</th></tr>";
            
            foreach ($anyResults as $result) {
                $deletedStatus = $result['deleted_at'] ? 'YES' : 'NO';
                echo "<tr>";
                echo "<td>{$result['id']}</td>";
                echo "<td>{$result['full_name']}</td>";
                echo "<td>{$result['status_id']}</td>";
                echo "<td>{$result['id_pp_wp_no']}</td>";
                echo "<td>{$deletedStatus}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No type=2 users found at all.</p>";
        }
    }
    
    // Check specifically for Elias Hammes in type=2
    echo "<h3>Checking specifically for Elias Hammes with type=2:</h3>";
    $config = new \Config\Database();
    $db = \CodeIgniter\Database\Config::connect($config->default);
    
    $eliasCheck = $db->query("
        SELECT id, full_name, type, status_id, islander_no, id_pp_wp_no, deleted_at
        FROM users 
        WHERE full_name LIKE '%Elias Hammes%'
        AND type = 2
        ORDER BY id ASC
    ");
    $eliasResults = $eliasCheck->getResultArray();
    
    if (!empty($eliasResults)) {
        echo "<p style='color: red;'>Found Elias Hammes with type=2:</p>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Type</th><th>Status</th><th>Islander No</th><th>ID/PP/WP No</th><th>Deleted</th></tr>";
        
        foreach ($eliasResults as $result) {
            $deletedStatus = $result['deleted_at'] ? 'YES' : 'NO';
            echo "<tr>";
            echo "<td>{$result['id']}</td>";
            echo "<td>{$result['full_name']}</td>";
            echo "<td>{$result['type']}</td>";
            echo "<td>{$result['status_id']}</td>";
            echo "<td>{$result['islander_no']}</td>";
            echo "<td>{$result['id_pp_wp_no']}</td>";
            echo "<td>{$deletedStatus}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<p style='color: red; font-weight: bold;'>THESE RECORDS NEED TO BE FIXED!</p>";
        
    } else {
        echo "<p style='color: green; font-weight: bold;'>✓ No Elias Hammes records with type=2 found!</p>";
    }
    
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
</style>