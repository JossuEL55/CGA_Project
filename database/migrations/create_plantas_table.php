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
        Schema::create('plantas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_planta')->primary();
            $table->string('nombre', 100);
            $table->string('ubicacion', 150);
            $table->integer('id_cliente');
            $table->timestamps();
    
            // $table->foreign('id_cliente')->references('id_cliente')->on('clientes')->onDelete('cascade');
        });
    }
};