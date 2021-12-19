<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivosConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivos_conocimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('archivo_id')->references('id')->on('archivos');
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
        Schema::dropIfExists('archivos_conocimientos');
    }
}
