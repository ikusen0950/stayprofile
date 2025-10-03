<?php

namespace App\Controllers;

use App\Models\GenderModel;
use CodeIgniter\HTTP\RedirectResponse;

class GendersController extends BaseController
{
    protected $genderModel;
    protected $logModel;

    public function __construct()
    {
        $this->genderModel = new GenderModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for gender
     */
    private function sanitizeGenderInput(array $data): array
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
     * Log gender operations to the logs table
     */
    private function logGenderOperation(string $action, array $genderData, int $genderId = null): void
    {
        try {
            log_message('info', 'logGenderOperation called with action: ' . $action . ', genderId: ' . ($genderId ?? 'NULL'));
            
            $genderNumber = $genderId ?? ($genderData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Gender Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Gender Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Gender Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Gender ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description in the requested format
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $genderNumber . "\n";
            $actionDescription .= "Name: " . ($genderData['name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($genderData['description'] ?? 'No description provided');

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
            log_message('error', 'Failed to log Gender operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of Genders
     */
    public function index()
    {
        // Check if user has permission to view genders
        if (!has_permission('genders.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view genders.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $Genders = $this->genderModel->getGendersWithPagination($search, $limit, $offset);
        $totalGenders = $this->genderModel->getGendersCount($search);
        $totalPages = ceil($totalGenders / $limit);

        // Get active statuses for dropdown
        $statuses = $this->genderModel->getActiveStatuses();
        log_message('info', 'Statuses data: ' . json_encode($statuses));

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('genders.create'),
            'canEdit' => has_permission('genders.edit'),
            'canView' => has_permission('genders.view'),
            'canDelete' => has_permission('genders.delete')
        ];

        $data = [
            'title' => 'Gender Management',
            'Genders' => $Genders,
            'statuses' => $statuses,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalGenders' => $totalGenders,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('genders/index', $data);
    }

    /**
     * Store a newly created Gender in database
     */
    public function store()
    {
        // Check if user has permission to create Genders
        if (!has_permission('genders.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create Genders.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create Genders.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Gender store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        if (!$this->validate($this->genderModel->getValidationRules())) {
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
        $data = $this->sanitizeGenderInput($rawData);

        // Insert the Gender
        if ($genderId = $this->genderModel->insert($data)) {
            // Get the full Gender data for logging
            $genderData = $this->genderModel->getGender($genderId);
            
            // Log the create operation
            $this->logGenderOperation('create', $genderData, $genderId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Gender created successfully!'
                ]);
            }
            return redirect()->to('/Genders')
                           ->with('success', 'Gender created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create Gender. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create Gender. Please try again.');
        }
    }

    /**
     * Display the specified Gender (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view Genders
        if (!has_permission('genders.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view Genders.'
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
                'message' => 'Gender ID is required.'
            ]);
        }

        $Gender = $this->genderModel->getGender($id);

        if (!$Gender) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gender not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $Gender
        ]);
    }

    /**
     * Update the specified Gender in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit Genders
        if (!has_permission('genders.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit Genders.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit Genders.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Gender update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gender ID is required.'
                ]);
            }
            return redirect()->to('/Genders')
                           ->with('error', 'Gender ID is required.');
        }

        $Gender = $this->genderModel->getGender($id);

        if (!$Gender) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gender not found.'
                ]);
            }
            return redirect()->to('/Genders')
                           ->with('error', 'Gender not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = [
            'name' => $this->request->getPost('name'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $inputData = $this->sanitizeGenderInput($rawData);
        
        $validationResult = $this->genderModel->validateForUpdate($inputData, $id);
        
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

        // Update the Gender
        try {
            // Skip model validation since we already validated
            $this->genderModel->skipValidation(true);
            $result = $this->genderModel->update($id, $data);
            $this->genderModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated Gender data for logging
                $updatedGender = $this->genderModel->getGender($id);
                
                // Log the update operation
                $this->logGenderOperation('update', $updatedGender, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Gender updated successfully!'
                    ]);
                }
                return redirect()->to('/Genders')
                               ->with('success', 'Gender updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->genderModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update Gender: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update Gender: ' . $errorMessage);
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
     * Remove the specified Gender from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete Genders
        if (!has_permission('genders.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete Genders.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gender ID is required.'
            ]);
        }

        $Gender = $this->genderModel->getGender($id);

        if (!$Gender) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gender not found.'
            ]);
        }

        // Delete the Gender
        if ($this->genderModel->delete($id)) {
            // Log the delete operation
            $this->logGenderOperation('delete', $Gender, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Gender deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete Gender. Please try again.'
            ]);
        }
    }

    /**
     * Get Genders for AJAX requests
     */
    public function getGenders()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $Genders = $this->genderModel->getGendersWithPagination($search, $limit, $offset);
        $totalGenders = $this->genderModel->getGendersCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $Genders,
            'total' => $totalGenders
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

        $statuses = $this->genderModel->getActiveStatuses();

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

        $Genders = $this->genderModel->getGendersWithPagination($search, $limit, $offset);
        $totalGenders = $this->genderModel->getGendersCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $Genders,
            'total' => $totalGenders,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalGenders
        ]);
    }
}
