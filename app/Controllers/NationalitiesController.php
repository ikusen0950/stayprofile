<?php

namespace App\Controllers;

use App\Models\NationalityModel;
use CodeIgniter\HTTP\RedirectResponse;

class NationalitiesController extends BaseController
{
    protected $nationalityModel;
    protected $logModel;

    public function __construct()
    {
        $this->nationalityModel = new NationalityModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for nationality
     */
    private function sanitizeNationalityInput(array $data): array
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
     * Log nationality operations to the logs table
     */
    private function logNationalityOperation(string $action, array $nationalityData, int $nationalityId = null): void
    {
        try {
            log_message('info', 'logNationalityOperation called with action: ' . $action . ', nationalityId: ' . ($nationalityId ?? 'NULL'));
            
            $nationalityNumber = $nationalityId ?? ($nationalityData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Nationality Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Nationality Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Nationality Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Nationality ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description in the requested format
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $nationalityNumber . "\n";
            $actionDescription .= "Name: " . ($nationalityData['name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($nationalityData['description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 10, // Nationalities module ID (10 for nationalities)
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
            log_message('error', 'Failed to log Nationality operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of Nationalities
     */
    public function index()
    {
        // Check if user has permission to view nationalities
        if (!has_permission('nationalities.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view nationalities.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $nationalities = $this->nationalityModel->getNationalitiesWithPagination($search, $limit, $offset);
        $totalNationalities = $this->nationalityModel->getNationalitiesCount($search);
        $totalPages = ceil($totalNationalities / $limit);

        // Get active statuses for dropdown
        $statuses = $this->nationalityModel->getActiveStatuses();
        log_message('info', 'Statuses data: ' . json_encode($statuses));

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('nationalities.create'),
            'canEdit' => has_permission('nationalities.edit'),
            'canView' => has_permission('nationalities.view'),
            'canDelete' => has_permission('nationalities.delete')
        ];

        $data = [
            'title' => 'Nationality Management',
            'nationalities' => $nationalities,
            'statuses' => $statuses,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalNationalities' => $totalNationalities,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('nationalities/index', $data);
    }

    /**
     * Store a newly created Nationality in database
     */
    public function store()
    {
        // Check if user has permission to create Nationalities
        if (!has_permission('nationalities.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create Nationalities.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create Nationalities.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Nationality store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        if (!$this->validate($this->nationalityModel->getValidationRules())) {
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
        $data = $this->sanitizeNationalityInput($rawData);

        // Insert the Nationality
        if ($nationalityId = $this->nationalityModel->insert($data)) {
            // Get the full Nationality data for logging
            $nationalityData = $this->nationalityModel->getNationality($nationalityId);
            
            // Log the create operation
            $this->logNationalityOperation('create', $nationalityData, $nationalityId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Nationality created successfully!'
                ]);
            }
            return redirect()->to('/nationalities')
                           ->with('success', 'Nationality created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create Nationality. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create Nationality. Please try again.');
        }
    }

    /**
     * Display the specified Nationality (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view Nationalities
        if (!has_permission('nationalities.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view Nationalities.'
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
                'message' => 'Nationality ID is required.'
            ]);
        }

        $nationality = $this->nationalityModel->getNationality($id);

        if (!$nationality) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nationality not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $nationality
        ]);
    }

    /**
     * Update the specified Nationality in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit Nationalities
        if (!has_permission('nationalities.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit Nationalities.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit Nationalities.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Nationality update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nationality ID is required.'
                ]);
            }
            return redirect()->to('/nationalities')
                           ->with('error', 'Nationality ID is required.');
        }

        $nationality = $this->nationalityModel->getNationality($id);

        if (!$nationality) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nationality not found.'
                ]);
            }
            return redirect()->to('/nationalities')
                           ->with('error', 'Nationality not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = [
            'name' => $this->request->getPost('name'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $inputData = $this->sanitizeNationalityInput($rawData);
        
        $validationResult = $this->nationalityModel->validateForUpdate($inputData, $id);
        
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

        // Update the Nationality
        try {
            // Skip model validation since we already validated
            $this->nationalityModel->skipValidation(true);
            $result = $this->nationalityModel->update($id, $data);
            $this->nationalityModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated Nationality data for logging
                $updatedNationality = $this->nationalityModel->getNationality($id);
                
                // Log the update operation
                $this->logNationalityOperation('update', $updatedNationality, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Nationality updated successfully!'
                    ]);
                }
                return redirect()->to('/nationalities')
                               ->with('success', 'Nationality updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->nationalityModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update Nationality: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update Nationality: ' . $errorMessage);
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
     * Remove the specified Nationality from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete Nationalities
        if (!has_permission('nationalities.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete Nationalities.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nationality ID is required.'
            ]);
        }

        $nationality = $this->nationalityModel->getNationality($id);

        if (!$nationality) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nationality not found.'
            ]);
        }

        // Delete the Nationality
        if ($this->nationalityModel->delete($id)) {
            // Log the delete operation
            $this->logNationalityOperation('delete', $nationality, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Nationality deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete Nationality. Please try again.'
            ]);
        }
    }

    /**
     * Get Nationalities for AJAX requests
     */
    public function getNationalities()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $nationalities = $this->nationalityModel->getNationalitiesWithPagination($search, $limit, $offset);
        $totalNationalities = $this->nationalityModel->getNationalitiesCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $nationalities,
            'total' => $totalNationalities
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

        $statuses = $this->nationalityModel->getActiveStatuses();

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

        $nationalities = $this->nationalityModel->getNationalitiesWithPagination($search, $limit, $offset);
        $totalNationalities = $this->nationalityModel->getNationalitiesCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $nationalities,
            'total' => $totalNationalities,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalNationalities
        ]);
    }
}