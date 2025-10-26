<?php
// Define FCPATH
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);

require_once 'vendor/autoload.php';

// Initialize CodeIgniter
$paths = new \Config\Paths();
$bootstrap = rtrim(realpath(FCPATH . '../app'), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'Bootstrap.php';
require $bootstrap;

$app = \Config\Services::codeigniter();
$app->initialize();

$db = \Config\Database::connect();

echo "Auth Group ID 5 Details:\n";
echo "========================\n";

// Check auth group 5 details
$group = $db->table('auth_groups')->where('id', 5)->get()->getRowArray();
if ($group) {
    echo "Group Name: " . $group['name'] . "\n";
    echo "Description: " . $group['description'] . "\n\n";
    
    // Check permissions
    echo "Permissions for this group:\n";
    echo "---------------------------\n";
    $permissions = $db->table('auth_groups_permissions agp')
                    ->join('auth_permissions ap', 'ap.id = agp.permission_id')
                    ->where('agp.group_id', 5)
                    ->get()
                    ->getResultArray();
    
    if (!empty($permissions)) {
        foreach ($permissions as $perm) {
            echo "- " . $perm['name'] . ": " . $perm['description'] . "\n";
        }
    } else {
        echo "No permissions found for this group.\n";
    }
    
    // Check if requests.view permission exists
    echo "\n";
    echo "Checking if 'requests.view' permission exists:\n";
    echo "----------------------------------------------\n";
    $requestsViewPerm = $db->table('auth_permissions')->where('name', 'requests.view')->get()->getRowArray();
    if ($requestsViewPerm) {
        echo "✓ requests.view permission exists (ID: " . $requestsViewPerm['id'] . ")\n";
        
        // Check if group 5 has this permission
        $hasPermission = $db->table('auth_groups_permissions')
                           ->where('group_id', 5)
                           ->where('permission_id', $requestsViewPerm['id'])
                           ->get()
                           ->getRowArray();
        
        if ($hasPermission) {
            echo "✓ Group 5 HAS the requests.view permission\n";
        } else {
            echo "✗ Group 5 DOES NOT have the requests.view permission\n";
        }
    } else {
        echo "✗ requests.view permission does not exist in the database\n";
    }
    
} else {
    echo "Group with ID 5 not found.\n";
}
?>