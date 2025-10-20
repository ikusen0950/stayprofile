<?php

namespace App\Controllers;

use App\Models\FlightRouteModel;
use CodeIgniter\HTTP\RedirectResponse;

class FlightRoutesController extends BaseController
{
    protected $flightRouteModel;
    protected $logModel;

    public function __construct()
    {
        $this->flightRouteModel = new FlightRouteModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for flight route
     */
    private function sanitizeFlightRouteInput(array $data): array
    {
        $sanitized = [
            'name' => isset($data['name']) ? trim(strip_tags($data['name'])) : '',
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
     * Log flight route operations to the logs table
     */
    private function logFlightRouteOperation(string $action, array $flightRouteData, int $flightRouteId = null): void
    {
        try {
            log_message('info', 'logFlightRouteOperation called with action: ' . $action . ', flightRouteId: ' . ($flightRouteId ?? 'NULL'));
            
            $flightRouteNumber = $flightRouteId ?? ($flightRouteData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Flight Route Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Flight Route Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Flight Route Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Flight Route ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description in the requested format
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $flightRouteNumber . "\n";
            $actionDescription .= "Name: " . ($flightRouteData['name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($flightRouteData['description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 9, // Status module ID (from modules table)
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
            log_message('error', 'Failed to log Flight Route operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of Flight Routes
     */
    public function index()
    {
        // Check if user has permission to view flight routes
        if (!has_permission('flight_routes.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view flight routes.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $FlightRoutes = $this->flightRouteModel->getFlightRoutesWithPagination($search, $limit, $offset);
        $totalFlightRoutes = $this->flightRouteModel->getFlightRoutesCount($search);
        $totalPages = ceil($totalFlightRoutes / $limit);

        // Get active statuses for dropdown
        $statuses = $this->flightRouteModel->getActiveStatuses();
        log_message('info', 'Statuses data: ' . json_encode($statuses));

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('flight_routes.create'),
            'canEdit' => has_permission('flight_routes.edit'),
            'canView' => has_permission('flight_routes.view'),
            'canDelete' => has_permission('flight_routes.delete')
        ];

        $data = [
            'title' => 'Flight Route Management',
            'FlightRoutes' => $FlightRoutes,
            'statuses' => $statuses,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalFlightRoutes' => $totalFlightRoutes,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('flight_routes/index', $data);
    }

    /**
     * Store a newly created Flight Route in database
     */
    public function store()
    {
        // Check if user has permission to create Flight Routes
        if (!has_permission('flight_routes.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create Flight Routes.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create Flight Routes.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Flight Route store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        if (!$this->validate($this->flightRouteModel->getValidationRules())) {
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
        $data = $this->sanitizeFlightRouteInput($rawData);

        // Insert the Flight Route
        if ($flightRouteId = $this->flightRouteModel->insert($data)) {
            // Get the full Flight Route data for logging
            $flightRouteData = $this->flightRouteModel->getFlightRoute($flightRouteId);
            
            // Log the create operation
            $this->logFlightRouteOperation('create', $flightRouteData, $flightRouteId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Flight Route created successfully!'
                ]);
            }
            return redirect()->to('/flight-routes')
                           ->with('success', 'Flight Route created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create Flight Route. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create Flight Route. Please try again.');
        }
    }

    /**
     * Display the specified Flight Route (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view Flight Routes
        if (!has_permission('flight_routes.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view Flight Routes.'
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
                'message' => 'Flight Route ID is required.'
            ]);
        }

        $FlightRoute = $this->flightRouteModel->getFlightRoute($id);

        if (!$FlightRoute) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Flight Route not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $FlightRoute
        ]);
    }

    /**
     * Update the specified Flight Route in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit Flight Routes
        if (!has_permission('flight_routes.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit Flight Routes.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit Flight Routes.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Flight Route update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Flight Route ID is required.'
                ]);
            }
            return redirect()->to('/flight-routes')
                           ->with('error', 'Flight Route ID is required.');
        }

        $FlightRoute = $this->flightRouteModel->getFlightRoute($id);

        if (!$FlightRoute) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Flight Route not found.'
                ]);
            }
            return redirect()->to('/flight-routes')
                           ->with('error', 'Flight Route not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = [
            'name' => $this->request->getPost('name'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $inputData = $this->sanitizeFlightRouteInput($rawData);
        
        $validationResult = $this->flightRouteModel->validateForUpdate($inputData, $id);
        
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

        // Update the Flight Route
        try {
            // Skip model validation since we already validated
            $this->flightRouteModel->skipValidation(true);
            $result = $this->flightRouteModel->update($id, $data);
            $this->flightRouteModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated Flight Route data for logging
                $updatedFlightRoute = $this->flightRouteModel->getFlightRoute($id);
                
                // Log the update operation
                $this->logFlightRouteOperation('update', $updatedFlightRoute, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Flight Route updated successfully!'
                    ]);
                }
                return redirect()->to('/flight-routes')
                               ->with('success', 'Flight Route updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->flightRouteModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update Flight Route: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update Flight Route: ' . $errorMessage);
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
     * Remove the specified Flight Route from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete Flight Routes
        if (!has_permission('flight_routes.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete Flight Routes.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Flight Route ID is required.'
            ]);
        }

        $FlightRoute = $this->flightRouteModel->getFlightRoute($id);

        if (!$FlightRoute) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Flight Route not found.'
            ]);
        }

        // Delete the Flight Route
        if ($this->flightRouteModel->delete($id)) {
            // Log the delete operation
            $this->logFlightRouteOperation('delete', $FlightRoute, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Flight Route deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete Flight Route. Please try again.'
            ]);
        }
    }

    /**
     * Get Flight Routes for AJAX requests
     */
    public function getFlightRoutes()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $FlightRoutes = $this->flightRouteModel->getFlightRoutesWithPagination($search, $limit, $offset);
        $totalFlightRoutes = $this->flightRouteModel->getFlightRoutesCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $FlightRoutes,
            'total' => $totalFlightRoutes
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

        $statuses = $this->flightRouteModel->getActiveStatuses();

        return $this->response->setJSON([
            'success' => true,
            'data' => $statuses
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

        $FlightRoutes = $this->flightRouteModel->getFlightRoutesWithPagination($search, $limit, $offset);
        $totalFlightRoutes = $this->flightRouteModel->getFlightRoutesCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $FlightRoutes,
            'total' => $totalFlightRoutes,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalFlightRoutes
        ]);
    }
}