<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksArchivosConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links-archivos_conocimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id');
            $table->foreign('link_id')->references('id')->on('links');
            $table->foreignId('conocimiento_id');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links-archivos_conocimientos');
    }
}
