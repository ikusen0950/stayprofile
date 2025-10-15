<?php

namespace App\Models;

use CodeIgniter\Model;

class RequestingRuleModel extends Model
{
    protected $table      = 'authorization_rules';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'user_id',
        'rule_type',
        'target_type',
        'approval_level',
        'division_ids',
        'department_ids',
        'section_ids',
        'rules_config',
        'is_active',
        'can_request',
        'description',
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
        'user_id' => [
            'label'  => 'User',
            'rules'  => 'required|numeric|is_not_unique[users.id]',
            'errors' => [
                'required'      => 'User is required.',
                'numeric'       => 'User must be a valid number.',
                'is_not_unique' => 'Selected user does not exist.'
            ]
        ],
        'rule_type' => [
            'label'  => 'Rule Type',
            'rules'  => 'required|in_list[all,division,department,section,multiple]',
            'errors' => [
                'required' => 'Rule type is required.',
                'in_list'  => 'Rule type must be one of: all, division, department, section, multiple.'
            ]
        ],
        'target_type' => [
            'label'  => 'Target Type',
            'rules'  => 'required|in_list[islanders,visitors,both,multiple]',
            'errors' => [
                'required' => 'Target type is required.',
                'in_list'  => 'Target type must be one of: islanders, visitors, both, multiple.'
            ]
        ],
        'approval_level' => [
            'label'  => 'Approval Level',
            'rules'  => 'required|in_list[level_1,level_2,level_3,no_approval,multiple]',
            'errors' => [
                'required' => 'Approval level is required.',
                'in_list'  => 'Approval level must be one of: level_1, level_2, level_3, no_approval, multiple.'
            ]
        ],
        'division_ids' => [
            'label'  => 'Division IDs',
            'rules'  => 'permit_empty|valid_json_or_array|valid_numeric_array',
            'errors' => [
                'valid_json_or_array' => 'Division IDs must be valid JSON or array format.',
                'valid_numeric_array' => 'Division IDs must contain only numeric values.'
            ]
        ],
        'department_ids' => [
            'label'  => 'Department IDs',
            'rules'  => 'permit_empty|valid_json_or_array|valid_numeric_array',
            'errors' => [
                'valid_json_or_array' => 'Department IDs must be valid JSON or array format.',
                'valid_numeric_array' => 'Department IDs must contain only numeric values.'
            ]
        ],
        'section_ids' => [
            'label'  => 'Section IDs',
            'rules'  => 'permit_empty|valid_json_or_array|valid_numeric_array',
            'errors' => [
                'valid_json_or_array' => 'Section IDs must be valid JSON or array format.',
                'valid_numeric_array' => 'Section IDs must contain only numeric values.'
            ]
        ],
        'rules_config' => [
            'label'  => 'Rules Configuration',
            'rules'  => 'permit_empty',
            'errors' => []
        ],
        'is_active' => [
            'label'  => 'Status',
            'rules'  => 'required|in_list[0,1]',
            'errors' => [
                'required' => 'Status is required.',
                'in_list'  => 'Status must be active (1) or inactive (0).'
            ]
        ],
        'can_request' => [
            'label'  => 'Can Request',
            'rules'  => 'permit_empty|in_list[0,1]',
            'errors' => [
                'in_list'  => 'Can Request must be yes (1) or no (0).'
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

    protected $beforeInsert = ['setCreatedBy', 'processJsonFields'];
    protected $beforeUpdate = ['setUpdatedBy', 'processJsonFields'];

    /**
     * Set created_by field before insert
     */
    protected function setCreatedBy(array $data)
    {
        helper('auth');
        
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        
        try {
            if (function_exists('user') && user() !== null && isset(user()->id)) {
                $data['data']['created_by'] = user()->id;
            }
            elseif (session()->has('logged_in') && session()->has('user_id')) {
                $data['data']['created_by'] = session()->get('user_id');
            }
            else {
                $data['data']['created_by'] = 1; // Default to system user
            }
        } catch (Exception $e) {
            log_message('error', 'Error setting created_by: ' . $e->getMessage());
            $data['data']['created_by'] = 1; // Default to system user
        }

        return $data;
    }

    /**
     * Set updated_by field before update
     */
    protected function setUpdatedBy(array $data)
    {
        helper('auth');
        
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        
        try {
            if (function_exists('user') && user() !== null && isset(user()->id)) {
                $data['data']['updated_by'] = user()->id;
            }
            elseif (session()->has('logged_in') && session()->has('user_id')) {
                $data['data']['updated_by'] = session()->get('user_id');
            }
            else {
                $data['data']['updated_by'] = 1; // Default to system user
            }
        } catch (Exception $e) {
            log_message('error', 'Error setting updated_by: ' . $e->getMessage());
            $data['data']['updated_by'] = 1; // Default to system user
        }

        return $data;
    }

    /**
     * Process JSON fields before saving
     */
    protected function processJsonFields(array $data)
    {
        $jsonFields = ['division_ids', 'department_ids', 'section_ids'];
        
        foreach ($jsonFields as $field) {
            if (isset($data['data'][$field])) {
                // If it's already a JSON string, keep it as is
                if (is_string($data['data'][$field]) && is_array(json_decode($data['data'][$field], true))) {
                    continue;
                }
                
                // If it's an array, encode it to JSON
                if (is_array($data['data'][$field])) {
                    // Filter out empty values and ensure integers
                    $cleanArray = array_filter($data['data'][$field], function($value) {
                        return !empty($value) && is_numeric($value);
                    });
                    $cleanArray = array_map('intval', $cleanArray);
                    $data['data'][$field] = !empty($cleanArray) ? json_encode(array_values($cleanArray)) : null;
                }
                
                // If it's null or empty, set to null
                if (empty($data['data'][$field])) {
                    $data['data'][$field] = null;
                }
            }
        }

        return $data;
    }

    /**
     * Get requesting rules with pagination - filters for can_request = 1
     */
    public function getRequestingRulesWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('authorization_rules ar');
        
        $builder->select('ar.*, 
                         u.full_name as user_name,
                         u.islander_no as user_islander_no,
                         CONCAT(u.islander_no, " - ", u.full_name) as user_display_name,
                         CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                         CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                ->join('users u', 'u.id = ar.user_id', 'left')
                ->join('users cu', 'cu.id = ar.created_by', 'left')
                ->join('users uu', 'uu.id = ar.updated_by', 'left')
                ->where('ar.deleted_at IS NULL')
                ->where('ar.can_request', 1); // Filter for requesting rules only
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('u.full_name', $search)
                    ->orLike('u.islander_no', $search)
                    ->orLike('ar.rule_type', $search)
                    ->orLike('ar.target_type', $search)
                    ->orLike('ar.description', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('ar.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count requesting rules with search filter - filters for can_request = 1
     */
    public function getRequestingRulesCount($search = '')
    {
        $builder = $this->db->table('authorization_rules ar');
        
        $builder->join('users u', 'u.id = ar.user_id', 'left')
                ->where('ar.deleted_at IS NULL')
                ->where('ar.can_request', 1); // Filter for requesting rules only
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('u.full_name', $search)
                    ->orLike('u.islander_no', $search)
                    ->orLike('ar.rule_type', $search)
                    ->orLike('ar.target_type', $search)
                    ->orLike('ar.description', $search)
                    ->groupEnd();
        }
        
        return $builder->countAllResults();
    }

    /**
     * Get a requesting rule by ID
     */
    public function getRequestingRule($id)
    {
        $builder = $this->db->table('authorization_rules ar');
        
        $rule = $builder->select('ar.*, 
                                 u.full_name as user_name,
                                 u.islander_no as user_islander_no,
                                 CONCAT(u.islander_no, " - ", u.full_name) as user_display_name,
                                 CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                                 CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                        ->join('users u', 'u.id = ar.user_id', 'left')
                        ->join('users cu', 'cu.id = ar.created_by', 'left')
                        ->join('users uu', 'uu.id = ar.updated_by', 'left')
                        ->where('ar.id', $id)
                        ->where('ar.deleted_at IS NULL')
                        ->where('ar.can_request', 1) // Filter for requesting rules only
                        ->get()
                        ->getRowArray();

        return $rule;
    }

    /**
     * Get all active users for dropdown
     */
    public function getActiveUsers()
    {
        return $this->db->table('users')
                       ->select('id, full_name as name, islander_no, CONCAT(islander_no, " - ", full_name) as display_name')
                       ->where('active', 1)
                       ->orderBy('full_name', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get all active divisions for dropdown
     */
    public function getActiveDivisions()
    {
        return $this->db->table('divisions')
                       ->select('id, name')
                       ->where('status_id', 1) // Active status
                       ->orderBy('name', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get all active departments for dropdown
     */
    public function getActiveDepartments()
    {
        return $this->db->table('departments')
                       ->select('id, name, division_id')
                       ->where('status_id', 1) // Active status
                       ->orderBy('name', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get all active sections for dropdown
     */
    public function getActiveSections()
    {
        return $this->db->table('sections')
                       ->select('id, name, department_id')
                       ->where('status_id', 1) // Active status
                       ->orderBy('name', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Parse JSON fields for display
     */
    public function parseJsonFields($rule)
    {
        $jsonFields = ['division_ids', 'department_ids', 'section_ids', 'rules_config'];
        
        foreach ($jsonFields as $field) {
            if (isset($rule[$field]) && !is_null($rule[$field])) {
                $rule[$field] = json_decode($rule[$field], true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $rule[$field] = [];
                }
            } else {
                $rule[$field] = [];
            }
        }
        
        return $rule;
    }

    /**
     * Get requesting rule details with names
     */
    public function getRequestingRuleDetails($id)
    {
        $rule = $this->getRequestingRule($id);
        
        if (!$rule) {
            return null;
        }

        // Parse JSON fields
        $rule = $this->parseJsonFields($rule);

        // Get division names
        if (!empty($rule['division_ids'])) {
            $divisionNames = $this->db->table('divisions')
                                    ->select('name')
                                    ->whereIn('id', $rule['division_ids'])
                                    ->get()
                                    ->getResultArray();
            $rule['division_names'] = array_column($divisionNames, 'name');
        } else {
            $rule['division_names'] = [];
        }

        // Get department names
        if (!empty($rule['department_ids'])) {
            $departmentNames = $this->db->table('departments')
                                      ->select('name')
                                      ->whereIn('id', $rule['department_ids'])
                                      ->get()
                                      ->getResultArray();
            $rule['department_names'] = array_column($departmentNames, 'name');
        } else {
            $rule['department_names'] = [];
        }

        // Get section names
        if (!empty($rule['section_ids'])) {
            $sectionNames = $this->db->table('sections')
                                   ->select('name')
                                   ->whereIn('id', $rule['section_ids'])
                                   ->get()
                                   ->getResultArray();
            $rule['section_names'] = array_column($sectionNames, 'name');
        } else {
            $rule['section_names'] = [];
        }

        return $rule;
    }

    /**
     * Get validation rules for create operations
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
        // Allow same user for requesting rules updates (removed unique constraint)
        $rules['user_id']['rules'] = "required|numeric|is_not_unique[users.id]";
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