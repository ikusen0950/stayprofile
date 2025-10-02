<?php

// Test script to create a status and verify logging
echo "=== Status Creation and Logging Test ===\n\n";

// Simulate creating a status via HTTP request
$url = 'http://localhost:8080/status/store';
$postData = [
    'name' => 'Test Status from CLI',
    'module_id' => 1, // System module
    'color' => '#FF5733',
    'description' => 'This is a test status created from CLI script for logging verification'
];

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'X-Requested-With: XMLHttpRequest'
]);

echo "Sending POST request to create status...\n";
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Response Code: $httpCode\n";
echo "Response: $response\n\n";

// Parse response
$responseData = json_decode($response, true);
if ($responseData && isset($responseData['success'])) {
    if ($responseData['success']) {
        echo "✅ Status creation successful!\n";
        echo "Message: " . $responseData['message'] . "\n\n";
        
        echo "Now checking if log entry was created...\n";
        echo "Please check the logs table and logs page manually.\n";
    } else {
        echo "❌ Status creation failed!\n";
        echo "Message: " . $responseData['message'] . "\n";
        if (isset($responseData['errors'])) {
            echo "Errors: " . json_encode($responseData['errors']) . "\n";
        }
    }
} else {
    echo "❌ Invalid response format\n";
}

echo "\n=== Test Complete ===\n";
?>