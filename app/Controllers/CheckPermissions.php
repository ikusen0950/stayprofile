<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CheckPermissions extends Controller
{
    public function visitors()
    {
        $db = \Config\Database::connect();
        
        echo "<h2>Checking visitors permissions in auth_permissions table:</h2>\n";

        $permissions = $db->table('auth_permissions')
                         ->like('name', 'visitors.', 'after')
                         ->get()
                         ->getResultArray();

        if (empty($permissions)) {
            echo "<p>No visitors permissions found.</p>\n";
        } else {
            echo "<p>Found " . count($permissions) . " visitors permissions:</p>\n";
            echo "<ul>\n";
            foreach ($permissions as $permission) {
                echo "<li>ID: {$permission['id']}, Name: {$permission['name']}, Description: {$permission['description']}</li>\n";
            }
            echo "</ul>\n";
        }

        echo "<h2>Checking group permissions assignments:</h2>\n";

        $groupPermissions = $db->query("
            SELECT g.name as group_name, p.name as permission_name 
            FROM auth_groups g 
            JOIN auth_groups_permissions gp ON g.id = gp.group_id 
            JOIN auth_permissions p ON gp.permission_id = p.id 
            WHERE p.name LIKE 'visitors.%' 
            ORDER BY g.name, p.name
        ")->getResultArray();

        if (empty($groupPermissions)) {
            echo "<p>No group permissions found for visitors.</p>\n";
        } else {
            echo "<p>Found " . count($groupPermissions) . " group permission assignments:</p>\n";
            echo "<ul>\n";
            foreach ($groupPermissions as $gp) {
                echo "<li>Group: {$gp['group_name']}, Permission: {$gp['permission_name']}</li>\n";
            }
            echo "</ul>\n";
        }

        echo "<h2>All permissions in database:</h2>\n";
        $allPermissions = $db->table('auth_permissions')->get()->getResultArray();
        echo "<ul>\n";
        foreach ($allPermissions as $permission) {
            echo "<li>ID: {$permission['id']}, Name: {$permission['name']}, Description: {$permission['description']}</li>\n";
        }
        echo "</ul>\n";

        echo "<p>Done.</p>\n";
    }
}