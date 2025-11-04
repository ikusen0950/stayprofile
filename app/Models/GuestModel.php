<?php

namespace App\Models;

use CodeIgniter\Model;

class GuestModel extends Model
{
    protected $table      = 'guests';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'villa_id',
        'full_name',
        'phone',
        'email',
        'arrival_date',
        'departure_date',
        'arrival_to_here',
        'departure_from_here',
        'inclusive',
        'guest_type',
        'status',
        'guest_token',
        'reservation_code',
        'notes',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'full_name' => [
            'label'  => 'Full Name',
            'rules'  => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required'    => 'Full name is required.',
                'min_length'  => 'Full name must be at least 3 characters long.',
                'max_length'  => 'Full name cannot exceed 255 characters.'
            ]
        ],
        'email' => [
            'label'  => 'Email',
            'rules'  => 'permit_empty|valid_email|max_length[255]',
            'errors' => [
                'valid_email' => 'Please enter a valid email address.',
                'max_length'  => 'Email cannot exceed 255 characters.'
            ]
        ],
        'phone' => [
            'label'  => 'Phone',
            'rules'  => 'permit_empty|max_length[20]',
            'errors' => [
                'max_length' => 'Phone number cannot exceed 20 characters.'
            ]
        ],
        'villa_id' => [
            'label'  => 'Villa',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'Villa must be a valid number.'
            ]
        ],
        'guest_type' => [
            'label'  => 'Guest Type',
            'rules'  => 'permit_empty|in_list[adult,child,infant,vip,other]',
            'errors' => [
                'in_list'  => 'Please select a valid guest type.'
            ]
        ],
        'status' => [
            'label'  => 'Status',
            'rules'  => 'permit_empty|in_list[invited,pending,submitted,checked_in,checked_out,canceled]',
            'errors' => [
                'in_list'  => 'Please select a valid status.'
            ]
        ],
        'inclusive' => [
            'label'  => 'Inclusive',
            'rules'  => 'permit_empty|max_length[500]',
            'errors' => [
                'max_length' => 'Inclusive details cannot exceed 500 characters.'
            ]
        ],
        'guest_token' => [
            'label'  => 'Guest Token',
            'rules'  => 'permit_empty|max_length[150]',
            'errors' => [
                'max_length' => 'Guest token cannot exceed 150 characters.'
            ]
        ],
        'reservation_code' => [
            'label'  => 'Reservation Code',
            'rules'  => 'permit_empty|max_length[50]',
            'errors' => [
                'max_length' => 'Reservation code cannot exceed 50 characters.'
            ]
        ],
        'notes' => [
            'label'  => 'Notes',
            'rules'  => 'permit_empty|max_length[1000]',
            'errors' => [
                'max_length' => 'Notes cannot exceed 1000 characters.'
            ]
        ],
        'arrival_to_here' => [
            'label'  => 'Arrival to Here',
            'rules'  => 'permit_empty|max_length[50]',
            'errors' => [
                'max_length' => 'Arrival time cannot exceed 50 characters.'
            ]
        ],
        'departure_from_here' => [
            'label'  => 'Departure from Here',
            'rules'  => 'permit_empty|max_length[50]',
            'errors' => [
                'max_length' => 'Departure time cannot exceed 50 characters.'
            ]
        ]
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Get all active villas for dropdown
     */
    public function getActiveVillas()
    {
        $villaModel = new \App\Models\VillaModel();
        return $villaModel->where('status_id', 1)->findAll();
    }

    /**
     * Get guest by ID with related data
     */
    public function getGuest($id)
    {
        $builder = $this->db->table('guests g');
        
        return $builder->select('g.*, 
                               v.villa_name,
                               v.villa_code,
                               CONCAT(creator.islander_no, " - ", creator.full_name) as created_by_name,
                               CONCAT(updater.islander_no, " - ", updater.full_name) as updated_by_name')
                      ->join('villas v', 'v.id = g.villa_id', 'left')
                      ->join('users creator', 'creator.id = g.created_by', 'left')
                      ->join('users updater', 'updater.id = g.updated_by', 'left')
                      ->where('g.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get guests with pagination and search
     */
    public function getGuestsWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('guests g');
        
        // Join with related tables
        $builder->select('g.*, 
                         v.villa_name,
                         v.villa_code,
                         CONCAT(creator.islander_no, " - ", creator.full_name) as created_by_name,
                         CONCAT(updater.islander_no, " - ", updater.full_name) as updated_by_name')
                ->join('villas v', 'v.id = g.villa_id', 'left')
                ->join('users creator', 'creator.id = g.created_by', 'left')
                ->join('users updater', 'updater.id = g.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('g.full_name', $search)
                    ->orLike('g.email', $search)
                    ->orLike('g.phone', $search)
                    ->orLike('g.guest_token', $search)
                    ->orLike('g.reservation_code', $search)
                    ->orLike('v.villa_name', $search)
                    ->orLike('v.villa_code', $search)
                    ->orLike('g.guest_type', $search)
                    ->orLike('g.status', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('g.id', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count guests with search filter
     */
    public function getGuestsCount($search = '')
    {
        $builder = $this->db->table('guests g');
        
        // Join with related tables for consistent search results
        $builder->join('villas v', 'v.id = g.villa_id', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('g.full_name', $search)
                    ->orLike('g.email', $search)
                    ->orLike('g.phone', $search)
                    ->orLike('g.guest_token', $search)
                    ->orLike('g.reservation_code', $search)
                    ->orLike('v.villa_name', $search)
                    ->orLike('v.villa_code', $search)
                    ->orLike('g.guest_type', $search)
                    ->orLike('g.status', $search)
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
        $rules = $this->validationRules;
        
        // No unique fields in guests table, so no changes needed for updates
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
     * Get guest types for dropdown
     */
    public function getGuestTypes()
    {
        return [
            ['value' => 'adult', 'name' => 'Adult'],
            ['value' => 'child', 'name' => 'Child'],
            ['value' => 'infant', 'name' => 'Infant'],
            ['value' => 'vip', 'name' => 'VIP'],
            ['value' => 'other', 'name' => 'Other'],
        ];
    }

    /**
     * Get guest statuses for dropdown
     */
    public function getGuestStatuses()
    {
        return [
            ['value' => 'invited', 'name' => 'Invited'],
            ['value' => 'pending', 'name' => 'Pending'],
            ['value' => 'submitted', 'name' => 'Submitted'],
            ['value' => 'checked_in', 'name' => 'Checked In'],
            ['value' => 'checked_out', 'name' => 'Checked Out'],
            ['value' => 'canceled', 'name' => 'Canceled'],
        ];
    }

    /**
     * Generate a unique guest token in the format: 
     * xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx-xxxx-xxxx-xxxx
     */
    public function generateGuestToken()
    {
        do {
            // Generate UUID-like segments
            $segment1 = sprintf('%08x', mt_rand(0, 0xffffffff)); // 8 hex chars
            $segment2 = sprintf('%04x', mt_rand(0, 0xffff));     // 4 hex chars
            $segment3 = sprintf('%04x', mt_rand(0, 0xffff));     // 4 hex chars
            $segment4 = sprintf('%04x', mt_rand(0, 0xffff));     // 4 hex chars
            $segment5 = sprintf('%08x', mt_rand(0, 0xffffffff)); // 8 hex chars
            $segment6 = sprintf('%04x', mt_rand(0, 0xffff));     // 4 hex chars
            
            // Create the token in your specified format
            $token = $segment1 . '-' . $segment2 . '-' . $segment3 . '-' . $segment4 . '-' . $segment5 . $segment6 . '-' . $segment2 . '-' . $segment3 . '-' . $segment4;
            
        } while ($this->where('guest_token', $token)->first());
        
        return $token;
    }
}
