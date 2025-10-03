<?php

namespace App\Controllers;

use App\Models\DivisionModel;
use CodeIgniter\HTTP\RedirectResponse;

class DivisionsController extends BaseController
{
    protected $divisionModel;
    protected $logModel;

    public function __construct()
    {
        $this->divisionModel = new DivisionModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for division
     */
    private function sanitizeDivisionInput(array $data): array
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
     * Log division operations to the logs table
     */
    private function logDivisionOperation(string $action, array $divisionData, int $divisionId = null): void
    {
        try {
            log_message('info', 'logDivisionOperation called with action: ' . $action . ', divisionId: ' . $divisionId);
            
            $divisionNumber = $divisionId ?? ($divisionData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Division Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Division Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Division Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Division ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description in the requested format
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $divisionNumber . "\n";
            $actionDescription .= "Name: " . ($divisionData['name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($divisionData['description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 5, // Status module ID (from modules table)
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
            log_message('error', 'Failed to log division operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of divisions
     */
    public function index()
    {
        // Check if user has permission to view divisions
        if (!has_permission('divisions.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view divisions.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $divisions = $this->divisionModel->getDivisionsWithPagination($search, $limit, $offset);
        $totalDivisions = $this->divisionModel->getDivisionsCount($search);
        $totalPages = ceil($totalDivisions / $limit);

        // Get active statuses for dropdown
        $statuses = $this->divisionModel->getActiveStatuses();
        log_message('info', 'Statuses data: ' . json_encode($statuses));

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('divisions.create'),
            'canEdit' => has_permission('divisions.edit'),
            'canView' => has_permission('divisions.view'),
            'canDelete' => has_permission('divisions.delete')
        ];

        $data = [
            'title' => 'Division Management',
            'divisions' => $divisions,
            'statuses' => $statuses,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalDivisions' => $totalDivisions,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('divisions/index', $data);
    }

    /**
     * Store a newly created division in database
     */
    public function store()
    {
        // Check if user has permission to create divisions
        if (!has_permission('divisions.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create divisions.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create divisions.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Division store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        if (!$this->validate($this->divisionModel->getValidationRules())) {
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
        $data = $this->sanitizeDivisionInput($rawData);

        // Insert the division
        if ($divisionId = $this->divisionModel->insert($data)) {
            // Get the full division data for logging
            $divisionData = $this->divisionModel->getDivision($divisionId);
            
            // Log the create operation
            $this->logDivisionOperation('create', $divisionData, $divisionId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Division created successfully!'
                ]);
            }
            return redirect()->to('/divisions')
                           ->with('success', 'Division created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create division. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create division. Please try again.');
        }
    }

    /**
     * Display the specified division (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view divisions
        if (!has_permission('divisions.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view divisions.'
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
                'message' => 'Division ID is required.'
            ]);
        }

        $division = $this->divisionModel->getDivision($id);

        if (!$division) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Division not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $division
        ]);
    }

    /**
     * Update the specified division in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit divisions
        if (!has_permission('divisions.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit divisions.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit divisions.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Division update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Division ID is required.'
                ]);
            }
            return redirect()->to('/divisions')
                           ->with('error', 'Division ID is required.');
        }

        $division = $this->divisionModel->getDivision($id);

        if (!$division) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Division not found.'
                ]);
            }
            return redirect()->to('/divisions')
                           ->with('error', 'Division not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = [
            'name' => $this->request->getPost('name'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $inputData = $this->sanitizeDivisionInput($rawData);
        
        $validationResult = $this->divisionModel->validateForUpdate($inputData, $id);
        
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

        // Update the division
        try {
            // Skip model validation since we already validated
            $this->divisionModel->skipValidation(true);
            $result = $this->divisionModel->update($id, $data);
            $this->divisionModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated division data for logging
                $updatedDivision = $this->divisionModel->getDivision($id);
                
                // Log the update operation
                $this->logDivisionOperation('update', $updatedDivision, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Division updated successfully!'
                    ]);
                }
                return redirect()->to('/divisions')
                               ->with('success', 'Division updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->divisionModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update division: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update division: ' . $errorMessage);
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
     * Remove the specified division from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete divisions
        if (!has_permission('divisions.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete divisions.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Division ID is required.'
            ]);
        }

        $division = $this->divisionModel->getDivision($id);

        if (!$division) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Division not found.'
            ]);
        }

        // Delete the division
        if ($this->divisionModel->delete($id)) {
            // Log the delete operation
            $this->logDivisionOperation('delete', $division, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Division deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete division. Please try again.'
            ]);
        }
    }

    /**
     * Get divisions for AJAX requests
     */
    public function getDivisions()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $divisions = $this->divisionModel->getDivisionsWithPagination($search, $limit, $offset);
        $totalDivisions = $this->divisionModel->getDivisionsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $divisions,
            'total' => $totalDivisions
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

        $statuses = $this->divisionModel->getActiveStatuses();

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

        $divisions = $this->divisionModel->getDivisionsWithPagination($search, $limit, $offset);
        $totalDivisions = $this->divisionModel->getDivisionsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $divisions,
            'total' => $totalDivisions,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalDivisions
        ]);
    }
}