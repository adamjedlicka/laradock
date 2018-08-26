<?php

namespace AdamJedlicka\Laradock\Console\Commands;

use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\File;

class LaradockInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laradock:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the laradock';

    /**
     * Laradock repository
     *
     * @var string
     */
    protected $repository = 'https://github.com/Laradock/laradock.git';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        File::exists(base_path(config('laradock.directory')))
            ? $this->pullRepository()
            : $this->cloneRepository();

        $this->checkoutVersion();

        $this->createEnvFile();
    }

    protected function pullRepository()
    {
        $this->exec('git pull origin master', config('laradock.directory'));
    }

    protected function cloneRepository()
    {
        $repository = $this->repository;
        $directory = config('laradock.directory');

        $this->exec("git clone $repository $directory");
    }

    protected function checkoutVersion()
    {
        $version = config('laradock.version');

        $this->exec("git checkout $version", config('laradock.directory'));
    }

    protected function createEnvFile()
    {
        $source = 'env-example';
        $target = '.env';

        $this->exec("cp $source $target", config('laradock.directory'));
    }
}
