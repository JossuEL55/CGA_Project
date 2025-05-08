<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrdenTecnica extends Model
{
    use HasFactory;

    protected $table = 'ordenes_tecnicas';
    protected $primaryKey = 'id_orden';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_orden',
        'descripcion',
        'fecha_servicio',
        'estado',
        'id_planta',
        'id_tecnico',
    ];

    public function planta(): BelongsTo
    {
        return $this->belongsTo(Planta::class, 'id_planta', 'id_planta');
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(Tecnico::class, 'id_tecnico', 'id_tecnico');
    }

    public function validaciones(): HasMany
    {
        return $this->hasMany(Validacion::class, 'id_orden', 'id_orden');
    }
}
