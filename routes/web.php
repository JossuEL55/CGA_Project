<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use Illuminate\Support\Facades\Artisan;

Route::get('/run-migrations', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return '✅ Migraciones ejecutadas con éxito.';
    } catch (Exception $e) {
        return '❌ Error al ejecutar migraciones: ' . $e->getMessage();
    }
});
