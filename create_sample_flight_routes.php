<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

// Get database instance
$db = \Config\Database::connect();

echo "<h2>Adding Sample Flight Routes</h2>\n";

try {
    // Sample departure routes
    $departureRoutes = [
        ['name' => 'Male to Finolhu', 'description' => 'Direct route from Male International Airport to Finolhu Resort', 'type' => 'Departure'],
        ['name' => 'Finolhu to Hanimaadhoo', 'description' => 'Route from Finolhu Resort to Hanimaadhoo Airport', 'type' => 'Departure'],
        ['name' => 'Male to Hanimaadhoo', 'description' => 'Domestic route from Male to Hanimaadhoo Airport', 'type' => 'Departure'],
    ];
    
    // Sample arrival routes
    $arrivalRoutes = [
        ['name' => 'Finolhu to Male', 'description' => 'Return route from Finolhu Resort to Male International Airport', 'type' => 'Arrival'],
        ['name' => 'Hanimaadhoo to Finolhu', 'description' => 'Route from Hanimaadhoo Airport to Finolhu Resort', 'type' => 'Arrival'],
        ['name' => 'Hanimaadhoo to Male', 'description' => 'Domestic route from Hanimaadhoo Airport to Male', 'type' => 'Arrival'],
    ];
    
    $allRoutes = array_merge($departureRoutes, $arrivalRoutes);
    
    foreach ($allRoutes as $route) {
        // Check if route already exists
        $existing = $db->table('flight_routes')
                      ->where('name', $route['name'])
                      ->get()
                      ->getRowArray();
        
        if (!$existing) {
            $data = [
                'name' => $route['name'],
                'description' => $route['description'],
                'type' => $route['type'],
                'status_id' => 1, // Active status
                'created_by' => 1, // Assuming user ID 1 exists
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('flight_routes')->insert($data);
            echo "<p>✓ Added: {$route['name']} ({$route['type']})</p>\n";
        } else {
            echo "<p>- Already exists: {$route['name']} ({$route['type']})</p>\n";
        }
    }
    
    echo "<h3>Flight Routes Summary:</h3>\n";
    
    // Get all routes
    $query = $db->query("SELECT id, name, description, type, status_id FROM flight_routes ORDER BY type, name");
    $routes = $query->getResultArray();
    
    echo "<table border='1' cellpadding='5' cellspacing='0'>\n";
    echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Type</th><th>Status ID</th></tr>\n";
    
    foreach ($routes as $route) {
        echo "<tr>";
        echo "<td>" . $route['id'] . "</td>";
        echo "<td>" . htmlspecialchars($route['name'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($route['description'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($route['type'] ?? '') . "</td>";
        echo "<td>" . $route['status_id'] . "</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
    
    echo "<p><strong>Sample data created successfully!</strong></p>\n";
    echo "<p><a href='requests'>Test the Transfer Modal</a></p>\n";
    
} catch (\Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>\n";
}