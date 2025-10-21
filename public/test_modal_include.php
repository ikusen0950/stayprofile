<?php
// Simple test to check modal include
require_once '../vendor/autoload.php';

// Bootstrap CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

// Set some test data
$departure_routes = [
    ['id' => 1, 'name' => 'Test Departure Route']
];
$arrival_routes = [
    ['id' => 2, 'name' => 'Test Arrival Route']  
];

echo "<!-- SIMPLE TEST: departure_routes=" . count($departure_routes) . " -->";
echo "<h1>Testing Modal Include</h1>";

// Try to include the modal directly
try {
    echo view('requests/create_transfer_modal.php', [
        'departure_routes' => $departure_routes,
        'arrival_routes' => $arrival_routes,
        'leaves' => [],
        'leave_reasons' => [],
        'islanders' => [],
        'visitors' => [],
        'canCreatePastDate' => false
    ]);
} catch (\Exception $e) {
    echo "Error including modal: " . $e->getMessage();
}
?>