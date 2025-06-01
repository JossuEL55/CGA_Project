<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_tecnicas', function (Blueprint $table) {
            // PK auto‐incremental SERIAL en PostgreSQL
            $table->increments('id_orden');

            $table->text('descripcion');
            $table->date('fecha_servicio')->nullable();

            // Estado con valores fijos
            $table->enum('estado', ['Pendiente', 'En Proceso', 'Validada', 'Rechazada'])
                  ->default('Pendiente');

            // FK → plantas.id_planta
            $table->unsignedBigInteger('id_planta');
            $table->foreign('id_planta')
                  ->references('id_planta')
                  ->on('plantas')
                  ->onDelete('cascade');

            // FK → tecnicos.id_tecnico (técnico responsable)
            $table->unsignedInteger('id_tecnico');
            $table->foreign('id_tecnico')
                  ->references('id_tecnico')
                  ->on('tecnicos')
                  ->onDelete('set null');

            // FK → tecnicos.id_tecnico (supervisor), nullable
            $table->unsignedInteger('supervisor_id')->nullable();
            $table->foreign('supervisor_id')
                  ->references('id_tecnico')
                  ->on('tecnicos')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_tecnicas');
    }
};
