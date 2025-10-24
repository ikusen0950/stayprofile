<?php

// Include CodeIgniter
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
require_once FCPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->appDirectory . '/Config/Constants.php';
require_once $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

$db = \Config\Database::connect();

echo "<h2>Creating Sample Flight Routes</h2>\n";

// Sample flight routes
$routes = [
    // Departure routes
    ['name' => 'Finolhu to Malé', 'description' => 'Departure from Finolhu Resort to Malé International Airport', 'type' => 'Departure'],
    ['name' => 'Finolhu to Hanimaadhoo', 'description' => 'Departure from Finolhu Resort to Hanimaadhoo Airport', 'type' => 'Departure'],
    ['name' => 'Malé to Hanimaadhoo', 'description' => 'Domestic departure from Malé to Hanimaadhoo Airport', 'type' => 'Departure'],
    
    // Arrival routes
    ['name' => 'Malé to Finolhu', 'description' => 'Arrival from Malé International Airport to Finolhu Resort', 'type' => 'Arrival'],
    ['name' => 'Hanimaadhoo to Finolhu', 'description' => 'Arrival from Hanimaadhoo Airport to Finolhu Resort', 'type' => 'Arrival'],
    ['name' => 'Hanimaadhoo to Malé', 'description' => 'Domestic arrival from Hanimaadhoo Airport to Malé', 'type' => 'Arrival'],
];

foreach ($routes as $route) {
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
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            $db->table('flight_routes')->insert($data);
            echo "<p>✅ Created route: " . htmlspecialchars($route['name']) . " (" . $route['type'] . ")</p>\n";
        } catch (\Exception $e) {
            echo "<p>❌ Error creating route " . htmlspecialchars($route['name']) . ": " . $e->getMessage() . "</p>\n";
        }
    } else {
        echo "<p>ℹ️ Route already exists: " . htmlspecialchars($route['name']) . "</p>\n";
    }
}

// Show final results
echo "<h3>Final Flight Routes:</h3>\n";
$allRoutes = $db->table('flight_routes')->orderBy('type', 'ASC')->orderBy('name', 'ASC')->get()->getResultArray();

if (empty($allRoutes)) {
    echo "<p>❌ No flight routes found!</p>\n";
} else {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>\n";
    echo "<tr style='background: #f5f5f5;'><th>ID</th><th>Name</th><th>Type</th><th>Description</th><th>Status ID</th></tr>\n";
    foreach ($allRoutes as $route) {
        echo "<tr>";
        echo "<td>" . $route['id'] . "</td>";
        echo "<td>" . htmlspecialchars($route['name']) . "</td>";
        echo "<td><strong>" . htmlspecialchars($route['type']) . "</strong></td>";
        echo "<td>" . htmlspecialchars($route['description']) . "</td>";
        echo "<td>" . ($route['status_id'] ?? 'NULL') . "</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
}

// Test the model query
echo "<h3>Testing FlightRouteModel Query:</h3>\n";
try {
    $flightRouteModel = new \App\Models\FlightRouteModel();
    $departureRoutes = $flightRouteModel->getActiveRoutesByType('Departure');
    $arrivalRoutes = $flightRouteModel->getActiveRoutesByType('Arrival');
    
    echo "<p><strong>Departure Routes Found:</strong> " . count($departureRoutes) . "</p>\n";
    if (!empty($departureRoutes)) {
        echo "<ul>\n";
        foreach ($departureRoutes as $route) {
            echo "<li>ID: " . $route['id'] . " - " . htmlspecialchars($route['name']) . "</li>\n";
        }
        echo "</ul>\n";
    }
    
    echo "<p><strong>Arrival Routes Found:</strong> " . count($arrivalRoutes) . "</p>\n";
    if (!empty($arrivalRoutes)) {
        echo "<ul>\n";
        foreach ($arrivalRoutes as $route) {
            echo "<li>ID: " . $route['id'] . " - " . htmlspecialchars($route['name']) . "</li>\n";
        }
        echo "</ul>\n";
    }
    
} catch (\Exception $e) {
    echo "<p>❌ Error testing model: " . $e->getMessage() . "</p>\n";
}

echo "<p><strong>Done!</strong> You can now test the transfer modal.</p>\n";

?>