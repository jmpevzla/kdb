<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexUsersConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_conocimientos', function (Blueprint $table) {
            $table->unique(['user_id', 'conocimiento_id'], 'users_conocimientos_user_id_conocimiento_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_conocimientos', function (Blueprint $table) {
            $table->dropForeign('users_conocimientos_user_id_foreign');
            $table->dropForeign('users_conocimientos_conocimiento_id_foreign');
            $table->dropUnique('users_conocimientos_user_id_conocimiento_id_unique');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos');
        });
    }
}
