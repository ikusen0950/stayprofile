<?php

namespace App\Models;

use CodeIgniter\Model;

class DivisionModel extends Model
{
    protected $table      = 'divisions';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name', 
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
            'label'  => 'Division Name',
            'rules'  => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required'    => 'Division name is required.',
                'min_length'  => 'Division name must be at least 3 characters long.',
                'max_length'  => 'Division name cannot exceed 100 characters.'
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
     * Get division by ID with validation
     */
    public function getDivision($id)
    {
        $builder = $this->db->table('divisions d');
        
        return $builder->select('d.*, 
                               CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                               CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                      ->join('users cu', 'cu.id = d.created_by', 'left')
                      ->join('users uu', 'uu.id = d.updated_by', 'left')
                      ->where('d.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get divisions with pagination and search
     */
    public function getDivisionsWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('divisions d');
        
        // Join with users tables
        $builder->select('d.*, 
                         CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                         CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                ->join('users cu', 'cu.id = d.created_by', 'left')
                ->join('users uu', 'uu.id = d.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('d.name', $search)
                    ->orLike('d.description', $search)
                    ->orLike('cu.full_name', $search)
                    ->orLike('cu.islander_no', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('d.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count divisions with search filter
     */
    public function getDivisionsCount($search = '')
    {
        $builder = $this->db->table('divisions d');
        
        // Join with users tables for consistent search results
        $builder->join('users cu', 'cu.id = d.created_by', 'left')
                ->join('users uu', 'uu.id = d.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('d.name', $search)
                    ->orLike('d.description', $search)
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
        $rules['name']['rules'] = "required|min_length[3]|max_length[100]|is_unique[divisions.name,id,{$id}]";
        $rules['name']['errors']['is_unique'] = 'This division name already exists.';
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