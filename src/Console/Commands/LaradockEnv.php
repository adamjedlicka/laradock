<?php

namespace AdamJedlicka\Laradock\Console\Commands;

use Symfony\Component\Process\Process;


class LaradockEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laradock:env {cmd?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enters the workspace container in interactive shell';

    /**
     * Command to be executed
     *
     * @var array
     */
    protected $cmd = 'docker-compose exec --user=laradock workspace';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->checkInstallation();

        $cmd = implode(' ', $this->argument('cmd')) ? : 'bash';

        if ($cmd != 'bash') {
            $cmd = "bash -lc '{$cmd}'";
        }

        $process = new Process("{$this->cmd} {$cmd}", config('laradock.directory'));
        $process->setTty(true);

        return $process->run();
    }
}
