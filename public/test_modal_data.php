<?php
// Test modal include with hardcoded data
require_once '../vendor/autoload.php';

// Bootstrap CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

// Create test data exactly like the controller should
$departure_routes = [
    [
        'id' => 1,
        'name' => 'FIN-MLE',
        'type' => 'Departure',
        'description' => 'Finland to Male'
    ]
];

$arrival_routes = [
    [
        'id' => 2,
        'name' => 'MLE-FIN',
        'type' => 'Arrival',
        'description' => 'Male to Finland'
    ]
];

echo "<h3>Testing Modal with Hardcoded Data</h3>";
echo "departure_routes count: " . count($departure_routes) . "<br>";
echo "arrival_routes count: " . count($arrival_routes) . "<br>";

// Test the dropdown generation
echo "<h4>Testing Dropdown Generation:</h4>";
echo "<select>";
echo "<option value=''>Select departure route</option>";
if (isset($departure_routes) && !empty($departure_routes)) {
    foreach ($departure_routes as $route) {
        echo "<option value='" . ($route['id'] ?? '') . "'>";
        echo ($route['name'] ?? '') . " (" . ($route['type'] ?? '') . ")";
        echo "</option>";
    }
} else {
    echo "<option value=''>No departure routes available</option>";
}
echo "</select>";
?>