<?php

namespace App\Providers;

use Illuminate\Cache\CacheManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $config = $this->app['config']["cache.stores.momento"];
        $cacheManager = new CacheManager($this->app);
        $this->app->booting(function () use ($config, $cacheManager) {
            $cacheManager->extend('momento', function ($app) use($config, $cacheManager) {
                return $cacheManager->repository(new MomentoStore($config['cache_name'], $config['default_ttl']));
            });
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
