<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNameUsuariosConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('usuarios_conocimientos', 'users_conocimientos');

        Schema::table('users_conocimientos', function (Blueprint $table) {
            $table->dropForeign('usuarios_conocimientos_user_id_foreign');
            $table->dropForeign('usuarios_conocimientos_conocimiento_id_foreign');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('users_conocimientos', 'usuarios_conocimientos');

        Schema::table('usuarios_conocimientos', function (Blueprint $table) {
            $table->dropForeign('users_conocimientos_user_id_foreign');
            $table->dropForeign('users_conocimientos_conocimiento_id_foreign');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos');
        });
    }
}
