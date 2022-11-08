<?php

namespace Xguard\BusinessIntelligence;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Xguard\BusinessIntelligence\Commands\CreateAdmin;
use Xguard\BusinessIntelligence\Http\Middleware\CheckHasAccess;

class BusinessIntelligenceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function register()
    {
        $this->app->make('Xguard\BusinessIntelligence\Http\Controllers\AppController');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'Xguard\BusinessIntelligence');
        $this->mergeConfigFrom(__DIR__.'/../config.php', 'bi');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        app('router')->aliasMiddleware('bi_role_check', CheckHasAccess::class);
        $this->loadMigrationsFrom(__DIR__.'/Http/Middleware');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadMigrationsFrom(__DIR__.'/database/seeds');
        $this->loadFactoriesFrom(__DIR__.'/database/factories');


        $this->commands([CreateAdmin::class]);

        include __DIR__.'/routes/web.php';
        include __DIR__.'/routes/api.php';

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/xguard-bi'),
        ], 'bi-assets');

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            //$schedule->command(DeleteExcessDataPoints::class)->daily(); // TODO: Potential daily re-renders to avoid load times? for quick data? Iunno.
        });
    }
}
