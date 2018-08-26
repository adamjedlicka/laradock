<?php

namespace AdamJedlicka\Laradock\Console\Commands;

use RuntimeException;
use Symfony\Component\Process\Process;
use Illuminate\Console\Command as BaseCommand;
use Illuminate\Support\Facades\File;

class Command extends BaseCommand
{
    /**
     * @var \Symfony\Component\Process\Process
     */
    protected $process;

    /**
     * @var boolean
     */
    protected $isTty = false;

    /**
     * Command to be executed
     *
     * @var array
     */
    protected $cmd = [];

    /**
     * Executes the command specified in $cmd variable and writes output to the terminal
     *
     * @param string|array $cmd Command to be executed
     * @param string|null $cwd Execution directory
     * @return int Return code of the run commadn
     */
    protected function exec($cmd, $cwd = null) : int
    {
        // Convert the command into string if it's in array
        if (!is_string($cmd)) $cmd = implode(' ', $cmd);

        $this->info("$ $cmd");

        $this->process = new Process($cmd, $cwd);

        $this->tryTty();

        // If TTY is enabled simply run the command.
        if ($this->isTty) return $this->process->run();

        // In nonTTY mode hight timeout is required because some advanced output is not displayed.
        $this->process->setTimeout(3600);
        $this->process->setIdleTimeout(300);

        // Run the process and print out the output
        return $this->process->run(function ($type, $data) {
            $this->output->write($data);
        });
    }

    protected function tryTty()
    {
        try {
            $this->process->setTty(true);
            $this->isTty = true;
        } catch (RuntimeException $e) {
            $this->error('TTY not enabled. Running in default mode...');
        }
    }

    protected function checkInstallation()
    {
        $installed = File::exists(base_path(config('laradock.directory') . '/.env'));
        if ($installed) return;

        $this->error('Laradock not installed!');
        $this->info('Please execute this command:');
        $this->line('$ php artisan laradock:install');

        die();
    }
}
