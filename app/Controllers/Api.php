<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Api extends ResourceController
{
    use ResponseTrait;

    /**
     * Get departments by division ID
     */
    public function departmentsByDivision()
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Direct access not allowed');
        }

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
                'message' => 'Departments retrieved successfully'
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
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Direct access not allowed');
        }

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
                'message' => 'Sections retrieved successfully'
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
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Direct access not allowed');
        }

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
                'message' => 'Positions retrieved successfully'
            ]);
            
        } catch (\Exception $e) {
            return $this->fail('Error retrieving positions: ' . $e->getMessage());
        }
    }
}