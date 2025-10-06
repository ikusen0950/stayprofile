<?php

namespace App\Controllers;

use App\Models\SessionModel;
use App\Models\LogModel;
use CodeIgniter\HTTP\RedirectResponse;

class SessionsController extends BaseController
{
    protected $sessionModel;
    protected $logModel;

    public function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for session
     */
    private function sanitizeSessionInput(array $data): array
    {
        $sanitized = [
            'id' => isset($data['id']) ? trim(strip_tags($data['id'])) : '',
            'ip_address' => isset($data['ip_address']) ? trim(strip_tags($data['ip_address'])) : '',
            'data' => isset($data['data']) ? $data['data'] : '', // Don't strip tags from session data
        ];

        return $sanitized;
    }

    /**
     * Log session operations to the logs table
     */
    private function logSessionOperation(string $operation, array $sessionData, int $statusId = 1): void
    {
        try {
            // Get current user info for logging
            helper('auth');
            $currentUser = user();
            
            if (!$currentUser) {
                return; // Can't log without user context
            }

            $logMessage = "Session {$operation}\n";
            $logMessage .= "Session ID: " . ($sessionData['id'] ?? 'N/A') . "\n";
            $logMessage .= "IP Address: " . ($sessionData['ip_address'] ?? 'N/A') . "\n";
            $logMessage .= "User: " . ($sessionData['user_name'] ?? 'N/A') . "\n";
            $logMessage .= "Islander No: " . ($sessionData['islander_no'] ?? 'N/A') . "\n";
            $logMessage .= "Timestamp: " . ($sessionData['timestamp'] ?? 'N/A');

            $this->logModel->insert([
                'status_id' => $statusId,
                'module_id' => 1, // System module
                'action' => $logMessage,
                'user_id' => $currentUser->id
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Failed to log session operation: ' . $e->getMessage());
        }
    }

    /**
     * Check user permissions
     */
    private function checkPermissions()
    {
        helper('auth');
        
        return [
            'canView' => has_permission('sessions.view'),
            'canCreate' => has_permission('sessions.create'),
            'canEdit' => has_permission('sessions.edit'),
            'canDelete' => has_permission('sessions.delete'),
        ];
    }

    /**
     * Display paginated list of sessions
     */
    public function index()
    {
        // Check permissions
        $permissions = $this->checkPermissions();
        if (!$permissions['canView']) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to view sessions.');
        }

        // Get search and pagination parameters
        $search = $this->request->getGet('search') ?? '';
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = ($page - 1) * $limit;

        try {
            // Get sessions with pagination
            $sessions = $this->sessionModel->getSessionsWithPagination($search, $limit, $offset);
            $totalSessions = $this->sessionModel->getSessionsCount($search);
            $totalPages = ceil($totalSessions / $limit);

            // Process session data for display
            foreach ($sessions as &$session) {
                // Parse session data if it exists
                if (!empty($session['data'])) {
                    $sessionData = @unserialize($session['data']);
                    $session['parsed_data'] = $sessionData;
                    $session['is_logged_in'] = isset($sessionData['logged_in']) && $sessionData['logged_in'];
                } else {
                    $session['parsed_data'] = [];
                    $session['is_logged_in'] = false;
                }

                // Format timestamp
                if (!empty($session['timestamp'])) {
                    $session['formatted_timestamp'] = date('M d, Y H:i:s', strtotime($session['timestamp']));
                    $session['time_ago'] = $this->timeAgo($session['timestamp']);
                }
            }

            $data = [
                'title' => 'Sessions Management',
                'sessions' => $sessions,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'totalSessions' => $totalSessions,
                'limit' => $limit,
                'search' => $search,
                'permissions' => $permissions
            ];

            return view('sessions/index', $data);

        } catch (\Exception $e) {
            log_message('error', 'Error in SessionsController::index: ' . $e->getMessage());
            return redirect()->to('/dashboard')->with('error', 'An error occurred while loading sessions.');
        }
    }

    /**
     * Display single session details
     */
    public function show($id)
    {
        // Check permissions
        $permissions = $this->checkPermissions();
        if (!$permissions['canView']) {
            return redirect()->to('/sessions')->with('error', 'You do not have permission to view session details.');
        }

        try {
            $session = $this->sessionModel->getSession($id);
            
            if (!$session) {
                return redirect()->to('/sessions')->with('error', 'Session not found.');
            }

            // Parse session data
            if (!empty($session['data'])) {
                $session['parsed_data'] = @unserialize($session['data']);
            } else {
                $session['parsed_data'] = [];
            }

            // Format timestamp
            if (!empty($session['timestamp'])) {
                $session['formatted_timestamp'] = date('M d, Y H:i:s', strtotime($session['timestamp']));
                $session['time_ago'] = $this->timeAgo($session['timestamp']);
            }

            $data = [
                'title' => 'Session Details',
                'session' => $session,
                'permissions' => $permissions
            ];

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'session' => $session
                ]);
            }

