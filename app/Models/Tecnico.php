<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tecnico extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_tecnico';

    public $incrementing = true; // si tu PK es auto-incremental

    protected $fillable = [
        'nombre',
        'cedula',
        'especialidad',
    ];
}
