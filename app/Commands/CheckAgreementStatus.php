<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CheckAgreementStatus extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'check:agreement';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Check users agreement status';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'check:agreement';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        CLI::write('Agreement Status Check', 'yellow');
        CLI::write('====================', 'yellow');
        
        $query = $db->query("SELECT id, username, email, has_accepted_agreement FROM users");
        $users = $query->getResult();
        
        foreach ($users as $user) {
            $status = $user->has_accepted_agreement == 1 ? 'WILL SHOW MODAL' : 'NO MODAL';
            CLI::write("User {$user->id} ({$user->username}): has_accepted_agreement = {$user->has_accepted_agreement} -> {$status}", 'cyan');
        }
        
        CLI::write('', 'white');
        CLI::write('Note: Modal shows when has_accepted_agreement = 1', 'green');
    }
}
