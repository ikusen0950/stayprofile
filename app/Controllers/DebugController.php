<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DebugController extends Controller
{
    public function checkGroup5Permissions()
    {
        $db = \Config\Database::connect();
        
        echo "<h2>Auth Group ID 5 Details</h2>";
        
        // Check auth group 5 details
        $group = $db->table('auth_groups')->where('id', 5)->get()->getRowArray();
        if ($group) {
            echo "<p><strong>Group Name:</strong> " . $group['name'] . "</p>";
            echo "<p><strong>Description:</strong> " . $group['description'] . "</p>";
            
            // Check permissions
            echo "<h3>Permissions for this group:</h3>";
            $permissions = $db->table('auth_groups_permissions agp')
                            ->join('auth_permissions ap', 'ap.id = agp.permission_id')
                            ->where('agp.group_id', 5)
                            ->get()
                            ->getResultArray();
            
            if (!empty($permissions)) {
                echo "<ul>";
                foreach ($permissions as $perm) {
                    echo "<li>" . $perm['name'] . ": " . $perm['description'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p><strong>No permissions found for this group.</strong></p>";
            }
            
            // Check if requests.view permission exists
            echo "<h3>Checking 'requests.view' permission:</h3>";
            $requestsViewPerm = $db->table('auth_permissions')->where('name', 'requests.view')->get()->getRowArray();
            if ($requestsViewPerm) {
                echo "<p>✓ requests.view permission exists (ID: " . $requestsViewPerm['id'] . ")</p>";
                
                // Check if group 5 has this permission
                $hasPermission = $db->table('auth_groups_permissions')
                               ->where('group_id', 5)
                               ->where('permission_id', $requestsViewPerm['id'])
                               ->get()
                               ->getRowArray();
                
                if ($hasPermission) {
                    echo "<p style='color: green;'>✓ Group 5 HAS the requests.view permission</p>";
                } else {
                    echo "<p style='color: red;'>✗ Group 5 DOES NOT have the requests.view permission</p>";
                    echo "<p><strong>This is why assistant managers are being redirected!</strong></p>";
                }
            } else {
                echo "<p style='color: red;'>✗ requests.view permission does not exist in the database</p>";
            }
            
        } else {
            echo "<p><strong>Group with ID 5 not found.</strong></p>";
        }
    }
}