<?php

namespace App\Models;

use CodeIgniter\Model;

class IslanderModel extends Model
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
        'islander_no' => [
            'label'  => 'Islander Number',
            'rules'  => 'required|min_length[3]|max_length[50]|is_unique[users.islander_no]',
            'errors' => [
                'required'    => 'Islander number is required.',
                'min_length'  => 'Islander number must be at least 3 characters long.',
                'max_length'  => 'Islander number cannot exceed 50 characters.',
                'is_unique'   => 'This islander number already exists.'
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
            'rules'  => 'permit_empty|valid_email|max_length[255]|is_unique[users.email]',
            'errors' => [
                'valid_email' => 'Please enter a valid email address.',
                'max_length'  => 'Email cannot exceed 255 characters.',
                'is_unique'   => 'This email address is already registered.'
            ]
        ],
        'phone' => [
            'label'  => 'Phone',
            'rules'  => 'permit_empty|max_length[20]',
            'errors' => [
                'max_length' => 'Phone number cannot exceed 20 characters.'
            ]
        ],
        'id_pp_wp_no' => [
            'label'  => 'ID/PP/WP Number',
            'rules'  => 'permit_empty|max_length[100]',
            'errors' => [
                'max_length' => 'ID/PP/WP number cannot exceed 100 characters.'
            ]
        ],
        'company' => [
            'label'  => 'Company',
            'rules'  => 'permit_empty|max_length[255]',
            'errors' => [
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
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'Division must be a valid number.'
            ]
        ],
        'department_id' => [
            'label'  => 'Department',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'Department must be a valid number.'
            ]
        ],
        'section_id' => [
            'label'  => 'Section',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'Section must be a valid number.'
            ]
        ],
        'position_id' => [
            'label'  => 'Position',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'Position must be a valid number.'
            ]
        ],
        'gender_id' => [
            'label'  => 'Gender',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'Gender must be a valid number.'
            ]
        ],
        'house_id' => [
            'label'  => 'House',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'House must be a valid number.'
            ]
        ],
        'status_id' => [
            'label'  => 'Status',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'Status must be a valid number.'
            ]
        ],
        'username' => [
            'label'  => 'Username',
            'rules'  => 'permit_empty|max_length[50]|is_unique[users.username]',
            'errors' => [
                'max_length' => 'Username cannot exceed 50 characters.',
                'is_unique'  => 'This username already exists.'
            ]
        ],
        'address' => [
            'label'  => 'Address',
            'rules'  => 'permit_empty|max_length[500]',
            'errors' => [
                'max_length' => 'Address cannot exceed 500 characters.'
            ]
        ],
        'notes' => [
            'label'  => 'Notes',
            'rules'  => 'permit_empty|max_length[1000]',
            'errors' => [
                'max_length' => 'Notes cannot exceed 1000 characters.'
            ]
        ]
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Get all active statuses for dropdown
     */
    public function getActiveStatuses()
    {
        $statusModel = new \App\Models\StatusModel();
        return $statusModel->where('module_id', 12)->findAll(); // Module ID 12 for status
    }

    /**
     * Get all active divisions for dropdown
     */
    public function getActiveDivisions()
    {
        $divisionModel = new \App\Models\DivisionModel();
        return $divisionModel->where('status_id', 1)->findAll(); // Status ID 1 for active
    }

    /**
     * Get all active departments for dropdown
     */
    public function getActiveDepartments()
    {
        $departmentModel = new \App\Models\DepartmentModel();
        return $departmentModel->where('status_id', 1)->findAll(); // Status ID 1 for active
    }

    /**
     * Get all active sections for dropdown
     */
    public function getActiveSections()
    {
        $sectionModel = new \App\Models\SectionModel();
        return $sectionModel->where('status_id', 1)->findAll(); // Status ID 1 for active
    }

    /**
     * Get all active positions for dropdown
     */
    public function getActivePositions()
    {
        $positionModel = new \App\Models\PositionModel();
        return $positionModel->where('status_id', 1)->findAll(); // Status ID 1 for active
    }

    /**
     * Get all active genders for dropdown
     */
    public function getActiveGenders()
    {
        $genderModel = new \App\Models\GenderModel();
        return $genderModel->where('status_id', 1)->findAll(); // Status ID 1 for active
    }

    /**
     * Get all active houses for dropdown
     */
    public function getActiveHouses()
    {
        $houseModel = new \App\Models\HouseModel();
        return $houseModel->where('status_id', 1)->findAll(); // Status ID 1 for active
    }

    /**
     * Get all active nationalities for dropdown
     */
    public function getActiveNationalities()
    {
        $nationalityModel = new \App\Models\NationalityModel();
        return $nationalityModel->where('status_id', 1)->findAll(); // Status ID 1 for active
    }

    /**
     * Get islander by ID with validation
     */
    public function getIslander($id)
    {
        $builder = $this->db->table('users u');
        
        return $builder->select('u.*, 
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
                      ->where('u.id', $id)
                      ->where('u.type', 1) // Only islanders
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get islanders with pagination and search
     */
    public function getIslandersWithPagination($search = '', $limit = 10, $offset = 0)
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
                ->where('u.type', 1) // Only islanders
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
                      ->orderBy('u.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count islanders with search filter
     */
    public function getIslandersCount($search = '')
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
                ->where('u.type', 1) // Only islanders
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
        $rules['islander_no']['rules'] = "required|min_length[3]|max_length[50]|is_unique[users.islander_no,id,{$id}]";
        $rules['email']['rules'] = "permit_empty|valid_email|max_length[255]|is_unique[users.email,id,{$id}]";
        $rules['username']['rules'] = "permit_empty|max_length[50]|is_unique[users.username,id,{$id}]";
        
        $rules['islander_no']['errors']['is_unique'] = 'This islander number already exists.';
        $rules['email']['errors']['is_unique'] = 'This email address is already registered.';
        $rules['username']['errors']['is_unique'] = 'This username already exists.';
        
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