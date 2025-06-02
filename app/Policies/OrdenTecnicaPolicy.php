<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrdenTecnica;

class OrdenTecnicaPolicy
{
    /**
     * Permite validar la orden solo si el usuario tiene rol 'supervisor'.
     */
    public function validar(User $user, OrdenTecnica $orden)
    {
        return $user->rol === 'supervisor';
    }

}