<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePresupuesto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuesto', function (Blueprint $table) {
            $table->dropColumn('venta_neta');
            $table->dropColumn('costo_neto');
            $table->string('folio',18)->default('');
            $table->double('total_inversion',18,2)->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presupuesto', function (Blueprint $table) {
            $table->dropColumn('folio');
            $table->dropColumn('total_inversion');
            $table->double('venta_neta',18,2);
            $table->double('costo_neto',18,2);
        });
    }
}
