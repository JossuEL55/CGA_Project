<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // …

    protected $routeMiddleware = [
        // Middlewares que ya vienen por defecto:
        'auth'       => \App\Http\Middleware\Authenticate::class,
        'verified'   => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'guest'      => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle'   => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'signed'     => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'bindings'   => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        // … otros middlewares que puedas tener …

        // Asegúrate de agregar estas líneas **exactamente** (si instalaste Spatie):
        'role'       => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        
        // Ejemplo de un middleware personalizado:
        // 'is_admin'   => \App\Http\Middleware\CheckIfUserIsAdmin::class,
    ];

    // …
}
