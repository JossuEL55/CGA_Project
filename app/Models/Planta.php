<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Planta extends Model
{
    use HasFactory;

    protected $table = 'plantas';
    protected $primaryKey = 'id_planta';
    public $incrementing = true;    // id_planta auto‐incremental
    protected $keyType = 'int';
    public $timestamps = true;      // espera created_at y updated_at

    protected $fillable = [
        'cliente_id',               // FK hacia clientes.id_cliente
        'nombre',
        'ubicacion',
    ];

    public function cliente(): BelongsTo
    {
        // Pertenece a un Cliente; en la tabla "plantas" hay "cliente_id"
        // que referencia "clientes.id_cliente".
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id_cliente');
    }

    public function ordenes(): HasMany
    {
        // Una Planta puede tener varias Órdenes Técnicas.
        // En ordenes_tecnicas, la fk es "planta_id" que apunta a "plantas.id_planta".
        return $this->hasMany(OrdenTecnica::class, 'planta_id', 'id_planta');
    }
}