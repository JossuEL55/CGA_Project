<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Si tu PK es “id_cliente” en lugar de “id”, agrégalo:
    protected $primaryKey = 'id_cliente';

    // Si quieres usar auto-increment con nombre personalizado:
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
        'ruc',
        'correo',
        'telefono',
        // … otros campos que hayas definido
    ];

    // Si es necesario, define relaciones con Plantas, etc.
    public function plantas()
    {
        return $this->hasMany(Planta::class, 'id_cliente', 'id_cliente');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Si tu PK es “id_cliente” en lugar de “id”, agrégalo:
    protected $primaryKey = 'id_cliente';

    // Si quieres usar auto-increment con nombre personalizado:
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
        'ruc',
        'correo',
        'telefono',
        // … otros campos que hayas definido
    ];

    // Si es necesario, define relaciones con Plantas, etc.
    public function plantas()
    {
        return $this->hasMany(Planta::class, 'id_cliente', 'id_cliente');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Si tu PK es “id_cliente” en lugar de “id”, agrégalo:
    protected $primaryKey = 'id_cliente';

    // Si quieres usar auto-increment con nombre personalizado:
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
        'ruc',
        'correo',
        'telefono',
        // … otros campos que hayas definido
    ];

    // Si es necesario, define relaciones con Plantas, etc.
    public function plantas()
    {
        return $this->hasMany(Planta::class, 'id_cliente', 'id_cliente');
    }
}
