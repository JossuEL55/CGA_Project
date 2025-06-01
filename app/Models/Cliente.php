<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class Cliente extends Model
{
    use HasFactory, HasRoles;
    protected $guard_name = 'web'; // <- Añadir esta línea


    // 1. Nombre de la tabla (Laravel lo infiere, pero no está de más)
    protected $table = 'clientes';

    // 2. Clave primaria personalizada
    protected $primaryKey = 'id_cliente';

    // 3. increments('id_cliente') hace que la PK sea auto-incremental
    public $incrementing = true;

    // 4. increments() genera un entero en la BD, así que el tipo es 'int'
    protected $keyType = 'int';

    // 5. Laravel manejará created_at y updated_at
    public $timestamps = true;

    // 6. Solo incluyo los campos que quiero asignar masivamente:
    //    no pongo 'id_cliente' aquí porque la BD lo genera sola.
    protected $fillable = [
        'name',
        'email',
        'password',
        ,
    ];

    /**
     * Relación: un cliente tiene muchas plantas.
     */
    public function plantas(): HasMany
    {
        // En la migración definimos `id_cliente` como FK en plantas.
        return $this->hasMany(Planta::class, 'id_cliente', 'id_cliente');
    }
}

