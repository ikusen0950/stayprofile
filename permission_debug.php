<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h2>Permission Check Debug</h2>\n";

$auth = \Config\Services::authentication();
$authorize = \Config\Services::authorization();

if (!$auth->check()) {
    echo "<p>❌ User not logged in</p>\n";
    echo "<p><a href='login'>Please login first</a></p>\n";
    exit;
}

$user = $auth->user();
echo "<p>✅ User logged in: " . ($user->username ?? 'Unknown') . " (ID: {$user->id})</p>\n";

// Check permissions exactly like the controller
$permissions = [
    'canCreate' => has_permission('requests.create'),
    'canEdit' => has_permission('requests.edit'),
    'canView' => has_permission('requests.view'),
    'canDelete' => has_permission('requests.delete')
];

echo "<h3>Controller Permission Check Results:</h3>\n";
foreach ($permissions as $perm => $hasIt) {
    echo "<p>{$perm}: " . ($hasIt ? '✅ YES' : '❌ NO') . "</p>\n";
}

if ($permissions['canCreate']) {
    echo "<p>✅ User has 'requests.create' permission - flight routes SHOULD be loaded</p>\n";
    
    // Test if we can actually load the flight routes
    try {
        $flightRouteModel = new \App\Models\FlightRouteModel();
        $departure_routes = $flightRouteModel->getActiveRoutesByType('Departure');
        $arrival_routes = $flightRouteModel->getActiveRoutesByType('Arrival');
        
        echo "<p>✅ Flight routes loaded successfully:</p>\n";
        echo "<ul>\n";
        echo "<li>Departure routes: " . count($departure_routes) . "</li>\n";
        echo "<li>Arrival routes: " . count($arrival_routes) . "</li>\n";
        echo "</ul>\n";
        
        if (count($departure_routes) > 0) {
            echo "<p>First departure route: {$departure_routes[0]['name']} (ID: {$departure_routes[0]['id']})</p>\n";
        }
        
    } catch (\Exception $e) {
        echo "<p>❌ Error loading flight routes: " . $e->getMessage() . "</p>\n";
    }
    
} else {
    echo "<p>❌ User does NOT have 'requests.create' permission - flight routes will be empty arrays</p>\n";
    echo "<p>This is why the modal shows 'departure_routes isset: NO'</p>\n";
}

echo "<p><a href='requests'>Go to Requests Page</a></p>\n";