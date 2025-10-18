<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table      = 'notifications';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'user_id', 
        'title', 
        'body', 
        'url', 
        'status_id', 
        'created_at'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';

    protected $validationRules = [
        'user_id' => [
            'label'  => 'User',
            'rules'  => 'required|numeric|is_not_unique[users.id]',
            'errors' => [
                'required'      => 'User is required.',
                'numeric'       => 'User must be a valid number.',
                'is_not_unique' => 'Selected user does not exist.'
            ]
        ],
        'title' => [
            'label'  => 'Title',
            'rules'  => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required'    => 'Title is required.',
                'min_length'  => 'Title must be at least 3 characters long.',
                'max_length'  => 'Title cannot exceed 255 characters.'
            ]
        ],
        'body' => [
            'label'  => 'Body',
            'rules'  => 'permit_empty|max_length[5000]',
            'errors' => [
                'max_length' => 'Body cannot exceed 5000 characters.'
            ]
        ],
        'url' => [
            'label'  => 'URL',
            'rules'  => 'permit_empty|valid_url|max_length[500]',
            'errors' => [
                'valid_url'   => 'URL must be a valid URL.',
                'max_length'  => 'URL cannot exceed 500 characters.'
            ]
        ],
        'status_id' => [
            'label'  => 'Status',
            'rules'  => 'required|numeric|is_not_unique[status.id]',
            'errors' => [
                'required'      => 'Status is required.',
                'numeric'       => 'Status must be a valid number.',
                'is_not_unique' => 'Selected status does not exist.'
            ]
        ]
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $beforeInsert = ['setCreatedAt'];

    /**
     * Set created_at field before insert
     */
    protected function setCreatedAt(array $data)
    {
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    /**
     * Get all active users for dropdown
     */
    public function getActiveUsers()
    {
        $userModel = new \App\Models\UserModel();
        return $userModel->select('id, CONCAT(islander_no, " - ", full_name) as display_name')
                        ->where('status_id', 1)
                        ->findAll();
    }

    /**
     * Get all active status for dropdown
     */
    public function getActiveStatus()
    {
        $statusModel = new \App\Models\StatusModel();
        return $statusModel->where('id >', 0)->findAll();
    }

    /**
     * Get notification by ID with related data
     */
    public function getNotification($id)
    {
        $builder = $this->db->table('notifications n');
        
        return $builder->select('n.*, 
                               CONCAT(u.islander_no, " - ", u.full_name) as user_name,
                               s.name as status_name,
                               s.color as status_color')
                      ->join('users u', 'u.id = n.user_id', 'left')
                      ->join('status s', 's.id = n.status_id', 'left')
                      ->where('n.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get notifications with pagination and search
     */
    public function getNotificationsWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('notifications n');
        
        // Join with users and status tables
        $builder->select('n.*, 
                         CONCAT(u.islander_no, " - ", u.full_name) as user_name,
                         s.name as status_name,
                         s.color as status_color')
                ->join('users u', 'u.id = n.user_id', 'left')
                ->join('status s', 's.id = n.status_id', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('n.title', $search)
                    ->orLike('n.body', $search)
                    ->orLike('u.full_name', $search)
                    ->orLike('u.islander_no', $search)
                    ->orLike('s.name', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('n.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count notifications with search filter
     */
    public function getNotificationsCount($search = '')
    {
        $builder = $this->db->table('notifications n');
        
        // Join with users and status tables for consistent search results
        $builder->join('users u', 'u.id = n.user_id', 'left')
                ->join('status s', 's.id = n.status_id', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('n.title', $search)
                    ->orLike('n.body', $search)
                    ->orLike('u.full_name', $search)
                    ->orLike('u.islander_no', $search)
                    ->orLike('s.name', $search)
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
     * Get validation rules for updates
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
        
        return true;
    }

    /**
     * Get notifications by user
     */
    public function getNotificationsByUser($userId)
    {
        return $this->where('user_id', $userId)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Get notifications by status
     */
    public function getNotificationsByStatus($statusId)
    {
        return $this->where('status_id', $statusId)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }
}
