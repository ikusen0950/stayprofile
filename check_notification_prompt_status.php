<?php
$db = new mysqli('localhost', 'root', '', 'aislanderapp');

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║  Notification Prompt Status - Who Will See the Popup?     ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

$result = $db->query("
    SELECT 
        id, 
        username, 
        email, 
        CASE 
            WHEN device_token IS NULL THEN '❌ Will see prompt'
            ELSE '✅ No prompt (has token)'
        END as prompt_status,
        CASE 
            WHEN device_token IS NOT NULL 
            THEN CONCAT('Token: ', LEFT(device_token, 20), '...')
            ELSE 'No token saved yet'
        END as token_info
    FROM users 
    ORDER BY id
    LIMIT 10
");

printf("%-5s %-15s %-25s %-25s %-30s\n", 'ID', 'Username', 'Email', 'Prompt Status', 'Token Info');
echo str_repeat('-', 110) . "\n";

while ($row = $result->fetch_assoc()) {
    printf(
        "%-5s %-15s %-25s %-25s %-30s\n",
        $row['id'],
        substr($row['username'], 0, 15),
        substr($row['email'], 0, 25),
        $row['prompt_status'],
        substr($row['token_info'], 0, 30)
    );
}

echo "\n";
echo "Summary:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$stats = $db->query("
    SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN device_token IS NULL THEN 1 ELSE 0 END) as will_see_prompt,
        SUM(CASE WHEN device_token IS NOT NULL THEN 1 ELSE 0 END) as no_prompt
    FROM users
")->fetch_assoc();

echo "Total Users:             {$stats['total']}\n";
echo "Will See Prompt:         {$stats['will_see_prompt']} users ❌\n";
echo "Already Have Token:      {$stats['no_prompt']} users ✅\n";

echo "\n";
echo "📝 Note: Users with NULL device_token will see the notification\n";
echo "   permission popup when they visit the dashboard.\n";
echo "\n";
