<?php

namespace App\Controllers;

use App\Models\LogModel;
use CodeIgniter\HTTP\RedirectResponse;

class LogController extends BaseController
{
    protected $logModel;

    public function __construct()
    {
        $this->logModel = new LogModel();
        helper(['form', 'url', 'auth']);
    }

    /**
     * Sanitize input data for logs
     */
    private function sanitizeLogInput(array $data): array
    {
        return [
            'status_id' => isset($data['status_id']) ? (int) $data['status_id'] : null,
            'module' => isset($data['module']) ? trim(strip_tags($data['module'])) : '',
            'action' => isset($data['action']) ? trim(strip_tags($data['action'])) : '',
            'message' => isset($data['message']) ? trim(strip_tags($data['message'])) : '',
            'user_id' => isset($data['user_id']) ? (int) $data['user_id'] : null,
        ];
    }

    /**
     * Display a listing of logs
     */
    public function index()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $logs = $this->logModel->getLogsWithPagination($search, $limit, $offset);
        $totalLogs = $this->logModel->getLogsCount($search);
        $totalPages = ceil($totalLogs / $limit);

        $data = [
            'title' => 'System Logs',
            'logs' => $logs,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalLogs' => $totalLogs,
            'limit' => $limit
        ];

        return view('logs/index', $data);
    }

    /**
     * API endpoint for AJAX pagination (mobile)
     */
    public function api()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = max(1, (int)($this->request->getGet('page') ?? 1));
        $limit = max(1, min(50, (int)($this->request->getGet('limit') ?? 10)));
        $offset = ($page - 1) * $limit;

        try {
            $logs = $this->logModel->getLogsWithPagination($search, $limit, $offset);
            $totalLogs = $this->logModel->getLogsCount($search);
            $hasMore = ($offset + $limit) < $totalLogs;

            return $this->response->setJSON([
                'success' => true,
                'data' => $logs,
                'hasMore' => $hasMore,
                'total' => $totalLogs,
                'currentPage' => $page
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Log API error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to load logs'
            ]);
        }
    }

    /**
     * Display the specified log (AJAX only for modals)
     */
    public function show($id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/logs');
        }

        $log = $this->logModel->getLog($id);
        
        if (!$log) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Log not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $log
        ]);
    }

    /**
     * Create a new log entry (AJAX only)
     */
    public function store()
    {
        // Debug: Log the incoming request
        log_message('info', 'Log store called. POST data: ' . json_encode($this->request->getPost()));
        
        if (!$this->request->isAJAX()) {
            return redirect()->to('/logs');
        }
        
        // Validate the input
        if (!$this->validate($this->logModel->getValidationRules())) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
                'message' => 'Validation failed.'
            ]);
        }

        // Prepare data for insertion with sanitization
        $rawData = [
            'status_id' => $this->request->getPost('status_id'),
            'module' => $this->request->getPost('module'),
            'action' => $this->request->getPost('action'),
            'message' => $this->request->getPost('message'),
        ];
        $data = $this->sanitizeLogInput($rawData);

        // Insert the log
        if ($logId = $this->logModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Log entry created successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to create log entry. Please try again.'
            ]);
        }
    }

    /**
     * Delete the specified log
     */
    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/logs');
        }

        $log = $this->logModel->find($id);
        if (!$log) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Log not found.'
            ]);
        }

        if ($this->logModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Log deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete log. Please try again.'
            ]);
        }
    }

    /**
     * Clear all logs (Admin only)
     */
    public function clear()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/logs');
        }

        // Additional security check could be added here for admin role
        
        try {
            $this->logModel->truncate();
            return $this->response->setJSON([
                'success' => true,
                'message' => 'All logs cleared successfully!'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Failed to clear logs: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to clear logs. Please try again.'
            ]);
        }
    }

    /**
     * Export logs to CSV
     */
    public function export()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $logs = $this->logModel->getLogsWithPagination($search, 1000, 0); // Get up to 1000 records

        $filename = 'system_logs_' . date('Y-m-d_H-i-s') . '.csv';
        
        $this->response->setHeader('Content-Type', 'text/csv')
                       ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, [
            'ID',
            'Status',
            'Module', 
            'Action',
            'Message',
            'User',
            'Logged At'
        ]);

        // CSV data
        foreach ($logs as $log) {
            fputcsv($output, [
                $log['id'],
                $log['status_name'] ?? 'N/A',
                $log['module'] ?? '',
                $log['action'] ?? '',
                $log['message'] ?? '',
                $log['user_name'] ?? 'System',
                $log['logged_at'] ?? ''
            ]);
        }

        fclose($output);
        return $this->response;
    }

    /**
     * Get log statistics for dashboard
     */
    public function stats()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/logs');
        }

        try {
            $builder = $this->logModel->builder();
            
            $stats = [
                'total' => $builder->countAllResults(false),
                'today' => $builder->where('DATE(logged_at)', date('Y-m-d'))->countAllResults(false),
                'this_week' => $builder->where('logged_at >=', date('Y-m-d', strtotime('-7 days')))->countAllResults(false),
                'this_month' => $builder->where('logged_at >=', date('Y-m-01'))->countAllResults()
            ];

            return $this->response->setJSON([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Log stats error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to load statistics'
            ]);
        }
    }
}