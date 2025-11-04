<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TestVillaImage extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'test:villa-image';
    protected $description = 'Test villa image model functionality';

    public function run(array $params)
    {
        CLI::write('Testing VillaImageModel...', 'yellow');
        
        $villaImageModel = new \App\Models\VillaImageModel();
        
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
        
        CLI::write('Test data: ' . json_encode($testData, JSON_PRETTY_PRINT), 'blue');
        
        try {
            $result = $villaImageModel->insert($testData);
            
            if ($result) {
                CLI::write('SUCCESS: Image inserted with ID: ' . $result, 'green');
                
                // Try to retrieve it
                $retrievedImage = $villaImageModel->find($result);
                CLI::write('Retrieved image: ' . json_encode($retrievedImage, JSON_PRETTY_PRINT), 'blue');
                
                // Clean up - delete the test record
                $villaImageModel->delete($result);
                CLI::write('Test record cleaned up.', 'green');
            } else {
                CLI::write('FAILED: Insert returned false', 'red');
                CLI::write('Validation errors: ' . json_encode($villaImageModel->errors(), JSON_PRETTY_PRINT), 'red');
            }
        } catch (\Exception $e) {
            CLI::write('EXCEPTION: ' . $e->getMessage(), 'red');
            CLI::write('Trace: ' . $e->getTraceAsString(), 'red');
        }
    }
}