<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Cliente;        // ← Importa Cliente
use App\Models\OrdenTecnica;   // ← Importa OrdenTecnica

class Planta extends Model
{
    use HasFactory;

    protected $table = 'plantas';
    protected $primaryKey = 'id_planta';
    public $incrementing = true;   // bigIncrements → se mapea como int
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_cliente',
        'nombre',
        'ubicacion',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function ordenes(): HasMany
    {
        return $this->hasMany(OrdenTecnica::class, 'id_planta', 'id_planta');
    }
}
