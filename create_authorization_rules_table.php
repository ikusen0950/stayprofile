<?php
// Create authorization_rules table manually
require_once 'vendor/autoload.php';

try {
    $config = new \Config\Database();
    $db = \CodeIgniter\Database\Config::connect($config->default);
    
    echo "<h2>Creating Authorization Rules Table</h2>";
    
    // Check if table already exists
    if ($db->tableExists('authorization_rules')) {
        echo "<p style='color: orange;'>Table 'authorization_rules' already exists!</p>";
    } else {
        // Create the table
        $sql = "
        CREATE TABLE `authorization_rules` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `user_id` INT(11) UNSIGNED NOT NULL COMMENT 'User who has this authorization rule',
            `rule_type` ENUM('all', 'division', 'department', 'section') NOT NULL DEFAULT 'division' COMMENT 'Type of authorization: all (admin), division, department, or section',
            `target_type` ENUM('islanders', 'visitors', 'both') NOT NULL DEFAULT 'both' COMMENT 'What type of users this rule applies to',
            `division_ids` TEXT NULL COMMENT 'JSON array of division IDs user can access (for division/department rules)',
            `department_ids` TEXT NULL COMMENT 'JSON array of department IDs user can access (for department rules)',
            `section_ids` TEXT NULL COMMENT 'JSON array of section IDs user can access (for section rules)',
            `is_active` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
            `description` TEXT NULL COMMENT 'Optional description of this authorization rule',
            `created_by` INT(11) UNSIGNED NULL,
            `updated_by` INT(11) UNSIGNED NULL,
            `created_at` DATETIME NULL,
            `updated_at` DATETIME NULL,
            `deleted_at` DATETIME NULL,
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`),
            KEY `rule_type` (`rule_type`),
            KEY `target_type` (`target_type`),
            KEY `is_active` (`is_active`),
            KEY `deleted_at` (`deleted_at`),
            CONSTRAINT `fk_authorization_rules_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT `fk_authorization_rules_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
            CONSTRAINT `fk_authorization_rules_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
        ) DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;
        ";
        
        $result = $db->query($sql);
        
        if ($result) {
            echo "<p style='color: green; font-weight: bold;'>✓ Table 'authorization_rules' created successfully!</p>";
            
            // Insert sample data
            echo "<h3>Inserting Sample Data</h3>";
            
            $sampleData = [
                [
                    'user_id' => 1,
                    'rule_type' => 'all',
                    'target_type' => 'both',
                    'division_ids' => null,
                    'department_ids' => null,
                    'section_ids' => null,
                    'is_active' => 1,
                    'description' => 'Administrator - can see all users',
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => 1
                ],
                [
                    'user_id' => 2,
                    'rule_type' => 'division',
                    'target_type' => 'both',
                    'division_ids' => json_encode([1]),
                    'department_ids' => null,
                    'section_ids' => null,
                    'is_active' => 1,
                    'description' => 'Division 1 Manager - can see all users in division 1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => 1
                ]
            ];
            
            $insertCount = 0;
            foreach ($sampleData as $data) {
                if ($db->table('authorization_rules')->insert($data)) {
                    $insertCount++;
                }
            }
            
            echo "<p style='color: green;'>✓ Inserted {$insertCount} sample authorization rules</p>";
            
        } else {
            echo "<p style='color: red;'>✗ Failed to create table</p>";
        }
    }
    
    // Show current authorization rules
    echo "<h3>Current Authorization Rules:</h3>";
    $rules = $db->table('authorization_rules ar')
                ->select('ar.*, u.full_name as user_name, u.islander_no')
                ->join('users u', 'u.id = ar.user_id', 'left')
                ->where('ar.deleted_at IS NULL')
                ->get()
                ->getResultArray();
    
    if (!empty($rules)) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'><th>ID</th><th>User</th><th>Rule Type</th><th>Target Type</th><th>Status</th><th>Description</th></tr>";
        
        foreach ($rules as $rule) {
            $status = $rule['is_active'] ? 'Active' : 'Inactive';
            $statusColor = $rule['is_active'] ? 'green' : 'red';
            
            echo "<tr>";
            echo "<td>{$rule['id']}</td>";
            echo "<td>{$rule['islander_no']} - {$rule['user_name']}</td>";
            echo "<td>" . ucfirst($rule['rule_type']) . "</td>";
            echo "<td>" . ucfirst($rule['target_type']) . "</td>";
            echo "<td style='color: {$statusColor};'>{$status}</td>";
            echo "<td>{$rule['description']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No authorization rules found.</p>";
    }
    
    echo "<hr>";
    echo "<h3>🎉 Authorization Rules System Ready!</h3>";
    echo "<p><strong>You can now access the CRUD at:</strong></p>";
    echo "<p style='font-size: 18px; color: blue;'><strong>http://localhost/islanders_finolhu/public/authorization-rules</strong></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; max-width: 1000px; }
h2, h3 { color: #333; border-bottom: 2px solid #007cba; padding-bottom: 5px; }
table { width: 100%; margin: 10px 0; }
th { background: #f0f0f0; padding: 8px; text-align: left; }
td { padding: 6px; border-bottom: 1px solid #ddd; }
hr { margin: 20px 0; border: 1px solid #ddd; }
</style>