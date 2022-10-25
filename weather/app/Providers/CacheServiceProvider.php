<?php

namespace App\Providers;

use App\Extensions\MomentoStore;
use App\Extensions\MongoStore;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\ServiceProvider;
use Momento\Auth\EnvMomentoTokenProvider;
use Momento\Cache\SimpleCacheClient;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $cacheName = "laravel-momento";
        $authProvider = new EnvMomentoTokenProvider("MOMENTO_AUTH_TOKEN");
        $momentoSimpleCacheClient = new SimpleCacheClient($authProvider, 60);
        
        $cacheManager = new CacheManager($this->app);
        $this->app->booting(function () use ($momentoSimpleCacheClient, $cacheName, $cacheManager) {
            $cacheManager->extend('momento', function ($app) use ($cacheName, $momentoSimpleCacheClient, $cacheManager) {
                return $cacheManager->repository(new MomentoStore($momentoSimpleCacheClient, $cacheName));
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
