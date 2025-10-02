<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SessionCleanup extends BaseCommand
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
    protected $name = 'session:cleanup';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Clean up expired sessions from the database';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'session:cleanup [options]';

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
    protected $options = [
        '--force' => 'Force cleanup without confirmation'
    ];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $db = \Config\Database::connect();
        $sessionConfig = config('Session');
        
        // Calculate the cutoff time for expired sessions
        $expiredTime = date('Y-m-d H:i:s', time() - $sessionConfig->expiration);
        
        CLI::write('Session Cleanup Tool', 'yellow');
        CLI::write('Expiration time: ' . $sessionConfig->expiration . ' seconds (90 days)', 'cyan');
        CLI::write('Sessions older than: ' . $expiredTime . ' will be deleted', 'cyan');
        
        // Count expired sessions
        $query = $db->query("SELECT COUNT(*) as count FROM {$sessionConfig->savePath} WHERE timestamp < ?", [$expiredTime]);
        $expiredCount = $query->getRow()->count;
        
        if ($expiredCount === 0) {
            CLI::write('No expired sessions found.', 'green');
            return;
        }
        
        CLI::write("Found {$expiredCount} expired sessions.", 'yellow');
        
        // Ask for confirmation unless --force is used
        if (!CLI::getOption('force')) {
            $confirm = CLI::prompt('Do you want to delete these expired sessions?', ['y', 'n']);
            if ($confirm !== 'y') {
                CLI::write('Operation cancelled.', 'red');
                return;
            }
        }
        
        // Delete expired sessions
        $result = $db->query("DELETE FROM {$sessionConfig->savePath} WHERE timestamp < ?", [$expiredTime]);
        
        if ($result) {
            CLI::write("Successfully deleted {$expiredCount} expired sessions.", 'green');
        } else {
            CLI::write('Error occurred while deleting expired sessions.', 'red');
        }
    }
}
