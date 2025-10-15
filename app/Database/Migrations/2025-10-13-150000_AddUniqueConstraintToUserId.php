<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUniqueConstraintToUserId extends Migration
{
    public function up()
    {
        // Add unique constraint to user_id column
        $this->forge->addKey('user_id', false, true); // Third parameter true makes it unique
    }

    public function down()
    {
        // Remove the unique constraint
        $this->forge->dropKey('authorization_rules', 'user_id');
    }
}