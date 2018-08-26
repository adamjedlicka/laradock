<?php

namespace AdamJedlicka\Laradock\Console\Commands;

class LaradockDown extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laradock:down';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shuts down docker containers';

    /**
     * Command to be executed
     *
     * @var array
     */
    protected $cmd = ['docker-compose', 'down'];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->checkInstallation();

        return $this->exec(
            $this->cmd,
            config('laradock.directory')
        );
    }
}
