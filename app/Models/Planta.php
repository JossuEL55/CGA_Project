<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Planta extends Model
{
    use HasFactory;

    protected $table = 'plantas';
    protected $primaryKey = 'id_planta';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_planta',
        'nombre',
        'ubicacion',
        'id_cliente',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function ordenesTecnicas(): HasMany
    {
        return $this->hasMany(OrdenTecnica::class, 'id_planta', 'id_planta');
    }
}
