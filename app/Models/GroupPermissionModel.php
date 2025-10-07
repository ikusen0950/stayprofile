<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupPermissionModel extends Model
{
    protected $table      = 'auth_groups_permissions';
    protected $primaryKey = ['group_id', 'permission_id'];

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'group_id', 
        'permission_id'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'group_id' => [
            'label'  => 'Group',
            'rules'  => 'required|numeric|is_not_unique[auth_groups.id]',
            'errors' => [
                'required'        => 'Group is required.',
                'numeric'         => 'Group must be a valid number.',
                'is_not_unique'   => 'Selected group does not exist.'
            ]
        ],
        'permission_id' => [
            'label'  => 'Permission',
            'rules'  => 'required|numeric|is_not_unique[auth_permissions.id]',
            'errors' => [
                'required'        => 'Permission is required.',
                'numeric'         => 'Permission must be a valid number.',
                'is_not_unique'   => 'Selected permission does not exist.'
            ]
        ]
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Get all groups (roles) for dropdown
     */
    public function getAllGroups()
    {
        $builder = $this->db->table('auth_groups');
        return $builder->select('id, name, description')
                      ->orderBy('id', 'ASC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Get all permissions grouped by module/category
     */
    public function getAllPermissionsGrouped()
    {
        $builder = $this->db->table('auth_permissions');
        $permissions = $builder->select('id, name, description')
                              ->orderBy('name', 'ASC')
                              ->get()
                              ->getResultArray();

        // Group permissions by module (prefix before the dot)
        $grouped = [];
        foreach ($permissions as $permission) {
            $parts = explode('.', $permission['name']);
            $module = ucfirst($parts[0]);
            
            if (!isset($grouped[$module])) {
                $grouped[$module] = [];
            }
            
            $grouped[$module][] = [
                'id' => $permission['id'],
                'name' => $permission['name'],
                'action' => isset($parts[1]) ? ucfirst($parts[1]) : $permission['name'],
                'description' => $permission['description']
            ];
        }

        return $grouped;
    }

    /**
     * Get permissions assigned to a specific group
     */
    public function getGroupPermissions($groupId)
    {
        $builder = $this->db->table('auth_groups_permissions agp');
        
        return $builder->select('agp.permission_id, ap.name, ap.description')
                      ->join('auth_permissions ap', 'ap.id = agp.permission_id')
                      ->where('agp.group_id', $groupId)
                      ->get()
                      ->getResultArray();
    }

    /**
     * Get permission IDs assigned to a specific group (for checkbox checking)
     */
    public function getGroupPermissionIds($groupId)
    {
        $builder = $this->db->table('auth_groups_permissions');
        $results = $builder->select('permission_id')
                          ->where('group_id', $groupId)
                          ->get()
                          ->getResultArray();

        return array_column($results, 'permission_id');
    }

    /**
     * Update group permissions (remove old and add new)
     */
    public function updateGroupPermissions($groupId, $permissionIds = [])
    {
        $this->db->transStart();

        try {
            // Remove existing permissions for this group
            $this->db->table('auth_groups_permissions')
                    ->where('group_id', $groupId)
                    ->delete();

            // Add new permissions
            if (!empty($permissionIds)) {
                $insertData = [];
                foreach ($permissionIds as $permissionId) {
                    $insertData[] = [
                        'group_id' => $groupId,
                        'permission_id' => $permissionId
                    ];
                }
                
                $this->db->table('auth_groups_permissions')->insertBatch($insertData);
            }

            $this->db->transComplete();
            
            return $this->db->transStatus();
        } catch (\Exception $e) {
            $this->db->transRollback();
            return false;
        }
    }

    /**
     * Get group permission statistics
     */
    public function getGroupPermissionStats($groupId = null)
    {
        $builder = $this->db->table('auth_groups_permissions agp');
        
        if ($groupId) {
            $builder->where('agp.group_id', $groupId);
        }
        
        $stats = [
            'total_assignments' => $builder->countAllResults(),
            'total_groups' => $this->db->table('auth_groups')->countAllResults(),
            'total_permissions' => $this->db->table('auth_permissions')->countAllResults()
        ];

        if ($groupId) {
            $stats['assigned_permissions'] = $this->db->table('auth_groups_permissions')
                                                   ->where('group_id', $groupId)
                                                   ->countAllResults();
        }

        return $stats;
    }

    /**
     * Get group with permission summary
     */
    public function getGroupsWithPermissionCounts()
    {
        $builder = $this->db->table('auth_groups ag');
        
        return $builder->select('ag.id, ag.name, ag.description, 
                               COUNT(agp.permission_id) as permission_count')
                      ->join('auth_groups_permissions agp', 'agp.group_id = ag.id', 'left')
                      ->groupBy('ag.id, ag.name, ag.description')
                      ->orderBy('ag.id', 'ASC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Search permissions by name or description
     */
    public function searchPermissions($search = '')
    {
        $builder = $this->db->table('auth_permissions');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('name', $search)
                    ->orLike('description', $search)
                    ->groupEnd();
        }
        
        return $builder->orderBy('name', 'ASC')
                      ->get()
                      ->getResultArray();
    }
}