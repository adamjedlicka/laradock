<?php

namespace AdamJedlicka\Laradock;

use Illuminate\Contracts\Console\Kernel;
use AdamJedlicka\Laradock\Console\Commands\LaradockUp;
use AdamJedlicka\Laradock\Console\Commands\LaradockDown;
use AdamJedlicka\Laradock\Console\Commands\LaradockInstall;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use AdamJedlicka\Laradock\Console\Commands\LaradockEnv;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laradock.php', 'laradock');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $this->publishes([
            __DIR__ . '/../config/laradock.php' => config_path('laradock.php'),
        ]);

        $kernel->registerCommand(new LaradockInstall);
        $kernel->registerCommand(new LaradockUp);
        $kernel->registerCommand(new LaradockDown);
        $kernel->registerCommand(new LaradockEnv);
    }
}
