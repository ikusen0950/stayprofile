<?php

// Simple test to check if flight_routes table has data
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
require_once FCPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->appDirectory . '/Config/Constants.php';
require_once $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h2>Simple Flight Routes Test</h2>\n";

$db = \Config\Database::connect();

// Test 1: Check if table exists and has data
echo "<h3>1. Basic Table Check:</h3>\n";
try {
    $count = $db->table('flight_routes')->countAllResults();
    echo "<p>Total rows in flight_routes table: <strong>$count</strong></p>\n";
    
    if ($count > 0) {
        $routes = $db->table('flight_routes')->limit(5)->get()->getResultArray();
        echo "<p>First 5 rows:</p>\n";
        echo "<pre>" . print_r($routes, true) . "</pre>\n";
    }
} catch (\Exception $e) {
    echo "<p>❌ Error accessing flight_routes table: " . $e->getMessage() . "</p>\n";
}

// Test 2: Test FlightRouteModel instantiation
echo "<h3>2. FlightRouteModel Test:</h3>\n";
try {
    $flightRouteModel = new \App\Models\FlightRouteModel();
    echo "<p>✅ FlightRouteModel created successfully</p>\n";
    
    // Test the method directly
    $routes = $flightRouteModel->getDepartureRoutesForTransfer();
    echo "<p>getDepartureRoutesForTransfer() returned: " . count($routes) . " routes</p>\n";
    
    if (!empty($routes)) {
        echo "<pre>" . print_r($routes, true) . "</pre>\n";
    }
    
} catch (\Exception $e) {
    echo "<p>❌ Error with FlightRouteModel: " . $e->getMessage() . "</p>\n";
    echo "<pre>" . $e->getTraceAsString() . "</pre>\n";
}

// Test 3: Insert a test route if table is empty
echo "<h3>3. Create Test Route:</h3>\n";
try {
    $existingCount = $db->table('flight_routes')->countAllResults();
    
    if ($existingCount == 0) {
        echo "<p>Table is empty, creating test route...</p>\n";
        
        $testRoute = [
            'name' => 'Test Departure Route',
            'description' => 'Test route for debugging',
            'type' => 'Departure',
            'status_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $db->table('flight_routes')->insert($testRoute);
        echo "<p>✅ Test route created</p>\n";
        
        // Test again
        $routes = $flightRouteModel->getDepartureRoutesForTransfer();
        echo "<p>After creating test route, getDepartureRoutesForTransfer() returned: " . count($routes) . " routes</p>\n";
        
    } else {
        echo "<p>Table has $existingCount rows, no need to create test data</p>\n";
    }
    
} catch (\Exception $e) {
    echo "<p>❌ Error creating test route: " . $e->getMessage() . "</p>\n";
}

?>