<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'status_id',
        'islander_no',
        'full_name',
        'id_pp_wp_no',
        'division_id',
        'department_id',
        'section_id',
        'position_id',
        'on_leave_status',
        'nationality',
        'date_of_joining',
        'date_of_birth',
        'company',
        'house_id',
        'departed_date',
        'arrival_date',
        'gender_id',
        'phone',
        'email',
        'username',
        'address',
        'notes',
        'image',
        'cover_image',
        'password_hash',
        'reset_hash',
        'reset_at',
        'reset_expires',
        'activate_hash',
        'status',
        'status_message',
        'active',
        'force_pass_reset',
        'device_token',
        'password_changed',
        'type',
        'type_description',
        'out_of_office',
        'has_accepted_agreement',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'id_pp_wp_no' => [
            'label'  => 'NID/PP/WP Number',
            'rules'  => 'required|min_length[3]|max_length[100]|is_unique[users.id_pp_wp_no]',
            'errors' => [
                'required'    => 'NID/PP/WP number is required.',
                'min_length'  => 'NID/PP/WP number must be at least 3 characters long.',
                'max_length'  => 'NID/PP/WP number cannot exceed 100 characters.',
                'is_unique'   => 'This NID/PP/WP number already exists.'
            ]
        ],
        'islander_no' => [
            'label'  => 'Visitor Number',
            'rules'  => 'permit_empty|min_length[3]|max_length[50]',
            'errors' => [
                'min_length'  => 'Visitor number must be at least 3 characters long.',
                'max_length'  => 'Visitor number cannot exceed 50 characters.'
            ]
        ],
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
            'rules'  => 'required|valid_email|max_length[255]|is_unique[users.email]',
            'errors' => [
                'required'    => 'Email is required.',
                'valid_email' => 'Please enter a valid email address.',
                'max_length'  => 'Email cannot exceed 255 characters.',
                'is_unique'   => 'This email address is already registered.'
            ]
        ],
        'phone' => [
            'label'  => 'Phone',
            'rules'  => 'required|max_length[20]',
            'errors' => [
                'required'   => 'Phone number is required.',
                'max_length' => 'Phone number cannot exceed 20 characters.'
            ]
        ],
        'company' => [
            'label'  => 'Company',
            'rules'  => 'required|min_length[2]|max_length[255]',
            'errors' => [
                'required'   => 'Company name is required.',
                'min_length' => 'Company name must be at least 2 characters long.',
                'max_length' => 'Company name cannot exceed 255 characters.'
            ]
        ],
        'nationality' => [
            'label'  => 'Nationality',
            'rules'  => 'permit_empty|max_length[100]',
            'errors' => [
                'max_length' => 'Nationality cannot exceed 100 characters.'
            ]
        ],
        'division_id' => [
            'label'  => 'Division',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Division is required.',
                'numeric'  => 'Division must be a valid number.'
            ]
        ],
        'department_id' => [
            'label'  => 'Department',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Department is required.',
                'numeric'  => 'Department must be a valid number.'
            ]
        ],
        'section_id' => [
            'label'  => 'Section',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Section is required.',
                'numeric'  => 'Section must be a valid number.'
            ]
        ],
        'position_id' => [
            'label'  => 'Position',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Position is required.',
                'numeric'  => 'Position must be a valid number.'
            ]
        ],
        'house_id' => [
            'label'  => 'House',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'House must be a valid number.'
            ]
        ],
        'gender_id' => [
            'label'  => 'Gender',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Gender is required.',
                'numeric'  => 'Gender must be a valid number.'
            ]
        ],
        'status_id' => [
            'label'  => 'Status',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Status is required.',
                'numeric'  => 'Status must be a valid number.'
            ]
        ]
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Custom validation for visitor updates (email and id_pp_wp_no uniqueness)
     */
    public function validateForUpdate(array $data, int $id): bool|array
    {
        $rules = $this->validationRules;
        
        // Modify unique rules to exclude current record
        if (isset($data['id_pp_wp_no'])) {
            $rules['id_pp_wp_no']['rules'] = 'required|min_length[3]|max_length[100]|is_unique[users.id_pp_wp_no,id,' . $id . ']';
        }
        
        if (isset($data['email']) && !empty($data['email'])) {
            $rules['email']['rules'] = 'required|valid_email|max_length[255]|is_unique[users.email,id,' . $id . ']';
        }

        $validation = \Config\Services::validation();
        $validation->setRules($rules);

        if ($validation->run($data)) {
            return true;
        }

        return $validation->getErrors();
    }

    /**
     * Get visitors with pagination and search - only type = 2 (Visitors)
     */
    public function getVisitorsWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('users u');
        
        // Join with related tables
        $builder->select('u.*, 
                         s.name as status_name,
                         s.color as status_color,
                         d.name as division_name,
                         dep.name as department_name,
                         sec.name as section_name,
                         p.name as position_name,
                         g.name as gender_name,
                         h.name as house_name,
                         h.color as house_color,
                         n.name as nationality_name,
                         CONCAT(creator.islander_no, " - ", creator.full_name) as created_by_name,
                         CONCAT(updater.islander_no, " - ", updater.full_name) as updated_by_name')
                ->join('status s', 's.id = u.status_id', 'left')
                ->join('divisions d', 'd.id = u.division_id', 'left')
                ->join('departments dep', 'dep.id = u.department_id', 'left')
                ->join('sections sec', 'sec.id = u.section_id', 'left')
                ->join('positions p', 'p.id = u.position_id', 'left')
                ->join('genders g', 'g.id = u.gender_id', 'left')
                ->join('houses h', 'h.id = u.house_id', 'left')
                ->join('nationalities n', 'n.id = u.nationality', 'left')
                ->join('users creator', 'creator.id = u.created_by', 'left')
                ->join('users updater', 'updater.id = u.updated_by', 'left')
                ->where('u.type', 2) // Only visitors
                ->where('u.deleted_at IS NULL'); // Exclude soft deleted
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('u.islander_no', $search)
                    ->orLike('u.full_name', $search)
                    ->orLike('u.email', $search)
                    ->orLike('u.phone', $search)
                    ->orLike('u.id_pp_wp_no', $search)
                    ->orLike('u.company', $search)
                    ->orLike('d.name', $search)
                    ->orLike('dep.name', $search)
                    ->orLike('sec.name', $search)
                    ->orLike('p.name', $search)
                    ->orLike('g.name', $search)
                    ->orLike('h.name', $search)
                    ->orLike('n.name', $search)
                    ->orLike('s.name', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('u.id', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count visitors with search filter - only type = 2 (Visitors)
     */
    public function getVisitorsCount($search = '')
    {
        $builder = $this->db->table('users u');
        
        // Join with related tables for consistent search results
        $builder->join('status s', 's.id = u.status_id', 'left')
                ->join('divisions d', 'd.id = u.division_id', 'left')
                ->join('departments dep', 'dep.id = u.department_id', 'left')
                ->join('sections sec', 'sec.id = u.section_id', 'left')
                ->join('positions p', 'p.id = u.position_id', 'left')
                ->join('genders g', 'g.id = u.gender_id', 'left')
                ->join('houses h', 'h.id = u.house_id', 'left')
                ->join('nationalities n', 'n.id = u.nationality', 'left')
                ->where('u.type', 2) // Only visitors
                ->where('u.deleted_at IS NULL'); // Exclude soft deleted
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('u.islander_no', $search)
                    ->orLike('u.full_name', $search)
                    ->orLike('u.email', $search)
                    ->orLike('u.phone', $search)
                    ->orLike('u.id_pp_wp_no', $search)
                    ->orLike('u.company', $search)
                    ->orLike('d.name', $search)
                    ->orLike('dep.name', $search)
                    ->orLike('sec.name', $search)
                    ->orLike('p.name', $search)
                    ->orLike('g.name', $search)
                    ->orLike('h.name', $search)
                    ->orLike('n.name', $search)
                    ->orLike('s.name', $search)
                    ->groupEnd();
        }
        
        return $builder->countAllResults();
    }

    /**
     * Get a single visitor with all related data
     */
    public function getVisitor($id)
    {
        $builder = $this->db->table('users u');
        
        $visitor = $builder->select('u.*, 
                                   s.name as status_name,
                                   s.color as status_color,
                                   d.name as division_name,
                                   dep.name as department_name,
                                   sec.name as section_name,
                                   p.name as position_name,
                                   g.name as gender_name,
                                   h.name as house_name,
                                   h.color as house_color,
                                   n.name as nationality_name')
                          ->join('status s', 's.id = u.status_id', 'left')
                          ->join('divisions d', 'd.id = u.division_id', 'left')
                          ->join('departments dep', 'dep.id = u.department_id', 'left')
                          ->join('sections sec', 'sec.id = u.section_id', 'left')
                          ->join('positions p', 'p.id = u.position_id', 'left')
                          ->join('genders g', 'g.id = u.gender_id', 'left')
                          ->join('houses h', 'h.id = u.house_id', 'left')
                          ->join('nationalities n', 'n.id = u.nationality', 'left')
                          ->where('u.id', $id)
                          ->where('u.type', 2) // Only visitors
                          ->where('u.deleted_at IS NULL')
                          ->get()
                          ->getRowArray();
        
        return $visitor;
    }

    /**
     * Get active statuses for visitors
     */
    public function getActiveStatuses()
    {
        return $this->db->table('status')
                       ->where('module_id', 12) // Assuming visitors use same statuses as islanders
                       ->orderBy('name', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get active divisions
     */
    public function getActiveDivisions()
    {
        return $this->db->table('divisions')
                       ->where('status_id', 1)
                       ->orderBy('name', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get active departments
     */
    public function getActiveDepartments()
    {
        return $this->db->table('departments')
                       ->where('status_id', 1)
                       ->orderBy('name', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get active sections
     */
    public function getActiveSections()
    {
        return $this->db->table('sections')
                       ->where('status_id', 1)
                       ->orderBy('name', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get active positions
     */
    public function getActivePositions()
    {
        return $this->db->table('positions')
                       ->where('status_id', 1)
                       ->orderBy('name', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get active genders
     */
    public function getActiveGenders()
    {
        return $this->db->table('genders')
                       ->where('status_id', 1)
                       ->orderBy('name', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get active houses
     */
    public function getActiveHouses()
    {
        return $this->db->table('houses')
                       ->where('status_id', 1)
                       ->orderBy('name', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get active nationalities
     */
    public function getActiveNationalities()
    {
        return $this->db->table('nationalities')
                       ->where('status_id', 1)
                       ->orderBy('name', 'ASC')
                       ->get()
                       ->getResultArray();
    }
}