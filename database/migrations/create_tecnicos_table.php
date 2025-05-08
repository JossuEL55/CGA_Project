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
        Schema::create('tecnicos', function (Blueprint $table) {
            $table->integer('id_tecnico')->primary();
            $table->string('nombre', 100);
            $table->string('cedula', 20);
            $table->string('especialidad', 100);
            $table->timestamps();
        });
    }
};  