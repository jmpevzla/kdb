<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexUsersGrupos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_grupos', function (Blueprint $table) {
            $table->unique(['user_id', 'grupo_id'], 'users_grupos_user_id_grupo_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_grupos', function (Blueprint $table) {
            $table->dropForeign('users_grupos_user_id_foreign');
            $table->dropForeign('users_grupos_grupo_id_foreign');
            $table->dropUnique('users_grupos_user_id_grupo_id_unique');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('grupo_id')->references('id')->on('grupos');
        });
    }
}
