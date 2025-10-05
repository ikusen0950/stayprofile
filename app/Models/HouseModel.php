<?php

namespace App\Models;

use CodeIgniter\Model;

class HouseModel extends Model
{
    protected $table      = 'houses';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name', 
        'description', 
        'color',
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
            'label'  => 'House Name',
            'rules'  => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required'    => 'House name is required.',
                'min_length'  => 'House name must be at least 3 characters long.',
                'max_length'  => 'House name cannot exceed 100 characters.'
            ]
        ],
        'color' => [
            'label'  => 'House Color',
            'rules'  => 'permit_empty|max_length[7]|regex_match[/^#[0-9A-Fa-f]{6}$/]',
            'errors' => [
                'max_length'   => 'Color code cannot exceed 7 characters.',
                'regex_match'  => 'Color must be a valid hex color code (e.g., #FF0000).'
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
        return $statusModel->where('module_id', 1)->findAll(); // Module ID 1 for houses
    }

    /**
     * Get house by ID with validation
     */
    public function getHouse($id)
    {
        $builder = $this->db->table('houses h');
        
        return $builder->select('h.*, 
                               s.name as status_name,
                               s.color as status_color,
                               CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                               CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                      ->join('status s', 's.id = h.status_id', 'left')
                      ->join('users cu', 'cu.id = h.created_by', 'left')
                      ->join('users uu', 'uu.id = h.updated_by', 'left')
                      ->where('h.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get houses with pagination and search
     */
    public function getHousesWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('houses h');
        
        // Join with status and users tables
        $builder->select('h.*, 
                         s.name as status_name,
                         s.color as status_color,
                         CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                         CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                ->join('status s', 's.id = h.status_id', 'left')
                ->join('users cu', 'cu.id = h.created_by', 'left')
                ->join('users uu', 'uu.id = h.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('h.name', $search)
                    ->orLike('h.description', $search)
                    ->orLike('h.color', $search)
                    ->orLike('s.name', $search)
                    ->orLike('cu.full_name', $search)
                    ->orLike('cu.islander_no', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('h.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count houses with search filter
     */
    public function getHousesCount($search = '')
    {
        $builder = $this->db->table('houses h');
        
        // Join with status and users tables for consistent search results
        $builder->join('status s', 's.id = h.status_id', 'left')
                ->join('users cu', 'cu.id = h.created_by', 'left')
                ->join('users uu', 'uu.id = h.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('h.name', $search)
                    ->orLike('h.description', $search)
                    ->orLike('h.color', $search)
                    ->orLike('s.name', $search)
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
        $rules['name']['rules'] = "required|min_length[3]|max_length[100]|is_unique[houses.name,id,{$id}]";
        $rules['name']['errors']['is_unique'] = 'This house name already exists.';
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
}