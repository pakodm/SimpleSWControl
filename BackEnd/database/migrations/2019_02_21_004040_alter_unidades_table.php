<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unidades', function (Blueprint $table) {
            $table->double('metros_por_unidad',8,2)->default('1');
            $table->double('costo_por_metro',8,2)->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unidades', function ($table) {
            $table->dropColumn('metros_por_unidad');
            $table->dropColumn('costo_por_metro');
        });
    }
}
