<?php

namespace App\Models;

use CodeIgniter\Model;

class RequestModel extends Model
{
    protected $table      = 'requests';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'status_id', 
        'user_id', 
        'leave_id', 
        'transfer_type', 
        'transfer_route_type', 
        'transfer_departure_route_id', 
        'transfer_departure_date', 
        'transfer_arrival_route_id', 
        'transfer_arrival_date', 
        'second_transfer', 
        'expected_arrival_date', 
        'expected_departure_date', 
        'departed_route_id', 
        'departed_date', 
        'expected_departure_time', 
        'departed_time', 
        'arrived_route_id', 
        'arrived_date', 
        'expected_arrival_time', 
        'arrived_time', 
        'security_onduty_arrival', 
        'security_onduty_arrival_at', 
        'security_onduty_departure', 
        'security_onduty_departure_at', 
        'security_onduty_no_show', 
        'security_onduty_no_show_at', 
        'security_onduty_revert_back', 
        'security_onduty_revert_back_at', 
        'security_onduty_cancel', 
        'security_onduty_cancel_at', 
        'security_onduty_expired', 
        'security_onduty_expired_at', 
        'type', 
        'type_color', 
        'type_description', 
        'approval_level', 
        'remarks', 
        'created_by', 
        'updated_by',
        'created_at',
        'updated_at',
        'is_assistant_manager', 
        'approved_by', 
        'approved_at', 
        'rejected_by', 
        'rejected_at', 
        'transfer_departure_status', 
        'transfer_departure_carrier', 
        'transfer_departure_flight', 
        'transfer_departure_pnr', 
        'transfer_departure_check_in_time', 
        'transfer_departure_departure_time', 
        'transfer_departure_arrival_time', 
        'transfer_departure_remarks', 
        'transfer_arrival_status', 
        'transfer_arrival_carrier', 
        'transfer_arrival_flight', 
        'transfer_arrival_pnr', 
        'transfer_arrival_check_in_time', 
        'transfer_arrival_departure_time', 
        'transfer_arrival_arrival_time', 
        'mode_of_transport', 
        'luggage_assistance', 
        'transfer_arrival_remarks', 
        'booked_by', 
        'booked_at'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'status_id' => [
            'label'  => 'Status',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'Status must be a valid number.'
            ]
        ],
        'user_id' => [
            'label'  => 'User',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'User is required.',
                'numeric'  => 'User must be a valid number.'
            ]
        ],
        'type' => [
            'label'  => 'Request Type',
            'rules'  => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required'    => 'Request type is required.',
                'min_length'  => 'Request type must be at least 3 characters long.',
                'max_length'  => 'Request type cannot exceed 100 characters.'
            ]
        ],
        'type_color' => [
            'label'  => 'Type Color',
            'rules'  => 'permit_empty|regex_match[/^#[0-9A-Fa-f]{6}$/]',
            'errors' => [
                'regex_match' => 'Color must be a valid hex color code (e.g., #FF5733).'
            ]
        ],
        'type_description' => [
            'label'  => 'Type Description',
            'rules'  => 'permit_empty|max_length[1000]',
            'errors' => [
                'max_length' => 'Type description cannot exceed 1000 characters.'
            ]
        ],
        'remarks' => [
            'label'  => 'Remarks',
            'rules'  => 'permit_empty|max_length[2000]',
            'errors' => [
                'max_length' => 'Remarks cannot exceed 2000 characters.'
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
        return $statusModel->findAll();
    }

    /**
     * Get all active users for dropdown
     */
    public function getActiveUsers()
    {
        return $this->db->table('users')
            ->select('id, full_name, username, islander_no')
            ->where('active', 1)
            ->where('deleted_at IS NULL')
            ->orderBy('full_name, username')
            ->get()
            ->getResultArray();
    }

    /**
     * Get request by ID with validation
     */
    public function getRequest($id)
    {
        $builder = $this->db->table('requests r');
        
        return $builder->select('r.*, 
                               s.name as status_name,
                               s.color as status_color,
                               CONCAT(u.islander_no, " - ", u.full_name) as user_name,
                               CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                               CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name,
                               CONCAT(au.islander_no, " - ", au.full_name) as approved_by_name,
                               CONCAT(ru.islander_no, " - ", ru.full_name) as rejected_by_name,
                               CONCAT(bu.islander_no, " - ", bu.full_name) as booked_by_name')
                      ->join('status s', 's.id = r.status_id', 'left')
                      ->join('users u', 'u.id = r.user_id', 'left')
                      ->join('users cu', 'cu.id = r.created_by', 'left')
                      ->join('users uu', 'uu.id = r.updated_by', 'left')
                      ->join('users au', 'au.id = r.approved_by', 'left')
                      ->join('users ru', 'ru.id = r.rejected_by', 'left')
                      ->join('users bu', 'bu.id = r.booked_by', 'left')
                      ->where('r.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get requests with pagination and search
     */
    public function getRequestsWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('requests r');
        
        // Join with status and users tables
        $builder->select('r.*, 
                         s.name as status_name,
                         s.color as status_color,
                         CONCAT(u.islander_no, " - ", u.full_name) as user_name,
                         CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                         CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                ->join('status s', 's.id = r.status_id', 'left')
                ->join('users u', 'u.id = r.user_id', 'left')
                ->join('users cu', 'cu.id = r.created_by', 'left')
                ->join('users uu', 'uu.id = r.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('r.type', $search)
                    ->orLike('r.type_description', $search)
                    ->orLike('r.remarks', $search)
                    ->orLike('s.name', $search)
                    ->orLike('u.full_name', $search)
                    ->orLike('u.islander_no', $search)
                    ->orLike('cu.full_name', $search)
                    ->orLike('cu.islander_no', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('r.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count requests with search filter
     */
    public function getRequestsCount($search = '')
    {
        $builder = $this->db->table('requests r');
        
        // Join with status and users tables for consistent search results
        $builder->join('status s', 's.id = r.status_id', 'left')
                ->join('users u', 'u.id = r.user_id', 'left')
                ->join('users cu', 'cu.id = r.created_by', 'left')
                ->join('users uu', 'uu.id = r.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('r.type', $search)
                    ->orLike('r.type_description', $search)
                    ->orLike('r.remarks', $search)
                    ->orLike('s.name', $search)
                    ->orLike('u.full_name', $search)
                    ->orLike('u.islander_no', $search)
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
        // Remove unique constraint for updates since requests can have similar types
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
     * Get requests by user
     */
    public function getRequestsByUser($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }

    /**
     * Get requests by status
     */
    public function getRequestsByStatus($statusId)
    {
        return $this->where('status_id', $statusId)->findAll();
    }
}