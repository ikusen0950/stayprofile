<?php

namespace App\Controllers;

use App\Models\RequestModel;
use CodeIgniter\HTTP\RedirectResponse;

class RequestController extends BaseController
{
    protected $requestModel;
    protected $logModel;
    protected $db;
    protected $auth;

    public function __construct()
    {
        $this->requestModel = new RequestModel();
        $this->logModel = new \App\Models\LogModel();
        $this->db = \Config\Database::connect();
        $this->auth = service('authentication');
        
        // Load FCM helper for push notifications
        helper('fcm');
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

        // Fetch next auto-increment request ID for Request # field
        $db = \Config\Database::connect();
        $query = $db->query("SHOW TABLE STATUS LIKE 'requests'");
        $row = $query->getRowArray();
        $nextRequestId = isset($row['Auto_increment']) ? $row['Auto_increment'] : null;

        // Check if user can create past date requests
        $canCreatePastDate = has_permission('requests.create_past_date');

        $data = [
            'title' => 'Add New Request',
            'nextRequestId' => $nextRequestId,
            'statuses' => $this->requestModel->getActiveStatuses(),
            'users' => $this->requestModel->getActiveUsers(),
            'departments' => [],
            'divisions' => [],
            'positions' => [],
            'leave_reasons' => [],
            'islanders' => [],
            'visitors' => [],
            'canCreatePastDate' => $canCreatePastDate
        ];

        // Load additional data if we have the models available
        try {
            $departmentModel = new \App\Models\DepartmentModel();
            $divisionModel = new \App\Models\DivisionModel();
            $positionModel = new \App\Models\PositionModel();
            $leaveModel = new \App\Models\LeaveModel();
            $islanderModel = new \App\Models\IslanderModel();
            $visitorModel = new \App\Models\VisitorModel();
            
            $data['departments'] = $departmentModel->findAll();
            $data['divisions'] = $divisionModel->findAll();
            $data['positions'] = $positionModel->findAll();
            
            // Load active leaves for leave reason dropdown
            $data['leave_reasons'] = $leaveModel->getActiveLeavesWithStatus();
            
            // Load islanders and visitors for exit pass
            $data['islanders'] = $this->getAuthorizedIslanders();
            $data['visitors'] = $visitorModel->getActiveVisitors();
            
        } catch (\Exception $e) {
            // Models might not exist, continue with empty arrays
            log_message('info', 'Some models not available for request forms: ' . $e->getMessage());
            $data['leave_reasons'] = [];
            $data['islanders'] = [];
            $data['visitors'] = [];
        }

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

        // Fetch next auto-increment request ID for Request # field
        $db = \Config\Database::connect();
        $query = $db->query("SHOW TABLE STATUS LIKE 'requests'");
        $row = $query->getRowArray();
        $nextRequestId = isset($row['Auto_increment']) ? $row['Auto_increment'] : null;
        $data['nextRequestId'] = $nextRequestId;

        // Load additional data if we have the models available
        try {
            $departmentModel = new \App\Models\DepartmentModel();
            $divisionModel = new \App\Models\DivisionModel();
            $positionModel = new \App\Models\PositionModel();
            $leaveModel = new \App\Models\LeaveModel();
            $islanderModel = new \App\Models\IslanderModel();
            $visitorModel = new \App\Models\VisitorModel();
            
            $data['departments'] = $departmentModel->findAll();
            $data['divisions'] = $divisionModel->findAll();
            $data['positions'] = $positionModel->findAll();
            
            // Load active leaves for leave reason dropdown
            $data['leave_reasons'] = $leaveModel->getActiveLeavesWithStatus();
            
            // Load islanders and visitors for exit pass
            $data['islanders'] = $this->getAuthorizedIslanders();
            $data['visitors'] = $visitorModel->getActiveVisitors();
            
        } catch (\Exception $e) {
            // Models might not exist, continue with empty arrays
            log_message('info', 'Some models not available for request forms: ' . $e->getMessage());
            $data['leave_reasons'] = [];
            $data['islanders'] = [];
            $data['visitors'] = [];
        }

        // Return different views based on type
        switch($type) {
            case 'exit-pass':
                // Override leave reasons for exit pass with specific module filter
                try {
                    $data['leave_reasons'] = $leaveModel->getActiveLeavesWithStatusForExitPass();
                } catch (\Exception $e) {
                    log_message('error', 'Failed to load exit pass leave reasons: ' . $e->getMessage());
                    $data['leave_reasons'] = [];
                }
                return view('requests/create_exit_pass_modal', $data);
            case 'transfer':
                return view('requests/create_transfer', $data);
            default:
                return view('requests/create_modal', $data);
        }
    }

