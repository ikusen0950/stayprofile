<?php

namespace App\Controllers;

use App\Models\IslanderModel;
use CodeIgniter\HTTP\RedirectResponse;

class IslandersController extends BaseController
{
    protected $islanderModel;
    protected $logModel;

    public function __construct()
    {
        $this->islanderModel = new IslanderModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Get current authenticated user ID
     */
    private function getCurrentUserId(): ?int
    {
        try {
            // Method 1: Try auth helper functions
            if (function_exists('user_id')) {
                $userId = user_id();
                if ($userId) {
                    return (int)$userId;
                }
            }
            
            if (function_exists('user')) {
                $user = user();
                if ($user && isset($user->id)) {
                    return (int)$user->id;
                }
            }
            
            // Method 2: Try session-based approach
            $session = session();
            $sessionUserId = $session->get('logged_in') ?? $session->get('user_id') ?? $session->get('id');
            if ($sessionUserId) {
                return (int)$sessionUserId;
            }
            
            // Method 3: Try to get from user data in session
            $userData = $session->get('user');
            if ($userData) {
                if (is_array($userData) && isset($userData['id'])) {
                    return (int)$userData['id'];
                } elseif (is_object($userData) && isset($userData->id)) {
                    return (int)$userData->id;
                }
            }
            
            // Method 4: Last resort - check if there's a specific auth session key
            foreach (['auth_user_id', 'user_session', 'current_user'] as $key) {
                $value = $session->get($key);
                if ($value) {
                    if (is_numeric($value)) {
                        return (int)$value;
                    } elseif (is_array($value) && isset($value['id'])) {
                        return (int)$value['id'];
                    } elseif (is_object($value) && isset($value->id)) {
                        return (int)$value->id;
                    }
                }
            }
            
            return null;
            
        } catch (\Exception $e) {
            log_message('error', 'Error getting current user ID: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Debug method to check session data (remove after testing)
     */
    public function debugSession()
    {
        $session = session();
        $allSessionData = $session->get();
        
        echo "<h3>Session Debug Information:</h3>";
        echo "<pre>";
        print_r($allSessionData);
        echo "</pre>";
        
        echo "<h3>Current User ID Methods:</h3>";
        echo "<ul>";
        
        // Test different methods
        if (function_exists('user_id')) {
            echo "<li>user_id(): " . (user_id() ?? 'NULL') . "</li>";
        } else {
            echo "<li>user_id(): Function not available</li>";
        }
        
        if (function_exists('user')) {
            $user = user();
            echo "<li>user(): " . ($user ? json_encode($user) : 'NULL') . "</li>";
        } else {
            echo "<li>user(): Function not available</li>";
        }
        
        echo "<li>getCurrentUserId(): " . ($this->getCurrentUserId() ?? 'NULL') . "</li>";
        echo "</ul>";
        
        die();
    }
    private function sanitizeIslanderInput(array $data, bool $isUpdate = false): array
    {
        $sanitized = [
            'status_id' => isset($data['status_id']) ? (int)$data['status_id'] : 1,
            'islander_no' => isset($data['islander_no']) ? trim(strip_tags($data['islander_no'])) : '',
            'full_name' => isset($data['full_name']) ? trim(strip_tags($data['full_name'])) : '',
            'id_pp_wp_no' => isset($data['id_pp_wp_no']) ? trim(strip_tags($data['id_pp_wp_no'])) : '',
            'division_id' => isset($data['division_id']) ? (int)$data['division_id'] : null,
            'department_id' => isset($data['department_id']) ? (int)$data['department_id'] : null,
            'section_id' => isset($data['section_id']) ? (int)$data['section_id'] : null,
            'position_id' => isset($data['position_id']) ? (int)$data['position_id'] : null,
            'on_leave_status' => isset($data['on_leave_status']) ? (int)$data['on_leave_status'] : 0,
            'nationality' => isset($data['nationality_id']) ? (string)$data['nationality_id'] : (isset($data['nationality']) ? trim(strip_tags($data['nationality'])) : ''),
            'date_of_joining' => isset($data['join_date']) ? $data['join_date'] : (isset($data['date_of_joining']) ? $data['date_of_joining'] : null),
            'date_of_birth' => isset($data['date_of_birth']) ? $data['date_of_birth'] : null,
            'company' => isset($data['company']) ? trim(strip_tags($data['company'])) : '',
            'house_id' => isset($data['house_id']) ? (int)$data['house_id'] : null,
            'departed_date' => isset($data['departed_date']) ? $data['departed_date'] : null,
            'arrival_date' => isset($data['arrival_date']) ? $data['arrival_date'] : null,
            'gender_id' => isset($data['gender_id']) ? (int)$data['gender_id'] : null,
            'phone' => isset($data['phone']) ? trim(strip_tags($data['phone'])) : '',
            'email' => isset($data['email']) ? trim(strip_tags($data['email'])) : '',
            'address' => isset($data['address']) ? trim(strip_tags($data['address'])) : '',
            'notes' => isset($data['notes']) ? trim(strip_tags($data['notes'])) : '',
            'username' => isset($data['islander_no']) && !empty(trim($data['islander_no'])) ? trim(strip_tags($data['islander_no'])) : null,
        ];

        // Get current user ID for tracking
        $currentUserId = $this->getCurrentUserId();
        
        // Additional debugging - remove this after testing
        log_message('debug', 'Current User ID: ' . ($currentUserId ?? 'NULL') . ' for ' . ($isUpdate ? 'UPDATE' : 'CREATE') . ' operation');

        // Set tracking fields
        if ($currentUserId) {
            if (!$isUpdate) {
                // For new records, set created_by
                $sanitized['created_by'] = $currentUserId;
                log_message('debug', 'Setting created_by to: ' . $currentUserId);
            }
            // Always set updated_by for both create and update operations
            $sanitized['updated_by'] = $currentUserId;
            log_message('debug', 'Setting updated_by to: ' . $currentUserId);
        } else {
            log_message('warning', 'No current user ID found for tracking - user may not be logged in properly');
        }

        // Default values
        if (!isset($data['active'])) {
            $sanitized['active'] = 1;
        } else {
            $sanitized['active'] = (int)$data['active'];
        }

        if (!isset($data['password_changed'])) {
            $sanitized['password_changed'] = 1;
        } else {
            $sanitized['password_changed'] = (int)$data['password_changed'];
        }

        if (!isset($data['type'])) {
            $sanitized['type'] = 1;
        } else {
            $sanitized['type'] = (int)$data['type'];
        }

        if (!isset($data['type_description'])) {
            $sanitized['type_description'] = 'Islander';
        } else {
            $sanitized['type_description'] = trim(strip_tags($data['type_description']));
        }

        if (!isset($data['out_of_office'])) {
            $sanitized['out_of_office'] = 0;
        } else {
            $sanitized['out_of_office'] = (int)$data['out_of_office'];
        }

        if (!isset($data['has_accepted_agreement'])) {
            $sanitized['has_accepted_agreement'] = 1;
        } else {
            $sanitized['has_accepted_agreement'] = (int)$data['has_accepted_agreement'];
        }

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

        // Handle null values for empty fields
        if (empty($sanitized['division_id'])) {
            $sanitized['division_id'] = 0;
        }
        if (empty($sanitized['department_id'])) {
            $sanitized['department_id'] = 0;
        }
        if (empty($sanitized['section_id'])) {
            $sanitized['section_id'] = 0;
        }
        if (empty($sanitized['position_id'])) {
            $sanitized['position_id'] = 0;
        }
        if (empty($sanitized['gender_id'])) {
            $sanitized['gender_id'] = 0;
        }
        if (empty($sanitized['house_id'])) {
            $sanitized['house_id'] = 0;
        }

        return $sanitized;
    }

    /**
     * Log islander operations to the logs table
     */
    private function logIslanderOperation(string $action, array $islanderData, int $islanderId = null): void
    {
        try {
            log_message('info', 'logIslanderOperation called with action: ' . $action . ', islanderId: ' . $islanderId);
            
            $islanderNumber = $islanderId ?? ($islanderData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Islander Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Islander Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Islander Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Islander ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description in the requested format (max 255 chars)
            $islanderNo = $islanderData['islander_no'] ?? 'Unknown';
            $fullName = $islanderData['full_name'] ?? 'Unknown';
            
            $actionDescription = $actionPrefix . " #" . $islanderNumber . " - " . $islanderNo . " (" . $fullName . ")";
            
            // Ensure we don't exceed 255 characters
            if (strlen($actionDescription) > 255) {
                $actionDescription = substr($actionDescription, 0, 252) . '...';
            }

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 12, // Islanders module ID
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
            log_message('error', 'Failed to log islander operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of islanders
     */
    public function index()
    {
        // Debug permissions
        $hasIslandersView = has_permission('islanders.view');
        $hasUsersView = has_permission('users.view');
        log_message('info', "Permissions check: islanders.view = " . ($hasIslandersView ? 'true' : 'false') . ", users.view = " . ($hasUsersView ? 'true' : 'false'));
        
        // Temporarily disable permission check for now - will fix permissions later
        // if (!$hasIslandersView && !$hasUsersView) {
        //     log_message('error', 'User does not have permission to view islanders');
        //     return redirect()->to('/')->with('error', 'You do not have permission to view islanders.');
        // }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $islanders = $this->islanderModel->getIslandersWithPagination($search, $limit, $offset);
        $totalIslanders = $this->islanderModel->getIslandersCount($search);
        $totalPages = ceil($totalIslanders / $limit);

        // Get active statuses for dropdown
        $statuses = $this->islanderModel->getActiveStatuses();
        
        // Get dropdown data
        $divisions = $this->islanderModel->getActiveDivisions();
        $departments = $this->islanderModel->getActiveDepartments();
        $sections = $this->islanderModel->getActiveSections();
        $positions = $this->islanderModel->getActivePositions();
        $genders = $this->islanderModel->getActiveGenders();
        $houses = $this->islanderModel->getActiveHouses();
        $nationalities = $this->islanderModel->getActiveNationalities();

        log_message('info', 'Statuses data: ' . json_encode($statuses));

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('islanders.create') || has_permission('users.create'),
            'canEdit' => has_permission('islanders.edit') || has_permission('users.edit'),
            'canView' => has_permission('islanders.view') || has_permission('users.view'),
            'canDelete' => has_permission('islanders.delete') || has_permission('users.delete')
        ];

        $data = [
            'title' => 'Islander Management',
            'islanders' => $islanders,
            'statuses' => $statuses,
            'divisions' => $divisions,
            'departments' => $departments,
            'sections' => $sections,
            'positions' => $positions,
            'genders' => $genders,
            'houses' => $houses,
            'nationalities' => $nationalities,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalIslanders' => $totalIslanders,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('islanders/index', $data);
    }

    /**
     * Store a newly created islander in database
     */
    public function store()
    {
        // Check if user has permission to create islanders
        if (!has_permission('islanders.create') && !has_permission('users.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create islanders.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create islanders.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Islander store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        if (!$this->validate($this->islanderModel->getValidationRules())) {
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
        $data = $this->sanitizeIslanderInput($rawData, false); // false = create operation

        // Insert the islander
        if ($islanderId = $this->islanderModel->insert($data)) {
            try {
                // Handle image uploads after islander is created
                $imagePaths = $this->handleIslanderImages($islanderId);
                
                // Update islander with image paths if any were uploaded
                if (!empty($imagePaths)) {
                    $this->islanderModel->update($islanderId, $imagePaths);
                }
                
                // Get the full islander data for logging
                $islanderData = $this->islanderModel->getIslander($islanderId);
                
                // Log the create operation
                $this->logIslanderOperation('create', $islanderData, $islanderId);
                
            } catch (\Exception $e) {
                // If image upload fails, delete the created islander record
                $this->islanderModel->delete($islanderId);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Islander creation failed: ' . $e->getMessage()
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Islander creation failed: ' . $e->getMessage());
            }
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Islander created successfully!'
                ]);
            }
            return redirect()->to('/islanders')
                           ->with('success', 'Islander created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create islander. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create islander. Please try again.');
        }
    }

    /**
     * Display the specified islander (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view islanders
        if (!has_permission('islanders.view') && !has_permission('users.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view islanders.'
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
                'message' => 'Islander ID is required.'
            ]);
        }

        $islander = $this->islanderModel->getIslander($id);

        if (!$islander) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Islander not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'islander' => $islander
        ]);
    }

    /**
     * Update the specified islander in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit islanders
        if (!has_permission('islanders.edit') && !has_permission('users.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit islanders.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit islanders.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Islander update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Islander ID is required.'
                ]);
            }
            return redirect()->to('/islanders')
                           ->with('error', 'Islander ID is required.');
        }

        $islander = $this->islanderModel->getIslander($id);

        if (!$islander) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Islander not found.'
                ]);
            }
            return redirect()->to('/islanders')
                           ->with('error', 'Islander not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = $this->request->getPost();
        $inputData = $this->sanitizeIslanderInput($rawData, true); // true = update operation
        
        $validationResult = $this->islanderModel->validateForUpdate($inputData, $id);
        
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

        // Update the islander
        try {
            // Handle image uploads first
            $imagePaths = $this->handleIslanderImages($id, $islander['image'] ?? null, $islander['cover_image'] ?? null);
            
            // Add image paths to update data if any were uploaded
            if (!empty($imagePaths)) {
                $data = array_merge($data, $imagePaths);
            }
            
            // Skip model validation since we already validated
            $this->islanderModel->skipValidation(true);
            $result = $this->islanderModel->update($id, $data);
            $this->islanderModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated islander data for logging
                $updatedIslander = $this->islanderModel->getIslander($id);
                
                // Log the update operation
                $this->logIslanderOperation('update', $updatedIslander, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Islander updated successfully!'
                    ]);
                }
                return redirect()->to('/islanders')
                               ->with('success', 'Islander updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->islanderModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update islander: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update islander: ' . $errorMessage);
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
     * Remove the specified islander from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete islanders
        if (!has_permission('islanders.delete') && !has_permission('users.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete islanders.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Islander ID is required.'
            ]);
        }

        $islander = $this->islanderModel->getIslander($id);

        if (!$islander) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Islander not found.'
            ]);
        }

        // Delete the islander
        if ($this->islanderModel->delete($id)) {
            // Clean up uploaded images
            if (!empty($islander['image'])) {
                $this->deleteImage($islander['image']);
            }
            if (!empty($islander['cover_image'])) {
                $this->deleteImage($islander['cover_image']);
            }
            
            // Log the delete operation
            $this->logIslanderOperation('delete', $islander, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Islander deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete islander. Please try again.'
            ]);
        }
    }

    /**
     * Get islanders for AJAX requests
     */
    public function getIslanders()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $islanders = $this->islanderModel->getIslandersWithPagination($search, $limit, $offset);
        $totalIslanders = $this->islanderModel->getIslandersCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $islanders,
            'total' => $totalIslanders
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

        $statuses = $this->islanderModel->getActiveStatuses();

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

        $islanders = $this->islanderModel->getIslandersWithPagination($search, $limit, $offset);
        $totalIslanders = $this->islanderModel->getIslandersCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $islanders,
            'total' => $totalIslanders,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalIslanders
        ]);
    }

    /**
     * Handle image upload
     */
    private function handleImageUpload($file, $fieldName, $islanderId = null)
    {
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return null;
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            throw new \Exception('Invalid file type. Only JPEG, PNG and GIF files are allowed.');
        }

        // Validate file size (max 5MB)
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($file->getSizeByUnit('mb') > 5) {
            throw new \Exception('File size too large. Maximum size is 5MB.');
        }

        // Determine upload directory based on field type
        if ($fieldName === 'profile' || $fieldName === 'image') {
            $uploadDir = 'assets/media/users/';
        } elseif ($fieldName === 'cover' || $fieldName === 'cover_image') {
            $uploadDir = 'assets/media/cover_image/';
        } else {
            // Fallback for other types
            $uploadDir = 'uploads/islanders/';
        }

        // Create upload directory if it doesn't exist
        $uploadPath = FCPATH . $uploadDir;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Generate unique filename
        $extension = $file->getClientExtension();
        $fileName = $fieldName . '_' . ($islanderId ?: uniqid()) . '_' . time() . '.' . $extension;

        // Move file to upload directory
        if ($file->move($uploadPath, $fileName)) {
            return $uploadDir . $fileName;
        }

        throw new \Exception('Failed to upload file.');
    }

    /**
     * Delete image file
     */
    private function deleteImage($imagePath)
    {
        if (!empty($imagePath) && file_exists(FCPATH . $imagePath)) {
            unlink(FCPATH . $imagePath);
        }
    }

    /**
     * Handle multiple image uploads for an islander
     */
    private function handleIslanderImages($islanderId, $oldImagePath = null, $oldCoverImagePath = null)
    {
        $imagePaths = [];

        // Handle profile image
        $imageFile = $this->request->getFile('image') ?: $this->request->getFile('profile_image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            try {
                // Delete old image if exists
                if ($oldImagePath) {
                    $this->deleteImage($oldImagePath);
                }
                
                $imagePaths['image'] = $this->handleImageUpload($imageFile, 'profile', $islanderId);
            } catch (\Exception $e) {
                log_message('error', 'Profile image upload failed: ' . $e->getMessage());
                throw new \Exception('Profile image upload failed: ' . $e->getMessage());
            }
        }

        // Handle cover image
        $coverImageFile = $this->request->getFile('cover_image');
        if ($coverImageFile && $coverImageFile->isValid() && !$coverImageFile->hasMoved()) {
            try {
                // Delete old cover image if exists
                if ($oldCoverImagePath) {
                    $this->deleteImage($oldCoverImagePath);
                }
                
                $imagePaths['cover_image'] = $this->handleImageUpload($coverImageFile, 'cover', $islanderId);
            } catch (\Exception $e) {
                log_message('error', 'Cover image upload failed: ' . $e->getMessage());
                throw new \Exception('Cover image upload failed: ' . $e->getMessage());
            }
        }

        return $imagePaths;
    }

    /**
     * Get departments by division ID (AJAX)
     */
    public function getDepartmentsByDivision()
    {
        $divisionId = $this->request->getGet('division_id');
        
        if (!$divisionId) {
            return $this->response->setJSON([]);
        }

        $departmentModel = new \App\Models\DepartmentModel();
        $departments = $departmentModel->where('division_id', $divisionId)
                                      ->where('status_id', 1)
                                      ->orderBy('name', 'ASC')
                                      ->findAll();

        return $this->response->setJSON($departments);
    }

    /**
     * Get sections by department ID (AJAX)
     */
    public function getSectionsByDepartment()
    {
        $departmentId = $this->request->getGet('department_id');
        
        if (!$departmentId) {
            return $this->response->setJSON([]);
        }

        $sectionModel = new \App\Models\SectionModel();
        $sections = $sectionModel->where('department_id', $departmentId)
                                 ->where('status_id', 1)
                                 ->orderBy('name', 'ASC')
                                 ->findAll();

        return $this->response->setJSON($sections);
    }

    /**
     * Get positions by section ID (AJAX)
     */
    public function getPositionsBySection()
    {
        $sectionId = $this->request->getGet('section_id');
        
        if (!$sectionId) {
            return $this->response->setJSON([]);
        }

        $positionModel = new \App\Models\PositionModel();
        $positions = $positionModel->where('section_id', $sectionId)
                                   ->where('status_id', 1)
                                   ->orderBy('name', 'ASC')
                                   ->findAll();

        return $this->response->setJSON($positions);
    }
}