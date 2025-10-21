<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h2>Debug Controller Logic Step by Step</h2>\n";

$auth = \Config\Services::authentication();
$authorize = \Config\Services::authorization();

if (!$auth->check()) {
    echo "<p>❌ Please <a href='login'>login first</a></p>\n";
    exit;
}

$user = $auth->user();
echo "<p>✅ User: " . ($user->username ?? 'Unknown') . "</p>\n";

$permissions = [
    'canCreate' => has_permission('requests.create')
];

echo "<p>Permission 'requests.create': " . ($permissions['canCreate'] ? '✅ YES' : '❌ NO') . "</p>\n";

if ($permissions['canCreate']) {
    try {
        echo "<h3>Testing Model Loading:</h3>\n";
        
        // Test each model individually
        echo "<p>1. Testing LeaveModel...</p>\n";
        $leaveModel = new \App\Models\LeaveModel();
        echo "<p>✅ LeaveModel loaded</p>\n";
        
        echo "<p>2. Testing IslanderModel...</p>\n";
        $islanderModel = new \App\Models\IslanderModel();
        echo "<p>✅ IslanderModel loaded</p>\n";
        
        echo "<p>3. Testing VisitorModel...</p>\n";
        $visitorModel = new \App\Models\VisitorModel();
        echo "<p>✅ VisitorModel loaded</p>\n";
        
        echo "<p>4. Testing FlightRouteModel...</p>\n";
        $flightRouteModel = new \App\Models\FlightRouteModel();
        echo "<p>✅ FlightRouteModel loaded</p>\n";
        
        echo "<h3>Testing Data Loading:</h3>\n";
        
        // Load data like controller does
        $data = [];
        
        echo "<p>Loading leaves...</p>\n";
        $data['leaves'] = $leaveModel->getActiveLeavesWithStatus();
        echo "<p>✅ Leaves loaded: " . count($data['leaves']) . "</p>\n";
        
        $data['leave_reasons'] = $data['leaves'];
        
        echo "<p>Loading islanders...</p>\n";
        // Simulate getAuthorizedIslanders (might be causing issues)
        try {
            // This would need to be tested based on the actual method
            echo "<p>⚠️ Skipping islanders for now</p>\n";
            $data['islanders'] = [];
        } catch (\Exception $e) {
            echo "<p>❌ Error loading islanders: " . $e->getMessage() . "</p>\n";
            $data['islanders'] = [];
        }
        
        echo "<p>Loading visitors...</p>\n";
        $data['visitors'] = $visitorModel->getActiveVisitors();
        echo "<p>✅ Visitors loaded: " . count($data['visitors']) . "</p>\n";
        
        echo "<p>Loading flight routes...</p>\n";
        $data['departure_routes'] = $flightRouteModel->getActiveRoutesByType('Departure');
        $data['arrival_routes'] = $flightRouteModel->getActiveRoutesByType('Arrival');
        
        echo "<p>✅ Departure routes loaded: " . count($data['departure_routes']) . "</p>\n";
        echo "<p>✅ Arrival routes loaded: " . count($data['arrival_routes']) . "</p>\n";
        
        $data['canCreatePastDate'] = has_permission('requests.create_past_date');
        
        echo "<h3>Final Data Array:</h3>\n";
        echo "<pre>\n";
        echo "departure_routes: " . count($data['departure_routes']) . " items\n";
        echo "arrival_routes: " . count($data['arrival_routes']) . " items\n";
        if (count($data['departure_routes']) > 0) {
            echo "\nDeparture routes:\n";
            foreach ($data['departure_routes'] as $route) {
                echo "- ID: {$route['id']}, Name: {$route['name']}, Type: {$route['type']}\n";
            }
        }
        if (count($data['arrival_routes']) > 0) {
            echo "\nArrival routes:\n";
            foreach ($data['arrival_routes'] as $route) {
                echo "- ID: {$route['id']}, Name: {$route['name']}, Type: {$route['type']}\n";
            }
        }
        echo "</pre>\n";
        
    } catch (\Exception $e) {
        echo "<p>❌ <strong>Exception in try block:</strong> " . $e->getMessage() . "</p>\n";
        echo "<p>File: " . $e->getFile() . " Line: " . $e->getLine() . "</p>\n";
        echo "<pre>" . $e->getTraceAsString() . "</pre>\n";
    }
} else {
    echo "<p>❌ User doesn't have create permission</p>\n";
}

echo "<p><a href='requests'>Go to Requests Page</a></p>\n";