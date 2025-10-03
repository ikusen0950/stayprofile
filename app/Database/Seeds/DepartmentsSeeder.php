<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    public function run()
    {
        // Get divisions for reference
        $divisions = $this->db->table('divisions')->get()->getResultArray();
        
        if (empty($divisions)) {
            echo "No divisions found. Please run DivisionsSeeder first.\n";
            return;
        }

        // Create a mapping of division names to IDs
        $divisionMap = [];
        foreach ($divisions as $division) {
            $divisionMap[$division['name']] = $division['id'];
        }

        // Get admin user ID for created_by
        $adminUser = $this->db->table('users')->where('email', 'admin@example.com')->get()->getRow();
        $createdById = $adminUser ? $adminUser->id : 1; // Fallback to ID 1 if admin not found

        // Department data - assign to different divisions
        $departments = [
            // HR Division departments
            [
                'name' => 'Human Resources',
                'division_id' => $divisionMap['HR'] ?? 1,
                'description' => 'Manages employee recruitment, training, and policies.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 days'))
            ],
            [
                'name' => 'Payroll',
                'division_id' => $divisionMap['HR'] ?? 1,
                'description' => 'Handles employee compensation and benefits administration.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-25 days'))
            ],
            
            // Finance Division departments
            [
                'name' => 'Accounting',
                'division_id' => $divisionMap['Finance'] ?? 2,
                'description' => 'Manages financial records and reporting.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-20 days'))
            ],
            [
                'name' => 'Budgeting',
                'division_id' => $divisionMap['Finance'] ?? 2,
                'description' => 'Financial planning and budget management.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-18 days'))
            ],
            [
                'name' => 'Accounts Receivable',
                'division_id' => $divisionMap['Finance'] ?? 2,
                'description' => 'Manages incoming payments and customer billing.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
            ],
            
            // Operations Division departments
            [
                'name' => 'Front Office',
                'division_id' => $divisionMap['Operations'] ?? 3,
                'description' => 'Guest check-in, check-out, and front desk services.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-12 days'))
            ],
            [
                'name' => 'Reservations',
                'division_id' => $divisionMap['Operations'] ?? 3,
                'description' => 'Handles room bookings and reservation management.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
            ],
            
            // IT Division departments
            [
                'name' => 'Software Development',
                'division_id' => $divisionMap['IT'] ?? 4,
                'description' => 'Develops and maintains software applications.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-8 days'))
            ],
            [
                'name' => 'Network Administration',
                'division_id' => $divisionMap['IT'] ?? 4,
                'description' => 'Manages network infrastructure and connectivity.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-6 days'))
            ],
            [
                'name' => 'IT Support',
                'division_id' => $divisionMap['IT'] ?? 4,
                'description' => 'Provides technical support to users.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            
            // Marketing Division departments
            [
                'name' => 'Digital Marketing',
                'division_id' => $divisionMap['Marketing'] ?? 5,
                'description' => 'Online marketing campaigns and social media management.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-4 days'))
            ],
            [
                'name' => 'Sales',
                'division_id' => $divisionMap['Marketing'] ?? 5,
                'description' => 'Direct sales and customer acquisition.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            
            // Guest Services Division departments
            [
                'name' => 'Concierge',
                'division_id' => $divisionMap['Guest Services'] ?? 6,
                'description' => 'Personalized guest assistance and recommendations.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'name' => 'Guest Relations',
                'division_id' => $divisionMap['Guest Services'] ?? 6,
                'description' => 'Manages guest feedback and satisfaction.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            
            // F&B Division departments
            [
                'name' => 'Kitchen',
                'division_id' => $divisionMap['F&B'] ?? 7,
                'description' => 'Food preparation and culinary operations.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Restaurant Service',
                'division_id' => $divisionMap['F&B'] ?? 7,
                'description' => 'Restaurant and dining service operations.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Bar',
                'division_id' => $divisionMap['F&B'] ?? 7,
                'description' => 'Beverage service and bar operations.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Housekeeping Division departments
            [
                'name' => 'Room Cleaning',
                'division_id' => $divisionMap['Housekeeping'] ?? 8,
                'description' => 'Guest room cleaning and maintenance.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Laundry',
                'division_id' => $divisionMap['Housekeeping'] ?? 8,
                'description' => 'Laundry and linen management services.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Security Division departments
            [
                'name' => 'Security Operations',
                'division_id' => $divisionMap['Security'] ?? 9,
                'description' => 'Property security and surveillance.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Maintenance Division departments
            [
                'name' => 'Facilities Maintenance',
                'division_id' => $divisionMap['Maintenance'] ?? 10,
                'description' => 'Building and equipment maintenance.',
                'created_by' => $createdById,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($departments as $department) {
            // Check if department already exists
            $existing = $this->db->table('departments')
                                ->where('name', $department['name'])
                                ->get()
                                ->getRow();

            if (!$existing) {
                $this->db->table('departments')->insert($department);
                echo "Created department: {$department['name']}\n";
            } else {
                echo "Department already exists: {$department['name']}\n";
            }
        }

        echo "Departments seeding completed!\n";
    }
}
