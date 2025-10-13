<?php
// Test the updated VisitorModel for islander_no - full_name format
require_once 'vendor/autoload.php';

try {
    // Load VisitorModel
    $visitorModel = new \App\Models\VisitorModel();
    
    echo "<h2>Testing Updated VisitorModel::getActiveVisitors()</h2>";
    echo "<p>Now using format: islander_no - full_name</p>";
    
    // Get the results
    $visitors = $visitorModel->getActiveVisitors();
    
    echo "<h3>Results:</h3>";
    echo "<p>Found <strong>" . count($visitors) . "</strong> active visitors</p>";
    
    if (!empty($visitors)) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'><th>User ID</th><th>Full Name</th><th>Islander No</th><th>ID/PP/WP No</th><th>Display Name</th></tr>";
        
        foreach ($visitors as $visitor) {
            echo "<tr>";
            echo "<td>{$visitor['id']}</td>";
            echo "<td>{$visitor['full_name']}</td>";
            echo "<td>" . ($visitor['islander_no'] ?? 'NULL') . "</td>";
            echo "<td>" . ($visitor['id_pp_wp_no'] ?? 'NULL') . "</td>";
            echo "<td><strong>{$visitor['display_name']}</strong></td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } else {
        echo "<p style='color: orange;'>No active visitors found with status_id = 7.</p>";
        
        // Check for any type=2 users regardless of status
        echo "<h3>Checking for any type=2 users (any status)...</h3>";
        $config = new \Config\Database();
        $db = \CodeIgniter\Database\Config::connect($config->default);
        
        $anyVisitors = $db->query("
            SELECT id, full_name, type, status_id, islander_no, id_pp_wp_no, deleted_at,
                   CONCAT(COALESCE(islander_no, ''), ' - ', full_name) as display_name
            FROM users 
            WHERE type = 2 
            AND deleted_at IS NULL
            ORDER BY full_name ASC 
            LIMIT 10
        ");
        $anyResults = $anyVisitors->getResultArray();
        
        if (!empty($anyResults)) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Status</th><th>Islander No</th><th>ID/PP/WP No</th><th>Display Name</th></tr>";
            
            foreach ($anyResults as $result) {
                $highlight = ($result['status_id'] == 7) ? 'background: #eeffee;' : '';
                echo "<tr style='{$highlight}'>";
                echo "<td>{$result['id']}</td>";
                echo "<td>{$result['full_name']}</td>";
                echo "<td>{$result['status_id']}</td>";
                echo "<td>" . ($result['islander_no'] ?? 'NULL') . "</td>";
                echo "<td>" . ($result['id_pp_wp_no'] ?? 'NULL') . "</td>";
                echo "<td><strong>{$result['display_name']}</strong></td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Count active visitors (status_id = 7)
            $activeCount = 0;
            foreach ($anyResults as $result) {
                if ($result['status_id'] == 7) {
                    $activeCount++;
                }
            }
            echo "<p style='color: blue;'>Found {$activeCount} visitors with status_id = 7 out of " . count($anyResults) . " total visitors.</p>";
            
        } else {
            echo "<p>No type=2 users found at all.</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; max-width: 1200px; }
h2, h3 { color: #333; border-bottom: 2px solid #007cba; padding-bottom: 5px; }
table { width: 100%; margin: 10px 0; }
th { background: #f0f0f0; padding: 8px; text-align: left; }
td { padding: 6px; border-bottom: 1px solid #ddd; }
</style>