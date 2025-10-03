<?php

namespace App\Controllers;

use App\Models\DepartmentModel;
use CodeIgniter\HTTP\RedirectResponse;

class DepartmentsController extends BaseController
{
    protected $departmentModel;
    protected $logModel;

    public function __construct()
    {
        $this->departmentModel = new DepartmentModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for department
     */
    private function sanitizeDepartmentInput(array $data): array
    {
        $sanitized = [
            'name' => isset($data['name']) ? trim(strip_tags($data['name'])) : '',
            'division_id' => isset($data['division_id']) ? (int)$data['division_id'] : 0,
            'status_id' => isset($data['status_id']) ? (int)$data['status_id'] : 1,
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
     * Log department operations to the logs table
     */
    private function logDepartmentOperation(string $action, array $departmentData, int $departmentId = null): void
    {
        try {
            log_message('info', 'logDepartmentOperation called with action: ' . $action . ', departmentId: ' . $departmentId);
            
            $departmentNumber = $departmentId ?? ($departmentData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Department Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Department Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Department Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Department ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description in the requested format
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $departmentNumber . "\n";
            $actionDescription .= "Division: " . ($departmentData['division_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Name: " . ($departmentData['name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($departmentData['description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 6, // Status module ID (from modules table)
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
            log_message('error', 'Failed to log department operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of departments
     */
    public function index()
    {
        // Check if user has permission to view departments
        if (!has_permission('departments.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view departments.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $departments = $this->departmentModel->getDepartmentsWithPagination($search, $limit, $offset);
        $totalDepartments = $this->departmentModel->getDepartmentsCount($search);
        $totalPages = ceil($totalDepartments / $limit);

        // Get active divisions for dropdown
        $divisions = $this->departmentModel->getActiveDivisions();
        log_message('info', 'Divisions data: ' . json_encode($divisions));

        // Get active statuses for dropdown
        $statuses = $this->departmentModel->getActiveStatuses();
        log_message('info', 'Statuses data: ' . json_encode($statuses));

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('departments.create'),
            'canEdit' => has_permission('departments.edit'),
            'canView' => has_permission('departments.view'),
            'canDelete' => has_permission('departments.delete')
        ];

        $data = [
            'title' => 'Department Management',
            'departments' => $departments,
            'divisions' => $divisions,
            'statuses' => $statuses,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalDepartments' => $totalDepartments,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('departments/index', $data);
    }

    /**
     * Store a newly created department in database
     */
    public function store()
    {
        // Check if user has permission to create departments
        if (!has_permission('departments.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create departments.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create departments.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Department store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        if (!$this->validate($this->departmentModel->getValidationRules())) {
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
            'division_id' => $this->request->getPost('division_id'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $data = $this->sanitizeDepartmentInput($rawData);

        // Insert the department
        if ($departmentId = $this->departmentModel->insert($data)) {
            // Get the full department data for logging
            $departmentData = $this->departmentModel->getDepartment($departmentId);
            
            // Log the create operation
            $this->logDepartmentOperation('create', $departmentData, $departmentId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Department created successfully!'
                ]);
            }
            return redirect()->to('/departments')
                           ->with('success', 'Department created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create department. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create department. Please try again.');
        }
    }

    /**
     * Display the specified department (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view departments
        if (!has_permission('departments.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view departments.'
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
                'message' => 'Department ID is required.'
            ]);
        }

        $department = $this->departmentModel->getDepartment($id);

        if (!$department) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Department not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $department
        ]);
    }

    /**
     * Update the specified department in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit departments
        if (!has_permission('departments.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit departments.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit departments.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Department update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Department ID is required.'
                ]);
            }
            return redirect()->to('/departments')
                           ->with('error', 'Department ID is required.');
        }

        $department = $this->departmentModel->getDepartment($id);

        if (!$department) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Department not found.'
                ]);
            }
            return redirect()->to('/departments')
                           ->with('error', 'Department not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = [
            'name' => $this->request->getPost('name'),
            'division_id' => $this->request->getPost('division_id'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $inputData = $this->sanitizeDepartmentInput($rawData);
        
        $validationResult = $this->departmentModel->validateForUpdate($inputData, $id);
        
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

        // Update the department
        try {
            // Skip model validation since we already validated
            $this->departmentModel->skipValidation(true);
            $result = $this->departmentModel->update($id, $data);
            $this->departmentModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated department data for logging
                $updatedDepartment = $this->departmentModel->getDepartment($id);
                
                // Log the update operation
                $this->logDepartmentOperation('update', $updatedDepartment, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Department updated successfully!'
                    ]);
                }
                return redirect()->to('/departments')
                               ->with('success', 'Department updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->departmentModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update department: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update department: ' . $errorMessage);
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
     * Remove the specified department from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete departments
        if (!has_permission('departments.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete departments.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Department ID is required.'
            ]);
        }

        $department = $this->departmentModel->getDepartment($id);

        if (!$department) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Department not found.'
            ]);
        }

        // Delete the department
        if ($this->departmentModel->delete($id)) {
            // Log the delete operation
            $this->logDepartmentOperation('delete', $department, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Department deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete department. Please try again.'
            ]);
        }
    }

    /**
     * Get departments for AJAX requests
     */
    public function getDepartments()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $departments = $this->departmentModel->getDepartmentsWithPagination($search, $limit, $offset);
        $totalDepartments = $this->departmentModel->getDepartmentsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $departments,
            'total' => $totalDepartments
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

        $departments = $this->departmentModel->getDepartmentsWithPagination($search, $limit, $offset);
        $totalDepartments = $this->departmentModel->getDepartmentsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $departments,
            'total' => $totalDepartments,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalDepartments
        ]);
    }

    /**
     * Get divisions for dropdown (AJAX)
     */
    public function getDivisions()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $divisions = $this->departmentModel->getActiveDivisions();

        return $this->response->setJSON([
            'success' => true,
            'data' => $divisions
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

        $statuses = $this->departmentModel->getActiveStatuses();

        return $this->response->setJSON([
            'success' => true,
            'data' => $statuses
        ]);
    }
}