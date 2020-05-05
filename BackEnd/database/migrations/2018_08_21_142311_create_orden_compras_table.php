<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('folio');
            $table->dateTime('fecha_oc');
            $table->unsignedInteger('id_empresa');
            $table->unsignedInteger('id_proveedor');
            $table->text('observaciones');
            $table->double('subtotal',8,2);
            $table->double('total',8,2);
            $table->unsignedInteger('id_usuario_crea');
            $table->unsignedInteger('id_usuario_autoriza');
            $table->dateTime('fecha_creacion');
            $table->dateTime('fecha_autorizacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_compras');
    }
}
