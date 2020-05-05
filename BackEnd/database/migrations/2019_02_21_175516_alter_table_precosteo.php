<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePrecosteo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('precosteo', function (Blueprint $table) {
            $table->dropForeign(['id_presupuesto']);
            $table->dropColumn('id_presupuesto');
            $table->unsignedInteger('id_presupuesto_detalle');
            $table->foreign('id_presupuesto_detalle')->references('id')->on('presupuesto_detalle')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('precosteo', function (Blueprint $table) {
            $table->dropForeign(['id_presupuesto_detalle']);
            $table->dropColumn('id_presupuesto_detalle');
            $table->unsignedInteger('id_presupuesto');
            $table->foreign('id_presupuesto')->references('id')->on('presupuesto')->onDelete('cascade');
        });
    }
}
