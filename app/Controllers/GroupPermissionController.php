<?php

namespace App\Controllers;

use App\Models\GroupPermissionModel;
use CodeIgniter\HTTP\RedirectResponse;

class GroupPermissionController extends BaseController
{
    protected $groupPermissionModel;
    protected $logModel;

    public function __construct()
    {
        $this->groupPermissionModel = new GroupPermissionModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Log group permission operations to the logs table
     */
    private function logGroupPermissionOperation(string $action, array $data, int $groupId = null): void
    {
        try {
            log_message('info', 'logGroupPermissionOperation called with action: ' . $action);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'assigned':
                case 'assign':
                    $logStatusId = 3; // Success status for assign
                    $actionPrefix = 'Group Permissions Assigned';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Group Permissions Updated';
                    break;
                case 'removed':
                case 'remove':
                    $logStatusId = 5; // Warning status for remove
                    $actionPrefix = 'Group Permissions Removed';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Group Permission ' . ucfirst($action);
                    break;
            }
            
            // Create structured action description
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "Group: " . ($data['group_name'] ?? 'Unknown') . " (ID: " . ($groupId ?? 'N/A') . ")\n";
            $actionDescription .= "Permissions Count: " . ($data['permission_count'] ?? 0) . "\n";
            $actionDescription .= "Details:\n";
            $actionDescription .= ($data['details'] ?? 'No additional details provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 1, // System module ID
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
            log_message('error', 'Failed to log group permission operation: ' . $e->getMessage());
        }
    }

    /**
     * Display group permission management interface
     */
    public function index()
    {
        // Debug logging
        log_message('info', 'GroupPermissionController::index() called');
        log_message('info', 'Current user session: ' . json_encode(session()->get()));
        
        // Check if user has permission to view group permissions
        // Using system.admin permission for now since permissions.view might not be recognized yet
        if (!has_permission('system.admin') && !has_permission('permissions.view')) {
            log_message('info', 'User does not have system.admin or permissions.view permission - redirecting');
            return redirect()->to('/')->with('error', 'You do not have permission to view group permissions.');
        }
        
        log_message('info', 'User has required permissions - proceeding');

        // Get selected group from query parameter
        $selectedGroupId = (int)($this->request->getGet('group') ?? 0);

        // Get all groups for dropdown
        $groups = $this->groupPermissionModel->getAllGroups();
        
        // Get all permissions grouped by module
        $permissionsGrouped = $this->groupPermissionModel->getAllPermissionsGrouped();
        
        // Get assigned permissions for selected group
        $assignedPermissionIds = [];
        $selectedGroup = null;
        if ($selectedGroupId > 0) {
            $assignedPermissionIds = $this->groupPermissionModel->getGroupPermissionIds($selectedGroupId);
            $selectedGroup = array_filter($groups, function($group) use ($selectedGroupId) {
                return $group['id'] == $selectedGroupId;
            });
            $selectedGroup = $selectedGroup ? array_values($selectedGroup)[0] : null;
        }

        // Get groups with permission counts for mobile view
        $groupsWithCounts = $this->groupPermissionModel->getGroupsWithPermissionCounts();

        // Check user permissions for buttons
        $permissions = [
            'canView' => has_permission('permissions.view'),
            'canEdit' => has_permission('permissions.edit'),
            'canAssign' => has_permission('permissions.edit') // Same as edit for assigning permissions
        ];

        $data = [
            'title' => 'Group Permissions Management',
            'groups' => $groups,
            'groupsWithCounts' => $groupsWithCounts,
            'permissionsGrouped' => $permissionsGrouped,
            'selectedGroupId' => $selectedGroupId,
            'selectedGroup' => $selectedGroup,
            'assignedPermissionIds' => $assignedPermissionIds,
            'permissions' => $permissions
        ];

        log_message('info', 'About to return view with data: ' . json_encode(['groups_count' => count($groups), 'permissions_count' => count($permissionsGrouped)]));
        return view('group_permissions/index', $data);
    }

    /**
     * Update group permissions
     */
    public function update()
    {
        // Check if user has permission to edit group permissions
        // Using system.admin permission for now since permissions.edit might not be recognized yet
        if (!has_permission('system.admin') && !has_permission('permissions.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit group permissions.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit group permissions.');
        }

        $groupId = (int)$this->request->getPost('group_id');
        $permissionIds = $this->request->getPost('permissions') ?? [];

        // Debug logging
        log_message('info', 'Group Permission update called. Group ID: ' . $groupId);
        log_message('info', 'Permission IDs: ' . json_encode($permissionIds));

        if ($groupId <= 0) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Please select a valid group.'
                ]);
            }
            return redirect()->back()->with('error', 'Please select a valid group.');
        }

        // Ensure permission IDs are integers
        $permissionIds = array_map('intval', array_filter($permissionIds, 'is_numeric'));

        try {
            // Get group info for logging
            $groups = $this->groupPermissionModel->getAllGroups();
            $selectedGroup = array_filter($groups, function($group) use ($groupId) {
                return $group['id'] == $groupId;
            });
            $groupName = $selectedGroup ? array_values($selectedGroup)[0]['name'] : 'Unknown';

            // Update group permissions
            $result = $this->groupPermissionModel->updateGroupPermissions($groupId, $permissionIds);

            if ($result) {
                // Log the operation
                $logData = [
                    'group_name' => $groupName,
                    'permission_count' => count($permissionIds),
                    'details' => 'Updated permissions for group: ' . $groupName . 
                               '. Assigned ' . count($permissionIds) . ' permissions.'
                ];
                $this->logGroupPermissionOperation('update', $logData, $groupId);

                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Group permissions updated successfully!',
                        'assigned_count' => count($permissionIds)
                    ]);
                }

                return redirect()->to('/group-permissions?group=' . $groupId)
                               ->with('success', 'Group permissions updated successfully!');
            } else {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update group permissions. Please try again.'
                    ]);
                }

                return redirect()->back()
                               ->with('error', 'Failed to update group permissions. Please try again.');
            }

        } catch (\Exception $e) {
            log_message('error', 'Error updating group permissions: ' . $e->getMessage());

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ]);
            }

            return redirect()->back()
                           ->with('error', 'Database error: ' . $e->getMessage());
        }
    }

    /**
     * Get group permissions via AJAX
     */
    public function getGroupPermissions($groupId)
    {
        // Only allow AJAX requests
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        if (!has_permission('permissions.view')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view group permissions.'
            ]);
        }

        $assignedPermissionIds = $this->groupPermissionModel->getGroupPermissionIds($groupId);
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $assignedPermissionIds
        ]);
    }

    /**
     * API endpoint for mobile interface
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

        if (!has_permission('permissions.view')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view group permissions.'
            ]);
        }

        $groupsWithCounts = $this->groupPermissionModel->getGroupsWithPermissionCounts();

        return $this->response->setJSON([
            'success' => true,
            'data' => $groupsWithCounts
        ]);
    }

    /**
     * Get permission statistics
     */
    public function stats($groupId = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        if (!has_permission('permissions.view')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view permission statistics.'
            ]);
        }

        $stats = $this->groupPermissionModel->getGroupPermissionStats($groupId);

        return $this->response->setJSON([
            'success' => true,
            'stats' => $stats
        ]);
    }
}