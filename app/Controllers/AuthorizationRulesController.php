<?php

namespace App\Controllers;

use App\Models\AuthorizationRuleModel;
use CodeIgniter\HTTP\RedirectResponse;

class AuthorizationRulesController extends BaseController
{
    protected $authorizationRuleModel;
    protected $logModel;
    protected $db;

    public function __construct()
    {
        $this->authorizationRuleModel = new AuthorizationRuleModel();
        $this->logModel = new \App\Models\LogModel();
        $this->db = \Config\Database::connect();
    }

    /**
     * Sanitize input data for authorization rule
     */
    private function sanitizeAuthorizationRuleInput(array $data): array
    {
        $sanitized = [
            'user_id' => isset($data['user_id']) ? (int)$data['user_id'] : 0,
            'rule_type' => isset($data['rule_type']) ? trim(strip_tags($data['rule_type'])) : '',
            'target_type' => isset($data['target_type']) ? trim(strip_tags($data['target_type'])) : '',
            'approval_level' => isset($data['approval_level']) ? trim(strip_tags($data['approval_level'])) : 'no_approval',
            'division_ids' => $this->processArrayField($data['division_ids'] ?? null),
            'department_ids' => $this->processArrayField($data['department_ids'] ?? null),
            'section_ids' => $this->processArrayField($data['section_ids'] ?? null),
            'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1,
            'description' => isset($data['description']) ? 
                trim(strip_tags($data['description'], '<p><br><strong><em><ul><ol><li>')) : '',
        ];

        // Add audit fields if present
        if (isset($data['created_by'])) {
            $sanitized['created_by'] = (int)$data['created_by'];
        }
        if (isset($data['created_at'])) {
            $sanitized['created_at'] = $data['created_at'];
        }
        if (isset($data['updated_by'])) {
            $sanitized['updated_by'] = (int)$data['updated_by'];
        }
        if (isset($data['updated_at'])) {
            $sanitized['updated_at'] = $data['updated_at'];
        }

        return $sanitized;
    }

