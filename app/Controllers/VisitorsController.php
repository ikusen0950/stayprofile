<?php

namespace App\Controllers;

use App\Models\VisitorModel;
use CodeIgniter\HTTP\RedirectResponse;

class VisitorsController extends BaseController
{
    protected $visitorModel;
    protected $logModel;

    public function __construct()
    {
        $this->visitorModel = new VisitorModel();
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

    private function sanitizeVisitorInput(array $data, bool $isUpdate = false): array
    {
        $sanitized = [
            'status_id' => isset($data['status_id']) ? (int)$data['status_id'] : 1,
            'islander_no' => isset($data['id_pp_wp_no']) ? trim(strip_tags($data['id_pp_wp_no'])) : (isset($data['visitor_no']) ? trim(strip_tags($data['visitor_no'])) : (isset($data['islander_no']) ? trim(strip_tags($data['islander_no'])) : '')),
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
            'username' => isset($data['id_pp_wp_no']) && !empty(trim($data['id_pp_wp_no'])) ? trim(strip_tags($data['id_pp_wp_no'])) : (isset($data['visitor_no']) && !empty(trim($data['visitor_no'])) ? trim(strip_tags($data['visitor_no'])) : (isset($data['islander_no']) && !empty(trim($data['islander_no'])) ? trim(strip_tags($data['islander_no'])) : null)),
        ];

        // Get current user ID for tracking
        $currentUserId = $this->getCurrentUserId();
        
        // Set tracking fields
        if ($currentUserId) {
            if (!$isUpdate) {
                // For new records, set created_by
                $sanitized['created_by'] = $currentUserId;
            }
            // Always set updated_by for both create and update operations
            $sanitized['updated_by'] = $currentUserId;
        }

        // Default values for visitors
        if (!isset($data['active'])) {
            $sanitized['active'] = 0; // Visitors are inactive by default
        } else {
            $sanitized['active'] = (int)$data['active'];
        }

        if (!isset($data['password_changed'])) {
            $sanitized['password_changed'] = 1;
        } else {
            $sanitized['password_changed'] = (int)$data['password_changed'];
        }

        if (!isset($data['type'])) {
            $sanitized['type'] = 2; // Visitors type
        } else {
            $sanitized['type'] = (int)$data['type'];
        }

        if (!isset($data['type_description'])) {
            $sanitized['type_description'] = 'Visitor';
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
     * Assign role to a visitor
     */
    private function assignRoleToVisitor(int $visitorId, int $roleId, string $operation = 'assign'): bool
    {
        try {
            $groupModel = new \Myth\Auth\Models\GroupModel();
            
            if ($operation === 'update') {
                // For updates, remove from all groups first to avoid duplicates
                $groupModel->removeUserFromAllGroups($visitorId);
            }
            
            // Add to the specified group
            $success = $groupModel->addUserToGroup($visitorId, $roleId);
            
            if ($success) {
                log_message('info', "Role {$roleId} {$operation}ed for visitor {$visitorId}");
                return true;
            } else {
                log_message('warning', "Failed to {$operation} role {$roleId} for visitor {$visitorId}");
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', "Role {$operation} failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Log visitor operations to the logs table
     */
    private function logVisitorOperation(string $action, array $visitorData, int $visitorId = null): void
    {
        try {
            log_message('info', 'logVisitorOperation called with action: ' . $action . ', visitorId: ' . $visitorId);
            
            $visitorNumber = $visitorId ?? ($visitorData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Visitor Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Visitor Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Visitor Deleted';
                    break;
                case 'password reset':
                    $logStatusId = 4; // Success status for password reset
                    $actionPrefix = 'Visitor Password Reset';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Visitor ' . ucfirst($action);
                    break;
            }
            
            // Get related information if not already included
            $sectionName = $visitorData['section_name'] ?? 'Unknown';
            $positionName = $visitorData['position_name'] ?? 'Unknown';
            $departmentName = $visitorData['department_name'] ?? 'Unknown';
            
            // If we don't have the related names, try to fetch them
            if ($sectionName === 'Unknown' && isset($visitorData['section_id'])) {
                $sectionModel = new \App\Models\SectionModel();
                $section = $sectionModel->find($visitorData['section_id']);
                $sectionName = $section['name'] ?? 'Unknown';
            }
            
            if ($positionName === 'Unknown' && isset($visitorData['position_id'])) {
                $positionModel = new \App\Models\PositionModel();
                $position = $positionModel->find($visitorData['position_id']);
                $positionName = $position['name'] ?? 'Unknown';
            }
            
            if ($departmentName === 'Unknown' && isset($visitorData['department_id'])) {
                $departmentModel = new \App\Models\DepartmentModel();
                $department = $departmentModel->find($visitorData['department_id']);
                $departmentName = $department['name'] ?? 'Unknown';
            }
            
            // Create structured action description in the requested format
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $visitorNumber . "\n";
            $actionDescription .= "Visitor No: " . ($visitorData['islander_no'] ?? 'Unknown') . "\n";
            $actionDescription .= "Name: " . ($visitorData['full_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Username: " . ($visitorData['username'] ?? 'N/A') . "\n";
            $actionDescription .= "Email: " . ($visitorData['email'] ?? 'N/A') . "\n";
            $actionDescription .= "Phone: " . ($visitorData['phone'] ?? 'N/A') . "\n";
            $actionDescription .= "Position: " . $positionName . "\n";
            $actionDescription .= "Section: " . $sectionName . "\n";
            $actionDescription .= "Department: " . $departmentName . "\n";
            $actionDescription .= "Division: " . ($visitorData['division_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Status: " . ($visitorData['status_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Gender: " . ($visitorData['gender_name'] ?? 'N/A') . "\n";
            $actionDescription .= "Nationality: " . ($visitorData['nationality_name'] ?? 'N/A') . "\n";
            $actionDescription .= "Date of Birth: " . ($visitorData['date_of_birth'] ?? 'N/A') . "\n";
            $actionDescription .= "Date of Joining: " . ($visitorData['date_of_joining'] ?? 'N/A') . "\n";
            $actionDescription .= "Company: " . ($visitorData['company'] ?? 'N/A') . "\n";
            $actionDescription .= "House: " . ($visitorData['house_name'] ?? 'N/A') . "\n";
            $actionDescription .= "ID/PP/WP No: " . ($visitorData['id_pp_wp_no'] ?? 'N/A') . "\n";
            $actionDescription .= "Address: " . ($visitorData['address'] ?? 'N/A') . "\n";
            $actionDescription .= "Notes: " . ($visitorData['notes'] ?? 'No notes provided');

            $logData = [
                'status_id' => $logStatusId,
                'module_id' => 13, // Visitors module ID (assuming different from islanders)
                'action' => $actionDescription,
            ];

            log_message('info', 'Attempting to insert visitor log data: ' . json_encode($logData));
            
            $result = $this->logModel->insert($logData);
            
            if ($result) {
                log_message('info', 'Successfully inserted visitor log with ID: ' . $result);
            } else {
                $errors = $this->logModel->errors();
                log_message('error', 'Failed to insert visitor log. Errors: ' . json_encode($errors));
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to log visitor operation: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of visitors
     */
    public function index()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = ($page - 1) * $limit;

        $visitors = $this->visitorModel->getVisitorsWithPagination($search, $limit, $offset);
        $totalVisitors = $this->visitorModel->getVisitorsCount($search);
        $totalPages = ceil($totalVisitors / $limit);

        // Check if this is an AJAX request for pagination
        if ($this->request->isAJAX() || $this->request->getGet('ajax')) {
            return $this->response->setJSON([
                'success' => true,
                'visitors' => $visitors,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'totalVisitors' => $totalVisitors,
                'hasMore' => ($offset + $limit) < $totalVisitors
            ]);
        }

        // Get active statuses for dropdown
        $statuses = $this->visitorModel->getActiveStatuses();
        
        // Get dropdown data
        $divisions = $this->visitorModel->getActiveDivisions();
        $departments = $this->visitorModel->getActiveDepartments();
        $sections = $this->visitorModel->getActiveSections();
        $positions = $this->visitorModel->getActivePositions();
        $genders = $this->visitorModel->getActiveGenders();
        $houses = $this->visitorModel->getActiveHouses();
        $nationalities = $this->visitorModel->getActiveNationalities();
        
        // Get auth groups for role dropdown
        $authGroupsModel = new \Myth\Auth\Models\GroupModel();
        $auth_groups = $authGroupsModel->findAll();

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('visitors.create') || has_permission('users.create'),
            'canEdit' => has_permission('visitors.edit') || has_permission('users.edit'),
            'canView' => has_permission('visitors.view') || has_permission('users.view'),
            'canDelete' => has_permission('visitors.delete') || has_permission('users.delete')
        ];

        $data = [
            'title' => 'Visitor Management',
            'visitors' => $visitors,
            'statuses' => $statuses,
            'divisions' => $divisions,
            'departments' => $departments,
            'sections' => $sections,
            'positions' => $positions,
            'genders' => $genders,
            'houses' => $houses,
            'nationalities' => $nationalities,
            'auth_groups' => $auth_groups,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalVisitors' => $totalVisitors,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('visitors/index', $data);
    }

    /**
     * Store a newly created visitor in database
     */
    public function store()
    {
        // Check if user has permission to create visitors
        if (!has_permission('visitors.create') && !has_permission('users.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create visitors.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create visitors.');
        }

        // Validate the input
        if (!$this->validate($this->visitorModel->getValidationRules())) {
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
        $data = $this->sanitizeVisitorInput($rawData, false);
        
        // Extract role_id for later use
        $roleId = isset($rawData['role_id']) ? (int)$rawData['role_id'] : null;

        // Insert the visitor
        if ($visitorId = $this->visitorModel->insert($data)) {
            try {
                // Handle image uploads after visitor is created
                $imagePaths = $this->handleVisitorImages($visitorId);
                
                // Update visitor with image paths if any were uploaded
                if (!empty($imagePaths)) {
                    $this->visitorModel->update($visitorId, $imagePaths);
                }
                
                // Get the full visitor data for logging
                $visitorData = $this->visitorModel->getVisitor($visitorId);
                
                // Assign role to the visitor if role_id is provided
                if ($roleId) {
                    $this->assignRoleToVisitor($visitorId, $roleId, 'assign');
                }
                
                // Log the create operation
                $this->logVisitorOperation('create', $visitorData, $visitorId);
                
            } catch (\Exception $e) {
                // If image upload fails, delete the created visitor record
                $this->visitorModel->delete($visitorId);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Visitor creation failed: ' . $e->getMessage()
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Visitor creation failed: ' . $e->getMessage());
            }
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Visitor created successfully!'
                ]);
            }
            return redirect()->to('/visitors')
                           ->with('success', 'Visitor created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create visitor. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create visitor. Please try again.');
        }
    }

    /**
     * Display the specified visitor (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view visitors
        if (!has_permission('visitors.view') && !has_permission('users.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view visitors.'
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
                'message' => 'Visitor ID is required.'
            ]);
        }

        $visitor = $this->visitorModel->getVisitor($id);

        if (!$visitor) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Visitor not found.'
            ]);
        }

        // Get the visitor's current role
        try {
            $groupModel = new \Myth\Auth\Models\GroupModel();
            $userGroups = $groupModel->getGroupsForUser($id);
            
            // Add role_id to visitor data (assuming user has only one role)
            $visitor['role_id'] = !empty($userGroups) ? $userGroups[0]['group_id'] : null;
        } catch (\Exception $e) {
            log_message('error', 'Failed to get user groups: ' . $e->getMessage());
            $visitor['role_id'] = null;
        }

        return $this->response->setJSON([
            'success' => true,
            'visitor' => $visitor
        ]);
    }

    /**
     * Update the specified visitor in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit visitors
        if (!has_permission('visitors.edit') && !has_permission('users.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit visitors.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit visitors.');
        }

        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Visitor ID is required.'
                ]);
            }
            return redirect()->to('/visitors')
                           ->with('error', 'Visitor ID is required.');
        }

        $visitor = $this->visitorModel->getVisitor($id);

        if (!$visitor) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Visitor not found.'
                ]);
            }
            return redirect()->to('/visitors')
                           ->with('error', 'Visitor not found.');
        }

        // Sanitize and validate the input
        $rawData = $this->request->getPost();
        $inputData = $this->sanitizeVisitorInput($rawData, true);
        
        // Extract role_id for later use
        $roleId = isset($rawData['role_id']) ? (int)$rawData['role_id'] : null;
        
        $validationResult = $this->visitorModel->validateForUpdate($inputData, $id);
        
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

        // Update the visitor
        try {
            // Handle image uploads first
            $imagePaths = $this->handleVisitorImages($id, $visitor['image'] ?? null, $visitor['cover_image'] ?? null);
            
            // Add image paths to update data if any were uploaded
            if (!empty($imagePaths)) {
                $data = array_merge($data, $imagePaths);
            }
            
            // Skip model validation since we already validated
            $this->visitorModel->skipValidation(true);
            $result = $this->visitorModel->update($id, $data);
            $this->visitorModel->skipValidation(false);
            
            if ($result) {
                // Get the updated visitor data for logging
                $updatedVisitor = $this->visitorModel->getVisitor($id);
                
                // Update role assignment if role_id is provided
                if ($roleId) {
                    $this->assignRoleToVisitor($id, $roleId, 'update');
                }
                
                // Log the update operation
                $this->logVisitorOperation('update', $updatedVisitor, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Visitor updated successfully!'
                    ]);
                }
                return redirect()->to('/visitors')
                               ->with('success', 'Visitor updated successfully!');
            } else {
                $errors = $this->visitorModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update visitor: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update visitor: ' . $errorMessage);
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
     * Remove the specified visitor from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete visitors
        if (!has_permission('visitors.delete') && !has_permission('users.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete visitors.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Visitor ID is required.'
            ]);
        }

        $visitor = $this->visitorModel->getVisitor($id);

        if (!$visitor) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Visitor not found.'
            ]);
        }

        // Delete the visitor
        if ($this->visitorModel->delete($id)) {
            // Clean up uploaded images
            if (!empty($visitor['image'])) {
                $this->deleteImage($visitor['image']);
            }
            if (!empty($visitor['cover_image'])) {
                $this->deleteImage($visitor['cover_image']);
            }
            
            // Log the delete operation
            $this->logVisitorOperation('delete', $visitor, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Visitor deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete visitor. Please try again.'
            ]);
        }
    }

    /**
     * Reset visitor password to 1234
     */
    public function resetPassword($id = null)
    {
        // Check if user has permission to edit visitors
        if (!has_permission('visitors.edit') && !has_permission('users.edit')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to reset passwords.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Visitor ID is required.'
            ]);
        }

        $visitor = $this->visitorModel->getVisitor($id);

        if (!$visitor) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Visitor not found.'
            ]);
        }

        // Prepare data for password reset
        $data = [
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            'password_changed' => 1,
            'updated_by' => $this->getCurrentUserId()
        ];

        // Update the visitor's password
        try {
            $this->visitorModel->skipValidation(true);
            $result = $this->visitorModel->update($id, $data);
            $this->visitorModel->skipValidation(false);
            
            if ($result) {
                // Log the password reset operation
                $logData = array_merge($visitor, ['action' => 'password_reset']);
                $this->logVisitorOperation('password reset', $logData, $id);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Password reset successfully to 1234!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to reset password. Please try again.'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Password reset failed: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get visitors for AJAX requests
     */
    public function getVisitors()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $visitors = $this->visitorModel->getVisitorsWithPagination($search, $limit, $offset);
        $totalVisitors = $this->visitorModel->getVisitorsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $visitors,
            'total' => $totalVisitors
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

        $statuses = $this->visitorModel->getActiveStatuses();

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

        $visitors = $this->visitorModel->getVisitorsWithPagination($search, $limit, $offset);
        $totalVisitors = $this->visitorModel->getVisitorsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $visitors,
            'total' => $totalVisitors,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalVisitors
        ]);
    }

    /**
     * Handle image upload
     */
    private function handleImageUpload($file, $fieldName, $visitorId = null)
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
            $uploadDir = 'assets/media/visitors_cover/';
        } else {
            $uploadDir = 'uploads/visitors/';
        }

        // Create upload directory if it doesn't exist
        $uploadPath = FCPATH . $uploadDir;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Generate unique filename
        $extension = $file->getClientExtension();
        $fileName = $fieldName . '_' . ($visitorId ?: uniqid()) . '_' . time() . '.' . $extension;

        // Move file to upload directory
        if ($file->move($uploadPath, $fileName)) {
            return $fileName;
        }

        throw new \Exception('Failed to upload file.');
    }

    /**
     * Delete image file
     */
    private function deleteImage($imagePath)
    {
        if (empty($imagePath)) {
            return;
        }

        // If imagePath is just a filename, construct the full path
        if (strpos($imagePath, '/') === false) {
            if (strpos($imagePath, 'profile_') === 0) {
                $fullPath = FCPATH . 'assets/media/users/' . $imagePath;
            } elseif (strpos($imagePath, 'cover_') === 0) {
                $fullPath = FCPATH . 'assets/media/visitors_cover/' . $imagePath;
            } else {
                $fullPath = FCPATH . 'uploads/visitors/' . $imagePath;
            }
        } else {
            $fullPath = FCPATH . $imagePath;
        }

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    /**
     * Handle multiple image uploads for a visitor
     */
    private function handleVisitorImages($visitorId, $oldImagePath = null, $oldCoverImagePath = null)
    {
        $imagePaths = [];

        // Handle profile image
        $imageFile = $this->request->getFile('image') ?: $this->request->getFile('profile_image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            try {
                if ($oldImagePath) {
                    $this->deleteImage($oldImagePath);
                }
                
                $imagePaths['image'] = $this->handleImageUpload($imageFile, 'profile', $visitorId);
            } catch (\Exception $e) {
                log_message('error', 'Profile image upload failed: ' . $e->getMessage());
                throw new \Exception('Profile image upload failed: ' . $e->getMessage());
            }
        }

        // Handle cover image
        $coverImageFile = $this->request->getFile('cover_image');
        if ($coverImageFile && $coverImageFile->isValid() && !$coverImageFile->hasMoved()) {
            try {
                if ($oldCoverImagePath) {
                    $this->deleteImage($oldCoverImagePath);
                }
                
                $imagePaths['cover_image'] = $this->handleImageUpload($coverImageFile, 'cover', $visitorId);
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

    /**
     * Check if islander number is available
     */
    public function checkIslanderNumber()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $islanderNo = $this->request->getPost('islander_no');
        
        if (empty($islanderNo)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Islander number is required'
            ]);
        }

        // Check if islander number already exists in users table
        $existingUser = $this->visitorModel
            ->where('islander_no', $islanderNo)
            ->where('deleted_at IS NULL')
            ->first();

        return $this->response->setJSON([
            'success' => true,
            'available' => !$existingUser,
            'message' => $existingUser ? 'Islander number already exists' : 'Islander number is available'
        ]);
    }

    /**
     * Enrol visitor as islander
     */
    public function enrolAsIslander($id = null)
    {
        // Check if user has permission to edit visitors
        if (!has_permission('visitors.edit') && !has_permission('users.edit')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to enrol visitors.'
            ]);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Visitor ID is required.'
            ]);
        }

        $islanderNo = $this->request->getPost('islander_no');
        
        if (empty($islanderNo)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Islander number is required'
            ]);
        }

        // Get the visitor
        $visitor = $this->visitorModel->find($id);
        if (!$visitor) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Visitor not found.'
            ]);
        }

        // Check if visitor is already an islander
        if ($visitor['type'] == 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'This person is already an islander.'
            ]);
        }

        // Double-check islander number availability
        $existingUser = $this->visitorModel
            ->where('islander_no', $islanderNo)
            ->where('deleted_at IS NULL')
            ->first();

        if ($existingUser) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Islander number already exists.'
            ]);
        }

        // Prepare update data
        $updateData = [
            'islander_no' => $islanderNo,
            'username' => $islanderNo,
            'type' => 1, // Islander type
            'type_description' => 'Islander',
            'password_changed' => 1,
            'has_accepted_agreement' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => user_id()
        ];

        // Update the visitor record
        if ($this->visitorModel->update($id, $updateData)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => "Visitor successfully enrolled as Islander {$islanderNo}"
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to enrol visitor as islander'
            ]);
        }
    }
}