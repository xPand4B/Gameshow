<?php

namespace App\Console\Commands;

use Symfony\Component\Process\Process;

trait ShouldExecuteShellCommands
{
    public function runCommands(array $commands, array $devCommands = null): void
    {
        if ($devCommands) {
            $commands = array_merge($commands, $devCommands);
        }

        foreach ($commands as $command) {
            $command = str_replace('/', DIRECTORY_SEPARATOR, $command);

            $process = new Process(explode(' ', $command));
            $process->setTimeout(null);
            $this->info($command);
            $process->start();
            $iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);

            foreach ($iterator as $data) {
                echo $data;
            }
            $this->line('');
        }
    }
}
