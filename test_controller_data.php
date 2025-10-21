<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h2>Test Controller Data Loading</h2>\n";

try {
    // Load auth helper
    helper('auth');
    
    // Check current user permissions
    echo "<h3>User Permissions:</h3>\n";
    $canCreate = has_permission('requests.create');
    echo "<p>Can create requests: " . ($canCreate ? 'YES' : 'NO') . "</p>\n";
    
    if (!$canCreate) {
        echo "<p><strong>❌ User cannot create requests - modal data will not load</strong></p>\n";
        echo "<p><a href='add_requests_permissions.php'>Fix Permissions</a></p>\n";
        return;
    }
    
    // Test data loading similar to RequestController
    echo "<h3>Testing Flight Routes Loading:</h3>\n";
    
    $flightRouteModel = new \App\Models\FlightRouteModel();
    
    $departureRoutes = $flightRouteModel->getActiveRoutesByType('Departure');
    $arrivalRoutes = $flightRouteModel->getActiveRoutesByType('Arrival');
    
    echo "<p><strong>Departure routes found:</strong> " . count($departureRoutes) . "</p>\n";
    if (count($departureRoutes) > 0) {
        echo "<ul>\n";
        foreach ($departureRoutes as $route) {
            echo "<li>ID: {$route['id']}, Name: " . htmlspecialchars($route['name']) . "</li>\n";
        }
        echo "</ul>\n";
    } else {
        echo "<p>No departure routes found. Status_id = 1?</p>\n";
    }
    
    echo "<p><strong>Arrival routes found:</strong> " . count($arrivalRoutes) . "</p>\n";
    if (count($arrivalRoutes) > 0) {
        echo "<ul>\n";
        foreach ($arrivalRoutes as $route) {
            echo "<li>ID: {$route['id']}, Name: " . htmlspecialchars($route['name']) . "</li>\n";
        }
        echo "</ul>\n";
    } else {
        echo "<p>No arrival routes found. Status_id = 1?</p>\n";
    }
    
    // Test data array preparation like controller would do
    echo "<h3>Data Array Preparation:</h3>\n";
    
    $data = [
        'departure_routes' => $departureRoutes,
        'arrival_routes' => $arrivalRoutes,
        'leaves' => [],
        'leave_reasons' => [],
        'islanders' => [],
        'visitors' => [],
        'canCreatePastDate' => false
    ];
    
    echo "<p>Data array prepared successfully:</p>\n";
    echo "<ul>\n";
    echo "<li>departure_routes: " . count($data['departure_routes']) . " items</li>\n";
    echo "<li>arrival_routes: " . count($data['arrival_routes']) . " items</li>\n";
    echo "</ul>\n";
    
    if (count($data['departure_routes']) > 0 && count($data['arrival_routes']) > 0) {
        echo "<p>✅ <strong>Data loading works correctly!</strong></p>\n";
        echo "<p>The issue might be in view data passing or modal inclusion.</p>\n";
    } else {
        echo "<p>❌ <strong>No route data found!</strong></p>\n";
        echo "<p>Check if flight routes exist in database with status_id = 1</p>\n";
        echo "<p><a href='create_sample_flight_routes.php'>Create Sample Data</a></p>\n";
    }
    
} catch (\Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>\n";
    echo "<pre>" . $e->getTraceAsString() . "</pre>\n";
}

echo "<p><a href='requests'>Go to Requests Page</a></p>\n";