<?php

/**
 * This script demonstrates how device tokens are saved and retrieved
 */

echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║       Device Token Save Flow - Demonstration                 ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

// Direct database connection
$db = new mysqli('localhost', 'root', '', 'aislanderapp');

// 1. Show users table structure
echo "📋 Step 1: Users Table Structure\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$query = $db->query("DESCRIBE users");
$found = false;

while ($row = $query->fetch_assoc()) {
    if ($row['Field'] === 'device_token') {
        echo "✅ Found: {$row['Field']}\n";
        echo "   Type: {$row['Type']}\n";
        echo "   Null: {$row['Null']}\n";
        echo "   👆 THIS IS WHERE FCM TOKENS ARE STORED 👆\n";
        $found = true;
        break;
    }
}

if (!$found) {
    echo "❌ device_token field not found!\n";
    exit(1);
}

echo "\n";

// 2. Check current device tokens
echo "📱 Step 2: Current Device Tokens in Database\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$query = $db->query("
    SELECT 
        id,
        username,
        email,
        CASE 
            WHEN device_token IS NOT NULL 
            THEN CONCAT(LEFT(device_token, 30), '...')
            ELSE 'Not Registered'
        END as token_preview,
        CASE 
            WHEN device_token IS NOT NULL 
            THEN '✅ Yes'
            ELSE '❌ No'
        END as has_token
    FROM users
    LIMIT 10
");

if ($query->num_rows === 0) {
    echo "No users found in database.\n";
} else {
    printf("%-5s %-15s %-25s %-35s %-10s\n", 'ID', 'Username', 'Email', 'Token Preview', 'Has Token');
    echo str_repeat('-', 100) . "\n";
    
    while ($user = $query->fetch_assoc()) {
        printf(
            "%-5s %-15s %-25s %-35s %-10s\n",
            $user['id'],
            substr($user['username'], 0, 15),
            substr($user['email'], 0, 25),
            $user['token_preview'],
            $user['has_token']
        );
    }
}

echo "\n";

// 3. Simulate token registration flow
echo "🔄 Step 3: Simulating Token Registration Flow\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

echo "\n1️⃣  Mobile App Login:\n";
echo "   User logs in → Gets auth token\n";
echo "   user_id = 1, auth_token = 'abc123...'\n";

echo "\n2️⃣  Firebase Registration:\n";
echo "   App calls: PushNotifications.register()\n";
echo "   FCM returns: 'fK8x9p2mS_k:APA91bH...'\n";

echo "\n3️⃣  API Call to Backend:\n";
echo "   POST /api/device/register-token\n";
echo "   Headers: Authorization: Bearer abc123...\n";
echo "   Body: {\n";
echo "     \"device_token\": \"fK8x9p2mS_k:APA91bH...\",\n";
echo "     \"platform\": \"android\"\n";
echo "   }\n";

echo "\n4️⃣  Backend Processing:\n";
echo "   - Validates auth token → user_id = 1\n";
echo "   - Executes SQL:\n";
echo "     UPDATE users \n";
echo "     SET device_token = 'fK8x9p2mS_k:APA91bH...'\n";
echo "     WHERE id = 1;\n";

echo "\n5️⃣  Response to Mobile App:\n";
echo "   {\n";
echo "     \"success\": true,\n";
echo "     \"message\": \"Device token registered successfully\"\n";
echo "   }\n";

echo "\n6️⃣  Token Now Stored:\n";
echo "   User #1 can now receive push notifications! ✅\n";

echo "\n";

// 4. Show count of registered devices
echo "📊 Step 4: Statistics\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$query = $db->query("
    SELECT 
        COUNT(*) as total_users,
        SUM(CASE WHEN device_token IS NOT NULL THEN 1 ELSE 0 END) as registered_devices,
        SUM(CASE WHEN device_token IS NULL THEN 1 ELSE 0 END) as without_token
    FROM users
");

$stats = $query->fetch_object();

echo "Total Users:          {$stats->total_users}\n";
echo "Registered Devices:   {$stats->registered_devices} ✅\n";
echo "Without Token:        {$stats->without_token} ⏳\n";

echo "\n";

// 5. Show how to send notification
echo "📤 Step 5: How to Send Notification to User with Token\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

echo "\nIn your controller:\n\n";
echo "<?php\n";
echo "helper('notification');\n\n";
echo "// Send notification to user #1\n";
echo "\$result = send_push_notification(\n";
echo "    1,  // user_id (must have device_token in database)\n";
echo "    'New Request',\n";
echo "    'Request #123 has been assigned to you',\n";
echo "    ['url' => '/requests/123']\n";
echo ");\n\n";
echo "if (\$result['success']) {\n";
echo "    echo 'Notification sent! 🎉';\n";
echo "}\n";

echo "\n";
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║                    ✅ System Ready!                          ║\n";
echo "║  Device tokens are saved in: users.device_token (TEXT)       ║\n";
echo "║  API Endpoint: POST /api/device/register-token               ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n";
echo "\n";
