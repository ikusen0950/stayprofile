<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h2>User Permissions Debug</h2>\n";

try {
    // Load auth helper
    helper('auth');
    
    // Check current user
    $auth = service('authentication');
    if ($auth->check()) {
        $user = $auth->user();
        echo "<p><strong>Current User:</strong> " . ($user->full_name ?? 'Unknown') . " (ID: " . ($user->id ?? 'Unknown') . ")</p>\n";
        
        // Check specific permissions
        $permissions = [
            'requests.view',
            'requests.create',
            'requests.edit',
            'requests.delete',
            'requests.create_past_date'
        ];
        
        echo "<h3>Permission Check:</h3>\n";
        echo "<ul>\n";
        foreach ($permissions as $permission) {
            $hasPermission = has_permission($permission) ? '✅ YES' : '❌ NO';
            echo "<li><strong>{$permission}:</strong> {$hasPermission}</li>\n";
        }
        echo "</ul>\n";
        
        // Test flight routes loading with and without permission check
        echo "<h3>Flight Routes Loading Test:</h3>\n";
        
        $flightRouteModel = new \App\Models\FlightRouteModel();
        
        // Test direct model access
        $departureRoutes = $flightRouteModel->getActiveRoutesByType('Departure');
        $arrivalRoutes = $flightRouteModel->getActiveRoutesByType('Arrival');
        
        echo "<p><strong>Direct Model Access:</strong></p>\n";
        echo "<p>Departure routes: " . count($departureRoutes) . "</p>\n";
        echo "<p>Arrival routes: " . count($arrivalRoutes) . "</p>\n";
        
        // Test with permission check
        $canCreate = has_permission('requests.create');
        echo "<p><strong>Can Create Requests:</strong> " . ($canCreate ? 'YES' : 'NO') . "</p>\n";
        
        if ($canCreate) {
            echo "<p>✅ User has permission - flight routes should be loaded</p>\n";
        } else {
            echo "<p>❌ User lacks permission - flight routes will NOT be loaded</p>\n";
            echo "<p><strong>Solution:</strong> Grant 'requests.create' permission to this user</p>\n";
        }
        
    } else {
        echo "<p><strong>No user logged in</strong></p>\n";
        echo "<p><a href='/login'>Login first</a></p>\n";
    }
    
} catch (\Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>\n";
    echo "<pre>" . $e->getTraceAsString() . "</pre>\n";
}

echo "<p><a href='requests'>Go to Requests Page</a></p>\n";