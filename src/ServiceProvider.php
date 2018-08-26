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
        $this->commands([
            LaradockInstall::class,
            LaradockUp::class,
            LaradockEnv::class,
            LaradockDown::class,
        ]);
    }
}