    /**
     * Process array fields to proper format for database storage
     */
    private function processArrayField($field)
    {
        if (is_null($field) || (is_array($field) && empty($field))) {
            return null;
        }
        
        if (is_array($field)) {
            // Filter out empty values and convert to integers
            $filtered = array_filter($field, function($value) {
                return !empty($value) && is_numeric($value);
            });
            
            if (empty($filtered)) {
                return null;
            }
            
            // Convert to integers and return as array (model will JSON encode it)
            return array_map('intval', array_values($filtered));
        }
        
        if (is_string($field)) {
            // Try to decode if it's already JSON
            $decoded = json_decode($field, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
            
            // If it's a comma-separated string, convert to array
            if (strpos($field, ',') !== false) {
                $array = array_map('trim', explode(',', $field));
                $array = array_filter($array, function($value) {
                    return !empty($value) && is_numeric($value);
                });
                return empty($array) ? null : array_map('intval', $array);
            }
            
            // Single value
            if (is_numeric($field)) {
                return [(int)$field];
            }
        }
        
        return null;
    }

    /**
     * Log authorization rule operations to the logs table
     */
    private function logAuthorizationRuleOperation(string $action, array $ruleData, int $ruleId = null): void
    {
        try {
            log_message('info', 'logAuthorizationRuleOperation called with action: ' . $action . ', ruleId: ' . $ruleId);
            
            $ruleNumber = $ruleId ?? ($ruleData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Authorization Rule Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Authorization Rule Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Authorization Rule Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Authorization Rule ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $ruleNumber . "\n";
            $actionDescription .= "User: " . ($ruleData['user_display_name'] ?? $ruleData['user_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Rule Type: " . ($ruleData['rule_type'] ?? 'Unknown') . "\n";
            $actionDescription .= "Target Type: " . ($ruleData['target_type'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($ruleData['description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId,
                'module_id' => 18, // Authorization Rules module ID (you may need to adjust this)
                'action' => $actionDescription,
            ];

            log_message('info', 'Attempting to insert log data: ' . json_encode($logData));
            
            $result = $this->logModel->insert($logData);
            
            if ($result) {
                log_message('info', 'Successfully inserted log with ID: ' . $result);
            } else {
                $errors = $this->logModel->errors();
                log_message('error', 'Failed to insert log. Errors: ' . json_encode($errors));
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to log authorization rule operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of authorization rules
     */
    public function index()
    {
        // Check if user has permission to view authorization rules
        if (!has_permission('authorization_rules.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view authorization rules.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $authorizationRules = $this->authorizationRuleModel->getAuthorizationRulesWithPagination($search, $limit, $offset);
        $totalAuthorizationRules = $this->authorizationRuleModel->getAuthorizationRulesCount($search);
        $totalPages = ceil($totalAuthorizationRules / $limit);

        // Parse JSON fields and get names for each authorization rule
        foreach ($authorizationRules as &$rule) {
            $rule = $this->authorizationRuleModel->parseJsonFields($rule);
            
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
        }

        // Get data for dropdowns
        $users = $this->authorizationRuleModel->getActiveUsers();
        $divisions = $this->authorizationRuleModel->getActiveDivisions();
        $departments = $this->authorizationRuleModel->getActiveDepartments();
        $sections = $this->authorizationRuleModel->getActiveSections();

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('authorization_rules.create'),
            'canEdit' => has_permission('authorization_rules.edit'),
            'canView' => has_permission('authorization_rules.view'),
            'canDelete' => has_permission('authorization_rules.delete')
        ];

        $data = [
            'title' => 'Authorization Rules Management',
            'authorizationRules' => $authorizationRules,
            'users' => $users,
            'divisions' => $divisions,
            'departments' => $departments,
            'sections' => $sections,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalAuthorizationRules' => $totalAuthorizationRules,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('authorization_rules/index', $data);
    }

    /**
     * Store a newly created authorization rule in database
     */
    public function store()
    {
        // Check if user has permission to create authorization rules
        if (!has_permission('authorization_rules.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create authorization rules.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create authorization rules.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Authorization rule store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        if (!$this->validate($this->authorizationRuleModel->getValidationRules())) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $this->validator->getErrors(),
                    'message' => 'Validation failed.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->validator->getErrors());
        }

        // Prepare data for insertion with sanitization
        $rawData = [
            'user_id' => $this->request->getPost('user_id'),
            'rule_type' => $this->request->getPost('rule_type'),
            'target_type' => $this->request->getPost('target_type'),
            'approval_level' => $this->request->getPost('approval_level'),
            'division_ids' => $this->request->getPost('division_ids'),
            'department_ids' => $this->request->getPost('department_ids'),
            'section_ids' => $this->request->getPost('section_ids'),
            'is_active' => $this->request->getPost('is_active'),
            'description' => $this->request->getPost('description')
        ];
        $data = $this->sanitizeAuthorizationRuleInput($rawData);

        // Insert the authorization rule
        if ($ruleId = $this->authorizationRuleModel->insert($data)) {
            // Get the full authorization rule data for logging
            $ruleData = $this->authorizationRuleModel->getAuthorizationRule($ruleId);
            
            // Log the create operation
            $this->logAuthorizationRuleOperation('create', $ruleData, $ruleId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Authorization rule created successfully!'
                ]);
            }
            return redirect()->to('/authorization-rules')
                           ->with('success', 'Authorization rule created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create authorization rule. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create authorization rule. Please try again.');
        }
    }

    /**
     * Store multiple authorization rules in database
     */
    public function storeMultiple()
    {
        // Check if user has permission to create authorization rules
        if (!has_permission('authorization_rules.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create authorization rules.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create authorization rules.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Multiple authorization rules store called. POST data: ' . json_encode($this->request->getPost()));
        
        // Get common data
        $userId = $this->request->getPost('user_id');
        $description = $this->request->getPost('description');
        $isActive = $this->request->getPost('is_active');
        $rulesJson = $this->request->getPost('rules');
        
        if (!$userId) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User is required.'
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'User is required.');
        }
        
        if (!$rulesJson) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No rules provided.'
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'No rules provided.');
        }
        
        // Parse rules JSON
        $rules = json_decode($rulesJson, true);
        if (!$rules || !is_array($rules) || empty($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid rules data.'
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'Invalid rules data.');
        }

        // Validate that all rules have required fields
        $errors = [];
        foreach ($rules as $index => $rule) {
            if (empty($rule['rule_type'])) {
                $errors["Rule " . ($index + 1)]['rule_type'] = 'Rule type is required';
            }
            if (empty($rule['target_type'])) {
                $errors["Rule " . ($index + 1)]['target_type'] = 'Target type is required';
            }
            if (empty($rule['approval_level'])) {
                $errors["Rule " . ($index + 1)]['approval_level'] = 'Approval level is required';
            }
        }
        
        if (!empty($errors)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $errors,
                    'message' => 'Some rules have validation errors.'
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        
        try {
            // Collect all IDs from all rules for backward compatibility
            $allDivisionIds = [];
            $allDepartmentIds = [];
            $allSectionIds = [];
            
            log_message('info', 'Processing rules for ID collection: ' . json_encode($rules));
            
            foreach ($rules as $rule) {
                log_message('info', 'Processing rule: ' . json_encode($rule));
                
                if (!empty($rule['division_ids'])) {
                    log_message('info', 'Found division_ids: ' . json_encode($rule['division_ids']));
                    $allDivisionIds = array_merge($allDivisionIds, $rule['division_ids']);
                }
                if (!empty($rule['department_ids'])) {
                    log_message('info', 'Found department_ids: ' . json_encode($rule['department_ids']));
                    $allDepartmentIds = array_merge($allDepartmentIds, $rule['department_ids']);
                }
                if (!empty($rule['section_ids'])) {
                    log_message('info', 'Found section_ids: ' . json_encode($rule['section_ids']));
                    $allSectionIds = array_merge($allSectionIds, $rule['section_ids']);
                }
            }
            
            // Remove duplicates and prepare for JSON encoding
            $allDivisionIds = array_unique($allDivisionIds);
            $allDepartmentIds = array_unique($allDepartmentIds);
            $allSectionIds = array_unique($allSectionIds);
            
            log_message('info', 'Collected IDs - Divisions: ' . json_encode($allDivisionIds) . ', Departments: ' . json_encode($allDepartmentIds) . ', Sections: ' . json_encode($allSectionIds));
            
            // Create a single authorization rule record with multiple rule configurations
            $data = [
                'user_id' => $userId,
                'rule_type' => 'multiple', // Indicate this is a multi-rule record
                'target_type' => 'multiple', // Indicate this supports multiple targets
                'approval_level' => 'multiple', // Indicate this has multiple approval levels
                'division_ids' => !empty($allDivisionIds) ? $allDivisionIds : null, // Pass as array, model will JSON encode
                'department_ids' => !empty($allDepartmentIds) ? $allDepartmentIds : null, // Pass as array, model will JSON encode  
                'section_ids' => !empty($allSectionIds) ? $allSectionIds : null, // Pass as array, model will JSON encode
                'rules_config' => json_encode($rules), // Store all rules as JSON (not processed by model)
                'is_active' => $isActive,
                'description' => $description
            ];
            
            // Basic validation for the main record
            $validation = \Config\Services::validation();
            $validationRules = [
                'user_id' => 'required|numeric|is_not_unique[users.id]|is_unique[authorization_rules.user_id]',
                'rules_config' => 'required',
                'is_active' => 'required|in_list[0,1]'
            ];
            $validation->setRules($validationRules);
            
            // Set custom error messages
            $validation->setRule('user_id', 'User', 'required|numeric|is_not_unique[users.id]|is_unique[authorization_rules.user_id]', [
                'required' => 'User is required.',
                'numeric' => 'User must be a valid number.',
                'is_not_unique' => 'Selected user does not exist.',
                'is_unique' => 'This user already has an authorization rule. Please edit the existing rule instead of creating a new one.'
            ]);
            
            if (!$validation->run($data)) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'errors' => $validation->getErrors(),
                        'message' => 'Validation failed.'
                    ]);
                }
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }
            
            // Debug: Log the data being inserted
            log_message('info', 'Attempting to insert authorization rule data: ' . json_encode($data));
            log_message('info', 'Data types: ' . json_encode(array_map('gettype', $data)));
            
            // Insert the single record with multiple rules configuration
            if ($ruleId = $this->authorizationRuleModel->insert($data)) {
                log_message('info', 'Successfully inserted authorization rule with ID: ' . $ruleId);
                
                // Get the full authorization rule data for logging
                $fullRuleData = $this->authorizationRuleModel->getAuthorizationRule($ruleId);
                
                // Log the create operation
                $this->logAuthorizationRuleOperation('create', $fullRuleData, $ruleId);
                
                $successMessage = count($rules) === 1 
                    ? 'Authorization rule created successfully!'
                    : 'Authorization rule with ' . count($rules) . ' configurations created successfully!';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => $successMessage,
                        'rule_id' => $ruleId,
                        'rules_count' => count($rules)
                    ]);
                }
                return redirect()->to('/authorization-rules')
                               ->with('success', $successMessage);
            } else {
                // Get detailed error information
                $modelErrors = $this->authorizationRuleModel->errors();
                $errorMessage = 'Failed to create authorization rule.';
                
                if (!empty($modelErrors)) {
                    log_message('error', 'Model validation errors: ' . json_encode($modelErrors));
                    $errorMessage = 'Validation errors: ' . implode(', ', $modelErrors);
                }
                
                log_message('error', 'Failed to insert authorization rule. Data: ' . json_encode($data));
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => $errorMessage,
                        'errors' => $modelErrors,
                        'debug_data' => $data
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', $errorMessage);
            }
                           
        } catch (\Exception $e) {
            log_message('error', 'Failed to create multiple authorization rules: ' . $e->getMessage());
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'An error occurred while creating authorization rules.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'An error occurred while creating authorization rules.');
        }
    }

    /**
     * Display the specified authorization rule (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view authorization rules
        if (!has_permission('authorization_rules.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view authorization rules.'
            ]);
        }

        // Only allow AJAX requests for modals
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Authorization rule ID is required.'
            ]);
        }

        $authorizationRule = $this->authorizationRuleModel->getAuthorizationRuleDetails($id);

        if (!$authorizationRule) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Authorization rule not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $authorizationRule
        ]);
    }

    /**
     * Update the specified authorization rule in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit authorization rules
        if (!has_permission('authorization_rules.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit authorization rules.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit authorization rules.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Authorization rule update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Authorization rule ID is required.'
                ]);
            }
            return redirect()->to('/authorization-rules')
                           ->with('error', 'Authorization rule ID is required.');
        }

        $authorizationRule = $this->authorizationRuleModel->getAuthorizationRule($id);

        if (!$authorizationRule) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Authorization rule not found.'
                ]);
            }
            return redirect()->to('/authorization-rules')
                           ->with('error', 'Authorization rule not found.');
        }

        // Get common data (multiple rules format)
        $userId = $this->request->getPost('user_id');
        $description = $this->request->getPost('description');
        $isActive = $this->request->getPost('is_active');
        $rulesJson = $this->request->getPost('rules');
        
        if (!$userId) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User is required.'
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'User is required.');
        }
        
        if (!$rulesJson) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Rules data is required.'
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'Rules data is required.');
        }
        
        // Parse rules JSON
        $rules = json_decode($rulesJson, true);
        if (!$rules || !is_array($rules) || empty($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid rules data.'
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'Invalid rules data.');
        }
        
        log_message('info', 'Updating authorization rule ID: ' . $id . ' with ' . count($rules) . ' rules');
        
        // Process multiple rules - combine them into single rule data
        $combinedData = $this->combineMultipleRules($rules, $userId, $description, $isActive);
        
        // Check if combineMultipleRules returned validation errors
        if (isset($combinedData['rule_type']) && $combinedData['rule_type'] === 'Rule type is required') {
            // This means it returned validation errors, not valid data
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $combinedData,
                    'message' => 'Validation failed.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $combinedData);
        }
        
        // Validate the combined data
        $validationResult = $this->authorizationRuleModel->validateForUpdate($combinedData, $id);
        
        if ($validationResult !== true) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $validationResult,
                    'message' => 'Validation failed.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validationResult);
        }
        
        // Prepare data for update
        $data = $combinedData;

        // Update the authorization rule
        try {
            // Skip model validation since we already validated
            $this->authorizationRuleModel->skipValidation(true);
            $result = $this->authorizationRuleModel->update($id, $data);
            $this->authorizationRuleModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated authorization rule data for logging
                $updatedRule = $this->authorizationRuleModel->getAuthorizationRule($id);
                
                // Log the update operation
                $this->logAuthorizationRuleOperation('update', $updatedRule, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Authorization rule updated successfully!'
                    ]);
                }
                return redirect()->to('/authorization-rules')
                               ->with('success', 'Authorization rule updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->authorizationRuleModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update authorization rule: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update authorization rule: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Database error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified authorization rule from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete authorization rules
        if (!has_permission('authorization_rules.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete authorization rules.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Authorization rule ID is required.'
            ]);
        }

        $authorizationRule = $this->authorizationRuleModel->getAuthorizationRule($id);

        if (!$authorizationRule) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Authorization rule not found.'
            ]);
        }

        // Delete the authorization rule (soft delete)
        if ($this->authorizationRuleModel->delete($id)) {
            // Log the delete operation
            $this->logAuthorizationRuleOperation('delete', $authorizationRule, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Authorization rule deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete authorization rule. Please try again.'
            ]);
        }
    }

    /**
     * API endpoint for mobile infinite scroll
     */
    public function api()
    {
        // Only allow AJAX requests
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = ($page - 1) * $limit;

        $authorizationRules = $this->authorizationRuleModel->getAuthorizationRulesWithPagination($search, $limit, $offset);
        $totalAuthorizationRules = $this->authorizationRuleModel->getAuthorizationRulesCount($search);

        // Process authorization rules to include additional details
        foreach ($authorizationRules as &$rule) {
            $rule = $this->authorizationRuleModel->parseJsonFields($rule);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $authorizationRules,
            'total' => $totalAuthorizationRules,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalAuthorizationRules
        ]);
    }

    /**
     * Get departments by division (AJAX)
     */
    public function getDepartmentsByDivision($divisionId = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        if ($divisionId === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Division ID is required.'
            ]);
        }

