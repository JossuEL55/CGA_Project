<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdenTecnica extends Model
{
    use HasFactory;

    protected $table = 'ordenes_tecnicas'; // nombre real de la tabla
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

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class, 'id_tecnico', 'id_tecnico');
    }

    public function supervisor()
    {
        return $this->belongsTo(Tecnico::class, 'supervisor_id', 'id_tecnico');
    }
public function validaciones(){
    return $this->hasMany(Validacion::class,'id_orden');
}
    

}
