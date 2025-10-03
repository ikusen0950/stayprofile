<?php

namespace App\Controllers;

use App\Models\ModuleModel;
use CodeIgniter\HTTP\RedirectResponse;

class ModulesController extends BaseController
{
    protected $moduleModel;
    protected $logModel;

    public function __construct()
    {
        $this->moduleModel = new ModuleModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for module
     */
    private function sanitizeModuleInput(array $data): array
    {
        $sanitized = [
            'name' => isset($data['name']) ? trim(strip_tags($data['name'])) : '',
            'status_id' => isset($data['status_id']) ? (int)$data['status_id'] : 0,
            'description' => isset($data['description']) ? 
                trim(strip_tags($data['description'], '<p><br><strong><em><ul><ol><li>')) : '',
        ];

        // Add audit fields if present (these don't need sanitization as they're system-generated)
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
     * Log module operations to the logs table
     */
    private function logModuleOperation(string $action, array $moduleData, int $moduleId = null): void
    {
        try {
            log_message('info', 'logModuleOperation called with action: ' . $action . ', moduleId: ' . $moduleId);
            
            $moduleNumber = $moduleId ?? ($moduleData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Module Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Module Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Module Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Module ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description in the requested format
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $moduleNumber . "\n";
            $actionDescription .= "Module: Modules" . "\n";
            $actionDescription .= "Name: " . ($moduleData['name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($moduleData['description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 4, // Modules module ID (assuming ID 4 for modules)
                'action' => $actionDescription, // Structured action text with details
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
            // Log the error but don't break the main operation
            log_message('error', 'Failed to log module operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of modules
     */
    public function index()
    {
        // Check if user has permission to view modules
        if (!has_permission('modules.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view modules.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $modules = $this->moduleModel->getModulesWithPagination($search, $limit, $offset);
        $totalModules = $this->moduleModel->getModulesCount($search);
        $totalPages = ceil($totalModules / $limit);

        // Get active statuses for dropdown
        $statuses = $this->moduleModel->getActiveStatuses();
        log_message('info', 'Statuses data: ' . json_encode($statuses));

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('modules.create'),
            'canEdit' => has_permission('modules.edit'),
            'canView' => has_permission('modules.view'),
            'canDelete' => has_permission('modules.delete')
        ];

        $data = [
            'title' => 'Module Management',
            'modules' => $modules,
            'statuses' => $statuses,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalModules' => $totalModules,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('modules/index', $data);
    }

    /**
     * Store a newly created module in database
     */
    public function store()
    {
        // Check if user has permission to create modules
        if (!has_permission('modules.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create modules.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create modules.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Module store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        if (!$this->validate($this->moduleModel->getValidationRules())) {
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
            'name' => $this->request->getPost('name'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $data = $this->sanitizeModuleInput($rawData);

        // Insert the module
        if ($moduleId = $this->moduleModel->insert($data)) {
            // Get the full module data for logging
            $moduleData = $this->moduleModel->getModule($moduleId);
            
            // Log the create operation
            $this->logModuleOperation('create', $moduleData, $moduleId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Module created successfully!'
                ]);
            }
            return redirect()->to('/modules')
                           ->with('success', 'Module created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create module. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create module. Please try again.');
        }
    }

    /**
     * Display the specified module (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view modules
        if (!has_permission('modules.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view modules.'
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
                'message' => 'Module ID is required.'
            ]);
        }

        $module = $this->moduleModel->getModule($id);

        if (!$module) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Module not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $module
        ]);
    }

    /**
     * Update the specified module in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit modules
        if (!has_permission('modules.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit modules.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit modules.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Module update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Module ID is required.'
                ]);
            }
            return redirect()->to('/modules')
                           ->with('error', 'Module ID is required.');
        }

        $module = $this->moduleModel->getModule($id);

        if (!$module) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Module not found.'
                ]);
            }
            return redirect()->to('/modules')
                           ->with('error', 'Module not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = [
            'name' => $this->request->getPost('name'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $inputData = $this->sanitizeModuleInput($rawData);
        
        $validationResult = $this->moduleModel->validateForUpdate($inputData, $id);
        
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
        $data = $inputData;

        // Update the module
        try {
            // Skip model validation since we already validated
            $this->moduleModel->skipValidation(true);
            $result = $this->moduleModel->update($id, $data);
            $this->moduleModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated module data for logging
                $updatedModule = $this->moduleModel->getModule($id);
                
                // Log the update operation
                $this->logModuleOperation('update', $updatedModule, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Module updated successfully!'
                    ]);
                }
                return redirect()->to('/modules')
                               ->with('success', 'Module updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->moduleModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update module: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update module: ' . $errorMessage);
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
     * Remove the specified module from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete modules
        if (!has_permission('modules.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete modules.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Module ID is required.'
            ]);
        }

        $module = $this->moduleModel->getModule($id);

        if (!$module) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Module not found.'
            ]);
        }

        // Delete the module
        if ($this->moduleModel->delete($id)) {
            // Log the delete operation
            $this->logModuleOperation('delete', $module, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Module deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete module. Please try again.'
            ]);
        }
    }

    /**
     * Get modules for AJAX requests
     */
    public function getModules()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $modules = $this->moduleModel->getModulesWithPagination($search, $limit, $offset);
        $totalModules = $this->moduleModel->getModulesCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $modules,
            'total' => $totalModules
        ]);
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

        $modules = $this->moduleModel->getModulesWithPagination($search, $limit, $offset);
        $totalModules = $this->moduleModel->getModulesCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $modules,
            'total' => $totalModules,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalModules
        ]);
    }

    /**
     * Get statuses for dropdown (AJAX)
     */
    public function getStatuses()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $statuses = $this->moduleModel->getActiveStatuses();

        return $this->response->setJSON([
            'success' => true,
            'data' => $statuses
        ]);
    }
}