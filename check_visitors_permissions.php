<?php

// Check visitors permissions in database
$db = \Config\Database::connect();

echo "Checking visitors permissions in auth_permissions table:\n\n";

$permissions = $db->table('auth_permissions')
                 ->like('name', 'visitors.', 'after')
                 ->get()
                 ->getResultArray();

if (empty($permissions)) {
    echo "No visitors permissions found.\n";
} else {
    echo "Found " . count($permissions) . " visitors permissions:\n";
    foreach ($permissions as $permission) {
        echo "- ID: {$permission['id']}, Name: {$permission['name']}, Description: {$permission['description']}\n";
    }
}

echo "\nChecking group permissions assignments:\n\n";

$groupPermissions = $db->query("
    SELECT g.name as group_name, p.name as permission_name 
    FROM auth_groups g 
    JOIN auth_groups_permissions gp ON g.id = gp.group_id 
    JOIN auth_permissions p ON gp.permission_id = p.id 
    WHERE p.name LIKE 'visitors.%' 
    ORDER BY g.name, p.name
")->getResultArray();

if (empty($groupPermissions)) {
    echo "No group permissions found for visitors.\n";
} else {
    echo "Found " . count($groupPermissions) . " group permission assignments:\n";
    foreach ($groupPermissions as $gp) {
        echo "- Group: {$gp['group_name']}, Permission: {$gp['permission_name']}\n";
    }
}

echo "\nDone.\n";
?>