<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(CollectorRegistry::class, function() {
//            $registry = new CollectorRegistry(new \Prometheus\Storage\InMemory());
            $registry = new CollectorRegistry(new \Prometheus\Storage\Redis(['host'=>'redis']));
            return $registry;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
