<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // aquí tus binds, por ejemplo:
        // $this->app->bind(…);
    }

    public function boot(): void
    {
        // código que quieras ejecutar al boot
    }
}
