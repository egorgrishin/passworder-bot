<?php

namespace App\Providers;

use App\Parents\BaseServiceProvider;
use App\Start;
use Laravel\Lumen\Routing\Router;

class AppServiceProvider extends BaseServiceProvider
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
