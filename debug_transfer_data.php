<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h2>Debug Transfer Modal Data</h2>\n";

try {
    // Test the RequestController's index method data loading
    $requestController = new \App\Controllers\RequestController();
    
    // Check if user has create permission (simulate)
    echo "<h3>Simulating RequestController data loading:</h3>\n";
    
    $flightRouteModel = new \App\Models\FlightRouteModel();
    
    // Test the model methods directly
    $departureRoutes = $flightRouteModel->getActiveRoutesByType('Departure');
    $arrivalRoutes = $flightRouteModel->getActiveRoutesByType('Arrival');
    
    echo "<p><strong>Departure Routes:</strong> " . count($departureRoutes) . "</p>\n";
    if (count($departureRoutes) > 0) {
        echo "<pre>" . print_r($departureRoutes, true) . "</pre>\n";
    }
    
    echo "<p><strong>Arrival Routes:</strong> " . count($arrivalRoutes) . "</p>\n";
    if (count($arrivalRoutes) > 0) {
        echo "<pre>" . print_r($arrivalRoutes, true) . "</pre>\n";
    }
    
    // Check if the data would be available in the view
    echo "<h3>Checking Request Controller Integration:</h3>\n";
    
    // Simulate the controller's data preparation
    $data = [];
    
    // Load additional data for modals if user has create permission
    $permissions = ['canCreate' => true]; // Simulate permission
    
    if ($permissions['canCreate']) {
        try {
            $leaveModel = new \App\Models\LeaveModel();
            $islanderModel = new \App\Models\IslanderModel();
            $visitorModel = new \App\Models\VisitorModel();
            $flightRouteModel = new \App\Models\FlightRouteModel();
            
            // Load flight routes for transfer modal
            $data['departure_routes'] = $flightRouteModel->getActiveRoutesByType('Departure');
            $data['arrival_routes'] = $flightRouteModel->getActiveRoutesByType('Arrival');
            
            echo "<p>✅ Flight routes loaded successfully in controller simulation</p>\n";
            echo "<p><strong>Departure routes count:</strong> " . count($data['departure_routes']) . "</p>\n";
            echo "<p><strong>Arrival routes count:</strong> " . count($data['arrival_routes']) . "</p>\n";
            
        } catch (\Exception $e) {
            echo "<p>❌ Error in controller simulation: " . $e->getMessage() . "</p>\n";
        }
    }
    
    // Test the actual data that would be passed to view
    echo "<h3>Data that would be passed to view:</h3>\n";
    echo "<pre>\n";
    echo "departure_routes: " . print_r($data['departure_routes'] ?? [], true) . "\n";
    echo "arrival_routes: " . print_r($data['arrival_routes'] ?? [], true) . "\n";
    echo "</pre>\n";
    
} catch (\Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>\n";
    echo "<pre>" . $e->getTraceAsString() . "</pre>\n";
}

echo "<p><a href='requests'>Go to Requests Page</a></p>\n";