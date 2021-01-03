<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class PhpUnitTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test
                            {--filter= : Filter for special test.}
                            {--no-coverage : No coverage files are generated.}
                            {--coverage-dir=storage/builds/html-coverage : Where should the coverage-report be stored.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all PHPUnit tests.';

    /**
     * @var string
     */
    private const BASE_COMMAND = 'php vendor/phpunit/phpunit/phpunit --verbose --colors=always --coverage-text ';


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
        $command = self::BASE_COMMAND;

        if (! (bool)$this->option('no-coverage')) {
            $command .= '--coverage-html ' . $this->option('coverage-dir');
        }

        if ($this->option('filter') !== null) {
            $command .= ' --filter=' . $this->option('filter');
        }

//        dd($command);

        $command = explode(' ', $command);

        $process = new Process($command);
        $process->start();
        $iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);

        foreach ($iterator as $data) {
            echo $data;
        }
    }
}
