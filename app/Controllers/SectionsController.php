<?php

namespace App\Controllers;

use App\Models\SectionModel;
use CodeIgniter\HTTP\RedirectResponse;

class SectionsController extends BaseController
{
    protected $sectionModel;
    protected $logModel;

    public function __construct()
    {
        $this->sectionModel = new SectionModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for section
     */
    private function sanitizeSectionInput(array $data): array
    {
        $sanitized = [
            'name' => isset($data['name']) ? trim(strip_tags($data['name'])) : '',
            'department_id' => isset($data['department_id']) ? (int)$data['department_id'] : 0,
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
     * Log section operations to the logs table
     */
    private function logSectionOperation(string $action, array $sectionData, int $sectionId = null): void
    {
        try {
            log_message('info', 'logSectionOperation called with action: ' . $action . ', sectionId: ' . $sectionId);
            
            $sectionNumber = $sectionId ?? ($sectionData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Section Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Section Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Section Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Section ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description in the requested format
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $sectionNumber . "\n";
            $actionDescription .= "Department: " . ($sectionData['department_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Name: " . ($sectionData['name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($sectionData['description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 7, // Sections module ID (assuming 8 for sections)
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
            log_message('error', 'Failed to log section operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of sections
     */
    public function index()
    {
        // Check if user has permission to view sections
        if (!has_permission('sections.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view sections.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $sections = $this->sectionModel->getSectionsWithPagination($search, $limit, $offset);
        $totalSections = $this->sectionModel->getSectionsCount($search);
        $totalPages = ceil($totalSections / $limit);

        // Get active departments for dropdown
        $departments = $this->sectionModel->getActiveDepartments();
        log_message('info', 'Departments data: ' . json_encode($departments));

        // Get active statuses for dropdown
        $statuses = $this->sectionModel->getActiveStatuses();
        log_message('info', 'Statuses data: ' . json_encode($statuses));

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('sections.create'),
            'canEdit' => has_permission('sections.edit'),
            'canView' => has_permission('sections.view'),
            'canDelete' => has_permission('sections.delete')
        ];

        $data = [
            'title' => 'Section Management',
            'sections' => $sections,
            'departments' => $departments,
            'statuses' => $statuses,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalSections' => $totalSections,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('sections/index', $data);
    }

    /**
     * Store a newly created section in database
     */
    public function store()
    {
        // Check if user has permission to create sections
        if (!has_permission('sections.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create sections.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create sections.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Section store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        if (!$this->validate($this->sectionModel->getValidationRules())) {
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
            'department_id' => $this->request->getPost('department_id'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $data = $this->sanitizeSectionInput($rawData);

        // Insert the section
        if ($sectionId = $this->sectionModel->insert($data)) {
            // Get the full section data for logging
            $sectionData = $this->sectionModel->getSection($sectionId);
            
            // Log the create operation
            $this->logSectionOperation('create', $sectionData, $sectionId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Section created successfully!'
                ]);
            }
            return redirect()->to('/sections')
                           ->with('success', 'Section created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create section. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create section. Please try again.');
        }
    }

    /**
     * Display the specified section (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view sections
        if (!has_permission('sections.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view sections.'
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
                'message' => 'Section ID is required.'
            ]);
        }

        $section = $this->sectionModel->getSection($id);

        if (!$section) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Section not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $section
        ]);
    }

    /**
     * Update the specified section in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit sections
        if (!has_permission('sections.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit sections.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit sections.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Section update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Section ID is required.'
                ]);
            }
            return redirect()->to('/sections')
                           ->with('error', 'Section ID is required.');
        }

        $section = $this->sectionModel->getSection($id);

        if (!$section) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Section not found.'
                ]);
            }
            return redirect()->to('/sections')
                           ->with('error', 'Section not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = [
            'name' => $this->request->getPost('name'),
            'department_id' => $this->request->getPost('department_id'),
            'status_id' => $this->request->getPost('status_id'),
            'description' => $this->request->getPost('description')
        ];
        $inputData = $this->sanitizeSectionInput($rawData);
        
        $validationResult = $this->sectionModel->validateForUpdate($inputData, $id);
        
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

        // Update the section
        try {
            // Skip model validation since we already validated
            $this->sectionModel->skipValidation(true);
            $result = $this->sectionModel->update($id, $data);
            $this->sectionModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated section data for logging
                $updatedSection = $this->sectionModel->getSection($id);
                
                // Log the update operation
                $this->logSectionOperation('update', $updatedSection, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Section updated successfully!'
                    ]);
                }
                return redirect()->to('/sections')
                               ->with('success', 'Section updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->sectionModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update section: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update section: ' . $errorMessage);
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
     * Remove the specified section from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete sections
        if (!has_permission('sections.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete sections.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Section ID is required.'
            ]);
        }

        $section = $this->sectionModel->getSection($id);

        if (!$section) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Section not found.'
            ]);
        }

        // Delete the section
        if ($this->sectionModel->delete($id)) {
            // Log the delete operation
            $this->logSectionOperation('delete', $section, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Section deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete section. Please try again.'
            ]);
        }
    }

    /**
     * Get sections for AJAX requests
     */
    public function getSections()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $sections = $this->sectionModel->getSectionsWithPagination($search, $limit, $offset);
        $totalSections = $this->sectionModel->getSectionsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $sections,
            'total' => $totalSections
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

        $sections = $this->sectionModel->getSectionsWithPagination($search, $limit, $offset);
        $totalSections = $this->sectionModel->getSectionsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $sections,
            'total' => $totalSections,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalSections
        ]);
    }

    /**
     * Get departments for dropdown (AJAX)
     */
    public function getDepartments()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $departments = $this->sectionModel->getActiveDepartments();

        return $this->response->setJSON([
            'success' => true,
            'data' => $departments
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

        $statuses = $this->sectionModel->getActiveStatuses();

        return $this->response->setJSON([
            'success' => true,
            'data' => $statuses
        ]);
    }
}