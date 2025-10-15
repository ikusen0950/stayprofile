<?php

namespace App\Controllers;

use App\Models\RequestingRuleModel;
use CodeIgniter\HTTP\RedirectResponse;

class RequestingRulesController extends BaseController
{
    protected $requestingRuleModel;
    protected $logModel;
    protected $db;

    public function __construct()
    {
        $this->requestingRuleModel = new RequestingRuleModel();
        $this->logModel = new \App\Models\LogModel();
        $this->db = \Config\Database::connect();
    }

    /**
     * Sanitize input data for requesting rule
     */
    private function sanitizeRequestingRuleInput(array $data): array
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
            'can_request' => isset($data['can_request']) ? (int)$data['can_request'] : 1, // Default to 1 for requesting rules
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
     * Process array field to ensure proper format
     */
    private function processArrayField($field)
    {
        if (is_null($field) || $field === '') {
            return null;
        }

        if (is_string($field)) {
            $decoded = json_decode($field, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return array_map('intval', array_filter($decoded, 'is_numeric'));
            }
        }

        if (is_array($field)) {
            return array_map('intval', array_filter($field, 'is_numeric'));
        }

        return null;
    }

    /**
     * Display a listing of requesting rules
     */
    public function index()
    {
        // Check if user has permission to view requesting rules
        if (!has_permission('authorization_rules.view')) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to view requesting rules.');
        }

        $search = $this->request->getGet('search');
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $requestingRules = $this->requestingRuleModel->getRequestingRulesWithPagination($search, $limit, $offset);
        $totalRequestingRules = $this->requestingRuleModel->getRequestingRulesCount($search);
        $totalPages = ceil($totalRequestingRules / $limit);

        // Parse JSON fields and get names for each requesting rule
        foreach ($requestingRules as &$rule) {
            $rule = $this->requestingRuleModel->parseJsonFields($rule);
            
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
        $users = $this->requestingRuleModel->getActiveUsers();
        $divisions = $this->requestingRuleModel->getActiveDivisions();
        $departments = $this->requestingRuleModel->getActiveDepartments();
        $sections = $this->requestingRuleModel->getActiveSections();

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('authorization_rules.create'),
            'canEdit' => has_permission('authorization_rules.edit'),
            'canView' => has_permission('authorization_rules.view'),
            'canDelete' => has_permission('authorization_rules.delete')
        ];

        $data = [
            'title' => 'Requesting Rules Management',
            'requestingRules' => $requestingRules,
            'users' => $users,
            'divisions' => $divisions,
            'departments' => $departments,
            'sections' => $sections,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalRequestingRules' => $totalRequestingRules,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('requesting_rules/index', $data);
    }

