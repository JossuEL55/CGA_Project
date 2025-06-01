<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_tecnicas', function (Blueprint $table) {
            $table->increments('id_orden');
            $table->text('descripcion');
            $table->text('observaciones')->nullable();  // ✓ corresponde al modelo
            $table->date('fecha_servicio')->nullable();
            $table->enum('estado', ['Pendiente','En Proceso','Validada','Rechazada'])
                  ->default('Pendiente');

            $table->unsignedBigInteger('id_planta');
            $table->foreign('id_planta')
                  ->references('id_planta')
                  ->on('plantas')
                  ->onDelete('cascade');

            $table->unsignedInteger('id_tecnico')->nullable();
            $table->foreign('id_tecnico')
                  ->references('id_tecnico')
                  ->on('tecnicos')
                  ->onDelete('set null');

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
