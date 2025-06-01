<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenTecnica extends Model
{
    use HasFactory;

    protected $table = 'ordenes_tecnicas';
    protected $primaryKey = 'id_orden';

    // La migración usó increments('id_orden'), por tanto auto‐incremental
    public $incrementing = true;

    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'descripcion',
        'fecha_servicio',
        'estado',
        'id_planta',       // FK a plantas.id_planta
        'id_tecnico',      // FK a tecnicos.id_tecnico
        'supervisor_id',   // FK a tecnicos.id_tecnico
    ];

    public function planta(): BelongsTo
    {
        // FK: ordenes_tecnicas.planta_id → plantas.id_planta
        return $this->belongsTo(Planta::class, 'id_planta', 'id_planta');
    }

    public function tecnico(): BelongsTo
    {
        // FK: ordenes_tecnicas.id_tecnico → tecnicos.id_tecnico
        return $this->belongsTo(Tecnico::class, 'id_tecnico', 'id_tecnico');
    }

    public function supervisor(): BelongsTo
    {
        // FK: ordenes_tecnicas.supervisor_id → tecnicos.id_tecnico (puede ser null)
        return $this->belongsTo(Tecnico::class, 'supervisor_id', 'id_tecnico');
    }

    /**
     * (Opcional) Si quieres acceder al cliente directamente desde la orden,
     * agrega esta relación *solo si* la tabla ordenes_tecnicas tiene columna cliente_id
     * y definiste la migración en consecuencia. Si usas el diagrama que sugerí (sin cliente_id),
     * omite este método.
     */
    // public function cliente(): BelongsTo
    // {
    //     return $this->belongsTo(Cliente::class, 'cliente_id', 'id_cliente');
    // }
}
