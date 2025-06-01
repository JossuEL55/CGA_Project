<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            // PK auto‐incremental SERIAL en PostgreSQL
            $table->increments('id_cliente');

            $table->string('nombre', 100);
            $table->string('ruc', 13)->unique();
            $table->string('correo')->unique();
            $table->string('telefono', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
