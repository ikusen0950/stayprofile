<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusModel extends Model
{
    protected $table      = 'status';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name', 
        'module_id', 
        'color', 
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
        'name' => [
            'label'  => 'Status Name',
            'rules'  => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required'    => 'Status name is required.',
                'min_length'  => 'Status name must be at least 3 characters long.',
                'max_length'  => 'Status name cannot exceed 100 characters.'
            ]
        ],
        'module_id' => [
            'label'  => 'Module',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'Module must be a valid number.'
            ]
        ],
        'color' => [
            'label'  => 'Color',
            'rules'  => 'permit_empty|regex_match[/^#[0-9A-Fa-f]{6}$/]',
            'errors' => [
                'regex_match' => 'Color must be a valid hex color code (e.g., #FF5733).'
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
     * Get all active modules for dropdown
     */
    public function getActiveModules()
    {
        $moduleModel = new \App\Models\ModuleModel();
        return $moduleModel->where('status_id', 1)->findAll();
    }

    /**
     * Get status by ID with validation
     */
    public function getStatus($id)
    {
        $builder = $this->db->table('status s');
        
        return $builder->select('s.*, 
                               m.name as module_name,
                               CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                               CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                      ->join('modules m', 'm.id = s.module_id', 'left')
                      ->join('users cu', 'cu.id = s.created_by', 'left')
                      ->join('users uu', 'uu.id = s.updated_by', 'left')
                      ->where('s.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get status with pagination and search
     */
    public function getStatusWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('status s');
        
        // Join with modules and users tables
        $builder->select('s.*, 
                         m.name as module_name,
                         CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                         CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                ->join('modules m', 'm.id = s.module_id', 'left')
                ->join('users cu', 'cu.id = s.created_by', 'left')
                ->join('users uu', 'uu.id = s.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('s.name', $search)
                    ->orLike('s.description', $search)
                    ->orLike('m.name', $search)
                    ->orLike('cu.full_name', $search)
                    ->orLike('cu.islander_no', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('s.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count status with search filter
     */
    public function getStatusCount($search = '')
    {
        $builder = $this->db->table('status s');
        
        // Join with modules and users tables for consistent search results
        $builder->join('modules m', 'm.id = s.module_id', 'left')
                ->join('users cu', 'cu.id = s.created_by', 'left')
                ->join('users uu', 'uu.id = s.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('s.name', $search)
                    ->orLike('s.description', $search)
                    ->orLike('m.name', $search)
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
        $rules['name']['rules'] = "required|min_length[3]|max_length[100]|is_unique[status.name,id,{$id}]";
        $rules['name']['errors']['is_unique'] = 'This status name already exists.';
        return $rules;
    }

    /**
     * Validate data for update
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
     * Get status by module
     */
    public function getStatusByModule($moduleId)
    {
        return $this->where('module_id', $moduleId)->findAll();
    }
}