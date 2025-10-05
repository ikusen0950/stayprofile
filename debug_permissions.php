<?php

// Simple debug script to check current user permissions
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap CodeIgniter
$app = Config\Services::codeigniter();
$app->initialize();

// Check if user is logged in
echo "=== Current User Debug ===\n";

if (function_exists('logged_in') && logged_in()) {
    $user = user();
    echo "Logged in as: " . $user->username . " (ID: " . $user->id . ")\n";
    echo "Email: " . $user->email . "\n";
    
    // Check groups
    if (function_exists('in_groups')) {
        $isAdmin = in_groups('admin', $user->id);
        $isManager = in_groups('manager', $user->id);
        $isUser = in_groups('user', $user->id);
        
        echo "Is Admin: " . ($isAdmin ? 'Yes' : 'No') . "\n";
        echo "Is Manager: " . ($isManager ? 'Yes' : 'No') . "\n";
        echo "Is User: " . ($isUser ? 'Yes' : 'No') . "\n";
    }
    
    // Check specific permission
    if (function_exists('has_permission')) {
        $hasNationalitiesView = has_permission('nationalities.view', $user->id);
        echo "Has nationalities.view permission: " . ($hasNationalitiesView ? 'Yes' : 'No') . "\n";
        
        $hasDivisionsView = has_permission('divisions.view', $user->id);
        echo "Has divisions.view permission: " . ($hasDivisionsView ? 'Yes' : 'No') . "\n";
        
        $hasGendersView = has_permission('genders.view', $user->id);
        echo "Has genders.view permission: " . ($hasGendersView ? 'Yes' : 'No') . "\n";
    }
    
} else {
    echo "User is not logged in!\n";
}

echo "\n=== Database Permissions Check ===\n";
$db = \Config\Database::connect();

// Check if nationalities permissions exist
$nationalitiesPerms = $db->query("SELECT * FROM auth_permissions WHERE name LIKE 'nationalities.%'")->getResultArray();
echo "Nationalities permissions in database:\n";
foreach ($nationalitiesPerms as $perm) {
    echo "- " . $perm['name'] . ": " . $perm['description'] . "\n";
}

// Check admin group permissions
$adminPerms = $db->query("
    SELECT p.name 
    FROM auth_permissions p 
    JOIN auth_groups_permissions agp ON p.id = agp.permission_id 
    JOIN auth_groups g ON agp.group_id = g.id 
    WHERE g.name = 'admin' AND p.name LIKE 'nationalities.%'
")->getResultArray();

echo "\nAdmin group nationalities permissions:\n";
foreach ($adminPerms as $perm) {
    echo "- " . $perm['name'] . "\n";
}

echo "\nDebug completed!\n";
?>