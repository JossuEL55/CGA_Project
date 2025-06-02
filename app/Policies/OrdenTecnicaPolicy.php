<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrdenTecnica;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrdenTecnicaPolicy
{
    use HandlesAuthorization;

    /**
     * Método que intercepta primero: si el user es "admin" le damos acceso total.
     * Pero en este ejemplo despreciamos “admin” y queremos que solo el
     * supervisor pueda validar. Si quisiera que admin también valide, podría quedar:
     *
     *     if($user->rol==='admin') return true;
     *
     * En este caso dejamos TODO a false excepto validar().
     */
    public function before(User $user, $ability)
    {
        // Si quisieras dejar que admin también valide, descomenta la siguiente línea:
        // if($user->rol==='admin') return true;
    }

    /**
     * Este método controla si el usuario puede cambiar el estado de la orden.
     * (Es decir, “validar” la orden.) Solo devolvemos true para 'supervisor'.
     */
    public function validar(User $user, OrdenTecnica $orden)
    {
        return $user->rol === 'supervisor';
    }

    // IMPORTANTE: no definimos viewAny, view, create, update, etc.  
    // Si un método no existe, Laravel lo trata como “no autorizado”.  
    // Solo existe validar(): por lo tanto, todas las demás acciones
    // (crear/editar/ver detalles) caerán por defecto en “403” si
    // las autorizas con esta policy.  
    // Pero para no bloquear “index” o “show”, simplemente NO LLEVES
    // a cabo ninguna llamada a authorize() en esos métodos.
}
