<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaludoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PlantaController;
use App\Models\OrdenTecnica;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdenTecnicaController;
/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
|
| Estas rutas no requieren ningún middleware especial. 
| Por ejemplo, la página de bienvenida (SaludoController) es accesible para
| cualquier visitante sin autenticación.
|
*/

// Página de bienvenida / saludo
Route::get('/', [SaludoController::class, 'index'])->name('home');
Route::get('/saludo', [SaludoController::class, 'index'])->name('saludo');

/*
|--------------------------------------------------------------------------
| DASHBOARD (requiere usuario autenticado y verificado)
|--------------------------------------------------------------------------
|
| Esta ruta solo estará disponible para usuarios autenticados y cuyo correo 
| esté verificado. Si no quieres la verificación de correo, quita 'verified'.
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| PERFIL DEL USUARIO (requiere autenticación)
|--------------------------------------------------------------------------
|
| Grupo de rutas para editar, actualizar o eliminar el perfil del usuario
| que ya está autenticado.
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| RUTA DE DEPURACIÓN (OPCIONAL)
|--------------------------------------------------------------------------
|
| Esta ruta carga la primera OrdenTécnica junto con sus relaciones 
| (cliente, planta, técnico, supervisor). 
| 
| - Si la quieres pública, la dejas así.
| - Si prefieres que solo usuarios autenticados puedan usarla, 
|   agrega ->middleware('auth') después de la definición.
| - Si luego implementas roles y quieres que sea solo para admins, 
|   pon ->middleware(['auth','role:admin']).
|
*/

Route::get('/debug-relaciones', function () {
    $orden = OrdenTecnica::with(['cliente', 'planta', 'tecnico', 'supervisor'])->first();

    if (! $orden) {
        return response()->json([
            'mensaje' => 'No hay órdenes en la base de datos.'
        ], 404);
    }

    return [
        'orden_id'   => $orden->id_orden,
        'cliente'    => $orden->cliente?->nombre,
        'planta'     => $orden->planta?->nombre,
        'tecnico'    => $orden->tecnico?->nombre,
        'supervisor' => $orden->supervisor?->nombre,
        'estado'     => $orden->estado,
    ];
})->name('debug.relaciones');
// Si quieres protegerla con autenticación, cambia la línea anterior por:
// })->middleware('auth')->name('debug.relaciones');

/*
|--------------------------------------------------------------------------
| RUTAS DE ADMINISTRACIÓN (requieren autenticación)
|--------------------------------------------------------------------------
|
| Aquí van los recursos de Clientes y Plantas. En este momento solo
| estamos protegiéndolos con 'auth', pero cuando implementes roles
| podrás reemplazar por ['auth','role:admin'].
|
*/

Route::middleware('auth')->group(function () {
    // CRUD completo para Clientes
    Route::resource('clientes', ClienteController::class);
    
    // CRUD completo para Plantas
    Route::resource('plantas', PlantaController::class);
});

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN PREDETERMINADAS
|--------------------------------------------------------------------------
|
| Al final del archivo incluimos las rutas que genera Laravel Breeze / Jetstream
| o cualquier scaffolding que uses para login / register / contraseña, etc.
|
*/
Route::middleware('auth')->group(function() {
    Route::get('ordenes/create', [OrdenTecnicaController::class, 'create'])
         ->name('ordenes.create');
    Route::post('ordenes', [OrdenTecnicaController::class, 'store'])
         ->name('ordenes.store');
});

// Index/show y validar (admin | supervisor)
Route::middleware('auth')->group(function() {
    Route::get('ordenes', [OrdenTecnicaController::class, 'index'])
         ->name('ordenes.index');
    Route::get('ordenes/{ordenTecnica}', [OrdenTecnicaController::class, 'show'])
         ->name('ordenes.show');
    Route::post('ordenes/{ordenTecnica}/validar', [OrdenTecnicaController::class, 'validar'])
         ->name('ordenes.validar');
});

// Editar/actualizar observaciones (solo técnico)
Route::middleware('auth')->group(function() {
    // El index también lo ve el técnico, por eso lo repetimos sin nombre de ruta
    Route::get('ordenes', [OrdenTecnicaController::class, 'index']);

    Route::get('ordenes/{ordenTecnica}/edit', [OrdenTecnicaController::class, 'edit'])
         ->name('ordenes.edit');
    Route::put('ordenes/{ordenTecnica}', [OrdenTecnicaController::class, 'update'])
         ->name('ordenes.update');
});
require __DIR__ . '/auth.php';
