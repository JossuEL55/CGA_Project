<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('validaciones', function (Blueprint $table) {
            // PK SIMÉTRICO a un entero, aunque no auto‐incremental; aquí lo hacemos manual
            $table->integer('id_validacion')->primary();

            // FK → ordenes_tecnicas.id_orden
            $table->unsignedInteger('id_orden');
            $table->foreign('id_orden')
                  ->references('id_orden')
                  ->on('ordenes_tecnicas')
                  ->onDelete('cascade');

            // Nota: según tu migración, no se creó id_supervisor en esta tabla,
            // sino que existe una columna "validado_por" en lugar de "id_supervisor".
            // Por lo tanto, creamos exactamente las columnas que definiste:
            $table->string('validado_por', 100);
            $table->dateTime('fecha_validacion');
            $table->string('estado_validacion', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('validaciones');
    }
};
