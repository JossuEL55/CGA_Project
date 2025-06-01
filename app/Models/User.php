<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        // Si creaste más campos en tu migración de users (ej. cargo, telefono), agrégalos aquí.
    ];

    // Si añadiste campos custom (por ej. 'rol' o 'tipo_usuario'), inclúyelos en $fillable:

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Si quisieras, podrías agregar relaciones inversas:
    public function ordenesComoTecnico()
    {
        return $this->hasMany(OrdenTecnica::class, 'tecnico_id');
    }

    public function ordenesComoSupervisor()
    {
        return $this->hasMany(OrdenTecnica::class, 'supervisor_id');
    }
}
