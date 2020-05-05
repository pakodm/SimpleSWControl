<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePresupuestoDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuesto_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_presupuesto');
            $table->unsignedInteger('id_tipo_medio');
            $table->double('cantidad',8,2)->default('0');
            $table->double('costo_total',8,2)->default('0');
            $table->tinyInteger('borrado')->default('0');
            $table->unsignedInteger('id_usuario_modifico')->nullable();
            $table->foreign('id_presupuesto')->references('id')->on('presupuesto')->onDelete('cascade');
            $table->timestamps();
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
            $table->dropForeign(['id_presupuesto']);
        });
        Schema::dropIfExists('presupuesto_detalle');
    }
}
