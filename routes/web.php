<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PlantaController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\OrdenTecnicaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaludoController;

// Rutas públicas
Route::get('/', [SaludoController::class, 'index']);
Route::get('/saludo', [SaludoController::class, 'index']);

// Dashboard (usuario autenticado y verificado)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');

// Rutas para editar perfil (requiere auth)
Route::middleware('auth')->group(function() {
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');
});

// —————— RUTAS ADMIN ——————
Route::middleware('auth')->group(function() {
    // CRUD Cliente
    Route::resource('clientes', ClienteController::class);

    // CRUD Planta
    Route::resource('plantas', PlantaController::class);

    // CRUD Técnico
    Route::resource('tecnicos', TecnicoController::class)->except(['show']);
    // (si no usas show, lo omites; o bien incluye show si lo creaste)

    // Crear/almacenar Órdenes (un admin puede crear)
    Route::get('ordenes/create', [OrdenTecnicaController::class,'create'])->name('ordenes.create');
    Route::post('ordenes', [OrdenTecnicaController::class,'store'])->name('ordenes.store');
});

// —————— RUTAS ADMIN|SUPERVISOR ——————
Route::middleware('auth')->group(function() {
    // Listar Órdenes
    Route::get('ordenes', [OrdenTecnicaController::class,'index'])->name('ordenes.index');
    // Ver detalle y validar
    Route::get('ordenes/{ordenTecnica}', [OrdenTecnicaController::class,'show'])->name('ordenes.show');
    Route::post('ordenes/{ordenTecnica}/validar', [OrdenTecnicaController::class,'validar'])->name('ordenes.validar');
});

// —————— RUTAS TÉCNICO ——————
Route::middleware('auth')->group(function() {
    // Compartido: index estropea la ruta index de admin/supervisor, pero definiste index arriba.
    // Para editar observaciones:
    Route::get('ordenes/{ordenTecnica}/edit', [OrdenTecnicaController::class,'edit'])->name('ordenes.edit');
    Route::put('ordenes/{ordenTecnica}', [OrdenTecnicaController::class,'update'])->name('ordenes.update');
});

// Carga rutas de autenticación predeterminadas (login, register, etc.)
require __DIR__.'/auth.php';

