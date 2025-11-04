<?php

namespace App\Models;

use CodeIgniter\Model;

class VillaModel extends Model
{
    protected $table      = 'villas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'villa_name', 
        'villa_code', 
        'capacity', 
        'description', 
        'created_by', 
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'villa_name' => [
            'label'  => 'Villa Name',
            'rules'  => 'required|min_length[2]|max_length[255]',
            'errors' => [
                'required'    => 'Villa name is required.',
                'min_length'  => 'Villa name must be at least 2 characters long.',
                'max_length'  => 'Villa name cannot exceed 255 characters.'
            ]
        ],
        'villa_code' => [
            'label'  => 'Villa Code',
            'rules'  => 'permit_empty|min_length[2]|max_length[50]',
            'errors' => [
                'min_length'  => 'Villa code must be at least 2 characters long.',
                'max_length'  => 'Villa code cannot exceed 50 characters.'
            ]
        ],
        'capacity' => [
            'label'  => 'Capacity',
            'rules'  => 'permit_empty|numeric|greater_than_equal_to[0]',
            'errors' => [
                'numeric'  => 'Capacity must be a valid number.',
                'greater_than_equal_to' => 'Capacity must be 0 or greater.'
            ]
        ],
        'description' => [
            'label'  => 'Description',
            'rules'  => 'permit_empty|max_length[1000]',
            'errors' => [
                'max_length' => 'Description cannot exceed 1000 characters.'
            ]
        ]
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $beforeInsert = ['setCreatedBy'];
    protected $beforeUpdate = ['setUpdatedBy'];

    /**
     * Set created_by field before insert
     */
    protected function setCreatedBy(array $data)
    {
        // Load auth helper if not already loaded
        helper('auth');
        
        // Set created_at timestamp for new records
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        
        try {
            // Try Myth/Auth user() function first
            if (function_exists('user') && user() !== null && isset(user()->id)) {
                $data['data']['created_by'] = user()->id;
            }
            // Try session-based approach
            elseif (session()->has('logged_in') && session()->has('user_id')) {
                $data['data']['created_by'] = session('user_id');
            }
            // Try alternative session key
            elseif (session()->has('user') && is_array(session('user')) && isset(session('user')['id'])) {
                $data['data']['created_by'] = session('user')['id'];
            }
        } catch (\Exception $e) {
            // Log the error but continue without setting created_by
            log_message('error', 'Failed to set created_by: ' . $e->getMessage());
        }
        
        // Ensure updated_at is NOT set on insert (should be NULL)
        if (isset($data['data']['updated_at'])) {
            unset($data['data']['updated_at']);
        }
        
        return $data;
    }

    /**
     * Set updated_by field before update
     */
    protected function setUpdatedBy(array $data)
    {
        // Load auth helper if not already loaded
        helper('auth');
        
        // Set updated_at timestamp for updates
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        
        try {
            // Try Myth/Auth user() function first
            if (function_exists('user') && user() !== null && isset(user()->id)) {
                $data['data']['updated_by'] = user()->id;
            }
            // Try session-based approach
            elseif (session()->has('logged_in') && session()->has('user_id')) {
                $data['data']['updated_by'] = session('user_id');
            }
            // Try alternative session key
            elseif (session()->has('user') && is_array(session('user')) && isset(session('user')['id'])) {
                $data['data']['updated_by'] = session('user')['id'];
            }
        } catch (\Exception $e) {
            // Log the error but continue without setting updated_by
            log_message('error', 'Failed to set updated_by: ' . $e->getMessage());
        }
        
        return $data;
    }

