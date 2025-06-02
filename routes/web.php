<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PlantaController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\OrdenTecnicaController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se definen todas las rutas web de la aplicación.
*/

// ---------------- RUTAS PÚBLICAS ----------------
Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__ . '/auth.php';

// ---------------- DASHBOARD PRINCIPAL ----------------
Route::get('/dashboard', function () {
    return view('dashboard');
})
->middleware(['auth', 'verified'])
->name('dashboard');

// ---------------- PERFIL DE USUARIO ----------------
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------- RUTAS “ADMIN / SUPERVISOR / TÉCNICO” ----------------
Route::middleware(['auth'])->group(function () {

    // 1) CRUD Cliente
    Route::resource('clientes', ClienteController::class);

    // 2) CRUD Planta
    Route::resource('plantas', PlantaController::class);

    // 3) CRUD Técnico (excluimos “show” si no lo usamos)
    Route::resource('tecnicos', TecnicoController::class)->except(['show']);

    // 4) Dashboard específico de Órdenes Técnicas
    //    (debe definirse antes de Route::resource('ordenes', ...) para evitar colisiones)
    Route::get('ordenes/dashboard', [OrdenTecnicaController::class, 'dashboard'])
         ->name('ordenes.dashboard');

    // 5) CRUD Órdenes Técnicas (incluye método “show” para ver detalle de orden)
    Route::resource('ordenes', OrdenTecnicaController::class);

    // 6) Asignar técnico a una orden (formulario y acción)
    Route::get('ordenes/{orden}/asignar', [OrdenTecnicaController::class, 'asignarTecnicoForm'])
         ->name('ordenes.asignar.form');
    Route::post('ordenes/{orden}/asignar', [OrdenTecnicaController::class, 'asignarTecnico'])
         ->name('ordenes.asignar');

    // 7) Validar una orden (formulario y acción) — solo rol “supervisor”
    Route::get('ordenes/{orden}/validar', [OrdenTecnicaController::class, 'validarForm'])
         ->name('ordenes.validarForm');
    Route::post('ordenes/{orden}/validar', [OrdenTecnicaController::class, 'validar'])
         ->name('ordenes.validar');

    // 8) Historial de Órdenes (general, con filtros opcionales)
    Route::get('ordenes/historial', [OrdenTecnicaController::class, 'historial'])
         ->name('ordenes.historial');

    // 9) Historial de Órdenes filtrado por cliente
    Route::get('ordenes/historial/cliente/{cliente}', [OrdenTecnicaController::class, 'historialPorCliente'])
         ->name('ordenes.historial.cliente');

    // 10) Historial de Órdenes filtrado por técnico
    Route::get('ordenes/historial/tecnico/{tecnico}', [OrdenTecnicaController::class, 'historialPorTecnico'])
         ->name('ordenes.historial.tecnico');
});
