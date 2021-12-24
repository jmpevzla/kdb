<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexPersonasLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personas_links', function (Blueprint $table) {
            $table->unique(['persona_id', 'link_id'], 'personas_links_persona_id_link_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personas_links', function (Blueprint $table) {
            $table->dropForeign('personas_links_persona_id_foreign');
            $table->dropForeign('personas_links_link_id_foreign');
            $table->dropUnique('personas_links_persona_id_link_id_unique');
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->foreign('link_id')->references('id')->on('links');
        });
    }
}
