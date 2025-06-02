<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdenTecnica extends Model
{
    use HasFactory;

    protected $table = 'ordenes_tecnicas';
    protected $primaryKey = 'id_orden';

    // Solo los campos que realmente existen en la tabla
    protected $fillable = [
        'descripcion',
        'fecha_servicio',
        'id_planta',
        'id_tecnico',
        'estado',
        'supervisor_id',
    ];

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class, 'id_tecnico', 'id_tecnico');
    }

    public function supervisor()
    {
        return $this->belongsTo(Tecnico::class, 'supervisor_id', 'id_tecnico');
    }

    public function planta()
    {
        return $this->belongsTo(Planta::class, 'id_planta', 'id_planta');
    }

    public function validaciones()
    {
        return $this->hasMany(Validacion::class, 'id_orden');
    }
}