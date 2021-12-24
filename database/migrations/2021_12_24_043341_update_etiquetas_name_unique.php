<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEtiquetasNameUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etiquetas', function (Blueprint $table) {
            $table->unique('nombre', 'etiquetas_nombre_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etiquetas', function (Blueprint $table) {
            $table->dropUnique('etiquetas_nombre_unique');
        });
    }
}
