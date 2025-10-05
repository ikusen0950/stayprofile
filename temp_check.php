<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=aislanderapp', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    // First, let's see all islanders permissions
    echo "=== ISLANDERS PERMISSIONS ===\n";
    $stmt = $pdo->query('SELECT id, name, description FROM auth_permissions WHERE name LIKE "islanders.%" ORDER BY name');
    $permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($permissions as $perm) {
        echo "ID: {$perm['id']}, Name: {$perm['name']}\n";
    }
    
    // Check which groups have these permissions
    echo "\n=== GROUP ASSIGNMENTS ===\n";
    $stmt = $pdo->query('
        SELECT g.name as group_name, p.name as permission_name 
        FROM auth_groups_permissions gp
        JOIN auth_groups g ON gp.group_id = g.id
        JOIN auth_permissions p ON gp.permission_id = p.id
        WHERE p.name LIKE "islanders.%"
        ORDER BY g.name, p.name
    ');
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($assignments as $assign) {
        echo "Group: {$assign['group_name']}, Permission: {$assign['permission_name']}\n";
    }
    
    // Check current user groups
    echo "\n=== CURRENT USER GROUPS ===\n";
    $stmt = $pdo->query('
        SELECT u.email, g.name as group_name 
        FROM auth_users_groups ug
        JOIN users u ON ug.user_id = u.id
        JOIN auth_groups g ON ug.group_id = g.id
        ORDER BY u.email, g.name
    ');
    $userGroups = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($userGroups as $ug) {
        echo "User: {$ug['email']}, Group: {$ug['group_name']}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>