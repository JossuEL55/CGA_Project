<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PlantaController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\OrdenTecnicaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaludoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Rutas públicas
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard (usuario autenticado y verificado)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas para editar perfil (requiere auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
<<<<<<< HEAD
// Rutas Admin
Route::middleware('auth')->group(function(){
=======

// —————— RUTAS ADMIN ——————
Route::middleware('auth')->group(function () {
    // CRUD Cliente
>>>>>>> origin/develop2
    Route::resource('clientes', ClienteController::class);
    Route::resource('plantas', PlantaController::class);
<<<<<<< HEAD
    Route::resource('tecnicos', TecnicoController::class);
    Route::resource('ordenes', OrdenTecnicaController::class)->except(['edit', 'update', 'validar']);
});

// Rutas Supervisor
Route::middleware('auth')->group(function(){
    Route::get('ordenes', [OrdenTecnicaController::class, 'index'])->name('ordenes.index');
    Route::post('ordenes/{ordenTecnica}/validar', [OrdenTecnicaController::class, 'validar'])->name('ordenes.validar');
    Route::resource('validaciones', ValidacionController::class)->only(['index','show','store','create']);
=======

    // CRUD Técnico
    Route::resource('tecnicos', TecnicoController::class)->except(['show']);
    // (si no usas show, lo omites; o bien incluye show si lo creaste)

    // Crear/almacenar Órdenes (un admin puede crear)
    Route::get('ordenes/{ordenTecnica}/asignar', [OrdenTecnicaController::class, 'asignarTecnicoForm'])->name('ordenes.asignar.form');

    // Procesar asignación de técnico
    Route::post('ordenes/{ordenTecnica}/asignar', [OrdenTecnicaController::class, 'asignarTecnico'])->name('ordenes.asignar');
});

// —————— RUTAS ADMIN|SUPERVISOR ——————
Route::middleware('auth')->group(function () {
    // Listar Órdenes
    Route::get('ordenes', [OrdenTecnicaController::class, 'index'])->name('ordenes.index');
    // Ver detalle y validar
    Route::get('ordenes/{ordenTecnica}', [OrdenTecnicaController::class, 'show'])->name('ordenes.show');
    Route::post('ordenes/{ordenTecnica}/validar', [OrdenTecnicaController::class, 'validar'])->name('ordenes.validar');
>>>>>>> origin/develop2
});
// —————— RUTAS TÉCNICO ——————
<<<<<<< HEAD
// Rutas Técnico
Route::middleware('auth')->group(function(){
    Route::get('ordenes/{ordenTecnica}/edit', [OrdenTecnicaController::class,'edit'])->name('ordenes.edit');
    Route::put('ordenes/{ordenTecnica}', [OrdenTecnicaController::class,'update'])->name('ordenes.update');
=======
Route::middleware('auth')->group(function () {
    // Compartido: index estropea la ruta index de admin/supervisor, pero definiste index arriba.
    // Para editar observaciones:
    Route::get('ordenes/{ordenTecnica}/edit', [OrdenTecnicaController::class, 'edit'])->name('ordenes.edit');
    Route::put('ordenes/{ordenTecnica}', [OrdenTecnicaController::class, 'update'])->name('ordenes.update');
>>>>>>> origin/develop2
});

Route::middleware('auth')->group(function () {
    Route::get('validaciones', [ValidacionController::class, 'index'])->name('validaciones.index');
    Route::get('validaciones/create/{orden}', [ValidacionController::class, 'create'])->name('validaciones.create');
    Route::post('validaciones', [ValidacionController::class, 'store'])->name('validaciones.store');
    Route::get('validaciones/{validacion}', [ValidacionController::class, 'show'])->name('validaciones.show');
});


// Carga rutas de autenticación predeterminadas (login, register, etc.)
require __DIR__ . '/auth.php';

