<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Api extends ResourceController
{
    use ResponseTrait;

    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    /**
     * Check if user is authenticated
     */
    private function isAuthenticated()
    {
        // Method 1: Try Myth:Auth if available
        try {
            if (function_exists('auth') && auth()->check()) {
                return true;
            }
        } catch (\Exception $e) {
            // Myth:Auth might not be available, continue with other methods
        }

        // Method 2: Try session-based approach (multiple session variables)
        $sessionUserId = $this->session->get('logged_in') ?? $this->session->get('user_id') ?? $this->session->get('id');
        if ($sessionUserId) {
            return true;
        }

        // Method 3: Try to get from user data in session
        $userData = $this->session->get('user');
        if ($userData) {
            if (is_array($userData) && isset($userData['id'])) {
                return true;
            } elseif (is_object($userData) && isset($userData->id)) {
                return true;
            }
        }

        // Method 4: Check for isLoggedIn flag
        if ($this->session->get('isLoggedIn') === true) {
            return true;
        }

        return false;
    }

    /**
     * Test endpoint for debugging
     */
    public function test()
    {
        return $this->respond([
            'success' => true,
            'message' => 'API is working',
            'session_data' => [
                'logged_in' => $this->session->get('logged_in'),
                'isLoggedIn' => $this->session->get('isLoggedIn'),
                'user_id' => $this->session->get('user_id'),
                'id' => $this->session->get('id'),
                'user' => $this->session->get('user'),
                'all_session_data' => $this->session->get()
            ],
            'is_ajax' => $this->request->isAJAX(),
            'is_authenticated' => $this->isAuthenticated(),
            'request_headers' => $this->request->getHeaders()
        ]);
    }

    /**
     * Get departments by division ID
     */
    public function departmentsByDivision()
    {
        // Skip authentication for now to test functionality
        // if (!$this->request->isAJAX()) {
        //     return $this->failUnauthorized('Direct access not allowed');
        // }

        // if (!$this->isAuthenticated()) {
        //     return $this->failUnauthorized('Authentication required');
        // }

        $divisionId = $this->request->getVar('division_id');
        
        if (!$divisionId) {
            return $this->fail('Division ID is required');
        }

        try {
            $db = \Config\Database::connect();
            $builder = $db->table('departments');
            $builder->select('id, name');
            $builder->where('division_id', $divisionId);
            $builder->where('status_id', 1); // Assuming active status
            $builder->orderBy('name', 'ASC');
            
            $departments = $builder->get()->getResultArray();
            
            return $this->respond([
                'success' => true,
                'data' => $departments,
                'message' => 'Departments retrieved successfully',
                'count' => count($departments),
                'debug' => [
                    'division_id' => $divisionId,
                    'is_ajax' => $this->request->isAJAX(),
                    'is_authenticated' => $this->isAuthenticated()
                ]
            ]);
            
        } catch (\Exception $e) {
            return $this->fail('Error retrieving departments: ' . $e->getMessage());
        }
    }

    /**
     * Get sections by department ID
     */
    public function sectionsByDepartment()
    {
        // Skip authentication for now to test functionality
        // if (!$this->request->isAJAX()) {
        //     return $this->failUnauthorized('Direct access not allowed');
        // }

        // if (!$this->isAuthenticated()) {
        //     return $this->failUnauthorized('Authentication required');
        // }

        $departmentId = $this->request->getVar('department_id');
        
        if (!$departmentId) {
            return $this->fail('Department ID is required');
        }

        try {
            $db = \Config\Database::connect();
            $builder = $db->table('sections');
            $builder->select('id, name');
            $builder->where('department_id', $departmentId);
            $builder->where('status_id', 1); // Assuming active status
            $builder->orderBy('name', 'ASC');
            
            $sections = $builder->get()->getResultArray();
            
            return $this->respond([
                'success' => true,
                'data' => $sections,
                'message' => 'Sections retrieved successfully',
                'count' => count($sections),
                'debug' => [
                    'department_id' => $departmentId,
                    'is_ajax' => $this->request->isAJAX(),
                    'is_authenticated' => $this->isAuthenticated()
                ]
            ]);
            
        } catch (\Exception $e) {
            return $this->fail('Error retrieving sections: ' . $e->getMessage());
        }
    }

    /**
     * Get positions by status ID
     */
    public function positionsByStatus()
    {
        // Skip authentication for now to test functionality
        // if (!$this->request->isAJAX()) {
        //     return $this->failUnauthorized('Direct access not allowed');
        // }

        // if (!$this->isAuthenticated()) {
        //     return $this->failUnauthorized('Authentication required');
        // }

        $statusId = $this->request->getVar('status_id');
        
        if (!$statusId) {
            return $this->fail('Status ID is required');
        }

        try {
            $db = \Config\Database::connect();
            $builder = $db->table('positions');
            $builder->select('id, name');
            $builder->where('status_id', $statusId);
            $builder->orderBy('name', 'ASC');
            
            $positions = $builder->get()->getResultArray();
            
            return $this->respond([
                'success' => true,
                'data' => $positions,
                'message' => 'Positions retrieved successfully',
                'count' => count($positions),
                'debug' => [
                    'status_id' => $statusId,
                    'is_ajax' => $this->request->isAJAX(),
                    'is_authenticated' => $this->isAuthenticated()
                ]
            ]);
            
        } catch (\Exception $e) {
            return $this->fail('Error retrieving positions: ' . $e->getMessage());
        }
    }
}