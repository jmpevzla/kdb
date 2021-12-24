<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIndexApodos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apodos', function (Blueprint $table) {
            $table->unique(['apodo', 'persona_id'], 'apodos_apodo_persona_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apodos', function (Blueprint $table) {
            $table->dropUnique('apodos_apodo_persona_id_unique');
        });
    }
}
