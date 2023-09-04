<?php

namespace App\Parents;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class BaseServiceProvider extends ServiceProvider
{
    /**
     * The application instance.
     * @var Application
     */
    protected $app;
}
