<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoAndSupervisorToOrdenesTecnicasTable extends Migration
{
    public function up()
    {
        Schema::table('ordenes_tecnicas', function (Blueprint $table) {
            $table->string('estado')->default('Pendiente');
            $table->unsignedBigInteger('supervisor_id')->nullable();

            $table->foreign('supervisor_id')->references('id_tecnico')->on('tecnicos')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('ordenes_tecnicas', function (Blueprint $table) {
            $table->dropForeign(['supervisor_id']);
            $table->dropColumn(['estado', 'supervisor_id']);
        });
    }
}