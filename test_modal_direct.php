<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

$auth = \Config\Services::authentication();
if (!$auth->check()) {
    echo "Please <a href='login'>login first</a>";
    exit;
}

// Create test data
$departure_routes = [
    ['id' => 1, 'name' => 'FIN-MLE', 'description' => 'Finolhu to Malé']
];

$arrival_routes = [
    ['id' => 2, 'name' => 'MLE-FIN', 'description' => 'Malé to Finolhu']
];

$leaves = [];
$islanders = [];
$visitors = [];
$canCreatePastDate = false;

?><!DOCTYPE html>
<html>
<head>
    <title>Test Transfer Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Test Transfer Modal with Known Data</h2>
    <p>This page tests the transfer modal with hardcoded flight routes data to isolate the issue.</p>
    
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#transferModal">
        Test Transfer Modal
    </button>
    
    <div class="mt-3">
        <h5>Test Data:</h5>
        <ul>
            <li>Departure routes: <?= count($departure_routes) ?> (<?= $departure_routes[0]['name'] ?>)</li>
            <li>Arrival routes: <?= count($arrival_routes) ?> (<?= $arrival_routes[0]['name'] ?>)</li>
        </ul>
    </div>
</div>

<?php 
// Include the modal directly with our test data
include 'app/Views/requests/create_transfer_modal.php';
?>

</body>
</html>