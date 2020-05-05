<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorRutaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor_ruta', function (Blueprint $table) {
            $table->unsignedInteger('proveedor_id', false);
            $table->unsignedInteger('ruta_id', false);
            $table->foreign('ruta_id')->references('id')->on('rutas')->onDelete('cascade');
            $table->tinyInteger('activo')->default('1');
            $table->primary(array('proveedor_id','ruta_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedor_ruta');
    }
}
