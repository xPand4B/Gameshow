<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    use ShouldExecuteShellCommands;

    protected $signature = 'install {--dev : Install in dev-mode.}';

    protected $description = 'Install the Application.';

    private const COMMANDS = [
//        'cp .env.example .env',
        'php artisan key:generate --ansi',
        'php artisan migrate:fresh --force',
        'php artisan storage:link',
    ];

    private const DEV_COMMANDS = [
        'npm install',
        'npm run dev'
    ];

    public function handle(): void
    {
        $this->runCommands(
            self::COMMANDS,
            $this->option('dev') ? self::DEV_COMMANDS : null
        );
    }
}
