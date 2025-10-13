<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CheckPermissions extends BaseCommand
{
    protected $group       = 'Development';
    protected $name        = 'check:permissions';
    protected $description = 'Check authorization permissions in database';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        CLI::write('=== Authorization Related Permissions ===', 'green');
        $query = $db->query("SELECT * FROM auth_permissions WHERE name LIKE '%authorization%' OR name LIKE '%sequence%'");
        $results = $query->getResultArray();

        if (empty($results)) {
            CLI::write('No authorization/sequence permissions found!', 'red');
        } else {
            foreach ($results as $row) {
                CLI::write("ID: {$row['id']}, Name: {$row['name']}, Description: {$row['description']}");
            }
        }

        CLI::newLine();
        CLI::write('=== Status Related Permissions ===', 'green');
        $query = $db->query("SELECT * FROM auth_permissions WHERE name LIKE '%status%'");
        $results = $query->getResultArray();

        foreach ($results as $row) {
            CLI::write("ID: {$row['id']}, Name: {$row['name']}, Description: {$row['description']}");
        }

        CLI::newLine();
        CLI::write('=== All Groups ===', 'green');
        $query = $db->query("SELECT * FROM auth_groups ORDER BY name");
        $results = $query->getResultArray();

        foreach ($results as $row) {
            CLI::write("ID: {$row['id']}, Name: {$row['name']}, Description: {$row['description']}");
        }

        CLI::newLine();
        CLI::write('=== Current User Groups ===', 'green');
        $query = $db->query("SELECT u.username, g.name as group_name FROM auth_groups_users gu JOIN users u ON gu.user_id = u.id JOIN auth_groups g ON gu.group_id = g.id ORDER BY u.username");
        $results = $query->getResultArray();

        foreach ($results as $row) {
            CLI::write("User: {$row['username']}, Group: {$row['group_name']}");
        }
    }
}