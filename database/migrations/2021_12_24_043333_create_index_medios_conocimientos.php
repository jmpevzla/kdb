<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIndexMediosConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medios_conocimientos', function (Blueprint $table) {
            $table->unique(['medio_id', 'conocimiento_id'], 'medios_conocimientos_medio_id_conocimiento_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medios_conocimientos', function (Blueprint $table) {
            $table->dropForeign('medios_conocimientos_medio_id_foreign');
            $table->dropForeign('medios_conocimientos_conocimiento_id_foreign');
            $table->dropUnique('medios_conocimientos_medio_id_conocimiento_id_unique');
            $table->foreign('medio_id')->references('id')->on('medios');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos');
        });
    }
}
