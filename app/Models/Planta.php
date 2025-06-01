<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Planta extends Model
{
    use HasFactory;

    protected $table = 'plantas';
    protected $primaryKey = 'id_planta';

    // En la migración usamos bigIncrements('id_planta'), así que también es auto‐incremental.
    public $incrementing = true;

    // bigIncrements() crea un BIGINT, pero Laravel lo mapea como int en el modelo.
    protected $keyType = 'int';

    public $timestamps = true;

    // En migración definimos: id_cliente, nombre, ubicacion
    protected $fillable = [
        'id_cliente',
        'nombre',
        'ubicacion',
    ];

    public function cliente(): BelongsTo
    {
        // En migración la tabla 'plantas' tiene una FK id_cliente → clientes.id_cliente
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function ordenes(): HasMany
    {
        // En migración definimos FK planta_id → plantas.id_planta
        return $this->hasMany(OrdenTecnica::class, 'id_planta', 'id_planta');
    }
}
