<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIndexAutoresConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autores_conocimientos', function (Blueprint $table) {
            $table->unique(['persona_id', 'conocimiento_id'], 'autores_conocimientos_persona_id_conocimiento_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('autores_conocimientos', function (Blueprint $table) {
            $table->dropForeign('autores_conocimientos_persona_id_foreign');
            $table->dropForeign('autores_conocimientos_conocimiento_id_foreign');
            $table->dropUnique('autores_conocimientos_persona_id_conocimiento_id_unique');
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos');
        });
    }
}
