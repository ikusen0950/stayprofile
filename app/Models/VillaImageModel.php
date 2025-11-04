<?php

namespace App\Models;

use CodeIgniter\Model;

class VillaImageModel extends Model
{
    protected $table      = 'villa_images';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'villa_id',
        'image_path',
        'image_name',
        'alt_text',
        'display_order',
        'is_primary',
        'file_size',
        'mime_type',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'villa_id'      => 'required|integer|greater_than[0]',
        'image_path'    => 'required|max_length[255]',
        'image_name'    => 'permit_empty|max_length[255]',
        'alt_text'      => 'permit_empty|max_length[255]',
        'display_order' => 'permit_empty|integer',
        'is_primary'    => 'permit_empty|in_list[0,1]',
        'file_size'     => 'permit_empty|integer',
        'mime_type'     => 'permit_empty|max_length[100]',
    ];

    protected $validationMessages = [
        'villa_id' => [
            'required'      => 'Villa ID is required',
            'integer'       => 'Villa ID must be an integer',
            'greater_than'  => 'Villa ID must be valid'
        ],
        'image_path' => [
            'required'   => 'Image path is required',
            'max_length' => 'Image path cannot exceed 255 characters'
        ]
    ];

    /**
     * Get all images for a specific villa
     */
    public function getVillaImages(int $villaId): array
    {
        return $this->where('villa_id', $villaId)
                    ->orderBy('is_primary', 'DESC')
                    ->orderBy('display_order', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    /**
     * Get primary image for a villa
     */
    public function getPrimaryImage(int $villaId): ?array
    {
        $image = $this->where('villa_id', $villaId)
                      ->where('is_primary', 1)
                      ->first();
        
        // If no primary image, get the first image
        if (!$image) {
            $image = $this->where('villa_id', $villaId)
                          ->orderBy('display_order', 'ASC')
                          ->orderBy('created_at', 'ASC')
                          ->first();
        }
        
        return $image;
    }

    /**
     * Set a specific image as primary (and unset others)
     */
    public function setPrimaryImage(int $villaId, int $imageId): bool
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // First, unset all primary flags for this villa
            $this->where('villa_id', $villaId)->set(['is_primary' => 0])->update();
            
            // Then set the specific image as primary
            $result = $this->where('id', $imageId)->where('villa_id', $villaId)->set(['is_primary' => 1])->update();
            
            $db->transComplete();
            
            return $db->transStatus() && $result;
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Failed to set primary image: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update display order for multiple images
     */
    public function updateDisplayOrder(array $orderData): bool
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            foreach ($orderData as $imageId => $order) {
                $this->where('id', $imageId)->set(['display_order' => $order])->update();
            }
            
            $db->transComplete();
            return $db->transStatus();
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Failed to update display order: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete image and its file
     */
    public function deleteImageWithFile(int $imageId): bool
    {
        $image = $this->find($imageId);
        if (!$image) {
            return false;
        }

        // Delete the physical file
        $fullPath = FCPATH . 'assets/media/villas/' . $image['image_path'];
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        // Delete the database record
        return $this->delete($imageId);
    }

    /**
     * Get image statistics for a villa
     */
    public function getImageStats(int $villaId): array
    {
        $images = $this->getVillaImages($villaId);
        
        return [
            'total_images' => count($images),
            'total_size' => array_sum(array_column($images, 'file_size')),
            'has_primary' => !empty(array_filter($images, fn($img) => $img['is_primary'] == 1))
        ];
    }

    /**
     * Clean up orphaned image files
     */
    public function cleanupOrphanedFiles(): array
    {
        $uploadsPath = FCPATH . 'assets/media/villas/';
        $cleaned = [];
        
        if (!is_dir($uploadsPath)) {
            return $cleaned;
        }

        $files = glob($uploadsPath . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                $filename = basename($file);
                $exists = $this->where('image_path', $filename)->first();
                
                if (!$exists) {
                    if (unlink($file)) {
                        $cleaned[] = $filename;
                    }
                }
            }
        }
        
        return $cleaned;
    }
}