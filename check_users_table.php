<?php
// Check users table for type=2 and Elias Hammes
require_once 'vendor/autoload.php';

try {
    // Get database connection using CodeIgniter config
    $config = new \Config\Database();
    $db = \CodeIgniter\Database\Config::connect($config->default);
    
    echo "<h2>Users Table Analysis - Type=2 (Visitors)</h2>";
    
    // Check all users with type=2
    echo "<h3>1. All users with type=2:</h3>";
    $type2Query = $db->query("
        SELECT id, full_name, type, status_id, islander_no, id_pp_wp_no, deleted_at
        FROM users 
        WHERE type = 2 
        ORDER BY full_name ASC
    ");
    $type2Users = $type2Query->getResultArray();
    echo "Found: " . count($type2Users) . " users with type=2<br><br>";
    
    foreach ($type2Users as $user) {
        echo "- ID: {$user['id']}, Name: {$user['full_name']}, Status: {$user['status_id']}, Islander No: " . 
             ($user['islander_no'] ?: 'NULL') . ", ID_PP_WP: " . ($user['id_pp_wp_no'] ?: 'NULL') . 
             ", Deleted: " . ($user['deleted_at'] ?: 'No') . "<br>";
    }
    
    // Specifically search for Elias Hammes
    echo "<h3>2. All records for 'Elias Hammes':</h3>";
    $eliasQuery = $db->query("
        SELECT id, full_name, type, status_id, islander_no, id_pp_wp_no, deleted_at
        FROM users 
        WHERE full_name LIKE '%Elias Hammes%'
        ORDER BY id ASC
    ");
    $eliasUsers = $eliasQuery->getResultArray();
    echo "Found: " . count($eliasUsers) . " records for 'Elias Hammes'<br><br>";
    
    foreach ($eliasUsers as $user) {
        echo "- ID: {$user['id']}, Name: {$user['full_name']}, Type: {$user['type']}, Status: {$user['status_id']}, Islander No: " . 
             ($user['islander_no'] ?: 'NULL') . ", ID_PP_WP: " . ($user['id_pp_wp_no'] ?: 'NULL') . 
             ", Deleted: " . ($user['deleted_at'] ?: 'No') . "<br>";
    }
    
    // Check for duplicate names regardless of type
    echo "<h3>3. Users with duplicate names:</h3>";
    $duplicateQuery = $db->query("
        SELECT full_name, COUNT(*) as count
        FROM users 
        WHERE deleted_at IS NULL
        GROUP BY full_name 
        HAVING COUNT(*) > 1
        ORDER BY count DESC, full_name ASC
    ");
    $duplicates = $duplicateQuery->getResultArray();
    echo "Found: " . count($duplicates) . " names with duplicates<br><br>";
    
    foreach ($duplicates as $dup) {
        echo "- Name: '{$dup['full_name']}' appears {$dup['count']} times<br>";
        
        // Show details for this duplicate name
        $detailQuery = $db->query("
            SELECT id, type, status_id, islander_no
            FROM users 
            WHERE full_name = ? AND deleted_at IS NULL
            ORDER BY id ASC
        ", [$dup['full_name']]);
        $details = $detailQuery->getResultArray();
        
        foreach ($details as $detail) {
            echo "  → ID: {$detail['id']}, Type: {$detail['type']}, Status: {$detail['status_id']}, Islander No: " . 
                 ($detail['islander_no'] ?: 'NULL') . "<br>";
        }
        echo "<br>";
    }
    
    // Check the exact query used by getActiveVisitors
    echo "<h3>4. Exact Visitor Model Query (type=2, status_id=7, no islander_no):</h3>";
    $exactQuery = $db->query("
        SELECT u.id, u.full_name as name, u.id_pp_wp_no
        FROM users u 
        WHERE u.type = 2 
        AND u.status_id = 7 
        AND u.deleted_at IS NULL 
        AND (u.islander_no IS NULL OR u.islander_no = '')
        ORDER BY u.full_name ASC
    ");
    $exactResult = $exactQuery->getResultArray();
    echo "Found: " . count($exactResult) . " records matching visitor criteria<br><br>";
    
    foreach ($exactResult as $visitor) {
        echo "- ID: {$visitor['id']}, Name: {$visitor['name']}, ID_PP_WP: " . ($visitor['id_pp_wp_no'] ?: 'NULL') . "<br>";
    }
    
    // Check for users with islander_no but type=2 (data inconsistency)
    echo "<h3>5. Data Inconsistency Check - Type=2 users WITH islander_no:</h3>";
    $inconsistentQuery = $db->query("
        SELECT id, full_name, type, status_id, islander_no
        FROM users 
        WHERE type = 2 
        AND islander_no IS NOT NULL 
        AND islander_no != ''
        AND deleted_at IS NULL
        ORDER BY full_name ASC
    ");
    $inconsistent = $inconsistentQuery->getResultArray();
    echo "Found: " . count($inconsistent) . " type=2 users with islander_no (should be type=1)<br><br>";
    
    foreach ($inconsistent as $user) {
        echo "- ID: {$user['id']}, Name: {$user['full_name']}, Type: {$user['type']}, Status: {$user['status_id']}, Islander No: {$user['islander_no']}<br>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; }
h2, h3 { color: #333; }
.error { color: red; font-weight: bold; }
.warning { color: orange; font-weight: bold; }
</style>