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
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'descripcion',
        'observaciones',
        'fecha_servicio',
        'estado',
        'id_planta',
        'id_tecnico',
        'supervisor_id',
    ];

    public function planta(): BelongsTo
    {
        return $this->belongsTo(Planta::class, 'id_planta', 'id_planta');
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(Tecnico::class, 'id_tecnico', 'id_tecnico');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Tecnico::class, 'supervisor_id', 'id_tecnico');
    }

    

}