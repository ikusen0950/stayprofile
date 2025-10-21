<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

// Get database instance
$db = \Config\Database::connect();

echo "<h2>Updating Flight Routes Status ID</h2>\n";

try {
    // Update existing flight routes to use status_id = 1 (active)
    $updated = $db->table('flight_routes')
                  ->where('status_id', 7)
                  ->update(['status_id' => 1]);
    
    echo "<p>Updated {$updated} flight routes from status_id = 7 to status_id = 1</p>\n";
    
    // Get all flight routes to verify
    $query = $db->query("SELECT id, name, description, type, status_id FROM flight_routes ORDER BY type, name");
    $routes = $query->getResultArray();
    
    echo "<h3>Current Flight Routes:</h3>\n";
    echo "<table border='1' cellpadding='5' cellspacing='0'>\n";
    echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Type</th><th>Status ID</th></tr>\n";
    
    foreach ($routes as $route) {
        $statusColor = $route['status_id'] == 1 ? 'green' : 'red';
        echo "<tr>";
        echo "<td>" . $route['id'] . "</td>";
        echo "<td>" . htmlspecialchars($route['name'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($route['description'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($route['type'] ?? '') . "</td>";
        echo "<td style='color: {$statusColor}; font-weight: bold;'>" . $route['status_id'] . "</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
    
    // Test the model method
    echo "<h3>Testing FlightRouteModel with status_id = 1:</h3>\n";
    
    $flightRouteModel = new \App\Models\FlightRouteModel();
    
    $departureRoutes = $flightRouteModel->getActiveRoutesByType('Departure');
    echo "<p><strong>Departure routes (active):</strong> " . count($departureRoutes) . "</p>\n";
    if (count($departureRoutes) > 0) {
        echo "<ul>\n";
        foreach ($departureRoutes as $route) {
            echo "<li>ID: {$route['id']}, Name: " . htmlspecialchars($route['name']) . "</li>\n";
        }
        echo "</ul>\n";
    }
    
    $arrivalRoutes = $flightRouteModel->getActiveRoutesByType('Arrival');
    echo "<p><strong>Arrival routes (active):</strong> " . count($arrivalRoutes) . "</p>\n";
    if (count($arrivalRoutes) > 0) {
        echo "<ul>\n";
        foreach ($arrivalRoutes as $route) {
            echo "<li>ID: {$route['id']}, Name: " . htmlspecialchars($route['name']) . "</li>\n";
        }
        echo "</ul>\n";
    }
    
    echo "<p><strong>✅ Flight routes are now using status_id = 1 (active)</strong></p>\n";
    echo "<p><a href='requests'>Test the Transfer Modal Now</a></p>\n";
    
} catch (\Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>\n";
}