        $departments = $this->db->table('departments')
                              ->select('id, name')
                              ->where('division_id', $divisionId)
                              ->where('status_id', 1)
                              ->orderBy('name', 'ASC')
                              ->get()
                              ->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'data' => $departments
        ]);
    }

    /**
     * Get sections by department (AJAX)
     */
    public function getSectionsByDepartment($departmentId = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        if ($departmentId === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Department ID is required.'
            ]);
        }

        $sections = $this->db->table('sections')
                           ->select('id, name')
                           ->where('department_id', $departmentId)
                           ->where('status_id', 1)
                           ->orderBy('name', 'ASC')
                           ->get()
                           ->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'data' => $sections
        ]);
    }
    
    /**
     * Combine multiple rules into a single authorization rule record
     */
    private function combineMultipleRules($rules, $userId, $description, $isActive)
    {
        // Validate that all rules have required fields
        $errors = [];
        foreach ($rules as $index => $rule) {
            if (empty($rule['rule_type'])) {
                $errors["rule_type"] = 'Rule type is required';
            }
            if (empty($rule['target_type'])) {
                $errors["target_type"] = 'Target type is required';
            }
            if (empty($rule['approval_level'])) {
                $errors["approval_level"] = 'Approval level is required';
            }
        }
        
        if (!empty($errors)) {
            return $errors; // Return validation errors
        }
        
        // Collect all IDs from all rules for backward compatibility
        $allDivisionIds = [];
        $allDepartmentIds = [];
        $allSectionIds = [];
        
        log_message('info', 'Processing rules for ID collection: ' . json_encode($rules));
        
        foreach ($rules as $rule) {
            log_message('info', 'Processing rule: ' . json_encode($rule));
            
            if (!empty($rule['division_ids'])) {
                log_message('info', 'Found division_ids: ' . json_encode($rule['division_ids']));
                $allDivisionIds = array_merge($allDivisionIds, $rule['division_ids']);
            }
            if (!empty($rule['department_ids'])) {
                log_message('info', 'Found department_ids: ' . json_encode($rule['department_ids']));
                $allDepartmentIds = array_merge($allDepartmentIds, $rule['department_ids']);
            }
            if (!empty($rule['section_ids'])) {
                log_message('info', 'Found section_ids: ' . json_encode($rule['section_ids']));
                $allSectionIds = array_merge($allSectionIds, $rule['section_ids']);
            }
        }
        
        // Remove duplicates and prepare for JSON encoding
        $allDivisionIds = array_unique($allDivisionIds);
        $allDepartmentIds = array_unique($allDepartmentIds);
        $allSectionIds = array_unique($allSectionIds);
        
        log_message('info', 'Collected IDs - Divisions: ' . json_encode($allDivisionIds) . ', Departments: ' . json_encode($allDepartmentIds) . ', Sections: ' . json_encode($allSectionIds));
        
        // Create a single authorization rule record with multiple rule configurations
        return [
            'user_id' => $userId,
            'rule_type' => 'multiple', // Indicate this is a multi-rule record
            'target_type' => 'multiple', // Indicate this supports multiple targets
            'approval_level' => 'multiple', // Indicate this has multiple approval levels
            'division_ids' => !empty($allDivisionIds) ? $allDivisionIds : null, // Pass as array, model will JSON encode
            'department_ids' => !empty($allDepartmentIds) ? $allDepartmentIds : null, // Pass as array, model will JSON encode  
            'section_ids' => !empty($allSectionIds) ? $allSectionIds : null, // Pass as array, model will JSON encode
            'rules_config' => json_encode($rules), // Store all rules as JSON (not processed by model)
            'is_active' => $isActive,
            'description' => $description
        ];
    }
}