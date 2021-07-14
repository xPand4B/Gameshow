<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class UpdateCommand extends Command
{
    use ShouldExecuteShellCommands;

    protected $signature = 'update';

    protected $description = 'Updates the application and compiles into production mode.';

    private const COMMANDS = [
        'php artisan down',
        'git checkout master',
        'git stash',
        'git pull',
        'php artisan migrate',
        'npm install',
        'npm run prod',
        'rm -rf node_modules',
        'php artisan up',
    ];

    public function handle(): void
    {
        $this->runCommands(self::COMMANDS);
    }
}
