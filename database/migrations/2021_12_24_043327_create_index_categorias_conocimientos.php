<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIndexCategoriasConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categorias_conocimientos', function (Blueprint $table) {
            $table->unique(['categoria_id', 'conocimiento_id'], 'categorias_conocimientos_categoria_id_conocimiento_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categorias_conocimientos', function (Blueprint $table) {
            $table->dropForeign('categorias_conocimientos_categoria_id_foreign');
            $table->dropForeign('categorias_conocimientos_conocimiento_id_foreign');
            $table->dropUnique('categorias_conocimientos_categoria_id_conocimiento_id_unique');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos');
        });
    }
}
