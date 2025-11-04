<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
    protected $table      = 'questions';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'label', 
        'description', 
        'type', 
        'is_required', 
        'is_active',
        'sort_order',
        'page',
        'created_by', 
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'label' => [
            'label'  => 'Question Label',
            'rules'  => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required'    => 'Question label is required.',
                'min_length'  => 'Question label must be at least 3 characters long.',
                'max_length'  => 'Question label cannot exceed 255 characters.'
            ]
        ],
        'description' => [
            'label'  => 'Description',
            'rules'  => 'permit_empty|max_length[1000]',
            'errors' => [
                'max_length' => 'Description cannot exceed 1000 characters.'
            ]
        ],
        'type' => [
            'label'  => 'Question Type',
            'rules'  => 'required|in_list[text,textarea,single_mcq,multi_mcq,text_block]',
            'errors' => [
                'required' => 'Question type is required.',
                'in_list'  => 'Please select a valid question type.'
            ]
        ],
        'is_required' => [
            'label'  => 'Required',
            'rules'  => 'permit_empty|in_list[0,1]',
            'errors' => [
                'in_list' => 'Required field must be 0 or 1.'
            ]
        ],
        'is_active' => [
            'label'  => 'Active',
            'rules'  => 'permit_empty|in_list[0,1]',
            'errors' => [
                'in_list' => 'Active field must be 0 or 1.'
            ]
        ],
        'sort_order' => [
            'label'  => 'Sort Order',
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric' => 'Sort order must be a valid number.'
            ]
        ],
        'page' => [
            'label'  => 'Page',
            'rules'  => 'permit_empty|max_length[100]',
            'errors' => [
                'max_length' => 'Page cannot exceed 100 characters.'
            ]
        ]
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $beforeInsert = ['setCreatedBy'];
    protected $beforeUpdate = ['setUpdatedBy'];

    /**
     * Validate question based on type-specific rules
     */
    public function validateForType($data)
    {
        $validation = \Config\Services::validation();
        $errors = [];

        // Basic validation first
        if (!$validation->setRules($this->validationRules)->run($data)) {
            $errors = array_merge($errors, $validation->getErrors());
        }

        // Type-specific validation
        if (!empty($data['type'])) {
            $typeErrors = $this->validateByQuestionType($data['type'], $data);
            $errors = array_merge($errors, $typeErrors);
        }

        return $errors;
    }

    /**
     * Type-specific validation rules
     */
    private function validateByQuestionType($type, $data)
    {
        $errors = [];

        switch ($type) {
            case 'text':
                // Text: label, question type, page, sort order are required
                if (empty($data['label'])) {
                    $errors['label'] = 'Label is required for text questions';
                }
                if (empty($data['page'])) {
                    $errors['page'] = 'Page is required for text questions';
                }
                if (!isset($data['sort_order']) || $data['sort_order'] === '') {
                    $errors['sort_order'] = 'Sort order is required for text questions';
                }
                break;

            case 'textarea':
                // Textarea: label, question type, page, sort order are required
                if (empty($data['label'])) {
                    $errors['label'] = 'Label is required for textarea questions';
                }
                if (empty($data['page'])) {
                    $errors['page'] = 'Page is required for textarea questions';
                }
                if (!isset($data['sort_order']) || $data['sort_order'] === '') {
                    $errors['sort_order'] = 'Sort order is required for textarea questions';
                }
                break;

            case 'single_mcq':
                // Single MCQ: label, question type, page, sort order and at least 2 options are required
                if (empty($data['label'])) {
                    $errors['label'] = 'Label is required for single choice questions';
                }
                if (empty($data['page'])) {
                    $errors['page'] = 'Page is required for single choice questions';
                }
                if (!isset($data['sort_order']) || $data['sort_order'] === '') {
                    $errors['sort_order'] = 'Sort order is required for single choice questions';
                }
                // Options validation will be handled separately in controller
                break;

            case 'multi_mcq':
                // Multiple MCQ: label, question type, page, sort order and at least 2 options are required
                if (empty($data['label'])) {
                    $errors['label'] = 'Label is required for multiple choice questions';
                }
                if (empty($data['page'])) {
                    $errors['page'] = 'Page is required for multiple choice questions';
                }
                if (!isset($data['sort_order']) || $data['sort_order'] === '') {
                    $errors['sort_order'] = 'Sort order is required for multiple choice questions';
                }
                // Options validation will be handled separately in controller
                break;

            case 'text_block':
                // Text block: either label or description is required
                if (empty($data['label']) && empty($data['description'])) {
                    $errors['label'] = 'Either label or description is required for text block questions';
                    $errors['description'] = 'Either label or description is required for text block questions';
                }
                break;

            default:
                $errors['type'] = 'Invalid question type';
                break;
        }

        return $errors;
    }

    /**
     * Get validation rules for specific question type
     */
    public function getValidationRulesForType($type)
    {
        $baseRules = $this->validationRules;

        switch ($type) {
            case 'text':
            case 'textarea':
            case 'single_mcq':
            case 'multi_mcq':
                // These types require label, page, and sort_order
                $baseRules['label']['rules'] = 'required|min_length[3]|max_length[255]';
                $baseRules['page']['rules'] = 'required|max_length[100]';
                $baseRules['sort_order']['rules'] = 'required|numeric';
                break;

            case 'text_block':
                // Text block requires either label or description
                // This will be handled in custom validation
                break;
        }

        return $baseRules;
    }

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
     * Get question types for dropdown
     */
    public function getQuestionTypes()
    {
        return [
            ['value' => 'text', 'name' => 'Text Input'],
            ['value' => 'textarea', 'name' => 'Textarea'],
            ['value' => 'single_mcq', 'name' => 'Single Choice (MCQ)'],
            ['value' => 'multi_mcq', 'name' => 'Multiple Choice (MCQ)'],
            ['value' => 'text_block', 'name' => 'Text Block']
        ];
    }

    /**
     * Get question by ID with validation
     */
    public function getQuestion($id)
    {
        $builder = $this->db->table('questions q');
        
        return $builder->select('q.*, 
                               CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                               CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                      ->join('users cu', 'cu.id = q.created_by', 'left')
                      ->join('users uu', 'uu.id = q.updated_by', 'left')
                      ->where('q.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get questions with pagination and search
     */
    public function getQuestionsWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('questions q');
        
        // Join with users tables
        $builder->select('q.*, 
                         CONCAT(cu.islander_no, " - ", cu.full_name) as created_by_name,
                         CONCAT(uu.islander_no, " - ", uu.full_name) as updated_by_name')
                ->join('users cu', 'cu.id = q.created_by', 'left')
                ->join('users uu', 'uu.id = q.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('q.label', $search)
                    ->orLike('q.description', $search)
                    ->orLike('q.type', $search)
                    ->orLike('q.page', $search)
                    ->orLike('cu.full_name', $search)
                    ->orLike('cu.islander_no', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('q.sort_order', 'ASC')
                      ->orderBy('q.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count questions with search filter
     */
    public function getQuestionsCount($search = '')
    {
        $builder = $this->db->table('questions q');
        
        // Join with users tables for consistent search results
        $builder->join('users cu', 'cu.id = q.created_by', 'left')
                ->join('users uu', 'uu.id = q.updated_by', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('q.label', $search)
                    ->orLike('q.description', $search)
                    ->orLike('q.type', $search)
                    ->orLike('q.page', $search)
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
        $rules['label']['rules'] = "required|min_length[3]|max_length[255]|is_unique[questions.label,id,{$id}]";
        $rules['label']['errors']['is_unique'] = 'This question label already exists.';
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
     * Get questions by page
     */
    public function getQuestionsByPage($page)
    {
        return $this->where('page', $page)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Get active questions by page
     */
    public function getActiveQuestionsByPage($page)
    {
        return $this->where('is_active', 1)
                    ->where('page', $page)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Get total number of pages
     */
    public function getTotalPages()
    {
        $result = $this->select('MAX(page) as max_page')
                       ->where('is_active', 1)
                       ->first();
        
        return (int)($result['max_page'] ?? 1);
    }

    /**
     * Get active questions
     */
    public function getActiveQuestions()
    {
        return $this->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }
}