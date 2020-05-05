<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaniasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campanias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->unsignedInteger('id_tipo_medio');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campanias');
    }
}
