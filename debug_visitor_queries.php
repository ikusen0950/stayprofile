<?php
// Debug visitor query
require_once 'vendor/autoload.php';

try {
    // Get database connection using CodeIgniter config
    $config = new \Config\Database();
    $db = \CodeIgniter\Database\Config::connect($config->default);
    
    echo "<h2>Visitor Query Debug</h2>";
    
    // Test the exact same queries as the model
    
    echo "<h3>1. First Query: type=2, status_id=7, no islander_no</h3>";
    $query1 = $db->query("
        SELECT u.id, u.full_name as name, u.id_pp_wp_no, u.type, u.status_id, u.islander_no
        FROM users u 
        WHERE u.type = 2 
        AND u.status_id = 7 
        AND u.deleted_at IS NULL 
        AND (u.islander_no IS NULL OR u.islander_no = '') 
        ORDER BY u.full_name ASC
    ");
    $result1 = $query1->getResultArray();
    echo "Found: " . count($result1) . " records<br>";
    foreach ($result1 as $user) {
        echo "- ID: {$user['id']}, Name: {$user['name']}, Type: {$user['type']}, Status: {$user['status_id']}, Islander No: " . ($user['islander_no'] ?: 'NULL') . "<br>";
    }
    
    echo "<h3>2. Second Query: type=2, any status, no islander_no</h3>";
    $query2 = $db->query("
        SELECT u.id, u.full_name as name, u.id_pp_wp_no, u.status_id, u.type, u.islander_no
        FROM users u 
        WHERE u.type = 2 
        AND u.deleted_at IS NULL 
        AND (u.islander_no IS NULL OR u.islander_no = '') 
        ORDER BY u.full_name ASC 
        LIMIT 10
    ");
    $result2 = $query2->getResultArray();
    echo "Found: " . count($result2) . " records<br>";
    foreach ($result2 as $user) {
        echo "- ID: {$user['id']}, Name: {$user['name']}, Type: {$user['type']}, Status: {$user['status_id']}, Islander No: " . ($user['islander_no'] ?: 'NULL') . "<br>";
    }
    
    echo "<h3>3. Third Query: no islander_no, status_id=7 (any type)</h3>";
    $query3 = $db->query("
        SELECT u.id, u.full_name as name, u.id_pp_wp_no, u.type, u.status_id, u.islander_no
        FROM users u 
        WHERE u.status_id = 7 
        AND u.deleted_at IS NULL 
        AND (u.islander_no IS NULL OR u.islander_no = '') 
        ORDER BY u.full_name ASC 
        LIMIT 10
    ");
    $result3 = $query3->getResultArray();
    echo "Found: " . count($result3) . " records<br>";
    foreach ($result3 as $user) {
        echo "- ID: {$user['id']}, Name: {$user['name']}, Type: {$user['type']}, Status: {$user['status_id']}, Islander No: " . ($user['islander_no'] ?: 'NULL') . "<br>";
    }
    
    echo "<h3>4. Fourth Query: no islander_no (any type, any status)</h3>";
    $query4 = $db->query("
        SELECT u.id, u.full_name as name, u.id_pp_wp_no, u.status_id, u.type, u.islander_no
        FROM users u 
        WHERE u.deleted_at IS NULL 
        AND (u.islander_no IS NULL OR u.islander_no = '') 
        ORDER BY u.full_name ASC 
        LIMIT 10
    ");
    $result4 = $query4->getResultArray();
    echo "Found: " . count($result4) . " records<br>";
    foreach ($result4 as $user) {
        echo "- ID: {$user['id']}, Name: {$user['name']}, Type: {$user['type']}, Status: {$user['status_id']}, Islander No: " . ($user['islander_no'] ?: 'NULL') . "<br>";
    }
    
    // Check for duplicates in the name "Elias Hammes"
    echo "<h3>5. Search for 'Elias Hammes' specifically:</h3>";
    $eliasQuery = $db->query("
        SELECT u.id, u.full_name, u.type, u.status_id, u.islander_no, u.deleted_at
        FROM users u 
        WHERE u.full_name LIKE '%Elias Hammes%'
        ORDER BY u.id
    ");
    $eliasResults = $eliasQuery->getResultArray();
    echo "Found: " . count($eliasResults) . " records with 'Elias Hammes'<br>";
    foreach ($eliasResults as $user) {
        echo "- ID: {$user['id']}, Name: {$user['full_name']}, Type: {$user['type']}, Status: {$user['status_id']}, Islander No: " . ($user['islander_no'] ?: 'NULL') . ", Deleted: " . ($user['deleted_at'] ?: 'No') . "<br>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; }
h2 { color: #333; margin-top: 30px; }
h3 { color: #666; margin-top: 20px; }
</style>