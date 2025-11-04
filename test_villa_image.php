<?php

// Load CodeIgniter bootstrap
define('SYSTEMPATH', __DIR__ . '/vendor/codeigniter4/framework/system/');
define('APPPATH', __DIR__ . '/app/');
define('FCPATH', __DIR__ . '/public/');
define('WRITEPATH', __DIR__ . '/writable/');
define('ROOTPATH', __DIR__ . '/');
define('CI_DEBUG', 1);

require_once SYSTEMPATH . 'bootstrap.php';

// Load database configuration
$config = config('Database');
$db = \Config\Database::connect();

echo "Testing direct database insert into villa_images table...\n";

// Test data
$testData = [
    'villa_id' => 1,
    'image_path' => 'test_image.jpg',
    'image_name' => 'Test Image',
    'alt_text' => 'Test image alt text',
    'display_order' => 0,
    'is_primary' => 1,
    'file_size' => 123456,
    'mime_type' => 'image/jpeg',
    'created_by' => 1,
    'created_at' => date('Y-m-d H:i:s')
];

echo "Test data: " . json_encode($testData, JSON_PRETTY_PRINT) . "\n";

try {
    // Direct database insert
    $result = $db->table('villa_images')->insert($testData);
    
    if ($result) {
        echo "SUCCESS: Direct database insert successful\n";
        
        // Get the inserted ID
        $insertId = $db->insertID();
        echo "Inserted ID: " . $insertId . "\n";
        
        // Try to retrieve it
        $retrievedImage = $db->table('villa_images')->where('id', $insertId)->get()->getRowArray();
        echo "Retrieved image: " . json_encode($retrievedImage, JSON_PRETTY_PRINT) . "\n";
        
        // Clean up - delete the test record
        $db->table('villa_images')->where('id', $insertId)->delete();
        echo "Test record cleaned up.\n";
    } else {
        echo "FAILED: Direct database insert failed\n";
        echo "Database error: " . $db->error() . "\n";
    }
    
    // Now test with model
    echo "\nTesting with VillaImageModel...\n";
    $villaImageModel = new \App\Models\VillaImageModel();
    
    $modelResult = $villaImageModel->insert($testData);
    
    if ($modelResult) {
        echo "SUCCESS: Model insert successful with ID: " . $modelResult . "\n";
        
        // Clean up
        $villaImageModel->delete($modelResult);
        echo "Model test record cleaned up.\n";
    } else {
        echo "FAILED: Model insert failed\n";
        echo "Validation errors: " . json_encode($villaImageModel->errors(), JSON_PRETTY_PRINT) . "\n";
    }
    
} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}