<?php

declare(strict_types=1);

namespace SergeevPasha\Pecom\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use SergeevPasha\Pecom\Libraries\PecomClient;

class PecomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/pecom.php', 'pecom');
        $this->app->singleton(PecomClient::class, fn () => new PecomClient(config('pecom.user'), config('pecom.key')));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerRoutes();
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'pecom');
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/pecom.php' => config_path('pecom.php'),
            ], 'config');
        }
    }
    
    /**
     * Register routes
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }
    
    /**
     * Routes Configuration
     *
     * @return array<mixed>
     */
    protected function routeConfiguration(): array
    {
        return [
            'prefix' => config('pecom.prefix'),
            'middleware' => config('pecom.middleware'),
        ];
    }
}
