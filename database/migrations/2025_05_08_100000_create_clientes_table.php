<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
git status
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id_cliente');        // SERIAL PK
            $table->string('nombre', 100);
            $table->string('ruc', 13)->unique();
            $table->string('correo')->unique();      // único
            $table->string('telefono', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
