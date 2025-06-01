<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaludoController;
use App\Models\OrdenTecnica;          // 1) Importa el modelo aquí
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', [SaludoController::class, 'index']); 
Route::get('/saludo', [SaludoController::class, 'index']);

// Dashboard (requiere usuario autenticado)
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

    // Si no hay ninguna orden en BD, devolvemos un array “vacío”
    if (! $orden) {
        return response()->json([
            'mensaje' => 'No hay órdenes en la base de datos.'
        ], 404);
    }

    return [
        'orden_id'     => $orden->id,                     // Ten en cuenta que tu PK puede ser 'id_orden' o 'id'; ajusta si es distinto
        'cliente'      => $orden->cliente?->nombre,        // Si existe relación cliente, mostramos nombre
        'planta'       => $orden->planta?->nombre,         // Si existe relación planta, mostramos nombre
        'tecnico'      => $orden->tecnico?->name,          // Si existe relación técnico, mostramos name
        'supervisor'   => $orden->supervisor?->name,       // Si existe relación supervisor, mostramos name
        'estado'       => $orden->estado,
        'observaciones'=> $orden->observaciones,
    ];
});
// Si prefieres protegerla con autenticación, reemplaza la línea anterior por:
// Route::get('/debug-relaciones', function() { … })->middleware('auth');

// Finalmente cargamos las rutas de autenticación predeterminadas
require __DIR__ . '/auth.php';
