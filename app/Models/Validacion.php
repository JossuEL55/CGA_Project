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
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_validacion',
        'id_orden',
        'validado_por',
        'fecha_validacion',
        'estado_validacion',
    ];

    public function ordenTecnica(): BelongsTo
    {
        return $this->belongsTo(OrdenTecnica::class, 'id_orden', 'id_orden');
    }
}
