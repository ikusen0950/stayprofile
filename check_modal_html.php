<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h2>Raw HTML Debug for Transfer Modal</h2>\n";

$auth = \Config\Services::authentication();
$authorize = \Config\Services::authorization();

if (!$auth->check()) {
    echo "<p>❌ Please <a href='login'>login first</a></p>\n";
    exit;
}

echo "<h3>Testing Flight Routes Data:</h3>\n";

// Simulate the controller data loading
$flightRouteModel = new \App\Models\FlightRouteModel();
$departure_routes = $flightRouteModel->getActiveRoutesByType('Departure');
$arrival_routes = $flightRouteModel->getActiveRoutesByType('Arrival');

echo "<p>Departure routes count: " . count($departure_routes) . "</p>\n";
echo "<p>Arrival routes count: " . count($arrival_routes) . "</p>\n";

echo "<h3>Generated HTML for Departure Routes:</h3>\n";
echo "<select name='test_departure'>\n";
echo "<option value=''>Select departure route</option>\n";
if (isset($departure_routes) && !empty($departure_routes)) {
    foreach ($departure_routes as $route) {
        echo "<option value='" . htmlspecialchars($route['id'] ?? '') . "'>";
        echo htmlspecialchars($route['name'] ?? '');
        if (!empty($route['description'])) {
            echo " - " . htmlspecialchars($route['description']);
        }
        echo "</option>\n";
    }
} else {
    echo "<option value=''>No departure routes available</option>\n";
}
echo "</select>\n";

echo "<h3>Generated HTML for Arrival Routes:</h3>\n";
echo "<select name='test_arrival'>\n";
echo "<option value=''>Select arrival route</option>\n";
if (isset($arrival_routes) && !empty($arrival_routes)) {
    foreach ($arrival_routes as $route) {
        echo "<option value='" . htmlspecialchars($route['id'] ?? '') . "'>";
        echo htmlspecialchars($route['name'] ?? '');
        if (!empty($route['description'])) {
            echo " - " . htmlspecialchars($route['description']);
        }
        echo "</option>\n";
    }
} else {
    echo "<option value=''>No arrival routes available</option>\n";
}
echo "</select>\n";

echo "<h3>Test the modal include directly...</h3>\n";

// Test if the modal include has the data
try {
    echo "<p>Including modal with data...</p>\n";
    
    // Prepare data like the controller
    $modalData = [
        'departure_routes' => $departure_routes,
        'arrival_routes' => $arrival_routes,
        'canCreatePastDate' => false,
        'leaves' => [],
        'islanders' => [],
        'visitors' => []
    ];
    
    echo "<p>Modal data prepared:</p>\n";
    echo "<ul>\n";
    echo "<li>departure_routes: " . count($modalData['departure_routes']) . "</li>\n";
    echo "<li>arrival_routes: " . count($modalData['arrival_routes']) . "</li>\n";
    echo "</ul>\n";
    
} catch (\Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>\n";
}

echo "<p><a href='requests'>Go to Requests Page</a></p>\n";

function esc($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}