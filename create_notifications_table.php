<?php

require_once 'vendor/autoload.php';

// Get database connection
$db = \Config\Database::connect();

// Drop table if exists (to start fresh)
$db->query("DROP TABLE IF EXISTS notifications");

// Create the notifications table
$sql = "CREATE TABLE notifications (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT(11) UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NULL,
    url VARCHAR(500) NULL,
    status_id INT(11) UNSIGNED NOT NULL DEFAULT 1,
    created_at DATETIME NULL,
    PRIMARY KEY (id),
    CONSTRAINT notifications_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT notifications_status_id_foreign FOREIGN KEY (status_id) REFERENCES status(id) ON DELETE CASCADE ON UPDATE CASCADE
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";

try {
    $db->query($sql);
    echo "✓ Notifications table created successfully!\n";
    
    // Now update the migrations table to mark this migration as run
    $migrationSql = "INSERT INTO migrations (version, class, `group`, namespace, time, batch) 
                     VALUES ('2025-10-18-054347', 'App\\\\Database\\\\Migrations\\\\CreateNotificationsTable', 'default', 'App', " . time() . ", 
                            (SELECT COALESCE(MAX(batch), 0) + 1 FROM (SELECT batch FROM migrations) AS temp))";
    
    $db->query($migrationSql);
    echo "✓ Migration tracking updated!\n";
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

// Verify the table was created
$result = $db->query("SHOW TABLES LIKE 'notifications'");
if ($result->getNumRows() > 0) {
    echo "✓ Notifications table exists in database\n";
    
    // Show table structure
    $structure = $db->query("DESCRIBE notifications");
    echo "\nTable structure:\n";
    foreach ($structure->getResultArray() as $column) {
        echo "  - {$column['Field']} ({$column['Type']})\n";
    }
} else {
    echo "✗ Notifications table was not created\n";
}
