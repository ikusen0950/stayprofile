<?php

namespace App\Models;

use CodeIgniter\Model;

class PositionModel extends Model
{
    protected $table      = 'positions';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name', 
        'section_id', 
        'description', 
        'status_id',
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
            'label'  => 'Position Name',
            'rules'  => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required'    => 'Position name is required.',
                'min_length'  => 'Position name must be at least 3 characters long.',
                'max_length'  => 'Position name cannot exceed 100 characters.'
            ]
        ],
        'section_id' => [
            'label'  => 'Section',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'Section must be a valid number.'
            ]
        ],
        'status_id' => [
            'label'  => 'Status',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'Status must be a valid number.'
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
     * Get all active statuses for dropdown
     */
    public function getActiveStatuses()
    {
        $statusModel = new \App\Models\StatusModel();
        return $statusModel->where('module_id', 1)->findAll(); // Module ID 1 for divisions/departments
    }

    /**
     * Get all active sections for dropdown
     */
    public function getActiveSections()
    {
        $sectionModel = new \App\Models\SectionModel();
        return $sectionModel->findAll();
    }

    /**
     * Get position by ID with validation
     */
    public function getPosition($id)
    {
        $builder = $this->db->table('positions p');
        
        return $builder->select('p.*, 
                               s.name as section_name,
                               st.name as status_name,
                               st.color as status_color,
                               CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                               CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                      ->join('sections s', 's.id = p.section_id', 'left')
                      ->join('status st', 'st.id = p.status_id', 'left')
                      ->join('users cu', 'cu.id = p.created_by', 'left')
                      ->join('users uu', 'uu.id = p.updated_by', 'left')
                      ->where('p.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get positions with pagination and search
     */
    public function getPositionsWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('positions p');
        
        // Join with sections, status and users tables
        $builder->select('p.*, 
                         s.name as section_name,
                         st.name as status_name,
                         st.color as status_color,
                         CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                         CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                ->join('sections s', 's.id = p.section_id', 'left')
                ->join('status st', 'st.id = p.status_id', 'left')
                ->join('users cu', 'cu.id = p.created_by', 'left')
                ->join('users uu', 'uu.id = p.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('p.name', $search)
                    ->orLike('p.description', $search)
                    ->orLike('s.name', $search)
                    ->orLike('st.name', $search)
                    ->orLike('cu.full_name', $search)
                    ->orLike('cu.islander_no', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('p.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count positions with search filter
     */
    public function getPositionsCount($search = '')
    {
        $builder = $this->db->table('positions p');
        
        // Join with sections, status and users tables for consistent search results
        $builder->join('sections s', 's.id = p.section_id', 'left')
                ->join('status st', 'st.id = p.status_id', 'left')
                ->join('users cu', 'cu.id = p.created_by', 'left')
                ->join('users uu', 'uu.id = p.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('p.name', $search)
                    ->orLike('p.description', $search)
                    ->orLike('s.name', $search)
                    ->orLike('st.name', $search)
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
     * Get validation rules for updates (basic rules, custom uniqueness handled separately)
     */
    public function getUpdateValidationRules($id)
    {
        return $this->validationRules;
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

        // Check for uniqueness within section
        if (!empty($data['name']) && !empty($data['section_id'])) {
            if (!$this->isUniqueInSection($data['name'], 'name', $data, $id)) {
                return ['name' => 'This position name already exists in the selected section.'];
            }
        }
        
        return true;
    }

    /**
     * Get validation rules for create (basic rules, custom uniqueness handled separately)
     */
    public function getCreateValidationRules()
    {
        return $this->validationRules;
    }

    /**
     * Validate data for create
     */
    public function validateForCreate($data)
    {
        $validation = \Config\Services::validation();
        $validation->setRules($this->getCreateValidationRules());
        
        if (!$validation->run($data)) {
            return $validation->getErrors();
        }

        // Check for uniqueness within section
        if (!empty($data['name']) && !empty($data['section_id'])) {
            if (!$this->isUniqueInSection($data['name'], 'name', $data)) {
                return ['name' => 'This position name already exists in the selected section.'];
            }
        }
        
        return true;
    }

    /**
     * Custom validation: Check if position name is unique within the same section
     */
    public function isUniqueInSection($name, $field, $data, $updateId = null)
    {
        $sectionId = $data['section_id'] ?? null;
        
        if (!$sectionId) {
            return true; // If no section specified, skip this validation
        }
        
        $query = $this->where('name', $name)
                     ->where('section_id', $sectionId);
        
        if ($updateId) {
            $query->where('id !=', $updateId);
        }
        
        return $query->countAllResults() === 0;
    }

    /**
     * Get positions by section
     */
    public function getPositionsBySection($sectionId)
    {
        return $this->where('section_id', $sectionId)->findAll();
    }
}
