<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\LogModel;
use Myth\Auth\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class NotificationsController extends BaseController
{
    protected $notificationModel;
    protected $userModel;
    protected $logModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
        $this->userModel = new UserModel();
        $this->logModel = new LogModel();
        
        // Load FCM helper for push notifications
        helper('fcm');
    }

    /**
     * Get user display name with fallback handling
     */
    private function getUserDisplayName(array $user): string
    {
        if (!empty($user['full_name'])) {
            return $user['full_name'];
        } elseif (!empty($user['islander_no'])) {
            return $user['islander_no'];
        } else {
            return 'Unknown User';
        }
    }

    /**
     * Sanitize input data for notification
     */
    private function sanitizeNotificationInput(array $data): array
    {
        $sanitized = [
            'user_id' => isset($data['user_id']) ? (int)$data['user_id'] : 0,
            'title' => isset($data['title']) ? trim(strip_tags($data['title'])) : '',
            'body' => isset($data['body']) ? 
                trim(strip_tags($data['body'], '<p><br><strong><em><ul><ol><li>')) : '',
            'url' => isset($data['url']) ? trim(strip_tags($data['url'])) : '',
            'status_id' => isset($data['status_id']) ? (int)$data['status_id'] : 1,
        ];

        // Add created_at if present
        if (isset($data['created_at'])) {
            $sanitized['created_at'] = $data['created_at'];
        }

        return $sanitized;
    }

    /**
     * Log notification operations to the logs table
     */
    private function logNotificationOperation(string $action, array $notificationData, int $notificationId = null): void
    {
        try {
            log_message('info', 'logNotificationOperation called with action: ' . $action . ', notificationId: ' . $notificationId);
            
            $notificationNumber = $notificationId ?? ($notificationData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Notification Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Notification Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Notification Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Notification ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $notificationNumber . "\n";
            $actionDescription .= "User: " . ($notificationData['user_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Title: " . ($notificationData['title'] ?? 'Unknown') . "\n";
            $actionDescription .= "Body:\n";
            $actionDescription .= ($notificationData['body'] ?? 'No body provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 6, // Notifications module ID (assuming we'll create this)
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
            log_message('error', 'Failed to log notification operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Display a listing of notifications
     */
    public function index()
    {
        // Check if user has permission to view notifications
        if (!has_permission('notifications.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view notifications.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = ($page - 1) * $limit;

        $notifications = $this->notificationModel->getNotificationsWithPagination($search, $limit, $offset);
        $totalNotifications = $this->notificationModel->getNotificationsCount($search);
        $totalPages = ceil($totalNotifications / $limit);

        // Check if this is an AJAX request for pagination
        if ($this->request->isAJAX() || $this->request->getGet('ajax')) {
            return $this->response->setJSON([
                'success' => true,
                'notifications' => $notifications,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'totalNotifications' => $totalNotifications,
                'hasMore' => ($offset + $limit) < $totalNotifications
            ]);
        }

        // Get active users and status for dropdowns
        $users = $this->notificationModel->getActiveUsers();
        $statuses = $this->notificationModel->getActiveStatus();

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('notifications.create'),
            'canEdit' => has_permission('notifications.edit'),
            'canView' => has_permission('notifications.view'),
            'canDelete' => has_permission('notifications.delete')
        ];

        $data = [
            'title' => 'Notification Management',
            'notifications' => $notifications,
            'users' => $users,
            'statuses' => $statuses,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalNotifications' => $totalNotifications,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('notifications/index', $data);
    }

    /**
     * Store a newly created notification in database
     */
    public function store()
    {
        // Check if user has permission to create notifications
        if (!has_permission('notifications.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create notifications.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create notifications.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Notification store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Validate the input
        if (!$this->validate($this->notificationModel->getValidationRules())) {
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
            'user_id' => $this->request->getPost('user_id'),
            'title' => $this->request->getPost('title'),
            'body' => $this->request->getPost('body'),
            'url' => $this->request->getPost('url'),
            'status_id' => $this->request->getPost('status_id')
        ];
        $data = $this->sanitizeNotificationInput($rawData);

        // Insert the notification
        if ($notificationId = $this->notificationModel->insert($data)) {
            // Get the full notification data for logging
            $notificationData = $this->notificationModel->getNotification($notificationId);
            
            // Log the create operation
            $this->logNotificationOperation('create', $notificationData, $notificationId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Notification created successfully!'
                ]);
            }
            return redirect()->to('/notifications')
                           ->with('success', 'Notification created successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create notification. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create notification. Please try again.');
        }
    }

    /**
     * Display the specified notification (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view notifications
        if (!has_permission('notifications.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view notifications.'
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
                'message' => 'Notification ID is required.'
            ]);
        }

        $notification = $this->notificationModel->getNotification($id);

        if (!$notification) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Notification not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $notification
        ]);
    }

    /**
     * Update the specified notification in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit notifications
        if (!has_permission('notifications.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit notifications.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit notifications.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Notification update called for ID: ' . $id . '. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Notification ID is required.'
                ]);
            }
            return redirect()->to('/notifications')
                           ->with('error', 'Notification ID is required.');
        }

        $notification = $this->notificationModel->getNotification($id);

        if (!$notification) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Notification not found.'
                ]);
            }
            return redirect()->to('/notifications')
                           ->with('error', 'Notification not found.');
        }

        // Sanitize and validate the input using model's custom validation for updates
        $rawData = [
            'user_id' => $this->request->getPost('user_id'),
            'title' => $this->request->getPost('title'),
            'body' => $this->request->getPost('body'),
            'url' => $this->request->getPost('url'),
            'status_id' => $this->request->getPost('status_id')
        ];
        $inputData = $this->sanitizeNotificationInput($rawData);
        
        $validationResult = $this->notificationModel->validateForUpdate($inputData, $id);
        
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

        // Update the notification
        try {
            // Skip model validation since we already validated
            $this->notificationModel->skipValidation(true);
            $result = $this->notificationModel->update($id, $data);
            $this->notificationModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Get the updated notification data for logging
                $updatedNotification = $this->notificationModel->getNotification($id);
                
                // Log the update operation
                $this->logNotificationOperation('update', $updatedNotification, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Notification updated successfully!'
                    ]);
                }
                return redirect()->to('/notifications')
                               ->with('success', 'Notification updated successfully!');
            } else {
                // Get model errors if any
                $errors = $this->notificationModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update notification: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update notification: ' . $errorMessage);
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
     * Remove the specified notification from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete notifications
        if (!has_permission('notifications.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete notifications.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Notification ID is required.'
            ]);
        }

        $notification = $this->notificationModel->getNotification($id);

        if (!$notification) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Notification not found.'
            ]);
        }

        // Delete the notification
        if ($this->notificationModel->delete($id)) {
            // Log the delete operation
            $this->logNotificationOperation('delete', $notification, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Notification deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete notification. Please try again.'
            ]);
        }
    }

    /**
     * Get recipient statistics for bulk notifications
     */
    public function recipientStats()
    {
        // Check if user has permission to send notifications
        if (!has_permission('notifications.send')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to access recipient statistics.'
            ]);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        try {
            $stats = $this->notificationModel->getRecipientStats();
            
            return $this->response->setJSON([
                'success' => true,
                'total_users' => $stats['total_users'],
                'users_with_tokens' => $stats['users_with_tokens'],
                'delivery_rate' => $stats['delivery_rate']
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error getting recipient stats: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to load recipient statistics.'
            ]);
        }
    }

    /**
     * Send bulk notification to all active users with device tokens
     */
    public function sendBulk()
    {
        // Check if user has permission to send notifications
        if (!has_permission('notifications.send')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to send bulk notifications.'
            ]);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $startTime = microtime(true);

        // Validate input
        $rules = [
            'title' => 'required|min_length[1]|max_length[100]',
            'body' => 'required|min_length[1]|max_length[500]',
            'url' => 'permit_empty|valid_url',
            'delivery_type' => 'required|in_list[immediate,scheduled]',
            'scheduled_at' => 'permit_empty|valid_date'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
                'message' => 'Validation failed.'
            ]);
        }

        $title = trim(strip_tags($this->request->getPost('title')));
        $body = trim(strip_tags($this->request->getPost('body')));
        $url = trim(strip_tags($this->request->getPost('url') ?? ''));
        $deliveryType = $this->request->getPost('delivery_type');
        $scheduledAt = $this->request->getPost('scheduled_at');

        try {
            // Get all active users with device tokens
            $users = $this->notificationModel->getActiveUsersWithTokens();
            
            if (empty($users)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No active users with device tokens found.'
                ]);
            }

            $sentCount = 0;
            $failedCount = 0;
            $results = [];

            // Load Firebase helper
            helper('firebase');

            foreach ($users as $user) {
                try {
                    // Create notification record for each user
                    $notificationData = [
                        'user_id' => $user['id'],
                        'title' => $title,
                        'body' => $body,
                        'url' => $url,
                        'status_id' => 1, // Active
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    // Insert notification record
                    $notificationId = $this->notificationModel->insert($notificationData);

                    if ($deliveryType === 'immediate') {
                        // Send FCM notification immediately
                        $fcmResult = send_fcm_push(
                            $user['device_token'],
                            $title,
                            $body,
                            $url ?? null,
                            $user['id'],
                            $notificationId
                        );

                        if ($fcmResult['status'] === 'success') {
                            $sentCount++;
                            $userName = $this->getUserDisplayName($user);
                            $results[] = [
                                'user_id' => $user['id'],
                                'user_name' => $userName,
                                'status' => 'sent',
                                'notification_id' => $notificationId
                            ];

                            // Log successful send
                            $this->logNotificationOperation('sent', [
                                'id' => $notificationId,
                                'user_name' => $userName,
                                'title' => $title,
                                'body' => $body
                            ], $notificationId);
                        } else {
                            $failedCount++;
                            $userName = $this->getUserDisplayName($user);
                            $results[] = [
                                'user_id' => $user['id'],
                                'user_name' => $userName,
                                'status' => 'failed',
                                'error' => $fcmResult['message'] ?? 'Unknown error',
                                'notification_id' => $notificationId
                            ];

                            log_message('error', 'Failed to send FCM to user ' . $user['id'] . ': ' . ($fcmResult['message'] ?? 'Unknown error'));
                        }
                    } else {
                        // Schedule for later (for now we'll just create the record)
                        $sentCount++;
                        $userName = $this->getUserDisplayName($user);
                        $results[] = [
                            'user_id' => $user['id'],
                            'user_name' => $userName,
                            'status' => 'scheduled',
                            'scheduled_at' => $scheduledAt,
                            'notification_id' => $notificationId
                        ];

                        // Log scheduled notification
                        $this->logNotificationOperation('scheduled', [
                            'id' => $notificationId,
                            'user_name' => $userName,
                            'title' => $title,
                            'body' => $body
                        ], $notificationId);
                    }

                } catch (\Exception $e) {
                    $failedCount++;
                    $userName = $this->getUserDisplayName($user);
                    $results[] = [
                        'user_id' => $user['id'],
                        'user_name' => $userName,
                        'status' => 'error',
                        'error' => $e->getMessage()
                    ];
                    log_message('error', 'Error processing notification for user ' . $user['id'] . ': ' . $e->getMessage());
                }
            }

            $endTime = microtime(true);
            $processingTime = round(($endTime - $startTime), 2) . 's';

            // Log bulk operation summary
            $this->logNotificationOperation('bulk_sent', [
                'id' => 0,
                'user_name' => 'System',
                'title' => $title,
                'body' => "Bulk notification sent to {$sentCount} users, {$failedCount} failed. Processing time: {$processingTime}"
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => "Bulk notification processed successfully!",
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
                'total_users' => count($users),
                'processing_time' => $processingTime,
                'results' => $results
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error in bulk notification send: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to process bulk notification: ' . $e->getMessage()
            ]);
        }
    }
}
