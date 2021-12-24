<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIndexLinksArchivosConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('links-archivos_conocimientos', function (Blueprint $table) {
            $table->unique(['link_id', 'conocimiento_id'], 'links_archivos_conocimientos_link_id_conocimiento_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links-archivos_conocimientos', function (Blueprint $table) {
            $table->dropForeign('links_archivos_conocimientos_link_id_foreign');
            $table->dropForeign('links_archivos_conocimientos_conocimiento_id_foreign');
            $table->dropUnique('links_archivos_conocimientos_link_id_conocimiento_id_unique');
            $table->foreign('link_id')->references('id')->on('links');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos');
        });
    }
}
