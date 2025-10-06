<?php

namespace App\Models;

use CodeIgniter\Model;

class SessionModel extends Model
{
    protected $table      = 'ci_sessions';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false; // Sessions use custom string IDs

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id', 
        'ip_address', 
        'timestamp', 
        'data'
    ];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';

    protected $validationRules = [
        'id' => [
            'label'  => 'Session ID',
            'rules'  => 'required|max_length[128]',
            'errors' => [
                'required'    => 'Session ID is required.',
                'max_length'  => 'Session ID cannot exceed 128 characters.'
            ]
        ],
        'ip_address' => [
            'label'  => 'IP Address',
            'rules'  => 'required|valid_ip',
            'errors' => [
                'required'  => 'IP address is required.',
                'valid_ip'  => 'IP address must be valid.'
            ]
        ],
        'data' => [
            'label'  => 'Session Data',
            'rules'  => 'permit_empty',
            'errors' => []
        ]
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Get session by ID with validation
     */
    public function getSession($id)
    {
        $builder = $this->db->table('ci_sessions s');
        
        return $builder->select('s.*, 
                               s.islander_no,
                               s.full_name as user_name,
                               u.email as user_email,
                               u.image as user_image,
                               d.name as department_name,
                               p.name as position_name')
                      ->join('users u', 's.user_id = u.id', 'left')
                      ->join('departments d', 'u.department_id = d.id', 'left')
                      ->join('positions p', 'u.position_id = p.id', 'left')
                      ->where('s.id', $id)
                      ->get()
                      ->getRowArray();
    }

    /**
     * Get sessions with pagination and search
     */
    public function getSessionsWithPagination($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->db->table('ci_sessions s');
        
        // Join with users table and related tables for complete user information
        $builder->select('s.*, 
                         s.islander_no,
                         s.full_name as user_name,
                         u.email as user_email,
                         u.image as user_image,
                         d.name as department_name,
                         p.name as position_name')
                ->join('users u', 's.user_id = u.id', 'left')
                ->join('departments d', 'u.department_id = d.id', 'left')
                ->join('positions p', 'u.position_id = p.id', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('s.id', $search)
                    ->orLike('s.ip_address', $search)
                    ->orLike('s.full_name', $search)
                    ->orLike('s.islander_no', $search)
                    ->orLike('u.email', $search)
                    ->orLike('d.name', $search)
                    ->orLike('p.name', $search)
                    ->groupEnd();
        }
        
        return $builder->limit($limit, $offset)
                      ->orderBy('s.timestamp', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count sessions with search filter
     */
    public function getSessionsCount($search = '')
    {
        $builder = $this->db->table('ci_sessions s');
        
        // Join with users table and related tables for consistent search results
        $builder->join('users u', 's.user_id = u.id', 'left')
                ->join('departments d', 'u.department_id = d.id', 'left')
                ->join('positions p', 'u.position_id = p.id', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('s.id', $search)
                    ->orLike('s.ip_address', $search)
                    ->orLike('s.full_name', $search)
                    ->orLike('s.islander_no', $search)
                    ->orLike('u.email', $search)
                    ->orLike('d.name', $search)
                    ->orLike('p.name', $search)
                    ->groupEnd();
        }
        
        return $builder->countAllResults();
    }

    /**
     * Get validation rules
     */
    public function getValidationRules(array $options = []): array
    {
        return $this->validationRules;
    }

    /**
     * Get all active sessions
     */
    public function getActiveSessions()
    {
        return $this->where('timestamp >', date('Y-m-d H:i:s', strtotime('-24 hours')))->findAll();
    }

    /**
     * Delete expired sessions
     */
    public function deleteExpiredSessions($expiry = 7200) // 2 hours default
    {
        $expiredTime = date('Y-m-d H:i:s', time() - $expiry);
        return $this->where('timestamp <', $expiredTime)->delete();
    }

    /**
     * Get session data as array
     */
    public function getSessionData($sessionId)
    {
        $session = $this->find($sessionId);
        if ($session && !empty($session['data'])) {
            return unserialize($session['data']);
        }
        return [];
    }

    /**
     * Get user ID from session data
     */
    public function getUserIdFromSession($sessionId)
    {
        $sessionData = $this->getSessionData($sessionId);
        return $sessionData['user_id'] ?? null;
    }

    /**
     * Force logout a session
     */
    public function forceLogout($sessionId)
    {
        return $this->delete($sessionId);
    }

    /**
     * Get sessions by user ID
     */
    public function getSessionsByUserId($userId)
    {
        $builder = $this->db->table('ci_sessions');
        
        // Use JSON extraction to find sessions for specific user
        return $builder->where("JSON_UNQUOTE(JSON_EXTRACT(data, '$.user_id'))", $userId)
                      ->orderBy('timestamp', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Get session statistics
     */
    public function getSessionStats()
    {
        $builder = $this->db->table('ci_sessions s');
        
        $stats = [
            'total_sessions' => $builder->countAllResults(false),
            'active_sessions_1h' => $builder->where('timestamp >', date('Y-m-d H:i:s', strtotime('-1 hour')))->countAllResults(false),
            'active_sessions_24h' => $builder->where('timestamp >', date('Y-m-d H:i:s', strtotime('-24 hours')))->countAllResults(false),
            'unique_users' => $builder->select("COUNT(DISTINCT JSON_UNQUOTE(JSON_EXTRACT(data, '$.user_id'))) as count")
                                    ->where("JSON_UNQUOTE(JSON_EXTRACT(data, '$.user_id')) IS NOT NULL")
                                    ->get()->getRow()->count ?? 0
        ];
        
        return $stats;
    }
}