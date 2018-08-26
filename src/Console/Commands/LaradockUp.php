<?php

namespace AdamJedlicka\Laradock\Console\Commands;

class LaradockUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laradock:up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts up docker containers';

    /**
     * Command to be executed
     *
     * @var array
     */
    protected $cmd = ['docker-compose', 'up', '-d'];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->checkInstallation();

        return $this->exec(
            array_merge($this->cmd, config('laradock.containers')),
            config('laradock.directory')
        );
    }
}
