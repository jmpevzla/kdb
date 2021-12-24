<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIndexArchivosConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('archivos_conocimientos', function (Blueprint $table) {
            $table->unique(['archivo_id', 'conocimiento_id'], 'archivos_conocimientos_archivo_id_conocimiento_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('archivos_conocimientos', function (Blueprint $table) {
            $table->dropForeign('archivos_conocimientos_archivo_id_foreign');
            $table->dropForeign('archivos_conocimientos_conocimiento_id_foreign');
            $table->dropUnique('archivos_conocimientos_archivo_id_conocimiento_id_unique');
            $table->foreign('archivo_id')->references('id')->on('archivos');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos');
        });
    }
}
