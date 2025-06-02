<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\OrdenTecnica;
use App\Policies\OrdenTecnicaPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        OrdenTecnica::class => OrdenTecnicaPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
