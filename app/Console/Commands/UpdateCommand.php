<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class UpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the application and compiles into production mode.';

    /**
     * @var string
     */
    private const COMMANDS = [
        'php artisan down',
        'git checkout master',
        'git stash',
        'git pull',
        'php artisan migrate',
        'npm run prod',
        'php artisan up',
    ];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (self::COMMANDS as $command) {
            $command = explode(' ', $command);

            $process = new Process($command);
            $process->start();
            $iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);

            foreach ($iterator as $data) {
                echo $data;
            }
        }
    }
}
