<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h2>Add requests.create Permission</h2>\n";

$auth = \Config\Services::authentication();
$authorize = \Config\Services::authorization();

if (!$auth->check()) {
    echo "<p>❌ Please <a href='login'>login first</a></p>\n";
    exit;
}

$user = $auth->user();
echo "<p>Current user: " . ($user->username ?? 'Unknown') . " (ID: {$user->id})</p>\n";

// Check current permission
$hasCreatePermission = has_permission('requests.create');
echo "<p>Current 'requests.create' permission: " . ($hasCreatePermission ? '✅ YES' : '❌ NO') . "</p>\n";

if (!$hasCreatePermission) {
    try {
        // Get database connection
        $db = \Config\Database::connect();
        
        // First, check if the permission exists
        $permissionQuery = $db->query("SELECT id FROM auth_permissions WHERE name = 'requests.create'");
        $permission = $permissionQuery->getRow();
        
        if (!$permission) {
            echo "<p>Creating 'requests.create' permission...</p>\n";
            $db->query("INSERT INTO auth_permissions (name, description) VALUES ('requests.create', 'Create requests')");
            $permissionQuery = $db->query("SELECT id FROM auth_permissions WHERE name = 'requests.create'");
            $permission = $permissionQuery->getRow();
        }
        
        $permissionId = $permission->id;
        echo "<p>Permission ID: {$permissionId}</p>\n";
        
        // Get user's groups
        $userGroupsQuery = $db->query("SELECT group_id FROM auth_groups_users WHERE user_id = ?", [$user->id]);
        $userGroups = $userGroupsQuery->getResult();
        
        echo "<p>User belongs to groups: ";
        foreach ($userGroups as $group) {
            echo $group->group_id . " ";
        }
        echo "</p>\n";
        
        // Add permission to each group the user belongs to
        foreach ($userGroups as $group) {
            // Check if group already has this permission
            $existingQuery = $db->query("SELECT id FROM auth_groups_permissions WHERE group_id = ? AND permission_id = ?", 
                [$group->group_id, $permissionId]);
            
            if ($existingQuery->getNumRows() == 0) {
                $db->query("INSERT INTO auth_groups_permissions (group_id, permission_id) VALUES (?, ?)", 
                    [$group->group_id, $permissionId]);
                echo "<p>✅ Added 'requests.create' permission to group {$group->group_id}</p>\n";
            } else {
                echo "<p>ℹ️ Group {$group->group_id} already has 'requests.create' permission</p>\n";
            }
        }
        
        echo "<p>✅ Permission setup complete!</p>\n";
        
    } catch (\Exception $e) {
        echo "<p>❌ Error: " . $e->getMessage() . "</p>\n";
    }
} else {
    echo "<p>✅ User already has 'requests.create' permission</p>\n";
}

echo "<p><a href='permission_debug.php'>Recheck Permissions</a></p>\n";
echo "<p><a href='requests'>Test Requests Page</a></p>\n";