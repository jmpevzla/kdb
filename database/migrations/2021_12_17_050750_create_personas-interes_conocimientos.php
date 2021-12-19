<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasInteresConocimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas-interes_conocimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->references('id')->on('personas');
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
        Schema::dropIfExists('personas-interes_conocimientos');
    }
}
