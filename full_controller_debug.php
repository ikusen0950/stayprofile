<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h2>Complete Controller Debug Test</h2>\n";

$auth = \Config\Services::authentication();
$authorize = \Config\Services::authorization();

if (!$auth->check()) {
    echo "<p>❌ Please <a href='login'>login first</a></p>\n";
    exit;
}

$user = $auth->user();
echo "<p>✅ User: " . ($user->username ?? 'Unknown') . "</p>\n";

// Test permissions exactly like the controller does
$permissions = [
    'canCreate' => has_permission('requests.create'),
    'canEdit' => has_permission('requests.edit'),
    'canView' => has_permission('requests.view'),
    'canDelete' => has_permission('requests.delete')
];

echo "<h3>Permissions Check:</h3>\n";
echo "<ul>\n";
foreach ($permissions as $perm => $hasIt) {
    echo "<li>{$perm}: " . ($hasIt ? '✅ YES' : '❌ NO') . "</li>\n";
}
echo "</ul>\n";

if ($permissions['canCreate']) {
    echo "<h3>Testing Controller Logic Exactly:</h3>\n";
    
    try {
        $leaveModel = new \App\Models\LeaveModel();
        $islanderModel = new \App\Models\IslanderModel();
        $visitorModel = new \App\Models\VisitorModel();
        $flightRouteModel = new \App\Models\FlightRouteModel();
        
        echo "<p>✅ All models loaded</p>\n";
        
        // Initialize data array with defaults (like the fixed controller)
        $data = [];
        $data['leaves'] = [];
        $data['leave_reasons'] = [];
        $data['islanders'] = [];
        $data['visitors'] = [];
        $data['departure_routes'] = [];
        $data['arrival_routes'] = [];
        $data['canCreatePastDate'] = false;
        
        echo "<p>✅ Data array initialized</p>\n";
        
        // Test leaves
        try {
            $data['leaves'] = $leaveModel->getActiveLeavesWithStatus();
            $data['leave_reasons'] = $data['leaves'];
            echo "<p>✅ Leaves loaded: " . count($data['leaves']) . "</p>\n";
        } catch (\Exception $e) {
            echo "<p>❌ Leaves failed: " . $e->getMessage() . "</p>\n";
        }
        
        // Test visitors
        try {
            $data['visitors'] = $visitorModel->getActiveVisitors();
            echo "<p>✅ Visitors loaded: " . count($data['visitors']) . "</p>\n";
        } catch (\Exception $e) {
            echo "<p>❌ Visitors failed: " . $e->getMessage() . "</p>\n";
        }
        
        // Test flight routes - THE CRITICAL PART
        try {
            echo "<p>Testing flight routes specifically...</p>\n";
            $data['departure_routes'] = $flightRouteModel->getActiveRoutesByType('Departure');
            $data['arrival_routes'] = $flightRouteModel->getActiveRoutesByType('Arrival');
            echo "<p>✅ Flight routes loaded successfully!</p>\n";
            echo "<p>   - Departure routes: " . count($data['departure_routes']) . "</p>\n";
            echo "<p>   - Arrival routes: " . count($data['arrival_routes']) . "</p>\n";
            
            if (count($data['departure_routes']) > 0) {
                echo "<p><strong>Departure Routes:</strong></p>\n";
                echo "<ul>\n";
                foreach ($data['departure_routes'] as $route) {
                    echo "<li>ID: {$route['id']}, Name: {$route['name']}, Type: {$route['type']}, Status: {$route['status_id']}</li>\n";
                }
                echo "</ul>\n";
            }
            
            if (count($data['arrival_routes']) > 0) {
                echo "<p><strong>Arrival Routes:</strong></p>\n";
                echo "<ul>\n";
                foreach ($data['arrival_routes'] as $route) {
                    echo "<li>ID: {$route['id']}, Name: {$route['name']}, Type: {$route['type']}, Status: {$route['status_id']}</li>\n";
                }
                echo "</ul>\n";
            }
            
        } catch (\Exception $e) {
            echo "<p>❌ Flight routes failed: " . $e->getMessage() . "</p>\n";
            echo "<p>   File: " . $e->getFile() . "</p>\n";
            echo "<p>   Line: " . $e->getLine() . "</p>\n";
        }
        
        // Test past date permission
        try {
            $data['canCreatePastDate'] = has_permission('requests.create_past_date');
            echo "<p>✅ Past date permission: " . ($data['canCreatePastDate'] ? 'YES' : 'NO') . "</p>\n";
        } catch (\Exception $e) {
            echo "<p>❌ Past date permission failed: " . $e->getMessage() . "</p>\n";
        }
        
        // Show final data array that would be passed to view
        echo "<h3>Final Data Array (like controller would create):</h3>\n";
        $finalData = [
            'title' => 'Request Management',
            'permissions' => $permissions,
            'leaves' => $data['leaves'] ?? [],
            'leave_reasons' => $data['leave_reasons'] ?? [],
            'islanders' => $data['islanders'] ?? [],
            'visitors' => $data['visitors'] ?? [],
            'departure_routes' => $data['departure_routes'] ?? [],
            'arrival_routes' => $data['arrival_routes'] ?? [],
            'canCreatePastDate' => $data['canCreatePastDate'] ?? false
        ];
        
        echo "<ul>\n";
        echo "<li>departure_routes: " . count($finalData['departure_routes']) . " items</li>\n";
        echo "<li>arrival_routes: " . count($finalData['arrival_routes']) . " items</li>\n";
        echo "<li>leaves: " . count($finalData['leaves']) . " items</li>\n";
        echo "<li>visitors: " . count($finalData['visitors']) . " items</li>\n";
        echo "</ul>\n";
        
    } catch (\Exception $e) {
        echo "<p>❌ Major error: " . $e->getMessage() . "</p>\n";
        echo "<p>File: " . $e->getFile() . " Line: " . $e->getLine() . "</p>\n";
        echo "<pre>" . $e->getTraceAsString() . "</pre>\n";
    }
    
} else {
    echo "<p>❌ No create permission - data won't be loaded</p>\n";
}

echo "<p><a href='requests'>Go to Requests Page</a></p>\n";