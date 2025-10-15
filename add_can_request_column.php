<?php
// Add can_request column to authorization_rules table

try {
    // Create database connection manually (adjust credentials as needed)
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'aislanderapp';
    
    $mysqli = new mysqli($host, $username, $password, $database);
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    echo "<h2>Adding can_request Column to Authorization Rules Table</h2>";
    
    // Check if column already exists
    $result = $mysqli->query("SHOW COLUMNS FROM authorization_rules LIKE 'can_request'");
    
    if ($result->num_rows > 0) {
        echo "<p style='color: orange;'>Column 'can_request' already exists in authorization_rules table!</p>";
    } else {
        // Add the column
        $sql = "ALTER TABLE `authorization_rules` ADD COLUMN `can_request` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = can request, 0 = cannot request' AFTER `is_active`";
        
        if ($mysqli->query($sql)) {
            echo "<p style='color: green;'>✓ Successfully added 'can_request' column to authorization_rules table</p>";
        } else {
            echo "<p style='color: red;'>✗ Failed to add 'can_request' column: " . $mysqli->error . "</p>";
        }
    }
    
    // Show current table structure
    echo "<h3>Current Table Structure:</h3>";
    $result = $mysqli->query("DESCRIBE authorization_rules");
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<br><a href='/'>Return to Application</a>";
?>
