<?php

namespace App\Models;

use CodeIgniter\Model;

class FlightRouteModel extends Model
{
    protected $table      = 'flight_routes';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name', 
        'description',
        'type',
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
            'label'  => 'Flight Route Name',
            'rules'  => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required'    => 'Flight route name is required.',
                'min_length'  => 'Flight route name must be at least 3 characters long.',
                'max_length'  => 'Flight route name cannot exceed 100 characters.'
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
        ],
        'type' => [
            'label'  => 'Type',
            'rules'  => 'permit_empty|in_list[Departure,Arrival]',
            'errors' => [
                'in_list' => 'Type must be either Departure or Arrival.'
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
        return $statusModel->where('module_id', 1)->findAll(); // Module ID 1 for flight routes
    }

    /**
     * Get flight route by ID with validation
     */
    public function getFlightRoute($id)
    {
        $builder = $this->db->table('flight_routes fr');
        
        return $builder->select('fr.*, 
                               s.name as status_name,
                               s.color as status_color,
                               CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                               CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                      ->join('status s', 's.id = fr.status_id', 'left')
                      ->join('users cu', 'cu.id = fr.created_by', 'left')
                      ->join('users uu', 'uu.id = fr.updated_by', 'left')
                      ->where('fr.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get flight routes with pagination and search
     */
    public function getFlightRoutesWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('flight_routes fr');
        
        // Join with status and users tables
        $builder->select('fr.*, 
                         s.name as status_name,
                         s.color as status_color,
                         CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                         CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                ->join('status s', 's.id = fr.status_id', 'left')
                ->join('users cu', 'cu.id = fr.created_by', 'left')
                ->join('users uu', 'uu.id = fr.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('fr.name', $search)
                    ->orLike('fr.description', $search)
                    ->orLike('s.name', $search)
                    ->orLike('cu.full_name', $search)
                    ->orLike('cu.islander_no', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('fr.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count flight routes with search filter
     */
    public function getFlightRoutesCount($search = '')
    {
        $builder = $this->db->table('flight_routes fr');
        
        // Join with status and users tables for consistent search results
        $builder->join('status s', 's.id = fr.status_id', 'left')
                ->join('users cu', 'cu.id = fr.created_by', 'left')
                ->join('users uu', 'uu.id = fr.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('fr.name', $search)
                    ->orLike('fr.description', $search)
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
        $rules['name']['rules'] = "required|min_length[3]|max_length[100]|is_unique[flight_routes.name,id,{$id}]";
        $rules['name']['errors']['is_unique'] = 'This flight route name already exists.';
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
     * Get active flight routes by type for dropdowns
     */
    public function getActiveRoutesByType($type)
    {
        $builder = $this->db->table('flight_routes');
        
        return $builder->select('id, name, description, type')
                      ->where('type', $type)
                      ->where('status_id', 1) // Active status
                      ->orderBy('name', 'ASC')
                      ->get()
                      ->getResultArray();
    }
}