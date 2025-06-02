<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Elimina las columnas que quieras
            $table->dropColumn(['nombre', 'ruc', 'correo', 'telefono']);
        });
        Schema::table('tecnicos', function (Blueprint $table) {
            // Elimina las columnas que quieras
            $table->dropColumn(['nombre', 'especialidad', 'cedula']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Vuelve a crear las columnas (tipo y opciones)
            $table->string('nombre')->nullable();
            $table->string('ruc')->nullable();
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
        });

        Schema::table('tecnicos', function (Blueprint $table) {
            $table->string('nombre')->nullable();
            $table->string('especialidad')->nullable();
            $table->string('cedula')->nullable();

        });
    }
};
