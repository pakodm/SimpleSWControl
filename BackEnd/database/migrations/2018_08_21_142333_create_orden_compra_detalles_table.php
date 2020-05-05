<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenCompraDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_orden_compra');
            $table->unsignedInteger('id_campania');
            $table->unsignedInteger('id_tipo_medio');
            $table->unsignedInteger('id_plaza');
            $table->text('direccion_ruta');
            $table->text('periodo_medio');
            $table->tinyInteger('vigencia_meses');
            $table->unsignedInteger('cantidad');
            $table->double('precio_unitario');
            $table->dateTime('fecha_creacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_compra_detalles');
    }
}
