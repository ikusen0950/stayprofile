<?php
// Test visitor model directly
require_once 'vendor/autoload.php';

try {
    // Initialize CodeIgniter
    $app = \Config\Services::codeigniter();
    $app->initialize();
    
    echo "<h2>Direct Visitor Model Test</h2>";
    
    // Test the VisitorModel directly
    $visitorModel = new \App\Models\VisitorModel();
    $visitors = $visitorModel->getActiveVisitors();
    
    echo "<h3>Visitor Model Results:</h3>";
    echo "Count: " . count($visitors) . "<br><br>";
    
    foreach ($visitors as $index => $visitor) {
        echo "Record #{$index}:<br>";
        echo "- ID: " . ($visitor['id'] ?? 'N/A') . "<br>";
        echo "- Name: " . ($visitor['name'] ?? 'N/A') . "<br>";
        echo "- ID PP WP No: " . ($visitor['id_pp_wp_no'] ?? 'N/A') . "<br>";
        if (isset($visitor['status_id'])) {
            echo "- Status ID: " . $visitor['status_id'] . "<br>";
        }
        echo "<br>";
    }
    
    // Check for duplicates by ID
    echo "<h3>Duplicate Check:</h3>";
    $ids = array_column($visitors, 'id');
    $duplicateIds = array_diff_assoc($ids, array_unique($ids));
    
    if (!empty($duplicateIds)) {
        echo "DUPLICATES FOUND:<br>";
        foreach ($duplicateIds as $index => $id) {
            echo "- Index {$index}: ID {$id}<br>";
        }
    } else {
        echo "No duplicate IDs found.<br>";
    }
    
    // Check for duplicates by name
    $names = array_column($visitors, 'name');
    $duplicateNames = array_diff_assoc($names, array_unique($names));
    
    if (!empty($duplicateNames)) {
        echo "DUPLICATE NAMES FOUND:<br>";
        foreach ($duplicateNames as $index => $name) {
            echo "- Index {$index}: Name '{$name}'<br>";
        }
    } else {
        echo "No duplicate names found.<br>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; }
h2, h3 { color: #333; }
</style>