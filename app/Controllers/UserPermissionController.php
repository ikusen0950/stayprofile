<?php

namespace App\Controllers;

use App\Models\UserPermissionModel;
use CodeIgniter\HTTP\RedirectResponse;

class UserPermissionController extends BaseController
{
    protected $userPermissionModel;
    protected $logModel;

    public function __construct()
    {
        $this->userPermissionModel = new UserPermissionModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Log user permission operations to the logs table
     */
    private function logUserPermissionOperation(string $action, array $data, int $userId = null): void
    {
        try {
            log_message('info', 'logUserPermissionOperation called with action: ' . $action);

            // Use default module ID for User Management (or 1 as fallback)
            $moduleId = 1; // Default module ID

            // Determine action prefix based on action type
            switch (strtolower($action)) {
                case 'assign':
                case 'create':
                    $actionPrefix = 'User Permissions Assigned';
                    $statusId = 2; // Created status
                    break;
                case 'update':
                case 'edit':
                    $actionPrefix = 'User Permissions Updated';
                    $statusId = 4; // Updated status
                    break;
                case 'remove':
                case 'delete':
                    $actionPrefix = 'User Permissions Removed';
                    $statusId = 5; // Deleted status
                    break;
                default:
                    $actionPrefix = 'User Permission ' . ucfirst($action);
                    $statusId = 4; // Default to updated status
                    break;
            }

            // Build action description
            $actionDescription = $actionPrefix;
            if ($userId) {
                $actionDescription .= "\nUser ID: " . $userId;
            }
            $actionDescription .= "\nPermissions Count: " . ($data['permission_count'] ?? 0) . "\n";
            
            if (!empty($data['details'])) {
                $actionDescription .= "Details:\n" . $data['details'];
            }

            log_message('info', 'Mapped status ID: ' . $statusId . ' for action: ' . $action);

            $logData = [
                'status_id' => $statusId,
                'module_id' => $moduleId,
                'action' => $actionDescription
            ];

            log_message('info', 'Attempting to insert log data: ' . json_encode($logData));

            if ($this->logModel->insert($logData)) {
                $insertId = $this->logModel->getInsertID();
                log_message('info', 'Successfully inserted log with ID: ' . $insertId);
            } else {
                log_message('error', 'Failed to insert log data');
            }

        } catch (\Exception $e) {
            log_message('error', 'Failed to log user permission operation: ' . $e->getMessage());
        }
    }

    /**
     * Display user permission management interface
     */
    public function index()
    {
        // Debug logging
        log_message('info', 'UserPermissionController::index() called');
        log_message('info', 'Current user session: ' . json_encode(session()->get()));
        
        // Check if user has permission to view user permissions
        // Using system.admin permission for now since permissions.view might not be recognized yet
        if (!has_permission('system.admin') && !has_permission('permissions.view')) {
            log_message('info', 'User does not have system.admin or permissions.view permission - redirecting');
            return redirect()->to('/')->with('error', 'You do not have permission to view user permissions.');
        }
        
        log_message('info', 'User has required permissions - proceeding');

        // Get selected user from query parameter
        $selectedUserId = (int)($this->request->getGet('user') ?? 0);

        // Get all users for dropdown
        $users = $this->userPermissionModel->getAllUsers();
        
        // Get all permissions grouped by module
        $permissionsGrouped = $this->userPermissionModel->getAllPermissionsGrouped();
        
        // Get assigned permissions for selected user
        $assignedPermissionIds = [];
        $selectedUser = null;
        if ($selectedUserId > 0) {
            $assignedPermissionIds = $this->userPermissionModel->getUserPermissionIds($selectedUserId);
            $selectedUser = $this->userPermissionModel->getUserById($selectedUserId);
        }

        // Get users with permission counts for mobile view
        $usersWithCounts = $this->userPermissionModel->getUsersWithPermissionCounts();

        // Check user permissions for buttons
        $permissions = [
            'canView' => has_permission('permissions.view'),
            'canEdit' => has_permission('permissions.edit'),
            'canAssign' => has_permission('permissions.edit') // Same as edit for assigning permissions
        ];

        $data = [
            'title' => 'User Permissions Management',
            'users' => $users,
            'usersWithCounts' => $usersWithCounts,
            'permissionsGrouped' => $permissionsGrouped,
            'selectedUserId' => $selectedUserId,
            'selectedUser' => $selectedUser,
            'assignedPermissionIds' => $assignedPermissionIds,
            'permissions' => $permissions
        ];

        log_message('info', 'About to return view with data: ' . json_encode(['users_count' => count($users), 'permissions_count' => count($permissionsGrouped)]));
        return view('user_permissions/index', $data);
    }

    /**
     * Update user permissions
     */
    public function update()
    {
        // Check if user has permission to edit user permissions
        // Using system.admin permission for now since permissions.edit might not be recognized yet
        if (!has_permission('system.admin') && !has_permission('permissions.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit user permissions.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit user permissions.');
        }

        $userId = (int)$this->request->getPost('user_id');
        $permissionIds = $this->request->getPost('permissions') ?? [];

        // Debug logging
        log_message('info', 'User Permission update called. User ID: ' . $userId);
        log_message('info', 'Permission IDs: ' . json_encode($permissionIds));

        if ($userId <= 0) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Please select a valid user.'
                ]);
            }
            return redirect()->back()->with('error', 'Please select a valid user.');
        }

        // Ensure permission IDs are integers and validate them
        $permissionIds = array_map('intval', array_filter($permissionIds, 'is_numeric'));
        $validPermissionIds = $this->userPermissionModel->validatePermissionIds($permissionIds);

        try {
            // Get user details for logging
            $user = $this->userPermissionModel->getUserById($userId);
            $userName = $user ? $user['display_name'] : "User ID: $userId";

            // Update user permissions
            $result = $this->userPermissionModel->updateUserPermissions($userId, $validPermissionIds);

            if ($result) {
                // Log the operation
                $this->logUserPermissionOperation('update', [
                    'permission_count' => count($validPermissionIds),
                    'details' => 'Updated permissions for user: ' . $userName . 
                                '. Assigned ' . count($validPermissionIds) . ' permissions.'
                ], $userId);

                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'User permissions updated successfully!',
                        'assigned_count' => count($validPermissionIds)
                    ]);
                }

                return redirect()->to('/user-permissions?user=' . $userId)
                               ->with('success', 'User permissions updated successfully!');
            } else {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update user permissions. Please try again.'
                    ]);
                }

                return redirect()->back()
                               ->with('error', 'Failed to update user permissions. Please try again.');
            }

        } catch (\Exception $e) {
            log_message('error', 'Error updating user permissions: ' . $e->getMessage());
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'An error occurred while updating permissions. Please try again.'
                ]);
            }

            return redirect()->back()
                           ->with('error', 'An error occurred while updating permissions. Please try again.');
        }
    }

    /**
     * API endpoint for user permissions data
     */
    public function api()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(404);
        }

        // Check permissions
        if (!has_permission('system.admin') && !has_permission('permissions.view')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ]);
        }

        try {
            $userId = (int)$this->request->getGet('user_id');
            
            if ($userId > 0) {
                $assignedPermissionIds = $this->userPermissionModel->getUserPermissionIds($userId);
                $user = $this->userPermissionModel->getUserById($userId);
                
                return $this->response->setJSON([
                    'success' => true,
                    'user' => $user,
                    'assigned_permissions' => $assignedPermissionIds,
                    'permission_count' => count($assignedPermissionIds)
                ]);
            }

            $users = $this->userPermissionModel->getUsersWithPermissionCounts();
            
            return $this->response->setJSON([
                'success' => true,
                'users' => $users
            ]);

        } catch (\Exception $e) {
            log_message('error', 'API error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while fetching data.'
            ]);
        }
    }
}