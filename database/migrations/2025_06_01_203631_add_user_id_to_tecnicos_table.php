<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToTecnicosTable extends Migration
{
    public function up()
    {
        Schema::table('tecnicos', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id_tecnico');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('tecnicos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}