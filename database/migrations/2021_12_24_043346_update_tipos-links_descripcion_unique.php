<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTiposLinksDescripcionUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipos-links', function (Blueprint $table) {
            $table->unique('descripcion', 'tipos_links_descripcion_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipos-links', function (Blueprint $table) {
            $table->dropUnique('tipos_links_descripcion_unique');
        });
    }
}
