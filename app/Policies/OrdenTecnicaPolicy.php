<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrdenTecnica;

class OrdenTecnicaPolicy
{
    // Método para permitir actualización solo al técnico asignado
    public function update(User $user, OrdenTecnica $orden)
    {
        return $user->hasRole('tecnico') &&
               $user->tecnico &&
               $orden->id_tecnico == $user->tecnico->id_tecnico;
    }

    // Método para validar solo para supervisores
    public function validar(User $user, OrdenTecnica $orden)
    {
        return $user->hasRole('supervisor');
    }

    // Método para ver la orden para admin, supervisor o técnico asignado
    public function view(User $user, OrdenTecnica $orden)
    {
        return $user->hasAnyRole(['admin', 'supervisor']) ||
               ($user->hasRole('tecnico') &&
                $user->tecnico &&
                $orden->id_tecnico == $user->tecnico->id_tecnico);
    }
}
