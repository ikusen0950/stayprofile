<?php
// Debug script to test flight routes loading in controller context
require_once 'vendor/autoload.php';

// Bootstrap CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

// Initialize models directly like the controller does
$flightRouteModel = new \App\Models\FlightRouteModel();

echo "<h3>Direct Model Test:</h3>";
try {
    $departure_routes = $flightRouteModel->getActiveRoutesByType('Departure');
    $arrival_routes = $flightRouteModel->getActiveRoutesByType('Arrival');
    
    echo "Departure routes count: " . count($departure_routes) . "<br>";
    echo "Arrival routes count: " . count($arrival_routes) . "<br>";
    
    if (count($departure_routes) > 0) {
        echo "First departure route: " . ($departure_routes[0]['name'] ?? 'no name') . "<br>";
    }
    
    if (count($arrival_routes) > 0) {
        echo "First arrival route: " . ($arrival_routes[0]['name'] ?? 'no name') . "<br>";
    }
    
    // Test the data array structure like in controller
    $data = [];
    $data['departure_routes'] = $departure_routes;
    $data['arrival_routes'] = $arrival_routes;
    
    echo "<h4>Data array structure:</h4>";
    echo "data['departure_routes'] count: " . count($data['departure_routes']) . "<br>";
    echo "data['arrival_routes'] count: " . count($data['arrival_routes']) . "<br>";
    
    // Simulate the final data array assignment like in controller
    $finalData = [
        'departure_routes' => $data['departure_routes'] ?? [],
        'arrival_routes' => $data['arrival_routes'] ?? [],
    ];
    
    echo "<h4>Final data structure:</h4>";
    echo "finalData['departure_routes'] count: " . count($finalData['departure_routes']) . "<br>";
    echo "finalData['arrival_routes'] count: " . count($finalData['arrival_routes']) . "<br>";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "Trace: " . $e->getTraceAsString() . "<br>";
}
?>