    /**
     * Get villa by ID with validation
     */
    public function getVilla($id)
    {
        $builder = $this->db->table('villas v');
        
        return $builder->select('v.*, 
                               CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                               CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                      ->join('users cu', 'cu.id = v.created_by', 'left')
                      ->join('users uu', 'uu.id = v.updated_by', 'left')
                      ->where('v.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get villas with pagination and search
     */
    public function getVillasWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('villas v');
        
        // Join with users tables
        $builder->select('v.*, 
                         CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                         CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                ->join('users cu', 'cu.id = v.created_by', 'left')
                ->join('users uu', 'uu.id = v.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('v.villa_name', $search)
                    ->orLike('v.villa_code', $search)
                    ->orLike('v.description', $search)
                    ->orLike('cu.full_name', $search)
                    ->orLike('cu.islander_no', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('v.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count villas with search filter
     */
    public function getVillasCount($search = '')
    {
        $builder = $this->db->table('villas v');
        
        // Join with users tables for consistent search results
        $builder->join('users cu', 'cu.id = v.created_by', 'left')
                ->join('users uu', 'uu.id = v.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('v.villa_name', $search)
                    ->orLike('v.villa_code', $search)
                    ->orLike('v.description', $search)
                    ->orLike('cu.full_name', $search)
                    ->orLike('cu.islander_no', $search)
                    ->groupEnd();
        }
        
        return $builder->countAllResults();
    }

    /**
     * Get validation rules
     */
    public function getValidationRules(array $options = []): array
    {
        return $this->validationRules;
    }

    /**
     * Get validation rules for updates (with unique constraint)
     */
    public function getUpdateValidationRules($id)
    {
        $rules = $this->validationRules;
        $rules['villa_name']['rules'] = "required|min_length[2]|max_length[255]|is_unique[villas.villa_name,id,{$id}]";
        $rules['villa_name']['errors']['is_unique'] = 'This villa name already exists.';
        
        if (!empty($rules['villa_code']['rules'])) {
            $rules['villa_code']['rules'] = "permit_empty|min_length[2]|max_length[50]|is_unique[villas.villa_code,id,{$id}]";
            $rules['villa_code']['errors']['is_unique'] = 'This villa code already exists.';
        }
        
        return $rules;
    }

    /**
     * Validate data for update operations
     */
    public function validateForUpdate($data, $id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules($this->getUpdateValidationRules($id));
        
        if (!$validation->run($data)) {
            return $validation->getErrors();
        }
        
        return true;
    }

    /**
     * Get villas with their primary images
     */
    public function getVillasWithImages(string $search = '', int $limit = 10, int $offset = 0): array
    {
        $villaImageModel = new \App\Models\VillaImageModel();
        
        $builder = $this->builder();
        
        if (!empty($search)) {
            $builder->groupStart()
                   ->like('villa_name', $search)
                   ->orLike('villa_code', $search)
                   ->orLike('description', $search)
                   ->groupEnd();
        }
        
        $villas = $builder->orderBy('villa_name', 'ASC')
                         ->limit($limit, $offset)
                         ->get()
                         ->getResultArray();
        
        // Add primary image to each villa
        foreach ($villas as &$villa) {
            $villa['primary_image'] = $villaImageModel->getPrimaryImage($villa['id']);
            $villa['image_count'] = $villaImageModel->where('villa_id', $villa['id'])->countAllResults();
        }
        
        return $villas;
    }

    /**
     * Get villa with all its images
     */
    public function getVillaWithImages(int $id): ?array
    {
        $villa = $this->find($id);
        if (!$villa) {
            return null;
        }
        
        $villaImageModel = new \App\Models\VillaImageModel();
        $villa['images'] = $villaImageModel->getVillaImages($id);
        $villa['primary_image'] = $villaImageModel->getPrimaryImage($id);
        
        return $villa;
    }

    /**
     * Delete villa and all associated images
     */
    public function deleteVillaWithImages(int $id): bool
    {
        $villaImageModel = new \App\Models\VillaImageModel();
        
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            // Get all images for this villa
            $images = $villaImageModel->getVillaImages($id);
            
            // Delete each image file and database record
            foreach ($images as $image) {
                $villaImageModel->deleteImageWithFile($image['id']);
            }
            
            // Delete the villa
            $result = $this->delete($id);
            
            $db->transComplete();
            
            return $db->transStatus() && $result;
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Failed to delete villa with images: ' . $e->getMessage());
            return false;
        }
    }
}