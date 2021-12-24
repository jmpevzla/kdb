<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIndexConocimientosRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conocimientos_rel', function (Blueprint $table) {
            $table->unique(['conocimiento_id', 'conocimiento_rel_id'], 'conocimientos_rel_conocimiento_id_conocimiento_rel_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conocimientos_rel', function (Blueprint $table) {
            $table->dropForeign('conocimientos_rel_conocimiento_id_foreign');
            $table->dropForeign('conocimientos_rel_conocimiento_rel_id_foreign');
            $table->dropUnique('conocimientos_rel_conocimiento_id_conocimiento_rel_id_unique');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos');
            $table->foreign('conocimiento_rel_id')->references('id')->on('conocimientos');
        });
    }
}
