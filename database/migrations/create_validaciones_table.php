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
    {Schema::create('validaciones', function (Blueprint $table) {
        $table->integer('id_validacion')->primary();
        $table->integer('id_orden');
        $table->string('validado_por', 100);
        $table->dateTime('fecha_validacion');
        $table->string('estado_validacion', 50);
        $table->timestamps();

        $table->foreign('id_orden')->references('id_orden')->on('ordenes_tecnicas')->onDelete('cascade');
    });

    }
};