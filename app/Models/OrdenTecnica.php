<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenTecnica extends Model
{
    use HasFactory;

    protected $table = 'ordenes_tecnicas';
    protected $primaryKey = 'id_orden'; // PK en migración, por ejemplo "increments('id_orden')"
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;          // espera created_at y updated_at

    protected $fillable = [
        'cliente_id',     // FK → clientes.id_cliente
        'planta_id',      // FK → plantas.id_planta
        'tecnico_id',     // FK → users.id
        'supervisor_id',  // FK → users.id
        'estado',
        'observaciones',
    ];

    public function cliente(): BelongsTo
    {
        // Pertenece a un Cliente; "cliente_id" referencia "clientes.id_cliente"
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id_cliente');
    }

    public function planta(): BelongsTo
    {
        // Pertenece a una Planta; "planta_id" referencia "plantas.id_planta"
        return $this->belongsTo(Planta::class, 'planta_id', 'id_planta');
    }

    public function tecnico(): BelongsTo
    {
        // Pertenece a un Usuario (técnico); "tecnico_id" referencia "users.id"
        return $this->belongsTo(User::class, 'tecnico_id', 'id');
    }

    public function supervisor(): BelongsTo
    {
        // Pertenece a un Usuario (supervisor); "supervisor_id" referencia "users.id"
        return $this->belongsTo(User::class, 'supervisor_id', 'id');
    }
}