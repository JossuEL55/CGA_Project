<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use App\Models\OrdenTecnica;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    // nombre de la tabla es "users" (Laravel lo infiere)

    protected $fillable = [
        'name',
        'email',
        'password',
        // Si añadiste otros campos (cedula, especialidad) en users, agrégalos aquí.
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Si bien en este Core estamos usando la tabla "tecnicos" para las órdenes,
    // este modelo User sirve para autenticación. Si necesitas enlazar User ↔ Tećnico,
    // tendrías que crear una relación adicional (no está en el alcance básico del Core).

    // Relaciones inversas a OrdenTecnica (solo si tu esquema usa user_id en lugar de id_tecnico).

}
