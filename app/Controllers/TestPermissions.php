<?php

namespace App\Controllers;

class TestPermissions extends BaseController
{
    public function authorizationRules()
    {
        echo "<h2>Authorization Rules Permission Test</h2>";
        
        // Check if user is logged in
        if (!logged_in()) {
            echo "<p style='color: red;'>User is NOT logged in</p>";
            return;
        }
        
        echo "<p style='color: green;'>User is logged in</p>";
        
        // Get current user
        $user = user();
        echo "<p>Current User: " . ($user->username ?? 'Unknown') . "</p>";
        
        // Check groups
        $groups = user()->getGroups();
        echo "<p>User Groups: " . implode(', ', $groups) . "</p>";
        
        // Test specific permissions
        $permissions = [
            'authorization_rules.view',
            'authorization_rules.create',
            'authorization_rules.edit',
            'authorization_rules.delete'
        ];
        
        echo "<h3>Permission Check Results:</h3>";
        foreach ($permissions as $permission) {
            $hasPermission = has_permission($permission);
            $status = $hasPermission ? 'YES' : 'NO';
            $color = $hasPermission ? 'green' : 'red';
            echo "<p style='color: {$color};'>{$permission}: {$status}</p>";
        }
        
        // Try to redirect to authorization rules
        echo "<br><a href='/authorization-rules'>Go to Authorization Rules</a>";
    }
}