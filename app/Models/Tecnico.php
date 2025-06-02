<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class Tecnico extends Model
{
    use HasFactory, HasRoles;
    protected $guard_name = 'web'; // <- Añadir esta línea

    protected $table = 'tecnicos';
    protected $primaryKey = 'id_tecnico';

    // **CORRECCIÓN**: la migración usó increments('id_tecnico'), 
    // por tanto esto DEBE ser true.
    public $incrementing = true;

    // increments() genera un entero, así que keyType es 'int'
    protected $keyType = 'int';

    public $timestamps = true;

    // En migración definimos: nombre, cedula, especialidad
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Relación: un técnico (en rol “ejecutor”) tiene varias órdenes.
     */
    public function ordenesAsignadas(): HasMany
    {
        // En migración de ordenes_tecnicas: id_tecnico → tecnicos.id_tecnico
        return $this->hasMany(OrdenTecnica::class, 'id_tecnico', 'id_tecnico');
    }

    /**
     * Relación: un técnico (en rol “supervisor”) supervisa muchas órdenes.
     */
    public function ordenesSupervisadas(): HasMany
    {
        // En ordenes_tecnicas: supervisor_id → tecnicos.id_tecnico
        return $this->hasMany(OrdenTecnica::class, 'supervisor_id', 'id_tecnico');
    }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}
}
