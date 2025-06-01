<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';
    public $incrementing = true;    // id_cliente será auto‐incremental
    protected $keyType = 'int';
    public $timestamps = true;      // espera campos created_at y updated_at

    protected $fillable = [
        'nombre',
        'ruc',
        'correo',
        'telefono',
    ];

    public function plantas(): HasMany
    {
        // En la tabla "plantas", la columna foreign key se llama "cliente_id"
        // y aquí la PK de Cliente es "id_cliente" según la migración.
        return $this->hasMany(Planta::class, 'cliente_id', 'id_cliente');
    }
}

