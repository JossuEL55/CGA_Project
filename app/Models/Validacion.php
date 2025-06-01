<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Validacion extends Model
{
    use HasFactory;

    protected $table = 'validaciones';
    protected $primaryKey = 'id_validacion';

    // En migración definimos increments('id_validacion'), por lo que es auto‐increment.
    public $incrementing = true;

    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_orden',        // FK → ordenes_tecnicas.id_orden
        'id_supervisor',   // FK → tecnicos.id_tecnico
        'resultado',       // Ej. 'Validada' o 'Rechazada'
        'comentarios',     // Texto opcional
    ];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(OrdenTecnica::class, 'id_orden', 'id_orden');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Tecnico::class, 'id_supervisor', 'id_tecnico');
    }
}
