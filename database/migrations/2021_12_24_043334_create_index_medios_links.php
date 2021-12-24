<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexMediosLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medios_links', function (Blueprint $table) {
            $table->unique(['medio_id', 'link_id'], 'medios_links_medio_id_link_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medios_links', function (Blueprint $table) {
            $table->dropForeign('medios_links_medio_id_foreign');
            $table->dropForeign('medios_links_link_id_foreign');
            $table->dropUnique('medios_links_medio_id_link_id_unique');
            $table->foreign('medio_id')->references('id')->on('medios');
            $table->foreign('link_id')->references('id')->on('links');
        });
    }
}
