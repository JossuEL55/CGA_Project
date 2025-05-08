<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ordenes_tecnicas', function (Blueprint $table) {
            $table->integer('id_orden')->primary();
            $table->text('descripcion');
            $table->date('fecha_servicio');
            $table->string('estado', 50);
            $table->integer('id_planta');
            $table->integer('id_tecnico');
            $table->timestamps();
    
            // $table->unsignedBigInteger('id_planta');
            // $table->foreign('id_planta')->references('id_planta')->on('plantas')->onDelete('cascade');
        });

    }
};