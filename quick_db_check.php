<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

// Get database instance
$db = \Config\Database::connect();

echo "<h2>Flight Routes Database Check</h2>\n";

try {
    // Get all flight routes
    $query = $db->query("SELECT id, name, description, type, status_id FROM flight_routes ORDER BY type, name");
    $routes = $query->getResultArray();
    
    echo "<p><strong>Total routes found:</strong> " . count($routes) . "</p>\n";
    
    if (count($routes) > 0) {
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
        
        // Test model method
        echo "<h3>Testing FlightRouteModel:</h3>\n";
        $flightRouteModel = new \App\Models\FlightRouteModel();
        
        $departureRoutes = $flightRouteModel->getActiveRoutesByType('Departure');
        $arrivalRoutes = $flightRouteModel->getActiveRoutesByType('Arrival');
        
        echo "<p><strong>Departure routes from model:</strong> " . count($departureRoutes) . "</p>\n";
        if (count($departureRoutes) > 0) {
            echo "<ul>\n";
            foreach ($departureRoutes as $route) {
                echo "<li>ID: {$route['id']}, Name: " . htmlspecialchars($route['name']) . "</li>\n";
            }
            echo "</ul>\n";
        }
        
        echo "<p><strong>Arrival routes from model:</strong> " . count($arrivalRoutes) . "</p>\n";
        if (count($arrivalRoutes) > 0) {
            echo "<ul>\n";
            foreach ($arrivalRoutes as $route) {
                echo "<li>ID: {$route['id']}, Name: " . htmlspecialchars($route['name']) . "</li>\n";
            }
            echo "</ul>\n";
        }
        
    } else {
        echo "<p><strong>❌ No flight routes found!</strong></p>\n";
        echo "<p>Need to create sample routes.</p>\n";
    }
    
} catch (\Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>\n";
}

echo "<p><a href='requests'>Go to Requests Page</a></p>\n";