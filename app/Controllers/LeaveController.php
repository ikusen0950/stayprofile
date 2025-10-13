<?php

namespace App\Controllers;

use App\Models\LeaveModel;
use CodeIgniter\HTTP\RedirectResponse;

class LeaveController extends BaseController
{
    protected $leaveModel;
    protected $logModel;

    public function __construct()
    {
        $this->leaveModel = new LeaveModel();
        $this->logModel = new \App\Models\LogModel();
    }

    private function sanitizeLeaveInput(array $data): array
    {
        $sanitized = [
            'name' => isset($data['name']) ? trim(strip_tags($data['name'])) : '',
            'module_id' => isset($data['module_id']) ? (int)$data['module_id'] : 0,
            'status_id' => isset($data['status_id']) ? (int)$data['status_id'] : null,
            'description' => isset($data['description']) ? trim(strip_tags($data['description'], '<p><br><strong><em><ul><ol><li>')) : '',
        ];
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
     * Log leave operations to the logs table
     */
    private function logLeaveOperation(string $action, array $leaveData, int $leaveId = null): void
    {
        try {
            log_message('info', 'logLeaveOperation called with action: ' . $action . ', leaveId: ' . $leaveId);
            $leaveNumber = $leaveId ?? ($leaveData['id'] ?? 0);
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Leave Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Leave Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Leave Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Leave ' . ucfirst($action);
                    break;
            }
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            // Create structured action description
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $leaveNumber . "\n";
            $actionDescription .= "Module: " . ($leaveData['module_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Name: " . ($leaveData['name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($leaveData['description'] ?? 'No description provided');
            $logData = [
                'status_id' => $logStatusId,
                'module_id' => 17, // Leave module ID (adjust as needed)
                'action' => $actionDescription,
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
            log_message('error', 'Failed to log leave operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of leaves
     */
    public function index()
    {
        // Check if user has permission to view leaves
        if (!has_permission('leave.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view leaves.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $leaves = $this->leaveModel->getLeavesWithPagination($search, $limit, $offset);
        $totalLeaves = $this->leaveModel->getLeavesCount($search);
        $totalPages = ceil($totalLeaves / $limit);

        // Get active modules for dropdown (if needed)
        $modules = method_exists($this->leaveModel, 'getActiveModules') ? $this->leaveModel->getActiveModules() : [];

        // Get statuses for module_id = 1
        $statusModel = new \App\Models\StatusModel();
        $statuses = $statusModel->getStatusByModule(1);

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('leave.create'),
            'canEdit' => has_permission('leave.edit'),
            'canView' => has_permission('leave.view'),
            'canDelete' => has_permission('leave.delete')
        ];

        $data = [
            'title' => 'Leave Management',
            'leaves' => $leaves,
            'modules' => $modules,
            'statuses' => $statuses,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalLeaves' => $totalLeaves,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('leave/index', $data);
    }

    /**
     * Store a newly created leave in database
     */
    public function store()
    {
        // Check if user has permission to create leave
        if (!has_permission('leave.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create leave.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create leave.');
        }

        // Validate the input
        if (method_exists($this->leaveModel, 'getValidationRules') && !$this->validate($this->leaveModel->getValidationRules())) {
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
        $data = $this->sanitizeLeaveInput($rawData);

        // Insert the leave
        if ($leaveId = $this->leaveModel->insert($data)) {
            // Get the full leave data for logging
            $leaveData = method_exists($this->leaveModel, 'getLeave') ? $this->leaveModel->getLeave($leaveId) : $this->leaveModel->find($leaveId);
            $this->logLeaveOperation('create', $leaveData, $leaveId);

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Leave created successfully!'
                ]);
            }
            return redirect()->to('/leave')
                           ->with('success', 'Leave created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create leave. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create leave. Please try again.');
        }
    }

    /**
     * Display the specified leave (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view leave
        if (!has_permission('leave.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view leave.'
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
                'message' => 'Leave ID is required.'
            ]);
        }

        $leave = method_exists($this->leaveModel, 'getLeave') ? $this->leaveModel->getLeave($id) : $this->leaveModel->find($id);

        if (!$leave) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Leave not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $leave
        ]);
    }

    /**
     * Update the specified leave in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit leave
        if (!has_permission('leave.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit leave.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit leave.');
        }

        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Leave ID is required.'
                ]);
            }
            return redirect()->to('/leave')
                           ->with('error', 'Leave ID is required.');
        }

        $leave = method_exists($this->leaveModel, 'getLeave') ? $this->leaveModel->getLeave($id) : $this->leaveModel->find($id);

        if (!$leave) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Leave not found.'
                ]);
            }
            return redirect()->to('/leave')
                           ->with('error', 'Leave not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = $this->request->getPost();
        $inputData = $this->sanitizeLeaveInput($rawData);

        $validationResult = method_exists($this->leaveModel, 'validateForUpdate') ? $this->leaveModel->validateForUpdate($inputData, $id) : true;

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

        // Update the leave
        try {
            if (method_exists($this->leaveModel, 'skipValidation')) {
                $this->leaveModel->skipValidation(true);
            }
            $result = $this->leaveModel->update($id, $data);
            if (method_exists($this->leaveModel, 'skipValidation')) {
                $this->leaveModel->skipValidation(false);
            }

            if ($result) {
                // Get the updated leave data for logging
                $updatedLeave = method_exists($this->leaveModel, 'getLeave') ? $this->leaveModel->getLeave($id) : $this->leaveModel->find($id);
                $this->logLeaveOperation('update', $updatedLeave, $id);

                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Leave updated successfully!'
                    ]);
                }
                return redirect()->to('/leave')
                               ->with('success', 'Leave updated successfully!');
            } else {
                // Get model errors if any
                $errors = method_exists($this->leaveModel, 'errors') ? $this->leaveModel->errors() : [];
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';

                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update leave: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update leave: ' . $errorMessage);
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
     * Remove the specified leave from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete leave
        if (!has_permission('leave.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete leave.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Leave ID is required.'
            ]);
        }

        $leave = method_exists($this->leaveModel, 'getLeave') ? $this->leaveModel->getLeave($id) : $this->leaveModel->find($id);

        if (!$leave) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Leave not found.'
            ]);
        }

        // Delete the leave
        if ($this->leaveModel->delete($id)) {
            $this->logLeaveOperation('delete', $leave, $id);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Leave deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete leave. Please try again.'
            ]);
        }
    }

    /**
     * Get leaves for AJAX requests
     */
    public function getLeaves()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $leaves = $this->leaveModel->getLeavesWithPagination($search, $limit, $offset);
        $totalLeaves = $this->leaveModel->getLeavesCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $leaves,
            'total' => $totalLeaves
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

        $leaves = $this->leaveModel->getLeavesWithPagination($search, $limit, $offset);
        $totalLeaves = $this->leaveModel->getLeavesCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $leaves,
            'total' => $totalLeaves,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalLeaves
        ]);
    }

    /**
     * Get modules for dropdown (AJAX)
     */
    public function getModules()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $modules = method_exists($this->leaveModel, 'getActiveModules') ? $this->leaveModel->getActiveModules() : [];

        return $this->response->setJSON([
            'success' => true,
            'data' => $modules
        ]);
    }
}
