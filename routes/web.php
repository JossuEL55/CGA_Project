<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaludoController;
use App\Http\Controllers\ClienteController;   // ← Importa tu ClienteController
use App\Http\Controllers\PlantaController;    // ← Importa tu PlantaController
use App\Models\OrdenTecnica;                 // 1) Importa el modelo aquí
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', [SaludoController::class, 'index']);
Route::get('/saludo', [SaludoController::class, 'index']);

// Dashboard (requiere usuario autenticado y verificado)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas que requieren autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ----------
// Ruta de depuración: /debug-relaciones
// ----------
// Si quieres que sea pública, deja así. Si quieres protegerla, agrega ->middleware('auth')
Route::get('/debug-relaciones', function() {
    // Toma la primera OrdenTécnica y carga cliente, planta, técnico y supervisor
    $orden = OrdenTecnica::with(['cliente', 'planta', 'tecnico', 'supervisor'])->first();

    // Si no hay ninguna orden en BD, devolvemos un mensaje
    if (! $orden) {
        return response()->json([
            'mensaje' => 'No hay órdenes en la base de datos.'
        ], 404);
    }

    return [
        'orden_id'     => $orden->id_orden,           // Ajusta a tu PK: 'id_orden', no 'id'
        'cliente'      => $orden->cliente?->nombre,
        'planta'       => $orden->planta?->nombre,
        'tecnico'      => $orden->tecnico?->nombre,    // El modelo Tecnico usa 'nombre'
        'supervisor'   => $orden->supervisor?->nombre, // También 'nombre'
        'estado'       => $orden->estado,
        // Tu modelo no tiene 'observaciones', así que no lo devolvemos
        // si quisieras un campo extra, asegúrate de que exista en la migración
    ];
});
// Para proteger /debug-relaciones con autenticación, usar:
// Route::get('/debug-relaciones', function() { … })->middleware('auth');

// ----------
// Aquí añadimos nuestras rutas resource para admin
// ----------

Route::middleware(['auth', 'role:admin'])->group(function() {
    // Resource completa para Clientes
    Route::resource('clientes', ClienteController::class);
    // Resource completa para Plantas
    Route::resource('plantas', PlantaController::class);
});

// Finalmente cargamos las rutas de autenticación predeterminadas
require __DIR__ . '/auth.php';
