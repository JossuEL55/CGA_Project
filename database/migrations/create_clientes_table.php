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
        Schema::create('clientes', function (Blueprint $table) {
            $table->integer('id_cliente')->primary();
            $table->string('nombre', 100);
            $table->string('ruc', 20);
            $table->string('correo', 100);
            $table->string('telefono', 20);
            $table->timestamps();
        });

    }
};
