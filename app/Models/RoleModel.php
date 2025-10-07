<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table      = 'auth_groups';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name', 
        'description'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'name' => [
            'label'  => 'Role Name',
            'rules'  => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required'    => 'Role name is required.',
                'min_length'  => 'Role name must be at least 3 characters long.',
                'max_length'  => 'Role name cannot exceed 255 characters.'
            ]
        ],
        'description' => [
            'label'  => 'Description',
            'rules'  => 'permit_empty|max_length[255]',
            'errors' => [
                'max_length' => 'Description cannot exceed 255 characters.'
            ]
        ]
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Get role by ID with validation
     */
    public function getRole($id)
    {
        $builder = $this->db->table('auth_groups ag');
        
        return $builder->select('ag.*')
                      ->where('ag.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get roles with pagination and search
     */
    public function getRolesWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('auth_groups ag');
        
        $builder->select('ag.*');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('ag.name', $search)
                    ->orLike('ag.description', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('ag.id', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count roles with search filter
     */
    public function getRolesCount($search = '')
    {
        $builder = $this->db->table('auth_groups ag');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('ag.name', $search)
                    ->orLike('ag.description', $search)
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
        $rules['name']['rules'] = "required|min_length[3]|max_length[255]|is_unique[auth_groups.name,id,{$id}]";
        $rules['name']['errors']['is_unique'] = 'This role name already exists.';
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
     * Get role statistics
     */
    public function getRoleStats()
    {
        $builder = $this->db->table('auth_groups');
        
        $stats = [
            'total_roles' => $builder->countAllResults(),
            'active_roles' => $builder->where('name !=', '')->countAllResults(),
        ];
        
        return $stats;
    }
}