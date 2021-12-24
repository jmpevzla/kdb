<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIndexGruposConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grupos_conocimientos', function (Blueprint $table) {
            $table->unique(['grupo_id', 'conocimiento_id'], 'grupos_conocimientos_grupo_id_conocimiento_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grupos_conocimientos', function (Blueprint $table) {
            $table->dropForeign('grupos_conocimientos_grupo_id_foreign');
            $table->dropForeign('grupos_conocimientos_conocimiento_id_foreign');
            $table->dropUnique('grupos_conocimientos_grupo_id_conocimiento_id_unique');
            $table->foreign('grupo_id')->references('id')->on('grupos');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos');
        });
    }
}
