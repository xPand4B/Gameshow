<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    use ShouldExecuteShellCommands;

    protected $signature = 'install {--dev : Install in dev-mode.}';

    protected $description = 'Install the Application.';

    private const COMMANDS = [
        'cp -n .env.example .env',
        'php artisan key:generate --ansi',
        'php artisan migrate:fresh --force',
        'php artisan storage:link',
        'npm install',
        'npm run prod',
    ];

    public function handle(): void
    {
        $this->runCommands(self::COMMANDS);
    }
}
