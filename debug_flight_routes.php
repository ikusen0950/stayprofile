<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

// Get database instance
$db = \Config\Database::connect();

echo "<h2>Flight Routes Debug Information</h2>\n";

// Check if flight_routes table exists
try {
    $query = $db->query("SHOW TABLES LIKE 'flight_routes'");
    $tableExists = $query->getNumRows() > 0;
    echo "<p><strong>Table exists:</strong> " . ($tableExists ? "Yes" : "No") . "</p>\n";
    
    if ($tableExists) {
        // Get all flight routes
        $query = $db->query("SELECT id, name, description, type, status_id FROM flight_routes ORDER BY type, name");
        $routes = $query->getResultArray();
        
        echo "<p><strong>Total flight routes:</strong> " . count($routes) . "</p>\n";
        
        if (count($routes) > 0) {
            echo "<h3>All Flight Routes:</h3>\n";
            echo "<table border='1' cellpadding='5' cellspacing='0'>\n";
            echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Type</th><th>Status ID</th></tr>\n";
            
            foreach ($routes as $route) {
                echo "<tr>";
                echo "<td>" . $route['id'] . "</td>";
                echo "<td>" . htmlspecialchars($route['name'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($route['description'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($route['type'] ?? '') . "</td>";
                echo "<td>" . $route['status_id'] . "</td>";
                echo "</tr>\n";
            }
            echo "</table>\n";
            
            // Test the model method
            echo "<h3>Testing FlightRouteModel Methods:</h3>\n";
            
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
            
        } else {
            echo "<p><strong>No flight routes found in database.</strong></p>\n";
            echo "<p>You need to add some flight routes through the Flight Routes management page.</p>\n";
        }
        
        // Check status table for reference
        echo "<h3>Available Status IDs:</h3>\n";
        $statusQuery = $db->query("SELECT id, name FROM status WHERE module_id IN (1, 6) ORDER BY id");
        $statuses = $statusQuery->getResultArray();
        
        if (count($statuses) > 0) {
            echo "<ul>\n";
            foreach ($statuses as $status) {
                echo "<li>ID: {$status['id']}, Name: " . htmlspecialchars($status['name']) . "</li>\n";
            }
            echo "</ul>\n";
        }
    }
    
} catch (\Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>\n";
}

echo "<p><a href='flight-routes'>Go to Flight Routes Management</a></p>\n";
echo "<p><a href='requests'>Go to Requests Page</a></p>\n";