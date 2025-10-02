<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table      = 'logs';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'status_id', 
        'action', 
        'user_id',
        'module_id',
        'logged_at'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'logged_at';
    protected $updatedField  = '';

    protected $validationRules = [
        'action' => [
            'label'  => 'Action',
            'rules'  => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required'    => 'Action is required.',
                'min_length'  => 'Action must be at least 3 characters long.',
                'max_length'  => 'Action cannot exceed 255 characters.'
            ]
        ],
        'status_id' => [
            'label'  => 'Status',
            'rules'  => 'required|in_list[1,2,3,4,5]',
            'errors' => [
                'required' => 'Status is required.',
                'in_list'  => 'Invalid status value.'
            ]
        ],
        'module_id' => [
            'label'  => 'Module',
            'rules'  => 'permit_empty|integer',
            'errors' => [
                'integer' => 'Module ID must be a valid integer.'
            ]
        ]
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $beforeInsert = ['setLoggedAt'];

    /**
     * Set logged_at field and user_id before insert
     */
    protected function setLoggedAt(array $data)
    {
        // Load auth helper if not already loaded
        helper('auth');
        
        // Set logged_at timestamp for new records
        $data['data']['logged_at'] = date('Y-m-d H:i:s');
        
        try {
            // Try Myth/Auth user() function first
            if (function_exists('user') && user() !== null && isset(user()->id)) {
                $data['data']['user_id'] = user()->id;
            }
            // Try session-based approach
            elseif (session()->has('logged_in') && session()->has('user_id')) {
                $data['data']['user_id'] = session('user_id');
            }
            // Try alternative session key
            elseif (session()->has('user') && is_array(session('user')) && isset(session('user')['id'])) {
                $data['data']['user_id'] = session('user')['id'];
            }
        } catch (\Exception $e) {
            // Log the error but continue without setting user_id
            log_message('error', 'Failed to set user_id: ' . $e->getMessage());
        }
        
        return $data;
    }

    /**
     * Get log by ID with validation
     */
    public function getLog($id)
    {
        $builder = $this->db->table('logs l');
        
        return $builder->select('l.*, 
                               CONCAT(u.islander_no, " - ", u.full_name) as user_name,
                               s.color as status_color,
                               s.name as status_name,
                               m.name as module_name')
                      ->join('users u', 'u.id = l.user_id', 'left')
                      ->join('status s', 's.id = l.status_id', 'left')
                      ->join('modules m', 'm.id = l.module_id', 'left')
                      ->where('l.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get logs with pagination and search
     */
    public function getLogsWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('logs l');
        
        // Join with users table for user information, status table for color, and modules table for module info
        $builder->select('l.*, 
                         CONCAT(u.islander_no, " - ", u.full_name) as user_name,
                         s.color as status_color,
                         s.name as status_name,
                         m.name as module_name')
                ->join('users u', 'u.id = l.user_id', 'left')
                ->join('status s', 's.id = l.status_id', 'left')
                ->join('modules m', 'm.id = l.module_id', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('l.action', $search)
                    ->orLike('u.full_name', $search)
                    ->orLike('u.islander_no', $search)
                    ->orLike('m.name', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('l.logged_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count logs with search filter
     */
    public function getLogsCount($search = '')
    {
        $builder = $this->db->table('logs l');
        
        // Join with users table, status table, and modules table for consistent search results
        $builder->join('users u', 'u.id = l.user_id', 'left')
                ->join('status s', 's.id = l.status_id', 'left')
                ->join('modules m', 'm.id = l.module_id', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('l.action', $search)
                    ->orLike('u.full_name', $search)
                    ->orLike('u.islander_no', $search)
                    ->orLike('m.name', $search)
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
     * Get all active logs
     */
    public function getActiveLogs()
    {
        return $this->where('status_id', 1)->findAll();
    }
}