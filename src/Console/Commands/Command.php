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
        if (!is_string($cmd)) $cmd = implode(' ', $cmd);

        $this->info("$ $cmd");

        $this->process = new Process($cmd, $cwd);

        return $this->process->run(function ($type, $data) {
            $this->output->write($data);
        });
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
