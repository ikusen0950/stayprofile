<?php

namespace App\Models;

use CodeIgniter\Model;

class LeaveModel extends Model
{
    protected $table      = 'leaves';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name',
        'module_id',
        'status_id',
        'description',
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
            'label'  => 'Leave Name',
            'rules'  => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required'    => 'Leave name is required.',
                'min_length'  => 'Leave name must be at least 3 characters long.',
                'max_length'  => 'Leave name cannot exceed 100 characters.'
            ]
        ],
        'module_id' => [
            'label'  => 'Module',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'  => 'Module must be a valid number.'
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
        ]
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $beforeInsert = ['setCreatedBy'];
    protected $beforeUpdate = ['setUpdatedBy'];

    protected function setCreatedBy(array $data)
    {
        helper('auth');
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        try {
            if (function_exists('user') && user() !== null && isset(user()->id)) {
                $data['data']['created_by'] = user()->id;
            } elseif (session()->has('logged_in') && session()->has('user_id')) {
                $data['data']['created_by'] = session('user_id');
            } elseif (session()->has('user') && is_array(session('user')) && isset(session('user')['id'])) {
                $data['data']['created_by'] = session('user')['id'];
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to set created_by: ' . $e->getMessage());
        }
        if (isset($data['data']['updated_at'])) {
            unset($data['data']['updated_at']);
        }
        return $data;
    }

    protected function setUpdatedBy(array $data)
    {
        helper('auth');
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        try {
            if (function_exists('user') && user() !== null && isset(user()->id)) {
                $data['data']['updated_by'] = user()->id;
            } elseif (session()->has('logged_in') && session()->has('user_id')) {
                $data['data']['updated_by'] = session('user_id');
            } elseif (session()->has('user') && is_array(session('user')) && isset(session('user')['id'])) {
                $data['data']['updated_by'] = session('user')['id'];
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to set updated_by: ' . $e->getMessage());
        }
        return $data;
    }

    // Add getActiveModules, getLeave, getLeavesWithPagination, getLeavesCount, getValidationRules, getUpdateValidationRules, validateForUpdate, getLeavesByModule

    public function getActiveModules()
    {
        $moduleModel = new \App\Models\ModuleModel();
        return $moduleModel->where('status_id', 1)->findAll();
    }

    public function getLeave($id)
    {
        $builder = $this->db->table('leaves l');
        return $builder->select('l.*, m.name as module_name, CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name, CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name, s.name as status_name,
                         s.color as status_color')
                      ->join('modules m', 'm.id = l.module_id', 'left')
                      ->join('users cu', 'cu.id = l.created_by', 'left')
                      ->join('users uu', 'uu.id = l.updated_by', 'left')
                      ->join('status s', 's.id = l.status_id', 'left')
                      ->where('l.id', $id)
                      ->get()
                      ->getRowArray();
    }

    public function getLeavesWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('leaves l');
        $builder->select('l.*, m.name as module_name, CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name, CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name,s.name as status_name,
                         s.color as status_color')
                ->join('modules m', 'm.id = l.module_id', 'left')
                ->join('users cu', 'cu.id = l.created_by', 'left')
                ->join('users uu', 'uu.id = l.updated_by', 'left')
                ->join('status s', 's.id = l.status_id', 'left');
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('l.name', $search)
                    ->orLike('l.description', $search)
                    ->orLike('m.name', $search)
                    ->orLike('cu.full_name', $search)
                    ->orLike('cu.islander_no', $search)
                    ->groupEnd();
        }
        return $builder->limit($limit, $offset)
                      ->orderBy('l.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    public function getLeavesCount($search = '')
    {
        $builder = $this->db->table('leaves l');
        $builder->join('modules m', 'm.id = l.module_id', 'left')
                ->join('users cu', 'cu.id = l.created_by', 'left')
                ->join('users uu', 'uu.id = l.updated_by', 'left');
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('l.name', $search)
                    ->orLike('l.description', $search)
                    ->orLike('m.name', $search)
                    ->orLike('cu.full_name', $search)
                    ->orLike('cu.islander_no', $search)
                    ->groupEnd();
        }
        return $builder->countAllResults();
    }

    public function getValidationRules(array $options = []): array
    {
        return $this->validationRules;
    }

    public function getUpdateValidationRules($id)
    {
        $rules = $this->validationRules;
        $rules['name']['rules'] = "required|min_length[3]|max_length[100]|is_unique[leaves.name,id,{$id}]";
        $rules['name']['errors']['is_unique'] = 'This leave name already exists.';
        return $rules;
    }

    public function validateForUpdate($data, $id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules($this->getUpdateValidationRules($id));
        if (!$validation->run($data)) {
            return $validation->getErrors();
        }
        return true;
    }

    public function getLeavesByModule($moduleId)
    {
        return $this->where('module_id', $moduleId)->findAll();
    }

    /**
     * Get active leaves with status information for dropdowns
     */
    public function getActiveLeavesWithStatus()
    {
        $builder = $this->db->table('leaves l');
        $builder->select('l.id, l.name, l.description')
                ->where('l.status_id', 1) // Active status for leaves
                ->orderBy('l.name', 'ASC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get active leaves with status information specifically for exit pass modal
     */
    public function getActiveLeavesWithStatusForExitPass()
    {
        $builder = $this->db->table('leaves l');
        $builder->select('l.id, l.name, l.description')
                ->where('l.status_id', 1) // Active status for leaves
                ->where('l.module_id', 15) // Filter by module ID 15 for exit pass
                ->orderBy('l.name', 'ASC');
        
        return $builder->get()->getResultArray();
    }
}