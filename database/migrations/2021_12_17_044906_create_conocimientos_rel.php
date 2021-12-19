<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConocimientosRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conocimientos_rel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conocimiento_id')->references('id')->on('conocimientos');
            $table->foreignId('conocimiento_rel_id')->references('id')->on('conocimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conocimientos_rel');
    }
}
