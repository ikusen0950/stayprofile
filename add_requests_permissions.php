<?php

// Include CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

// Get database instance
$db = \Config\Database::connect();

echo "<h2>Adding Requests Permissions</h2>\n";

try {
    // Define permissions for requests module
    $requestsPermissions = [
        ['name' => 'requests.view', 'description' => 'View requests'],
        ['name' => 'requests.create', 'description' => 'Create new requests'],
        ['name' => 'requests.edit', 'description' => 'Edit requests'],
        ['name' => 'requests.delete', 'description' => 'Delete requests'],
        ['name' => 'requests.create_past_date', 'description' => 'Create requests with past dates'],
    ];
    
    $permissionIds = [];
    
    // Insert permissions if they don't exist
    foreach ($requestsPermissions as $permission) {
        $existing = $db->table('auth_permissions')
                      ->where('name', $permission['name'])
                      ->get()
                      ->getRowArray();
        
        if (!$existing) {
            $db->table('auth_permissions')->insert($permission);
            $permissionId = $db->insertID();
            $permissionIds[$permission['name']] = $permissionId;
            echo "<p>✓ Created permission: {$permission['name']}</p>\n";
        } else {
            $permissionIds[$permission['name']] = $existing['id'];
            echo "<p>- Permission already exists: {$permission['name']}</p>\n";
        }
    }
    
    // Get admin and manager groups
    $adminGroup = $db->table('auth_groups')->where('name', 'admin')->get()->getRowArray();
    $managerGroup = $db->table('auth_groups')->where('name', 'manager')->get()->getRowArray();
    
    if ($adminGroup) {
        echo "<h3>Assigning permissions to admin group:</h3>\n";
        foreach ($permissionIds as $permName => $permId) {
            $existing = $db->table('auth_groups_permissions')
                          ->where('group_id', $adminGroup['id'])
                          ->where('permission_id', $permId)
                          ->get()
                          ->getRowArray();
            
            if (!$existing) {
                $db->table('auth_groups_permissions')->insert([
                    'group_id' => $adminGroup['id'],
                    'permission_id' => $permId
                ]);
                echo "<p>✓ Assigned {$permName} to admin group</p>\n";
            } else {
                echo "<p>- Admin already has {$permName}</p>\n";
            }
        }
    }
    
    if ($managerGroup) {
        echo "<h3>Assigning permissions to manager group:</h3>\n";
        // Managers get all permissions except delete
        $managerPermissions = ['requests.view', 'requests.create', 'requests.edit', 'requests.create_past_date'];
        
        foreach ($managerPermissions as $permName) {
            if (isset($permissionIds[$permName])) {
                $permId = $permissionIds[$permName];
                $existing = $db->table('auth_groups_permissions')
                              ->where('group_id', $managerGroup['id'])
                              ->where('permission_id', $permId)
                              ->get()
                              ->getRowArray();
                
                if (!$existing) {
                    $db->table('auth_groups_permissions')->insert([
                        'group_id' => $managerGroup['id'],
                        'permission_id' => $permId
                    ]);
                    echo "<p>✓ Assigned {$permName} to manager group</p>\n";
                } else {
                    echo "<p>- Manager already has {$permName}</p>\n";
                }
            }
        }
    }
    
    echo "<h3>Summary:</h3>\n";
    echo "<p>✅ All requests permissions have been set up successfully!</p>\n";
    echo "<p>🔐 Admin users now have full access to requests</p>\n";
    echo "<p>👥 Manager users can view, create, and edit requests</p>\n";
    
    echo "<p><strong>Next steps:</strong></p>\n";
    echo "<ol>\n";
    echo "<li>Logout and login again to refresh permissions</li>\n";
    echo "<li>Go to the requests page</li>\n";
    echo "<li>Test the transfer modal</li>\n";
    echo "</ol>\n";
    
    echo "<p><a href='debug_permissions.php'>Check Permissions Again</a></p>\n";
    echo "<p><a href='requests'>Go to Requests Page</a></p>\n";
    
} catch (\Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>\n";
    echo "<pre>" . $e->getTraceAsString() . "</pre>\n";
}