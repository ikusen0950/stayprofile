<?php

// Test script to verify force logout functionality
// Run this from: http://localhost:8080/test_force_logout.php

// Include CodeIgniter bootstrap
require_once __DIR__ . '/app/Config/Paths.php';
require_once ROOTPATH . 'vendor/autoload.php';

// Initialize CodeIgniter
$paths = new Config\Paths();
$bootstrap = new \CodeIgniter\Bootstrap\BootstrapFCPath($paths);
$app = $bootstrap->createApplication();

// Start the app to get database
$app->initialize();

// Get database instance
$db = \Config\Database::connect();

echo "<h1>Force Logout Functionality Test</h1>";

// Check if there are sessions
$sessions = $db->query("SELECT * FROM ci_sessions LIMIT 5")->getResultArray();

echo "<h2>Current Sessions (" . count($sessions) . " found):</h2>";
echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>Session ID</th><th>User ID</th><th>IP Address</th><th>Timestamp</th><th>Actions</th></tr>";

foreach ($sessions as $session) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars(substr($session['id'], 0, 20) . '...') . "</td>";
    echo "<td>" . htmlspecialchars($session['user_id'] ?? 'N/A') . "</td>";
    echo "<td>" . htmlspecialchars($session['ip_address']) . "</td>";
    echo "<td>" . htmlspecialchars($session['timestamp']) . "</td>";
    echo "<td>";
    echo "<button onclick=\"testForceLogout('" . addslashes($session['id']) . "')\">Test Force Logout</button>";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";

if (empty($sessions)) {
    echo "<p><em>No sessions found. The force logout test requires active sessions.</em></p>";
    echo "<p><a href='/auth/login'>Login to create a session</a> | <a href='/sessions'>Go to Sessions Management</a></p>";
} else {
    echo "<p><strong>Instructions:</strong> Click 'Test Force Logout' buttons above to test the functionality.</p>";
    echo "<p><a href='/sessions'>Go to Sessions Management</a></p>";
}

?>

<script>
function testForceLogout(sessionId) {
    if (confirm('Test force logout for session: ' + sessionId + '?')) {
        fetch('/sessions/' + encodeURIComponent(sessionId) + '/force-logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert('Result: ' + (data.success ? 'SUCCESS: ' + data.message : 'FAILED: ' + data.message));
            if (data.success) {
                location.reload(); // Reload to see updated session list
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
            console.error('Error:', error);
        });
    }
}
</script>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
table { margin: 20px 0; }
th, td { padding: 8px; text-align: left; }
th { background-color: #f2f2f2; }
button { background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
button:hover { background-color: #c82333; }
</style>