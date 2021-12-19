<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos_conocimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->references('id')->on('grupos');
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
        Schema::dropIfExists('grupos_conocimientos');
    }
}
