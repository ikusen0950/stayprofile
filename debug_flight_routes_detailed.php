<?php
// Debug flight routes data loading
require_once 'vendor/autoload.php';

// Bootstrap CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

// Start session to track debugging
session_start();

echo "<h3>Flight Routes Debug Test</h3>";

// Test permission first
$hasPermission = has_permission('requests.create');
echo "User has requests.create permission: " . ($hasPermission ? 'YES' : 'NO') . "<br><br>";

if ($hasPermission) {
    echo "<h4>Testing Flight Routes Loading:</h4>";
    
    try {
        $flightRouteModel = new \App\Models\FlightRouteModel();
        
        $departure_routes = $flightRouteModel->getActiveRoutesByType('Departure');
        $arrival_routes = $flightRouteModel->getActiveRoutesByType('Arrival');
        
        echo "Departure routes loaded: " . count($departure_routes) . "<br>";
        echo "Arrival routes loaded: " . count($arrival_routes) . "<br>";
        
        // Store in session for debugging
        $_SESSION['debug_departure_routes'] = $departure_routes;
        $_SESSION['debug_arrival_routes'] = $arrival_routes;
        
        // Test array structure like controller
        $data = [];
        $data['departure_routes'] = $departure_routes;
        $data['arrival_routes'] = $arrival_routes;
        
        echo "<h4>Data array test:</h4>";
        echo "data['departure_routes'] count: " . count($data['departure_routes']) . "<br>";
        echo "data['arrival_routes'] count: " . count($data['arrival_routes']) . "<br>";
        
        // Test final assignment like controller
        $finalData = [
            'departure_routes' => $data['departure_routes'] ?? [],
            'arrival_routes' => $data['arrival_routes'] ?? [],
        ];
        
        echo "<h4>Final assignment test:</h4>";
        echo "finalData['departure_routes'] count: " . count($finalData['departure_routes']) . "<br>";
        echo "finalData['arrival_routes'] count: " . count($finalData['arrival_routes']) . "<br>";
        
        if (count($departure_routes) > 0) {
            echo "<br><strong>Sample departure route:</strong><br>";
            print_r($departure_routes[0]);
        }
        
        if (count($arrival_routes) > 0) {
            echo "<br><strong>Sample arrival route:</strong><br>";
            print_r($arrival_routes[0]);
        }
        
    } catch (\Exception $e) {
        echo "Error loading flight routes: " . $e->getMessage() . "<br>";
        echo "Stack trace: " . $e->getTraceAsString() . "<br>";
    }
} else {
    echo "User does not have permission to load routes.<br>";
}

echo "<br><h4>Session Debug Data:</h4>";
if (isset($_SESSION['debug_departure_routes'])) {
    echo "Session departure routes: " . count($_SESSION['debug_departure_routes']) . "<br>";
} else {
    echo "No departure routes in session<br>";
}

if (isset($_SESSION['debug_arrival_routes'])) {
    echo "Session arrival routes: " . count($_SESSION['debug_arrival_routes']) . "<br>";
} else {
    echo "No arrival routes in session<br>";
}
?>