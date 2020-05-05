<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor_material', function (Blueprint $table) {
            $table->unsignedInteger('proveedor_id', false);
            $table->unsignedInteger('tipo_material_id', false);
            $table->foreign('tipo_material_id')->references('id')->on('tipo_material')->onDelete('cascade');
            $table->double('costo_m2',8,2)->default('1');
            $table->tinyInteger('activo')->default('1');
            $table->primary(array('proveedor_id','tipo_material_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedor_material');
    }
}
