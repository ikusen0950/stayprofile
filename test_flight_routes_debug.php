<?php

// Include CodeIgniter
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
require_once FCPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->appDirectory . '/Config/Constants.php';
require_once $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h2>Flight Routes Debug Test</h2>\n";

// Test direct database query first
$db = \Config\Database::connect();

echo "<h3>1. Direct Database Query:</h3>\n";
$allRoutes = $db->table('flight_routes')->get()->getResultArray();
echo "<p>Total routes in database: " . count($allRoutes) . "</p>\n";

if (!empty($allRoutes)) {
    echo "<table border='1'>\n";
    echo "<tr><th>ID</th><th>Name</th><th>Type</th><th>Status ID</th></tr>\n";
    foreach ($allRoutes as $route) {
        echo "<tr>";
        echo "<td>" . $route['id'] . "</td>";
        echo "<td>" . htmlspecialchars($route['name']) . "</td>";
        echo "<td>" . htmlspecialchars($route['type']) . "</td>";
        echo "<td>" . ($route['status_id'] ?? 'NULL') . "</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
}

// Test departure routes with status_id = 1
echo "<h3>2. Departure Routes with status_id = 1:</h3>\n";
$depRoutes = $db->table('flight_routes')
    ->where('type', 'Departure')
    ->where('status_id', 1)
    ->get()
    ->getResultArray();
echo "<p>Found: " . count($depRoutes) . " departure routes</p>\n";

// Test arrival routes with status_id = 1  
echo "<h3>3. Arrival Routes with status_id = 1:</h3>\n";
$arrRoutes = $db->table('flight_routes')
    ->where('type', 'Arrival')
    ->where('status_id', 1)
    ->get()
    ->getResultArray();
echo "<p>Found: " . count($arrRoutes) . " arrival routes</p>\n";

// Test FlightRouteModel
echo "<h3>4. Testing FlightRouteModel:</h3>\n";
try {
    $flightRouteModel = new \App\Models\FlightRouteModel();
    
    echo "<p><strong>Model Departure Routes:</strong></p>\n";
    $modelDeparture = $flightRouteModel->getActiveRoutesByType('Departure');
    echo "<p>Count: " . count($modelDeparture) . "</p>\n";
    if (!empty($modelDeparture)) {
        echo "<pre>" . print_r($modelDeparture, true) . "</pre>\n";
    }
    
    echo "<p><strong>Model Arrival Routes:</strong></p>\n";
    $modelArrival = $flightRouteModel->getActiveRoutesByType('Arrival');
    echo "<p>Count: " . count($modelArrival) . "</p>\n";
    if (!empty($modelArrival)) {
        echo "<pre>" . print_r($modelArrival, true) . "</pre>\n";
    }
    
} catch (\Exception $e) {
    echo "<p>❌ Error with FlightRouteModel: " . $e->getMessage() . "</p>\n";
    echo "<p>Stack trace:</p>\n";
    echo "<pre>" . $e->getTraceAsString() . "</pre>\n";
}

// Test RequestController simulation
echo "<h3>5. Simulating RequestController Logic:</h3>\n";
try {
    $data = [];
    $flightRouteModel = new \App\Models\FlightRouteModel();
    $data['departure_routes'] = $flightRouteModel->getActiveRoutesByType('Departure');
    $data['arrival_routes'] = $flightRouteModel->getActiveRoutesByType('Arrival');
    
    echo "<p>Controller departure_routes count: " . count($data['departure_routes']) . "</p>\n";
    echo "<p>Controller arrival_routes count: " . count($data['arrival_routes']) . "</p>\n";
    
    // Check if debug fallback would trigger
    if (empty($data['departure_routes'])) {
        echo "<p>⚠️ DEBUG: departure_routes is empty, fallback would trigger</p>\n";
    } else {
        echo "<p>✅ departure_routes has data, no fallback needed</p>\n";
        echo "<pre>" . print_r($data['departure_routes'], true) . "</pre>\n";
    }
    
    if (empty($data['arrival_routes'])) {
        echo "<p>⚠️ DEBUG: arrival_routes is empty, fallback would trigger</p>\n";
    } else {
        echo "<p>✅ arrival_routes has data, no fallback needed</p>\n";
        echo "<pre>" . print_r($data['arrival_routes'], true) . "</pre>\n";
    }
    
} catch (\Exception $e) {
    echo "<p>❌ Error in controller simulation: " . $e->getMessage() . "</p>\n";
}

?>