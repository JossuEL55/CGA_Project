<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agrega una columna "rol" tipo string. Por ejemplo:
            $table->string('rol', 20)->default('supervisor')->after('password');
            // Puedes cambiar el valor por defecto o eliminar ->default(...) si quieres gestionar
            // el rol al crear manualmente cada usuario.
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rol');
        });
    }
};
