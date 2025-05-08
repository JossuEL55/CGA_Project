<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tecnico extends Model
{
    use HasFactory;

    protected $table = 'tecnicos';
    protected $primaryKey = 'id_tecnico';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_tecnico',
        'nombre',
        'cedula',
        'especialidad',
    ];

    public function ordenesTecnicas(): HasMany
    {
        return $this->hasMany(OrdenTecnica::class, 'id_tecnico', 'id_tecnico');
    }
}
