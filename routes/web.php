<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PlantaController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\OrdenTecnicaController;
use App\Http\Controllers\ProfileController;

// ---------------- RUTAS PÚBLICAS ----------------
Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__ . '/auth.php';

// ---------------- DASHBOARD ----------------
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

    // 4) CRUD Órdenes Técnicas
    Route::resource('ordenes', OrdenTecnicaController::class);

    // 5) Asignar técnico a orden
    Route::get('ordenes/{orden}/asignar', [OrdenTecnicaController::class, 'asignarTecnicoForm'])
         ->name('ordenes.asignar.form');
    Route::post('ordenes/{orden}/asignar', [OrdenTecnicaController::class, 'asignarTecnico'])
         ->name('ordenes.asignar');

    // 6) Validar orden (solo rol: supervisor)
    Route::get('ordenes/{orden}/validar', [OrdenTecnicaController::class, 'validarForm'])
         ->name('ordenes.validarForm');

    Route::post('ordenes/{orden}/validar', [OrdenTecnicaController::class, 'validar'])
         ->name('ordenes.validar');
   
});
