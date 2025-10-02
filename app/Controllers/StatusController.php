<?php

namespace App\Controllers;

use App\Models\StatusModel;
use CodeIgniter\HTTP\RedirectResponse;

class StatusController extends BaseController
{
    protected $statusModel;
    protected $logModel;

    public function __construct()
    {
        $this->statusModel = new StatusModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for status
     */
    private function sanitizeStatusInput(array $data): array
    {
        $sanitized = [
            'name' => isset($data['name']) ? trim(strip_tags($data['name'])) : '',
            'module_id' => isset($data['module_id']) ? (int)$data['module_id'] : 0,
            'color' => isset($data['color']) ? trim(strip_tags($data['color'])) : '',
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
     * Log status operations to the logs table
     */
    private function logStatusOperation(string $action, array $statusData, int $statusId = null): void
    {
        try {
            log_message('info', 'logStatusOperation called with action: ' . $action . ', statusId: ' . $statusId);
            
            $statusNumber = $statusId ?? ($statusData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Status Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Status Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Status Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Status ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description in the requested format
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $statusNumber . "\n";
            $actionDescription .= "Module: " . ($statusData['module_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Name: " . ($statusData['name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($statusData['description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 3, // Status module ID (from modules table)
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
            log_message('error', 'Failed to log status operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of status
     */
    public function index()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $statuses = $this->statusModel->getStatusWithPagination($search, $limit, $offset);
        $totalStatus = $this->statusModel->getStatusCount($search);
        $totalPages = ceil($totalStatus / $limit);

        // Get active modules for dropdown
        $modules = $this->statusModel->getActiveModules();
        log_message('info', 'Modules data: ' . json_encode($modules));

        $data = [
            'title' => 'Status Management',
            'statuses' => $statuses,
            'modules' => $modules,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalStatus' => $totalStatus,
            'limit' => $limit
        ];

        return view('status/index', $data);
    }

    /**
     * Store a newly created status in database
     */
    public function store()
    {
        // Debug: Log the incoming request
        log_message('info', 'Status store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        if (!$this->validate($this->statusModel->getValidationRules())) {
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
            'module_id' => $this->request->getPost('module_id'),
            'color' => $this->request->getPost('color'),
            'description' => $this->request->getPost('description')
        ];
        $data = $this->sanitizeStatusInput($rawData);

        // Insert the status
        if ($statusId = $this->statusModel->insert($data)) {
            // Get the full status data for logging
            $statusData = $this->statusModel->getStatus($statusId);
            
            // Log the create operation
            $this->logStatusOperation('create', $statusData, $statusId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Status created successfully!'
                ]);
            }
            return redirect()->to('/status')
                           ->with('success', 'Status created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create status. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create status. Please try again.');
        }
    }

    /**
     * Display the specified status (AJAX only for modals)
     */
    public function show($id = null)
    {
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
                'message' => 'Status ID is required.'
            ]);
        }

        $status = $this->statusModel->getStatus($id);

        if (!$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Status not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $status
        ]);
    }

    /**
     * Update the specified status in database
     */
    public function update($id = null)
    {
        // Debug: Log the incoming request
        log_message('info', 'Status update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Status ID is required.'
                ]);
            }
            return redirect()->to('/status')
                           ->with('error', 'Status ID is required.');
        }

        $status = $this->statusModel->getStatus($id);

        if (!$status) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Status not found.'
                ]);
            }
            return redirect()->to('/status')
                           ->with('error', 'Status not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = [
            'name' => $this->request->getPost('name'),
            'module_id' => $this->request->getPost('module_id'),
            'color' => $this->request->getPost('color'),
            'description' => $this->request->getPost('description')
        ];
        $inputData = $this->sanitizeStatusInput($rawData);
        
        $validationResult = $this->statusModel->validateForUpdate($inputData, $id);
        
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

        // Update the status
        try {
            // Skip model validation since we already validated
            $this->statusModel->skipValidation(true);
            $result = $this->statusModel->update($id, $data);
            $this->statusModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated status data for logging
                $updatedStatus = $this->statusModel->getStatus($id);
                
                // Log the update operation
                $this->logStatusOperation('update', $updatedStatus, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Status updated successfully!'
                    ]);
                }
                return redirect()->to('/status')
                               ->with('success', 'Status updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->statusModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update status: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update status: ' . $errorMessage);
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
     * Remove the specified status from database
     */
    public function delete($id = null)
    {
        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Status ID is required.'
            ]);
        }

        $status = $this->statusModel->getStatus($id);

        if (!$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Status not found.'
            ]);
        }

        // Delete the status
        if ($this->statusModel->delete($id)) {
            // Log the delete operation
            $this->logStatusOperation('delete', $status, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete status. Please try again.'
            ]);
        }
    }

    /**
     * Get status for AJAX requests
     */
    public function getStatus()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $statuses = $this->statusModel->getStatusWithPagination($search, $limit, $offset);
        $totalStatus = $this->statusModel->getStatusCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $statuses,
            'total' => $totalStatus
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

        $statuses = $this->statusModel->getStatusWithPagination($search, $limit, $offset);
        $totalStatus = $this->statusModel->getStatusCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $statuses,
            'total' => $totalStatus,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalStatus
        ]);
    }

    /**
     * Get modules for dropdown (AJAX)
     */
    public function getModules()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $modules = $this->statusModel->getActiveModules();

        return $this->response->setJSON([
            'success' => true,
            'data' => $modules
        ]);
    }
}