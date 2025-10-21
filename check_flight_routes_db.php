<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

// Get database instance
$db = \Config\Database::connect();

echo "<h2>Database Flight Routes Check</h2>\n";

try {
    // Get all flight routes regardless of status
    $query = $db->query("SELECT id, name, description, type, status_id FROM flight_routes ORDER BY type, name");
    $allRoutes = $query->getResultArray();
    
    echo "<h3>All Flight Routes in Database:</h3>\n";
    
    if (count($allRoutes) > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>\n";
        echo "<tr><th>ID</th><th>Name</th><th>Type</th><th>Status ID</th><th>Action</th></tr>\n";
        
        foreach ($allRoutes as $route) {
            $statusColor = $route['status_id'] == 1 ? 'green' : 'red';
            echo "<tr>";
            echo "<td>" . $route['id'] . "</td>";
            echo "<td>" . htmlspecialchars($route['name']) . "</td>";
            echo "<td>" . htmlspecialchars($route['type']) . "</td>";
            echo "<td style='color: {$statusColor}; font-weight: bold;'>" . $route['status_id'] . "</td>";
            echo "<td>" . ($route['status_id'] == 1 ? '✅ Active' : '❌ Inactive') . "</td>";
            echo "</tr>\n";
        }
        echo "</table>\n";
        
        // Count by status
        $activeCount = 0;
        $inactiveCount = 0;
        foreach ($allRoutes as $route) {
            if ($route['status_id'] == 1) {
                $activeCount++;
            } else {
                $inactiveCount++;
            }
        }
        
        echo "<h3>Summary:</h3>\n";
        echo "<p><strong>Active routes (status_id = 1):</strong> {$activeCount}</p>\n";
        echo "<p><strong>Inactive routes:</strong> {$inactiveCount}</p>\n";
        
        if ($activeCount == 0) {
            echo "<div class='alert alert-danger'>\n";
            echo "<p><strong>❌ Problem Found!</strong></p>\n";
            echo "<p>No routes have status_id = 1 (active). This is why the dropdowns are empty.</p>\n";
            echo "<p><a href='#' onclick='fixStatuses()'>Fix All Route Statuses</a></p>\n";
            echo "</div>\n";
            
            echo "<script>\n";
            echo "function fixStatuses() {\n";
            echo "  if (confirm('Update all flight routes to status_id = 1 (active)?')) {\n";
            echo "    window.location.href = 'fix_flight_routes_status.php';\n";
            echo "  }\n";
            echo "}\n";
            echo "</script>\n";
        } else {
            echo "<p>✅ Routes with correct status found!</p>\n";
        }
        
    } else {
        echo "<p><strong>No flight routes found in database!</strong></p>\n";
        echo "<p><a href='create_sample_flight_routes.php'>Create Sample Routes</a></p>\n";
    }
    
    // Test model method directly
    echo "<h3>Testing Model Method:</h3>\n";
    $flightRouteModel = new \App\Models\FlightRouteModel();
    
    $departureRoutes = $flightRouteModel->getActiveRoutesByType('Departure');
    $arrivalRoutes = $flightRouteModel->getActiveRoutesByType('Arrival');
    
    echo "<p><strong>Model results:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Departure routes found: " . count($departureRoutes) . "</li>\n";
    echo "<li>Arrival routes found: " . count($arrivalRoutes) . "</li>\n";
    echo "</ul>\n";
    
} catch (\Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>\n";
}

echo "<p><a href='requests'>Go to Requests Page</a></p>\n";