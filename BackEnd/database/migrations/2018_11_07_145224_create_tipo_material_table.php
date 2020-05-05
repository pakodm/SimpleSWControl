<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_material', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion_corta',75);
            $table->string('descripcion',200)->nullable();
            $table->double('precio_unitario',8,2);
            $table->tinyInteger('activo');
            $table->unsignedInteger('id_usuario');
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
        Schema::dropIfExists('tipo_material');
    }
}
