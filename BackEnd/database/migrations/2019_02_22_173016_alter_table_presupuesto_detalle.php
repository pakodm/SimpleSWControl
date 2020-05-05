<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePresupuestoDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuesto_detalle', function (Blueprint $table) {
            $table->double('costo_medio',8,2)->nullable()->default('0');
            $table->double('costo_impresion',8,2)->nullable()->default('0');
            $table->double('costo_instalacion',8,2)->nullable()->default('0');
            $table->double('costo_otros',8,2)->nullable()->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presupuesto_detalle', function (Blueprint $table) {
            $table->dropColumn('costo_medio');
            $table->dropColumn('costo_impresion');
            $table->dropColumn('costo_instalacion');
            $table->dropColumn('costo_otros');
        });
    }
}
