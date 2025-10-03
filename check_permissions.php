<?php
require_once 'vendor/autoload.php';

// Initialize CodeIgniter
$app = Config\Services::codeigniter();
$app->initialize();

$db = \Config\Database::connect();

echo "=== User Group Assignments ===\n";
$userGroups = $db->query("
    SELECT u.id, u.username, u.email, g.name as group_name 
    FROM users u 
    LEFT JOIN auth_groups_users agu ON u.id = agu.user_id 
    LEFT JOIN auth_groups g ON agu.group_id = g.id
")->getResultArray();

foreach ($userGroups as $ug) {
    echo "User: {$ug['username']} (ID: {$ug['id']}) - Group: " . ($ug['group_name'] ?? 'No group') . "\n";
}

echo "\n=== Sections Permissions ===\n";
$sectionsPerms = $db->query("SELECT * FROM auth_permissions WHERE name LIKE 'sections.%'")->getResultArray();
foreach ($sectionsPerms as $perm) {
    echo "Permission: {$perm['name']} - {$perm['description']}\n";
}

echo "\n=== Admin Group Permissions ===\n";
$adminPerms = $db->query("
    SELECT p.name, p.description 
    FROM auth_permissions p 
    JOIN auth_groups_permissions agp ON p.id = agp.permission_id 
    JOIN auth_groups g ON agp.group_id = g.id 
    WHERE g.name = 'admin' AND p.name LIKE 'sections.%'
")->getResultArray();

foreach ($adminPerms as $perm) {
    echo "Admin has: {$perm['name']} - {$perm['description']}\n";
}
?>