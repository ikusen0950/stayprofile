<?php

namespace App\Controllers;

use App\Models\RequestModel;
use CodeIgniter\HTTP\RedirectResponse;

class RequestController extends BaseController
{
    protected $requestModel;
    protected $logModel;

    public function __construct()
    {
        $this->requestModel = new RequestModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for request
     */
    private function sanitizeRequestInput(array $data): array
    {
        $sanitized = [
            'status_id' => isset($data['status_id']) ? (int)$data['status_id'] : null,
            'user_id' => isset($data['user_id']) ? (int)$data['user_id'] : null,
            'leave_id' => isset($data['leave_id']) ? (int)$data['leave_id'] : null,
            'transfer_type' => isset($data['transfer_type']) ? trim(strip_tags($data['transfer_type'])) : '',
            'transfer_route_type' => isset($data['transfer_route_type']) ? trim(strip_tags($data['transfer_route_type'])) : '',
            'transfer_departure_route_id' => isset($data['transfer_departure_route_id']) ? (int)$data['transfer_departure_route_id'] : null,
            'transfer_departure_date' => isset($data['transfer_departure_date']) ? $data['transfer_departure_date'] : null,
            'transfer_arrival_route_id' => isset($data['transfer_arrival_route_id']) ? (int)$data['transfer_arrival_route_id'] : null,
            'transfer_arrival_date' => isset($data['transfer_arrival_date']) ? $data['transfer_arrival_date'] : null,
            'second_transfer' => isset($data['second_transfer']) ? (int)$data['second_transfer'] : 0,
            'expected_arrival_date' => isset($data['expected_arrival_date']) ? $data['expected_arrival_date'] : null,
            'expected_departure_date' => isset($data['expected_departure_date']) ? $data['expected_departure_date'] : null,
            'departed_route_id' => isset($data['departed_route_id']) ? (int)$data['departed_route_id'] : null,
            'departed_date' => isset($data['departed_date']) ? $data['departed_date'] : null,
            'expected_departure_time' => isset($data['expected_departure_time']) ? $data['expected_departure_time'] : null,
            'departed_time' => isset($data['departed_time']) ? $data['departed_time'] : null,
            'arrived_route_id' => isset($data['arrived_route_id']) ? (int)$data['arrived_route_id'] : null,
            'arrived_date' => isset($data['arrived_date']) ? $data['arrived_date'] : null,
            'expected_arrival_time' => isset($data['expected_arrival_time']) ? $data['expected_arrival_time'] : null,
            'arrived_time' => isset($data['arrived_time']) ? $data['arrived_time'] : null,
            'security_onduty_arrival' => isset($data['security_onduty_arrival']) ? (int)$data['security_onduty_arrival'] : 0,
            'security_onduty_arrival_at' => isset($data['security_onduty_arrival_at']) ? $data['security_onduty_arrival_at'] : null,
            'security_onduty_departure' => isset($data['security_onduty_departure']) ? (int)$data['security_onduty_departure'] : 0,
            'security_onduty_departure_at' => isset($data['security_onduty_departure_at']) ? $data['security_onduty_departure_at'] : null,
            'security_onduty_no_show' => isset($data['security_onduty_no_show']) ? (int)$data['security_onduty_no_show'] : 0,
            'security_onduty_no_show_at' => isset($data['security_onduty_no_show_at']) ? $data['security_onduty_no_show_at'] : null,
            'security_onduty_revert_back' => isset($data['security_onduty_revert_back']) ? (int)$data['security_onduty_revert_back'] : 0,
            'security_onduty_revert_back_at' => isset($data['security_onduty_revert_back_at']) ? $data['security_onduty_revert_back_at'] : null,
            'security_onduty_cancel' => isset($data['security_onduty_cancel']) ? (int)$data['security_onduty_cancel'] : 0,
            'security_onduty_cancel_at' => isset($data['security_onduty_cancel_at']) ? $data['security_onduty_cancel_at'] : null,
            'security_onduty_expired' => isset($data['security_onduty_expired']) ? (int)$data['security_onduty_expired'] : 0,
            'security_onduty_expired_at' => isset($data['security_onduty_expired_at']) ? $data['security_onduty_expired_at'] : null,
            'type' => isset($data['type']) ? trim(strip_tags($data['type'])) : '',
            'type_color' => isset($data['type_color']) ? trim(strip_tags($data['type_color'])) : '',
            'type_description' => isset($data['type_description']) ? 
                trim(strip_tags($data['type_description'], '<p><br><strong><em><ul><ol><li>')) : '',
            'approval_level' => isset($data['approval_level']) ? (int)$data['approval_level'] : 0,
            'remarks' => isset($data['remarks']) ? 
                trim(strip_tags($data['remarks'], '<p><br><strong><em><ul><ol><li>')) : '',
            'is_assistant_manager' => isset($data['is_assistant_manager']) ? (int)$data['is_assistant_manager'] : 0,
            'approved_by' => isset($data['approved_by']) ? (int)$data['approved_by'] : null,
            'approved_at' => isset($data['approved_at']) ? $data['approved_at'] : null,
            'rejected_by' => isset($data['rejected_by']) ? (int)$data['rejected_by'] : null,
            'rejected_at' => isset($data['rejected_at']) ? $data['rejected_at'] : null,
            'transfer_departure_status' => isset($data['transfer_departure_status']) ? trim(strip_tags($data['transfer_departure_status'])) : '',
            'transfer_departure_carrier' => isset($data['transfer_departure_carrier']) ? trim(strip_tags($data['transfer_departure_carrier'])) : '',
            'transfer_departure_flight' => isset($data['transfer_departure_flight']) ? trim(strip_tags($data['transfer_departure_flight'])) : '',
            'transfer_departure_pnr' => isset($data['transfer_departure_pnr']) ? trim(strip_tags($data['transfer_departure_pnr'])) : '',
            'transfer_departure_check_in_time' => isset($data['transfer_departure_check_in_time']) ? $data['transfer_departure_check_in_time'] : null,
            'transfer_departure_departure_time' => isset($data['transfer_departure_departure_time']) ? $data['transfer_departure_departure_time'] : null,
            'transfer_departure_arrival_time' => isset($data['transfer_departure_arrival_time']) ? $data['transfer_departure_arrival_time'] : null,
            'transfer_departure_remarks' => isset($data['transfer_departure_remarks']) ? 
                trim(strip_tags($data['transfer_departure_remarks'], '<p><br><strong><em><ul><ol><li>')) : '',
            'transfer_arrival_status' => isset($data['transfer_arrival_status']) ? trim(strip_tags($data['transfer_arrival_status'])) : '',
            'transfer_arrival_carrier' => isset($data['transfer_arrival_carrier']) ? trim(strip_tags($data['transfer_arrival_carrier'])) : '',
            'transfer_arrival_flight' => isset($data['transfer_arrival_flight']) ? trim(strip_tags($data['transfer_arrival_flight'])) : '',
            'transfer_arrival_pnr' => isset($data['transfer_arrival_pnr']) ? trim(strip_tags($data['transfer_arrival_pnr'])) : '',
            'transfer_arrival_check_in_time' => isset($data['transfer_arrival_check_in_time']) ? $data['transfer_arrival_check_in_time'] : null,
            'transfer_arrival_departure_time' => isset($data['transfer_arrival_departure_time']) ? $data['transfer_arrival_departure_time'] : null,
            'transfer_arrival_arrival_time' => isset($data['transfer_arrival_arrival_time']) ? $data['transfer_arrival_arrival_time'] : null,
            'mode_of_transport' => isset($data['mode_of_transport']) ? trim(strip_tags($data['mode_of_transport'])) : '',
            'luggage_assistance' => isset($data['luggage_assistance']) ? (int)$data['luggage_assistance'] : 0,
            'transfer_arrival_remarks' => isset($data['transfer_arrival_remarks']) ? 
                trim(strip_tags($data['transfer_arrival_remarks'], '<p><br><strong><em><ul><ol><li>')) : '',
            'booked_by' => isset($data['booked_by']) ? (int)$data['booked_by'] : null,
            'booked_at' => isset($data['booked_at']) ? $data['booked_at'] : null,
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
     * Log request operations to the logs table
     */
    private function logRequestOperation(string $action, array $requestData, int $requestId = null): void
    {
        try {
            
            $requestNumber = $requestId ?? ($requestData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Request Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Request Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Request Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Request ' . ucfirst($action);
                    break;
            }
            
            // Create structured action description in the requested format
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $requestNumber . "\n";
            $actionDescription .= "User: " . ($requestData['user_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Type: " . ($requestData['type'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($requestData['type_description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 14, // Request module ID (adjust as needed)
                'action' => $actionDescription, // Structured action text with details
            ];
            
            $result = $this->logModel->insert($logData);
            
        } catch (\Exception $e) {
            // Log the error but don't break the main operation
            log_message('error', 'Failed to log request operation: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of requests
     */
    public function index()
    {
        // Check if user has permission to view requests
        if (!has_permission('requests.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view requests.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $requests = $this->requestModel->getRequestsWithPagination($search, $limit, $offset);
        $totalRequests = $this->requestModel->getRequestsCount($search);
        $totalPages = ceil($totalRequests / $limit);

        // Get active statuses and users for dropdown
        $statuses = $this->requestModel->getActiveStatuses();
        $users = $this->requestModel->getActiveUsers();

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('requests.create'),
            'canEdit' => has_permission('requests.edit'),
            'canView' => has_permission('requests.view'),
            'canDelete' => has_permission('requests.delete')
        ];

        $data = [
            'title' => 'Request Management',
            'requests' => $requests,
            'statuses' => $statuses,
            'users' => $users,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalRequests' => $totalRequests,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('requests/index', $data);
    }

    /**
     * Display add request type selection page
     */
    public function add()
    {
        // Check if user has permission to create requests
        if (!has_permission('requests.create')) {
            return redirect()->to('/')->with('error', 'You do not have permission to create requests.');
        }

        $data = [
            'title' => 'Add New Request'
        ];

        return view('requests/add', $data);
    }

    /**
     * Display the form for creating a specific type of request
     */
    public function create()
    {
        // Check if user has permission to create requests
        if (!has_permission('requests.create')) {
            return redirect()->to('/')->with('error', 'You do not have permission to create requests.');
        }

        $type = $this->request->getGet('type');
        
        // Load necessary data for the forms
        $data = [
            'title' => 'Create New Request',
            'requestType' => $type,
            'statuses' => $this->requestModel->getActiveStatuses(),
            'users' => $this->requestModel->getActiveUsers(),
            'departments' => [], // Initialize as empty arrays for now
            'divisions' => [],
            'positions' => []
        ];

        // Load additional data if we have the models available
        try {
            $departmentModel = new \App\Models\DepartmentModel();
            $divisionModel = new \App\Models\DivisionModel();
            $positionModel = new \App\Models\PositionModel();
            
            $data['departments'] = $departmentModel->findAll();
            $data['divisions'] = $divisionModel->findAll();
            $data['positions'] = $positionModel->findAll();
        } catch (\Exception $e) {
            // Models might not exist, continue with empty arrays
            log_message('info', 'Some models not available for request forms: ' . $e->getMessage());
        }

        // Return different views based on type
        switch($type) {
            case 'exit-pass':
                return view('requests/create_exit_pass', $data);
            case 'transfer':
                return view('requests/create_transfer', $data);
            default:
                return view('requests/create_modal', $data);
        }
    }

    /**
     * Store a newly created request in database
     */
    public function store()
    {
        // Check if user has permission to create requests
        if (!has_permission('requests.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create requests.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create requests.');
        }
        
        // Validate the input
        if (!$this->validate($this->requestModel->getValidationRules())) {
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
        $rawData = $this->request->getPost();
        $data = $this->sanitizeRequestInput($rawData);

        // Insert the request
        if ($requestId = $this->requestModel->insert($data)) {
            // Get the full request data for logging
            $requestData = $this->requestModel->getRequest($requestId);
            
            // Log the create operation
            $this->logRequestOperation('create', $requestData, $requestId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Request created successfully!'
                ]);
            }
            return redirect()->to('/requests')
                           ->with('success', 'Request created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create request. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create request. Please try again.');
        }
    }

    /**
     * Display the specified request (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view requests
        if (!has_permission('requests.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view requests.'
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
                'message' => 'Request ID is required.'
            ]);
        }

        $request = $this->requestModel->getRequest($id);

        if (!$request) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $request
        ]);
    }

    /**
     * Update the specified request in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit requests
        if (!has_permission('requests.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit requests.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit requests.');
        }
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Request ID is required.'
                ]);
            }
            return redirect()->to('/requests')
                           ->with('error', 'Request ID is required.');
        }

        $request = $this->requestModel->getRequest($id);

        if (!$request) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Request not found.'
                ]);
            }
            return redirect()->to('/requests')
                           ->with('error', 'Request not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = $this->request->getPost();
        $inputData = $this->sanitizeRequestInput($rawData);
        
        $validationResult = $this->requestModel->validateForUpdate($inputData, $id);
        
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

        // Update the request
        try {
            // Skip model validation since we already validated
            $this->requestModel->skipValidation(true);
            $result = $this->requestModel->update($id, $data);
            $this->requestModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated request data for logging
                $updatedRequest = $this->requestModel->getRequest($id);
                
                // Log the update operation
                $this->logRequestOperation('update', $updatedRequest, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Request updated successfully!'
                    ]);
                }
                return redirect()->to('/requests')
                               ->with('success', 'Request updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->requestModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update request: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update request: ' . $errorMessage);
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
     * Remove the specified request from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete requests
        if (!has_permission('requests.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete requests.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request ID is required.'
            ]);
        }

        $request = $this->requestModel->getRequest($id);

        if (!$request) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request not found.'
            ]);
        }

        // Delete the request
        if ($this->requestModel->delete($id)) {
            // Log the delete operation
            $this->logRequestOperation('delete', $request, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Request deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete request. Please try again.'
            ]);
        }
    }

    /**
     * Get requests for AJAX requests
     */
    public function getRequests()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $requests = $this->requestModel->getRequestsWithPagination($search, $limit, $offset);
        $totalRequests = $this->requestModel->getRequestsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $requests,
            'total' => $totalRequests
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

        $requests = $this->requestModel->getRequestsWithPagination($search, $limit, $offset);
        $totalRequests = $this->requestModel->getRequestsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $requests,
            'total' => $totalRequests,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalRequests
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

        $statuses = $this->requestModel->getActiveStatuses();

        return $this->response->setJSON([
            'success' => true,
            'data' => $statuses
        ]);
    }

    /**
     * Get users for dropdown (AJAX)
     */
    public function getUsers()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $users = $this->requestModel->getActiveUsers();

        return $this->response->setJSON([
            'success' => true,
            'data' => $users
        ]);
    }
}