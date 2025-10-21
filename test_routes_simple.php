<?php
// Simple test to check if variables reach the view
require_once 'vendor/autoload.php';

// Bootstrap CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

// Test the model directly
$flightRouteModel = new \App\Models\FlightRouteModel();

echo "<h3>Direct Model Test Results:</h3>";

try {
    // Get all routes regardless of type first
    $allRoutes = $flightRouteModel->where('status_id', 1)->findAll();
    echo "Total active routes: " . count($allRoutes) . "<br><br>";
    
    if (count($allRoutes) > 0) {
        echo "<h4>All Active Routes:</h4>";
        foreach ($allRoutes as $route) {
            echo "ID: {$route['id']}, Name: {$route['name']}, Type: {$route['type']}<br>";
        }
    }
    
    echo "<br><h4>Departure Routes:</h4>";
    $departure_routes = $flightRouteModel->getActiveRoutesByType('Departure');
    echo "Count: " . count($departure_routes) . "<br>";
    foreach ($departure_routes as $route) {
        echo "ID: {$route['id']}, Name: {$route['name']}, Type: {$route['type']}<br>";
    }
    
    echo "<br><h4>Arrival Routes:</h4>";
    $arrival_routes = $flightRouteModel->getActiveRoutesByType('Arrival');
    echo "Count: " . count($arrival_routes) . "<br>";
    foreach ($arrival_routes as $route) {
        echo "ID: {$route['id']}, Name: {$route['name']}, Type: {$route['type']}<br>";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo "<br><h4>Test formatted display:</h4>";
if (isset($departure_routes) && count($departure_routes) > 0) {
    foreach ($departure_routes as $route) {
        $display = $route['name'] . ' (' . $route['type'] . ')';
        echo "Route display: {$display}<br>";
    }
}
?>