            return view('sessions/view_modal', $data);

        } catch (\Exception $e) {
            log_message('error', 'Error in SessionsController::show: ' . $e->getMessage());
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error loading session details.'
                ]);
            }

            return redirect()->to('/sessions')->with('error', 'Error loading session details.');
        }
    }

    /**
     * Force logout a session (delete session)
     */
    public function forceLogout($id)
    {
        // Debug logging
        log_message('debug', 'SessionsController::forceLogout called with ID: ' . $id);
        
        // Check permissions
        $permissions = $this->checkPermissions();
        if (!$permissions['canDelete']) {
            log_message('debug', 'Force logout permission denied');
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to force logout sessions.'
                ]);
            }
            return redirect()->to('/sessions')->with('error', 'You do not have permission to force logout sessions.');
        }

        try {
            // Get session details before deletion for logging
            $session = $this->sessionModel->getSession($id);
            
            if (!$session) {
                log_message('debug', 'Session not found for ID: ' . $id);
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Session not found.'
                    ]);
                }
                return redirect()->to('/sessions')->with('error', 'Session not found.');
            }

            // Delete the session
            $result = $this->sessionModel->forceLogout($id);
            log_message('debug', 'Force logout result: ' . ($result ? 'success' : 'failed'));

            if ($result) {
                // Log the operation
                $this->logSessionOperation('Force Logout', $session, 4); // Using status 4 for logout operations

                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Session logged out successfully.'
                    ]);
                }

                return redirect()->to('/sessions')->with('success', 'Session logged out successfully.');
            } else {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to logout session.'
                    ]);
                }

                return redirect()->to('/sessions')->with('error', 'Failed to logout session.');
            }

        } catch (\Exception $e) {
            log_message('error', 'Error in SessionsController::forceLogout: ' . $e->getMessage());

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error occurred while logging out session.'
                ]);
            }

            return redirect()->to('/sessions')->with('error', 'Error occurred while logging out session.');
        }
    }

    /**
     * Bulk delete expired sessions
     */
    public function cleanupExpired()
    {
        // Check permissions
        $permissions = $this->checkPermissions();
        if (!$permissions['canDelete']) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to cleanup sessions.'
                ]);
            }
            return redirect()->to('/sessions')->with('error', 'You do not have permission to cleanup sessions.');
        }

        try {
            $expiry = $this->request->getPost('expiry') ?? 7200; // 2 hours default
            $deletedCount = $this->sessionModel->deleteExpiredSessions($expiry);

            // Log the cleanup operation
            helper('auth');
            $currentUser = user();
            
            if ($currentUser) {
                $this->logModel->insert([
                    'status_id' => 4,
                    'module_id' => 1,
                    'action' => "Session Cleanup\nDeleted {$deletedCount} expired sessions\nExpiry threshold: {$expiry} seconds",
                    'user_id' => $currentUser->id
                ]);
            }

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => "Cleaned up {$deletedCount} expired sessions."
                ]);
            }

            return redirect()->to('/sessions')->with('success', "Cleaned up {$deletedCount} expired sessions.");

        } catch (\Exception $e) {
            log_message('error', 'Error in SessionsController::cleanupExpired: ' . $e->getMessage());

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error occurred during session cleanup.'
                ]);
            }

            return redirect()->to('/sessions')->with('error', 'Error occurred during session cleanup.');
        }
    }

    /**
     * Get session statistics
     */
    public function stats()
    {
        // Check permissions
        $permissions = $this->checkPermissions();
        if (!$permissions['canView']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view session statistics.'
            ]);
        }

        try {
            $stats = $this->sessionModel->getSessionStats();

            return $this->response->setJSON([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error in SessionsController::stats: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error loading session statistics.'
            ]);
        }
    }

    /**
     * Helper function to calculate time ago
     */
    private function timeAgo($datetime)
    {
        $time = time() - strtotime($datetime);

        if ($time < 60) return 'just now';
        if ($time < 3600) return floor($time/60) . ' minutes ago';
        if ($time < 86400) return floor($time/3600) . ' hours ago';
        if ($time < 2592000) return floor($time/86400) . ' days ago';
        if ($time < 31536000) return floor($time/2592000) . ' months ago';
        return floor($time/31536000) . ' years ago';
    }
}