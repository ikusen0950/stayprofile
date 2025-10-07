<?php

namespace App\Controllers;

use App\Models\RoleModel;
use CodeIgniter\HTTP\RedirectResponse;

class RoleController extends BaseController
{
    protected $roleModel;
    protected $logModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for role
     */
    private function sanitizeRoleInput(array $data): array
    {
        $sanitized = [
            'name' => isset($data['name']) ? trim(strip_tags($data['name'])) : '',
            'description' => isset($data['description']) ? 
                trim(strip_tags($data['description'], '<p><br><strong><em><ul><ol><li>')) : '',
        ];

        return $sanitized;
    }

    /**
     * Log role operations to the logs table
     */
    private function logRoleOperation(string $action, array $roleData, int $roleId = null): void
    {
        try {
            log_message('info', 'logRoleOperation called with action: ' . $action . ', roleId: ' . $roleId);
            
            $roleNumber = $roleId ?? ($roleData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Role Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Role Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Role Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Role ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $roleNumber . "\n";
            $actionDescription .= "Name: " . ($roleData['name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($roleData['description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 1, // System module ID (from modules table)
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
            log_message('error', 'Failed to log role operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of roles
     */
    public function index()
    {
        // Check if user has permission to view roles
        if (!has_permission('roles.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view roles.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $roles = $this->roleModel->getRolesWithPagination($search, $limit, $offset);
        $totalRoles = $this->roleModel->getRolesCount($search);
        $totalPages = ceil($totalRoles / $limit);

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('roles.create'),
            'canEdit' => has_permission('roles.edit'),
            'canView' => has_permission('roles.view'),
            'canDelete' => has_permission('roles.delete')
        ];

        $data = [
            'title' => 'Role Management',
            'roles' => $roles,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalRoles' => $totalRoles,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('roles/index', $data);
    }

    /**
     * Store a newly created role in database
     */
    public function store()
    {
        // Check if user has permission to create roles
        if (!has_permission('roles.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create roles.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create roles.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Role store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        if (!$this->validate($this->roleModel->getValidationRules())) {
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
            'description' => $this->request->getPost('description')
        ];
        $data = $this->sanitizeRoleInput($rawData);

        // Insert the role
        if ($roleId = $this->roleModel->insert($data)) {
            // Get the full role data for logging
            $roleData = $this->roleModel->getRole($roleId);
            
            // Log the create operation
            $this->logRoleOperation('create', $roleData, $roleId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Role created successfully!'
                ]);
            }
            return redirect()->to('/roles')
                           ->with('success', 'Role created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create role. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create role. Please try again.');
        }
    }

    /**
     * Display the specified role (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view roles
        if (!has_permission('roles.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view roles.'
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
                'message' => 'Role ID is required.'
            ]);
        }

        $role = $this->roleModel->getRole($id);

        if (!$role) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Role not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $role
        ]);
    }

    /**
     * Update the specified role in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit roles
        if (!has_permission('roles.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit roles.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit roles.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Role update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Role ID is required.'
                ]);
            }
            return redirect()->to('/roles')
                           ->with('error', 'Role ID is required.');
        }

        $role = $this->roleModel->getRole($id);

        if (!$role) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Role not found.'
                ]);
            }
            return redirect()->to('/roles')
                           ->with('error', 'Role not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];
        $inputData = $this->sanitizeRoleInput($rawData);
        
        $validationResult = $this->roleModel->validateForUpdate($inputData, $id);
        
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

        // Update the role
        try {
            // Skip model validation since we already validated
            $this->roleModel->skipValidation(true);
            $result = $this->roleModel->update($id, $data);
            $this->roleModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated role data for logging
                $updatedRole = $this->roleModel->getRole($id);
                
                // Log the update operation
                $this->logRoleOperation('update', $updatedRole, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Role updated successfully!'
                    ]);
                }
                return redirect()->to('/roles')
                               ->with('success', 'Role updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->roleModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update role: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update role: ' . $errorMessage);
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
     * Remove the specified role from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete roles
        if (!has_permission('roles.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete roles.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Role ID is required.'
            ]);
        }

        $role = $this->roleModel->getRole($id);

        if (!$role) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Role not found.'
            ]);
        }

        // Delete the role
        if ($this->roleModel->delete($id)) {
            // Log the delete operation
            $this->logRoleOperation('delete', $role, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Role deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete role. Please try again.'
            ]);
        }
    }

    /**
     * Get roles for AJAX requests
     */
    public function getRoles()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $roles = $this->roleModel->getRolesWithPagination($search, $limit, $offset);
        $totalRoles = $this->roleModel->getRolesCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $roles,
            'total' => $totalRoles
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

        $roles = $this->roleModel->getRolesWithPagination($search, $limit, $offset);
        $totalRoles = $this->roleModel->getRolesCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $roles,
            'total' => $totalRoles,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalRoles
        ]);
    }
}