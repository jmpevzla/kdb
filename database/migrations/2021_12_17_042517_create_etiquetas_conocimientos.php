<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtiquetasConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etiquetas_conocimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etiqueta_id')->references('id')->on('etiquetas');
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
        Schema::dropIfExists('etiquetas_conocimientos');
    }
}
