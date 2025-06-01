<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantas', function (Blueprint $table) {
            // PK auto‐incremental (BIGSERIAL en PostgreSQL)
            $table->bigIncrements('id_planta');

            // FK → clientes.id_cliente
            $table->unsignedInteger('id_cliente');
            $table->foreign('id_cliente')
                  ->references('id_cliente')
                  ->on('clientes')
                  ->onDelete('cascade');

            $table->string('nombre', 100);
            $table->string('ubicacion', 150);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plantas');
    }
};
