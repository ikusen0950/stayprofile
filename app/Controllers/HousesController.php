<?php

namespace App\Controllers;

use App\Models\HouseModel;
use CodeIgniter\HTTP\RedirectResponse;

class HousesController extends BaseController
{
    protected $houseModel;
    protected $logModel;

    public function __construct()
    {
        $this->houseModel = new HouseModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for house
     */
    private function sanitizeHouseInput(array $data): array
    {
        $sanitized = [
            'name' => isset($data['name']) ? trim(strip_tags($data['name'])) : '',
            'color' => isset($data['color']) ? trim(strip_tags($data['color'])) : '',
            'status_id' => isset($data['status_id']) ? (int)$data['status_id'] : 1,
            'description' => isset($data['description']) ? 
                trim(strip_tags($data['description'], '<p><br><strong><em><ul><ol><li>')) : '',
        ];

        // Add audit fields if present (these don't need sanitization as they're system-generated)
        if (isset($data['created_by'])) {
            $sanitized['created_by'] = (int)$data['created_by'];
        }
        if (isset($data['updated_by'])) {
            $sanitized['updated_by'] = (int)$data['updated_by'];
        }
        if (isset($data['created_at'])) {
            $sanitized['created_at'] = $data['created_at'];
        }
        if (isset($data['updated_at'])) {
            $sanitized['updated_at'] = $data['updated_at'];
        }

        return $sanitized;
    }

    /**
     * Log house operations for audit trail
     */
    private function logHouseOperation(string $action, array $houseData, int $houseId = null): void
    {
        try {
            helper('auth');
            
            // Map action to status_id based on the operation type
            $logStatusId = 1; // Default status (success)
            $actionPrefix = 'House';
            
            switch (strtolower($action)) {
                case 'create':
                case 'created':
                    $logStatusId = 1; // Success status for create
                    $actionPrefix = 'House Created';
                    break;
                case 'update':
                case 'updated':
                    $logStatusId = 1; // Success status for update
                    $actionPrefix = 'House Updated';
                    break;
                case 'delete':
                case 'deleted':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'House Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'House ' . ucfirst($action);
                    break;
            }
            
            // Generate house number for display
            $houseNumber = '#' . ($houseId ?? ($houseData['id'] ?? 'Unknown'));
            
            // Create shorter action description to fit VARCHAR(255) limit
            $houseName = $houseData['name'] ?? 'Unknown';
            $houseColor = $houseData['color'] ?? 'No color';
            
            // Keep it under 255 characters by truncating if necessary
            $actionDescription = $actionPrefix . " " . $houseNumber . " - " . $houseName;
            if (strlen($actionDescription) > 200) {
                $actionDescription = substr($actionDescription, 0, 200) . '...';
            } else {
                // Add color info if there's space
                $colorInfo = " (" . $houseColor . ")";
                if (strlen($actionDescription . $colorInfo) <= 255) {
                    $actionDescription .= $colorInfo;
                }
            }

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 11, // Houses module ID (from modules table)
                'action' => $actionDescription, // Structured action text with details
            ];

            log_message('info', 'Attempting to insert house log data: ' . json_encode($logData));
            
            $result = $this->logModel->insert($logData);
            
            if ($result) {
                log_message('info', 'House log inserted successfully with ID: ' . $result);
            } else {
                log_message('error', 'Failed to insert house log');
            }
            
        } catch (\Exception $e) {
            // Log the error but don't stop the operation
            log_message('error', 'Failed to log house operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of houses
     */
    public function index()
    {
        // Check if user has permission to view houses
        if (!has_permission('houses.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view houses.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $houses = $this->houseModel->getHousesWithPagination($search, $limit, $offset);
        $totalHouses = $this->houseModel->getHousesCount($search);
        $totalPages = ceil($totalHouses / $limit);

        // Get active statuses for dropdown
        $statuses = $this->houseModel->getActiveStatuses();
        log_message('info', 'Statuses data: ' . json_encode($statuses));

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('houses.create'),
            'canEdit' => has_permission('houses.edit'),
            'canView' => has_permission('houses.view'),
            'canDelete' => has_permission('houses.delete')
        ];

        $data = [
            'title' => 'House Management',
            'houses' => $houses,
            'statuses' => $statuses,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalHouses' => $totalHouses,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('houses/index', $data);
    }

    /**
     * Store a newly created house in database
     */
    public function store()
    {
        // Check if user has permission to create houses
        log_message('info', 'Checking houses.create permission...');
        $hasPermission = has_permission('houses.create');
        log_message('info', 'Permission check result: ' . ($hasPermission ? 'true' : 'false'));
        
        if (!$hasPermission) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create houses.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create houses.');
        }

        // Debug: Log the incoming request
        log_message('info', 'House store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        log_message('info', 'Starting validation...');
        $validationResult = $this->validate($this->houseModel->getValidationRules());
        log_message('info', 'Validation result: ' . ($validationResult ? 'passed' : 'failed'));
        
        if (!$validationResult) {
            log_message('error', 'Validation failed with errors: ' . json_encode($this->validator->getErrors()));
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
            'color' => $this->request->getPost('color'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $data = $this->sanitizeHouseInput($rawData);
        
        log_message('info', 'Sanitized house data for insertion: ' . json_encode($data));

        // Insert the house
        if ($houseId = $this->houseModel->insert($data)) {
            log_message('info', 'House inserted successfully with ID: ' . $houseId);
            
            // Get the full house data for logging
            $houseData = $this->houseModel->getHouse($houseId);
            log_message('info', 'Retrieved house data for logging: ' . json_encode($houseData));
            
            // Log the create operation
            log_message('info', 'About to call logHouseOperation');
            $this->logHouseOperation('create', $houseData, $houseId);
            log_message('info', 'logHouseOperation completed');
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'House created successfully!'
                ]);
            }
            return redirect()->to('/houses')
                           ->with('success', 'House created successfully!');
        } else {
            log_message('error', 'Failed to insert house. Model errors: ' . json_encode($this->houseModel->errors()));
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create house. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create house. Please try again.');
        }
    }

    /**
     * Display the specified house (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view houses
        if (!has_permission('houses.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view houses.'
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
                'message' => 'House ID is required.'
            ]);
        }

        $house = $this->houseModel->getHouse($id);

        if (!$house) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'House not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $house
        ]);
    }

    /**
     * Update the specified house in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit houses
        if (!has_permission('houses.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit houses.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit houses.');
        }

        // Debug: Log the incoming request
        log_message('info', 'House update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'House ID is required.'
                ]);
            }
            return redirect()->to('/houses')
                           ->with('error', 'House ID is required.');
        }

        $house = $this->houseModel->getHouse($id);

        if (!$house) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'House not found.'
                ]);
            }
            return redirect()->to('/houses')
                           ->with('error', 'House not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = [
            'name' => $this->request->getPost('name'),
            'color' => $this->request->getPost('color'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $inputData = $this->sanitizeHouseInput($rawData);
        
        $validationResult = $this->houseModel->validateForUpdate($inputData, $id);
        
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

        // Update the house
        try {
            // Skip model validation since we already validated
            $this->houseModel->skipValidation(true);
            $result = $this->houseModel->update($id, $data);
            $this->houseModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated house data for logging
                $updatedHouse = $this->houseModel->getHouse($id);
                
                // Log the update operation
                $this->logHouseOperation('update', $updatedHouse, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'House updated successfully!'
                    ]);
                }
                return redirect()->to('/houses')
                               ->with('success', 'House updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->houseModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update house: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update house: ' . $errorMessage);
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
     * Remove the specified house from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete houses
        if (!has_permission('houses.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete houses.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'House ID is required.'
            ]);
        }

        $house = $this->houseModel->getHouse($id);

        if (!$house) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'House not found.'
            ]);
        }

        // Delete the house
        if ($this->houseModel->delete($id)) {
            // Log the delete operation
            $this->logHouseOperation('delete', $house, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'House deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete house. Please try again.'
            ]);
        }
    }

    /**
     * Get houses for AJAX requests
     */
    public function getHouses()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $houses = $this->houseModel->getHousesWithPagination($search, $limit, $offset);
        $totalHouses = $this->houseModel->getHousesCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $houses,
            'total' => $totalHouses
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

        $statuses = $this->houseModel->getActiveStatuses();

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

        $houses = $this->houseModel->getHousesWithPagination($search, $limit, $offset);
        $totalHouses = $this->houseModel->getHousesCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $houses,
            'total' => $totalHouses,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalHouses
        ]);
    }
}