<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links_conocimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->references('id')->on('links');
            $table->foreignId('conocimiento_id')->references('id')->on('conocimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links_conocimientos');
    }
}