    /**
     * Store a newly created requesting rule in database
     */
    public function store()
    {
        // Check if user has permission to create requesting rules
        if (!has_permission('authorization_rules.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create requesting rules.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create requesting rules.');
        }

        $rawData = [
            'user_id' => $this->request->getPost('user_id'),
            'rule_type' => $this->request->getPost('rule_type'),
            'target_type' => $this->request->getPost('target_type'),
            'approval_level' => $this->request->getPost('approval_level'),
            'division_ids' => $this->request->getPost('division_ids'),
            'department_ids' => $this->request->getPost('department_ids'),
            'section_ids' => $this->request->getPost('section_ids'),
            'is_active' => $this->request->getPost('is_active'),
            'can_request' => 1, // Always set to 1 for requesting rules
            'description' => $this->request->getPost('description')
        ];
        $data = $this->sanitizeRequestingRuleInput($rawData);

        // Insert the requesting rule
        if ($ruleId = $this->requestingRuleModel->insert($data)) {
            // Get the full requesting rule data for logging
            $ruleData = $this->requestingRuleModel->getRequestingRule($ruleId);
            
            // Log the create operation
            $this->logRequestingRuleOperation('create', $ruleData, $ruleId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Requesting rule created successfully.',
                    'data' => $ruleData
                ]);
            }
            return redirect()->to('/requesting-rules')->with('success', 'Requesting rule created successfully.');
        } else {
            $errors = $this->requestingRuleModel->errors();
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create requesting rule.',
                    'errors' => $errors
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $errors);
        }
    }

    /**
     * Store multiple requesting rules
     */
    public function storeMultiple()
    {
        // Check if user has permission to create requesting rules
        if (!has_permission('authorization_rules.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create requesting rules.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create requesting rules.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Multiple requesting rules store called. POST data: ' . json_encode($this->request->getPost()));
        
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
                    'message' => 'At least one rule configuration is required.'
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'At least one rule configuration is required.');
        }
        
        // Parse the rules JSON
        $rules = json_decode($rulesJson, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($rules) || empty($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid rules data format.'
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'Invalid rules data format.');
        }
        
        log_message('info', 'Parsed rules: ' . json_encode($rules));
        
        // Combine multiple rules into a single record
        $combinedData = $this->combineMultipleRequestingRules($rules, $userId, $description, $isActive);
        
        if (is_array($combinedData) && isset($combinedData['user_id'])) {
            // Insert the combined requesting rule
            if ($ruleId = $this->requestingRuleModel->insert($combinedData)) {
                // Get the full requesting rule data for logging
                $ruleData = $this->requestingRuleModel->getRequestingRule($ruleId);
                
                // Log the create operation
                $this->logRequestingRuleOperation('create_multiple', $ruleData, $ruleId);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Multiple requesting rules created successfully.',
                        'data' => $ruleData
                    ]);
                }
                return redirect()->to('/requesting-rules')->with('success', 'Multiple requesting rules created successfully.');
            } else {
                $errors = $this->requestingRuleModel->errors();
                log_message('error', 'Failed to insert multiple requesting rules. Errors: ' . json_encode($errors));
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to create requesting rules.',
                        'errors' => $errors
                    ]);
                }
                return redirect()->back()->withInput()->with('errors', $errors);
            }
        } else {
            // Handle validation errors from combineMultipleRequestingRules
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $combinedData  // This should be validation errors
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $combinedData);
        }
    }

    /**
     * Display the specified requesting rule
     */
    public function show($id = null)
    {
        // Check if user has permission to view requesting rules
        if (!has_permission('authorization_rules.view')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to view requesting rules.'
                ]);
            }
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to view requesting rules.');
        }

        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Requesting rule ID is required.'
                ]);
            }
            return redirect()->to('/requesting-rules')->with('error', 'Requesting rule ID is required.');
        }

        $requestingRule = $this->requestingRuleModel->getRequestingRuleDetails($id);

        if (!$requestingRule) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Requesting rule not found.'
                ]);
            }
            return redirect()->to('/requesting-rules')->with('error', 'Requesting rule not found.');
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $requestingRule
            ]);
        }

        return view('requesting_rules/show', ['requestingRule' => $requestingRule]);
    }

    /**
     * Show the form for editing the specified requesting rule
     */
    public function edit($id = null)
    {
        return $this->show($id);
    }

    /**
     * Update the specified requesting rule in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit requesting rules
        if (!has_permission('authorization_rules.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit requesting rules.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit requesting rules.');
        }

        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Requesting rule ID is required.'
                ]);
            }
            return redirect()->to('/requesting-rules')->with('error', 'Requesting rule ID is required.');
        }

        $requestingRule = $this->requestingRuleModel->find($id);

        if (!$requestingRule) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Requesting rule not found.'
                ]);
            }
            return redirect()->to('/requesting-rules')->with('error', 'Requesting rule not found.');
        }

        $rawData = [
            'user_id' => $this->request->getPost('user_id'),
            'rule_type' => $this->request->getPost('rule_type'),
            'target_type' => $this->request->getPost('target_type'),
            'approval_level' => $this->request->getPost('approval_level'),
            'division_ids' => $this->request->getPost('division_ids'),
            'department_ids' => $this->request->getPost('department_ids'),
            'section_ids' => $this->request->getPost('section_ids'),
            'is_active' => $this->request->getPost('is_active'),
            'can_request' => $this->request->getPost('can_request', 1), // Default to 1 for requesting rules
            'description' => $this->request->getPost('description')
        ];
        $data = $this->sanitizeRequestingRuleInput($rawData);

        // Update the requesting rule
        if ($this->requestingRuleModel->update($id, $data)) {
            // Get the updated requesting rule data for logging
            $updatedRule = $this->requestingRuleModel->getRequestingRule($id);
            
            // Log the update operation
            $this->logRequestingRuleOperation('update', $updatedRule, $id);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Requesting rule updated successfully.',
                    'data' => $updatedRule
                ]);
            }
            return redirect()->to('/requesting-rules')->with('success', 'Requesting rule updated successfully.');
        } else {
            $errors = $this->requestingRuleModel->errors();
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update requesting rule.',
                    'errors' => $errors
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $errors);
        }
    }

    /**
     * Remove the specified requesting rule from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete requesting rules
        if (!has_permission('authorization_rules.delete')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to delete requesting rules.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to delete requesting rules.');
        }

        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Requesting rule ID is required.'
                ]);
            }
            return redirect()->to('/requesting-rules')->with('error', 'Requesting rule ID is required.');
        }

        $requestingRule = $this->requestingRuleModel->find($id);

        if (!$requestingRule) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Requesting rule not found.'
                ]);
            }
            return redirect()->to('/requesting-rules')->with('error', 'Requesting rule not found.');
        }

        // Get the full requesting rule data for logging before deletion
        $ruleData = $this->requestingRuleModel->getRequestingRule($id);

        if ($this->requestingRuleModel->delete($id)) {
            // Log the delete operation
            $this->logRequestingRuleOperation('delete', $ruleData, $id);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Requesting rule deleted successfully.'
                ]);
            }
            return redirect()->to('/requesting-rules')->with('success', 'Requesting rule deleted successfully.');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to delete requesting rule.'
                ]);
            }
            return redirect()->to('/requesting-rules')->with('error', 'Failed to delete requesting rule.');
        }
    }

    /**
     * API endpoint for requesting rules
     */
    public function api()
    {
        // Check if user has permission to view requesting rules
        if (!has_permission('authorization_rules.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to access requesting rules API.'
            ]);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $search = $this->request->getGet('search');
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = ($page - 1) * $limit;

        $requestingRules = $this->requestingRuleModel->getRequestingRulesWithPagination($search, $limit, $offset);
        $totalRequestingRules = $this->requestingRuleModel->getRequestingRulesCount($search);

        // Parse JSON fields for API response
        foreach ($requestingRules as &$rule) {
            $rule = $this->requestingRuleModel->parseJsonFields($rule);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $requestingRules,
            'total' => $totalRequestingRules,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalRequestingRules
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
     * Combine multiple rules into a single requesting rule record
     */
    private function combineMultipleRequestingRules($rules, $userId, $description, $isActive)
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
        
        log_message('info', 'Processing requesting rules for ID collection: ' . json_encode($rules));
        
        foreach ($rules as $rule) {
            log_message('info', 'Processing requesting rule: ' . json_encode($rule));
            
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
        
        // Create a single requesting rule record with multiple rule configurations
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
            'can_request' => 1, // Always set to 1 for requesting rules
            'description' => $description
        ];
    }

    /**
     * Log requesting rule operations
     */
    private function logRequestingRuleOperation($operation, $ruleData, $ruleId)
    {
        helper('auth');
        
        $logData = [
            'user_id' => function_exists('user') && user() ? user()->id : 1,
            'action' => strtoupper($operation) . '_REQUESTING_RULE',
            'description' => ucfirst($operation) . ' requesting rule for user: ' . ($ruleData['user_name'] ?? 'Unknown'),
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getHeaderLine('User-Agent'),
            'request_method' => $this->request->getMethod(),
            'request_uri' => $this->request->getUri()->getPath(),
            'table_name' => 'authorization_rules',
            'record_id' => $ruleId,
            'old_values' => null,
            'new_values' => json_encode($ruleData),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->logModel->insert($logData);
    }
}