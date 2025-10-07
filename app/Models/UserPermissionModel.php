<?php

namespace App\Models;

use CodeIgniter\Model;

class UserPermissionModel extends Model
{
    protected $table            = 'auth_users_permissions';
    protected $primaryKey       = ['user_id', 'permission_id'];
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'permission_id'];

    // Dates
    protected $useTimestamps = false;

    /**
     * Get all users for dropdown
     */
    public function getAllUsers(): array
    {
        return $this->db->table('users')
            ->select('users.id, users.username, users.email, 
                     COALESCE(users.full_name, users.username) as display_name')
            ->where('users.active', 1)
            ->where('users.deleted_at IS NULL')
            ->orderBy('users.full_name, users.username')
            ->get()
            ->getResultArray();
    }

    /**
     * Get all permissions grouped by module
     */
    public function getAllPermissionsGrouped(): array
    {
        $permissions = $this->db->table('auth_permissions')
            ->select('id, name, description')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();

        $grouped = [];
        foreach ($permissions as $permission) {
            // Extract module name from permission name (e.g., "users.view" -> "Users")
            $parts = explode('.', $permission['name']);
            $module = ucfirst($parts[0]);
            
            // Add action to permission data
            $permission['action'] = isset($parts[1]) ? ucfirst($parts[1]) : 'Unknown';
            $permission['module'] = $module;
            
            if (!isset($grouped[$module])) {
                $grouped[$module] = [];
            }
            $grouped[$module][] = $permission;
        }

        return $grouped;
    }

    /**
     * Get permission IDs assigned to a specific user
     */
    public function getUserPermissionIds(int $userId): array
    {
        if ($userId <= 0) {
            return [];
        }

        $result = $this->db->table('auth_users_permissions')
            ->select('permission_id')
            ->where('user_id', $userId)
            ->get()
            ->getResultArray();

        return array_column($result, 'permission_id');
    }

    /**
     * Get users with their permission counts for mobile view
     */
    public function getUsersWithPermissionCounts(): array
    {
        $users = $this->db->table('users')
            ->select('users.id, users.username, users.email, 
                     COALESCE(users.full_name, users.username) as display_name, users.active')
            ->where('users.active', 1)
            ->where('users.deleted_at IS NULL')
            ->orderBy('users.full_name, users.username')
            ->get()
            ->getResultArray();

        foreach ($users as &$user) {
            // Get permission count for each user
            $permissionCount = $this->db->table('auth_users_permissions')
                ->where('user_id', $user['id'])
                ->countAllResults();
            
            $user['permission_count'] = $permissionCount;
        }

        return $users;
    }

    /**
     * Update user permissions - replace all permissions for a user
     */
    public function updateUserPermissions(int $userId, array $permissionIds): bool
    {
        if ($userId <= 0) {
            return false;
        }

        // Start transaction
        $this->db->transStart();

        try {
            // Delete existing permissions for this user
            $this->db->table('auth_users_permissions')
                ->where('user_id', $userId)
                ->delete();

            // Insert new permissions
            if (!empty($permissionIds)) {
                $insertData = [];
                foreach ($permissionIds as $permissionId) {
                    if (is_numeric($permissionId) && $permissionId > 0) {
                        $insertData[] = [
                            'user_id' => $userId,
                            'permission_id' => (int)$permissionId
                        ];
                    }
                }

                if (!empty($insertData)) {
                    $this->db->table('auth_users_permissions')->insertBatch($insertData);
                }
            }

            // Complete transaction
            $this->db->transComplete();

            return $this->db->transStatus();
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Failed to update user permissions: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user details by ID
     */
    public function getUserById(int $userId): ?array
    {
        if ($userId <= 0) {
            return null;
        }

        $user = $this->db->table('users')
            ->select('users.id, users.username, users.email, 
                     COALESCE(users.full_name, users.username) as display_name, users.active')
            ->where('users.id', $userId)
            ->where('users.active', 1)
            ->where('users.deleted_at IS NULL')
            ->get()
            ->getRowArray();

        return $user;
    }

    /**
     * Check if a permission exists
     */
    public function permissionExists(int $permissionId): bool
    {
        if ($permissionId <= 0) {
            return false;
        }

        return $this->db->table('auth_permissions')
            ->where('id', $permissionId)
            ->countAllResults() > 0;
    }

    /**
     * Get permission details by ID
     */
    public function getPermissionById(int $permissionId): ?array
    {
        if ($permissionId <= 0) {
            return null;
        }

        return $this->db->table('auth_permissions')
            ->select('id, name, description')
            ->where('id', $permissionId)
            ->get()
            ->getRowArray();
    }

    /**
     * Validate permission IDs exist
     */
    public function validatePermissionIds(array $permissionIds): array
    {
        if (empty($permissionIds)) {
            return [];
        }

        $validIds = [];
        foreach ($permissionIds as $id) {
            if (is_numeric($id) && $id > 0) {
                $validIds[] = (int)$id;
            }
        }

        if (empty($validIds)) {
            return [];
        }

        $existingIds = $this->db->table('auth_permissions')
            ->select('id')
            ->whereIn('id', $validIds)
            ->get()
            ->getResultArray();

        return array_column($existingIds, 'id');
    }
}