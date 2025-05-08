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
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_cliente',
        'nombre',
        'ruc',
        'correo',
        'telefono',
    ];

    public function plantas(): HasMany
    {
        return $this->hasMany(Planta::class, 'id_cliente', 'id_cliente');
    }
}