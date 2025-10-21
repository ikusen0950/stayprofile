<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h2>Environment and Debug Info</h2>\n";

echo "<p><strong>Environment:</strong> " . ENVIRONMENT . "</p>\n";
echo "<p><strong>Defined constants:</strong></p>\n";
echo "<ul>\n";
echo "<li>ENVIRONMENT: " . (defined('ENVIRONMENT') ? ENVIRONMENT : 'Not defined') . "</li>\n";
echo "<li>CI_DEBUG: " . (defined('CI_DEBUG') ? CI_DEBUG : 'Not defined') . "</li>\n";
echo "</ul>\n";

// Test direct data loading
echo "<h3>Testing RequestController data loading:</h3>\n";

try {
    $flightRouteModel = new \App\Models\FlightRouteModel();
    
    $departureRoutes = $flightRouteModel->getActiveRoutesByType('Departure');
    $arrivalRoutes = $flightRouteModel->getActiveRoutesByType('Arrival');
    
    echo "<p><strong>Departure routes found:</strong> " . count($departureRoutes) . "</p>\n";
    if (count($departureRoutes) > 0) {
        echo "<ul>\n";
        foreach ($departureRoutes as $route) {
            echo "<li>ID: {$route['id']}, Name: " . htmlspecialchars($route['name']) . ", Description: " . htmlspecialchars($route['description'] ?? '') . "</li>\n";
        }
        echo "</ul>\n";
    }
    
    echo "<p><strong>Arrival routes found:</strong> " . count($arrivalRoutes) . "</p>\n";
    if (count($arrivalRoutes) > 0) {
        echo "<ul>\n";
        foreach ($arrivalRoutes as $route) {
            echo "<li>ID: {$route['id']}, Name: " . htmlspecialchars($route['name']) . ", Description: " . htmlspecialchars($route['description'] ?? '') . "</li>\n";
        }
        echo "</ul>\n";
    }
    
} catch (\Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>\n";
}

echo "<p><a href='requests'>Go to Requests Page</a></p>\n";