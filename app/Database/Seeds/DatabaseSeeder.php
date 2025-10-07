<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        echo "🚀 Starting database seeding..." . PHP_EOL . PHP_EOL;
        
        // Run the role seeder
        echo "📝 Seeding roles..." . PHP_EOL;
        $this->call('RoleSeeder');
        
        echo PHP_EOL . "✅ Database seeding completed successfully!" . PHP_EOL;
    }
}