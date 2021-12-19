<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UpdateConocimientosFechaInf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conocimientos', function(Blueprint $table) {
          $table->date('fecha_informacion')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('conocimientos')
            ->where('fecha_informacion', null)
            ->update(['fecha_informacion' => Carbon::createFromTimestamp(0)]);

        Schema::table('conocimientos', function(Blueprint $table) {
            $table->date('fecha_informacion')->nullable(false)->change();
        });
    }
}
