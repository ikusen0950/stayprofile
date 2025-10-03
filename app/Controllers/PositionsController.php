<?php

namespace App\Controllers;

use App\Models\PositionModel;
use CodeIgniter\HTTP\RedirectResponse;

class PositionsController extends BaseController
{
    protected $positionModel;
    protected $logModel;

    public function __construct()
    {
        $this->positionModel = new PositionModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for position
     */
    private function sanitizePositionInput(array $data): array
    {
        $sanitized = [
            'name' => isset($data['name']) ? trim(strip_tags($data['name'])) : '',
            'section_id' => isset($data['section_id']) ? (int)$data['section_id'] : 0,
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
     * Log position operations to the logs table
     */
    private function logPositionOperation(string $action, array $positionData, int $positionId = null): void
    {
        try {
            log_message('info', 'logPositionOperation called with action: ' . $action . ', positionId: ' . $positionId);
            
            $positionNumber = $positionId ?? ($positionData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Position Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Position Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Position Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Position ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description in the requested format
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $positionNumber . "\n";
            $actionDescription .= "Section: " . ($positionData['section_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Name: " . ($positionData['name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($positionData['description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 8, // Positions module ID (assuming 8 for positions)
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
            log_message('error', 'Failed to log position operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of positions
     */
    public function index()
    {
        // Check if user has permission to view positions
        if (!has_permission('positions.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view positions.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $positions = $this->positionModel->getPositionsWithPagination($search, $limit, $offset);
        $totalPositions = $this->positionModel->getPositionsCount($search);
        $totalPages = ceil($totalPositions / $limit);

        // Get active sections for dropdown
        $sections = $this->positionModel->getActiveSections();
        log_message('info', 'Sections data: ' . json_encode($sections));

        // Get active statuses for dropdown
        $statuses = $this->positionModel->getActiveStatuses();
        log_message('info', 'Statuses data: ' . json_encode($statuses));

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('positions.create'),
            'canEdit' => has_permission('positions.edit'),
            'canView' => has_permission('positions.view'),
            'canDelete' => has_permission('positions.delete')
        ];

        $data = [
            'title' => 'Position Management',
            'positions' => $positions,
            'sections' => $sections,
            'statuses' => $statuses,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPositions' => $totalPositions,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('positions/index', $data);
    }

    /**
     * Store a newly created position in database
     */
    public function store()
    {
        // Check if user has permission to create positions
        if (!has_permission('positions.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create positions.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create positions.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Position store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Prepare data for validation with sanitization
        $rawData = [
            'name' => $this->request->getPost('name'),
            'section_id' => $this->request->getPost('section_id'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $validationData = $this->sanitizePositionInput($rawData);

        // Validate the input (including section-scoped uniqueness)
        $validationResult = $this->positionModel->validateForCreate($validationData);
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

        // Prepare data for insertion
        $data = $validationData;

        // Insert the position
        if ($positionId = $this->positionModel->insert($data)) {
            // Get the full position data for logging
            $positionData = $this->positionModel->getPosition($positionId);
            
            // Log the create operation
            $this->logPositionOperation('create', $positionData, $positionId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Position created successfully!'
                ]);
            }
            return redirect()->to('/positions')
                           ->with('success', 'Position created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create position. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create position. Please try again.');
        }
    }

    /**
     * Display the specified position (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view positions
        if (!has_permission('positions.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view positions.'
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
                'message' => 'Position ID is required.'
            ]);
        }

        $position = $this->positionModel->getPosition($id);

        if (!$position) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Position not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $position
        ]);
    }

    /**
     * Update the specified position in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit positions
        if (!has_permission('positions.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit positions.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit positions.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Position update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Position ID is required.'
                ]);
            }
            return redirect()->to('/positions')
                           ->with('error', 'Position ID is required.');
        }

        $position = $this->positionModel->getPosition($id);

        if (!$position) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Position not found.'
                ]);
            }
            return redirect()->to('/positions')
                           ->with('error', 'Position not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = [
            'name' => $this->request->getPost('name'),
            'section_id' => $this->request->getPost('section_id'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $inputData = $this->sanitizePositionInput($rawData);
        
        $validationResult = $this->positionModel->validateForUpdate($inputData, $id);
        
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

        // Update the position
        try {
            // Skip model validation since we already validated
            $this->positionModel->skipValidation(true);
            $result = $this->positionModel->update($id, $data);
            $this->positionModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated position data for logging
                $updatedPosition = $this->positionModel->getPosition($id);
                
                // Log the update operation
                $this->logPositionOperation('update', $updatedPosition, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Position updated successfully!'
                    ]);
                }
                return redirect()->to('/positions')
                               ->with('success', 'Position updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->positionModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update position: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update position: ' . $errorMessage);
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
     * Remove the specified position from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete positions
        if (!has_permission('positions.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete positions.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Position ID is required.'
            ]);
        }

        $position = $this->positionModel->getPosition($id);

        if (!$position) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Position not found.'
            ]);
        }

        // Delete the position
        if ($this->positionModel->delete($id)) {
            // Log the delete operation
            $this->logPositionOperation('delete', $position, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Position deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete position. Please try again.'
            ]);
        }
    }

    /**
     * Get positions for AJAX requests
     */
    public function getPositions()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $positions = $this->positionModel->getPositionsWithPagination($search, $limit, $offset);
        $totalPositions = $this->positionModel->getPositionsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $positions,
            'total' => $totalPositions
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

        $positions = $this->positionModel->getPositionsWithPagination($search, $limit, $offset);
        $totalPositions = $this->positionModel->getPositionsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $positions,
            'total' => $totalPositions,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalPositions
        ]);
    }

    /**
     * Get sections for dropdown (AJAX)
     */
    public function getSections()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $sections = $this->positionModel->getActiveSections();

        return $this->response->setJSON([
            'success' => true,
            'data' => $sections
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

        $statuses = $this->positionModel->getActiveStatuses();

        return $this->response->setJSON([
            'success' => true,
            'data' => $statuses
        ]);
    }
}
