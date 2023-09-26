<?php

namespace App\Providers;

use App\Application;
use App\Start;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Routing\Router;

/**
 * @property Application $app
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        $this->app->router->group([], function (Router $router) {
            $router->post(
                env('TELEGRAM_BOT_WEBHOOK'),
                Start::class . '@start'
            );
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
