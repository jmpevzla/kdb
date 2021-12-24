<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIndexEtiquetasConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etiquetas_conocimientos', function (Blueprint $table) {
            $table->unique(['etiqueta_id', 'conocimiento_id'], 'etiquetas_conocimientos_etiqueta_id_conocimiento_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etiquetas_conocimientos', function (Blueprint $table) {
            $table->dropForeign('etiquetas_conocimientos_etiqueta_id_foreign');
            $table->dropForeign('etiquetas_conocimientos_conocimiento_id_foreign');
            $table->dropUnique('etiquetas_conocimientos_etiqueta_id_conocimiento_id_unique');
            $table->foreign('etiqueta_id')->references('id')->on('etiquetas');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos');
        });
    }
}
