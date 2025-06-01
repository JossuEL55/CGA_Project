<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Validacion extends Model
{
    protected $table = 'validaciones';
    protected $primaryKey = 'id_validacion';
    public $timestamps = true;

    protected $fillable = [
        'id_orden',
        'id_supervisor',
        'estado_validacion',
        'comentarios',
    ];

    public function orden()
    {
        return $this->belongsTo(OrdenTecnica::class, 'id_orden', 'id_orden');
    }

    public function supervisor()
    {
        return $this->belongsTo(Tecnico::class, 'id_supervisor', 'id_tecnico');
    }
}

