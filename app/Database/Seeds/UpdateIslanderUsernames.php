<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateIslanderUsernames extends Seeder
{
    public function run()
    {
        // Get all islanders
        $query = $this->db->query("SELECT id, islander_no FROM users WHERE type = 1 AND islander_no IS NOT NULL AND islander_no != ''");
        $islanders = $query->getResultArray();
        
        echo "Found " . count($islanders) . " islanders to update\n";
        
        foreach ($islanders as $islander) {
            // Update username to match islander_no
            $this->db->table('users')
                     ->where('id', $islander['id'])
                     ->update(['username' => $islander['islander_no']]);
            
            echo "Updated islander ID {$islander['id']} - username set to '{$islander['islander_no']}'\n";
        }
        
        echo "Username sync completed!\n";
    }
}