    /**
     * Check if user can create requests based on authorization_rules
     */
    private function canUserCreateRequest($userId)
    {
        try {
            $authorizationModel = new \App\Models\AuthorizationRuleModel();
            $rule = $authorizationModel->where('user_id', $userId)
                                     ->where('can_request', 1) // Check if user is blocked
                                     ->where('is_active', 1)
                                     ->first();
            
            // If rule exists with can_request = 1, user is BLOCKED from creating requests
            return $rule === null;
        } catch (\Exception $e) {
            log_message('error', "Failed to check user request permission: " . $e->getMessage());
            return true; // Allow request creation if check fails
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

        // Check if user is blocked from creating requests (can_request = 1 blocks, can_request = 0 allows)
        if (isset($rawData['user_id'])) {
            if (!$this->canUserCreateRequest($rawData['user_id'])) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'The selected user is blocked from creating requests.'
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'The selected user is blocked from creating requests.');
            }
        }

        // Check for existing exit pass requests and determine status_id for exit pass requests
        if (isset($rawData['type']) && $rawData['type'] === '1' && isset($rawData['user_id'])) {
            // Check if user already has an active exit pass request
            $existingRequest = $this->checkExistingExitPassRequest($rawData['user_id']);
            if ($existingRequest) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'User already has an active exit pass request.',
                        'existing_request' => $existingRequest
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'User already has an active exit pass request.');
            }

            // Determine status_id based on user role
            $statusId = $this->determineStatusByUserRole($rawData['user_id'], $rawData['user_type'] ?? null);
            if ($statusId) {
                $data['status_id'] = $statusId;
            }
        }

        // Insert the request
        if ($requestId = $this->requestModel->insert($data)) {
            // Get the full request data for logging
            $requestData = $this->requestModel->getRequest($requestId);
            
            // Log the create operation
            $this->logRequestOperation('create', $requestData, $requestId);
            
            // Send FCM notification for pending requests (status 13 and 14)
            if (isset($requestData['status_id']) && (
                $requestData['status_id'] == STATUS_MANAGER_NOTIFICATION_FCM || 
                $requestData['status_id'] == 14
            )) {
                $this->sendRequestNotification($requestData, $requestData['status_id']);
            }
            
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
                
                // Send FCM notification for status changes (approved/rejected)
                if (isset($updatedRequest['status_id'])) {
                    $statusId = $updatedRequest['status_id'];
                    if ($statusId == STATUS_APPROVE_FCM || $statusId == STATUS_REJECT_FCM) {
                        $this->sendRequestNotification($updatedRequest, $statusId);
                    }
                }
                
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

    /**
     * Check if user has existing exit pass request (AJAX)
     */
    public function checkExistingExitPass()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $userId = $this->request->getPost('user_id');
        
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User ID is required'
            ]);
        }

        $existingRequest = $this->checkExistingExitPassRequest((int)$userId);
        
        return $this->response->setJSON([
            'success' => true,
            'has_existing' => !empty($existingRequest),
            'existing_request' => $existingRequest
        ]);
    }

    /**
     * Get authorized islanders based on logged-in user's authorization rules
     */
    private function getAuthorizedIslanders()
    {
        // Check if user is logged in
        if (!$this->auth->check()) {
            return [];
        }

        $currentUser = $this->auth->user();
        $currentUserId = $currentUser->id;
        
        if (!$currentUserId) {
            return [];
        }

        // Get authorization rules for the current user
        $authorizationRuleModel = new \App\Models\AuthorizationRuleModel();
        $userAuthRules = $authorizationRuleModel->where('user_id', $currentUserId)
                                               ->where('is_active', 1)
                                               ->where('deleted_at IS NULL')
                                               ->findAll();

        $islanderModel = new \App\Models\IslanderModel();
        
        // If user has no authorization rules, check if they are an islander themselves
        if (empty($userAuthRules)) {
            // Only show current user if they are an actual islander (type = 1)
            $currentUser = $this->db->table('users')
                                   ->select('id, full_name as name, islander_no')
                                   ->where('id', $currentUserId)
                                   ->where('type', 1) // Only islanders
                                   ->where('status_id', 7) // Active status
                                   ->where('islander_no IS NOT NULL')
                                   ->where('islander_no !=', '')
                                   ->where('deleted_at IS NULL')
                                   ->get()
                                   ->getRowArray();
            
            // Return current user if they are a valid islander, otherwise empty array
            return $currentUser ? [$currentUser] : [];
        }

        // User has authorization rules - get authorized islanders
        $departmentIds = [];
        $sectionIds = [];
        $divisionIds = [];

        foreach ($userAuthRules as $rule) {
            // Parse JSON fields
            $parsedRule = $authorizationRuleModel->parseJsonFields($rule);
            
            if (!empty($parsedRule['department_ids'])) {
                $departmentIds = array_merge($departmentIds, $parsedRule['department_ids']);
            }
            if (!empty($parsedRule['section_ids'])) {
                $sectionIds = array_merge($sectionIds, $parsedRule['section_ids']);
            }
            if (!empty($parsedRule['division_ids'])) {
                $divisionIds = array_merge($divisionIds, $parsedRule['division_ids']);
            }
        }

        // Remove duplicates
        $departmentIds = array_unique($departmentIds);
        $sectionIds = array_unique($sectionIds);
        $divisionIds = array_unique($divisionIds);

        $builder = $this->db->table('users u');
        $builder->select('u.id, u.full_name as name, u.islander_no')
                ->where('u.type', 1) // Islander type
                ->where('u.status_id', 7) // Active status
                ->where('u.deleted_at IS NULL')
                ->where('u.islander_no IS NOT NULL')
                ->where('u.islander_no !=', '');

        // Apply filters based on authorization rules
        $hasFilters = false;
        
        if (!empty($departmentIds) || !empty($sectionIds) || !empty($divisionIds)) {
            $builder->groupStart(); // Start OR group
            
            if (!empty($departmentIds)) {
                $builder->whereIn('u.department_id', $departmentIds);
                $hasFilters = true;
            }
            
            if (!empty($sectionIds)) {
                if ($hasFilters) {
                    $builder->orWhereIn('u.section_id', $sectionIds);
                } else {
                    $builder->whereIn('u.section_id', $sectionIds);
                    $hasFilters = true;
                }
            }
            
            if (!empty($divisionIds)) {
                if ($hasFilters) {
                    $builder->orWhereIn('u.division_id', $divisionIds);
                } else {
                    $builder->whereIn('u.division_id', $divisionIds);
                }
            }
            
            $builder->groupEnd(); // End OR group
        }

        $builder->orderBy('u.islander_no', 'ASC');
        
        $result = $builder->get()->getResultArray();
        
        // If no authorized islanders found through authorization rules, check if current user is an islander
        if (empty($result)) {
            // Only show current user if they are an actual islander (type = 1)
            $currentUser = $this->db->table('users')
                                   ->select('id, full_name as name, islander_no')
                                   ->where('id', $currentUserId)
                                   ->where('type', 1) // Only islanders
                                   ->where('status_id', 7) // Active status
                                   ->where('islander_no IS NOT NULL')
                                   ->where('islander_no !=', '')
                                   ->where('deleted_at IS NULL')
                                   ->get()
                                   ->getRowArray();
            
            // Return current user if they are a valid islander, otherwise empty array
            return $currentUser ? [$currentUser] : [];
        }
        
        return $result;
    }

    /**
     * Determine status_id based on user's role/group
     * 
     * Status mapping for exit pass requests:
     * 1. If logged-in user is ADMINISTRATOR, EXCOM, or MANAGER: status_id = 14 (regardless of selected islander/visitor)
     * 2. Otherwise, check selected user's role:
     *    - ADMINISTRATOR, EXCOM, MANAGER: status_id = 14 (higher approval level)
     *    - ASSISTANT MANAGER, SUPERVISOR, COORDINATOR, ISLANDER, VISITOR: status_id = 13 (standard approval level)
     * 
     * @param int $userId The user ID to check role for (selected islander/visitor)
     * @param string|null $userType Whether it's islander (1) or visitor (2)
     * @return int|null The status ID or null if can't determine
     */
    private function determineStatusByUserRole(int $userId, ?string $userType = null): ?int
    {
        try {
            // First check the logged-in user's role
            $currentUser = $this->auth->user();
            $currentUserId = $currentUser ? $currentUser->id : null;
            
            if ($currentUserId) {
                $groupModel = new \Myth\Auth\Models\GroupModel();
                $currentUserGroups = $groupModel->getGroupsForUser($currentUserId);
                
                if (!empty($currentUserGroups)) {
                    $currentUserGroup = strtoupper($currentUserGroups[0]['name']);
                    
                    // If logged-in user is high-level, always assign status 14
                    if (in_array($currentUserGroup, ['ADMINISTRATOR', 'EXCOM', 'MANAGER'])) {
                        log_message('info', "Exit pass request by high-level user {$currentUserId} (group: {$currentUserGroup}): assigned status 14");
                        return 14;
                    }
                }
            }

            // For visitors, always return status 13 (if logged-in user is not high-level)
            if ($userType === '2') {
                log_message('info', "Exit pass request for visitor user {$userId}: assigned status 13");
                return 13;
            }

            // For islanders, get their role/group (if logged-in user is not high-level)
            $groupModel = new \Myth\Auth\Models\GroupModel();
            $userGroups = $groupModel->getGroupsForUser($userId);
            
            if (empty($userGroups)) {
                // No group assigned, default to status 13 (basic approval)
                log_message('info', "Exit pass request for user {$userId} with no group: assigned status 13");
                return 13;
            }
            
            // Get the first group (assuming user has one primary role)
            $primaryGroup = $userGroups[0];
            $groupName = strtoupper($primaryGroup['name']);
            
            // Map group names to status IDs according to requirements
            $statusId = null;
            switch ($groupName) {
                case 'ADMINISTRATOR':
                case 'EXCOM':
                case 'MANAGER':
                    $statusId = 14;
                    break;
                case 'ASSISTANT MANAGER':
                case 'SUPERVISOR':
                case 'COORDINATOR':
                case 'ISLANDER':
                case 'VISITOR':
                    $statusId = 13;
                    break;
                default:
                    // Unknown group, default to status 13
                    log_message('warning', "Unknown group '{$groupName}' for user {$userId}, defaulting to status 13");
                    $statusId = 13;
                    break;
            }
            
            log_message('info', "Exit pass request for user {$userId} with group '{$groupName}': assigned status {$statusId}");
            return $statusId;
            
        } catch (\Exception $e) {
            log_message('error', "Failed to determine status by user role for user {$userId}: " . $e->getMessage());
            // Default to status 13 if there's an error
            return 13;
        }
    }

    /**
     * Check if user already has an active exit pass request
     * 
     * @param int $userId The user ID to check for existing requests
     * @return array|null Returns existing request data if found, null otherwise
     */
    private function checkExistingExitPassRequest(int $userId): ?array
    {
        try {
            $builder = $this->db->table('requests');
            $existingRequest = $builder->select('id, type, type_description, status_id, created_at')
                                      ->where('user_id', $userId)
                                      ->where('type', '1') // Exit Pass type
                                      ->whereIn('status_id', [13, 14, 16, 18]) // Block if: PENDING(13), APPROVED(14), DEPARTED(16), NO_SHOW(18)
                                      // Allow: REJECTED(15), ARRIVED(17), EXPIRED(19), CANCELED(20)
                                      ->orderBy('created_at', 'DESC')
                                      ->get()
                                      ->getRowArray();

            if ($existingRequest) {
                // Get status name for better error message
                $statusBuilder = $this->db->table('status');
                $status = $statusBuilder->select('name')
                                       ->where('id', $existingRequest['status_id'])
                                       ->get()
                                       ->getRowArray();
                
                $existingRequest['status_name'] = $status['name'] ?? 'Unknown';
                
                log_message('info', "Existing exit pass request found for user {$userId}: Request ID {$existingRequest['id']}, Status: {$existingRequest['status_name']}");
                
                return $existingRequest;
            }

            return null;
            
        } catch (\Exception $e) {
            log_message('error', "Failed to check existing exit pass request for user {$userId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Send FCM notification for request status changes
     */
    private function sendRequestNotification($requestData, $status)
    {
        try {
            // Get user information to determine division, department, section
            $userModel = new \App\Models\UserModel();
            $user = $userModel->find($requestData['user_id']);
            
            if (!$user) {
                log_message('error', "User not found for notification: {$requestData['user_id']}");
                return false;
            }

            // Get user's organizational structure (using object property access)
            $divisionId = $user->division_id ?? null;
            $departmentId = $user->department_id ?? null;
            $sectionId = $user->section_id ?? null;
            $userId = $requestData['user_id'];
            $requestUid = $requestData['id']; // Use request ID as UID

            // Determine request type and send appropriate notification
            $requestType = $requestData['type'] ?? '1'; // Default to exit pass
            
            if ($requestType === '1') {
                // Exit Pass Request
                fcmNotificationExitPass(
                    $divisionId,
                    $departmentId, 
                    $sectionId,
                    $status,
                    $userId,
                    $requestUid
                );
            } else {
                // Transfer Request (assuming type '2' or other)
                fcmNotificationTransfer(
                    $divisionId,
                    $departmentId,
                    $sectionId, 
                    $status,
                    $userId,
                    $requestUid
                );
            }

            log_message('info', "FCM notification sent for request {$requestUid}, status: {$status}, user: {$userId}");
            return true;

        } catch (\Exception $e) {
            log_message('error', "Failed to send FCM notification: " . $e->getMessage());
            return false;
        }
    }
}