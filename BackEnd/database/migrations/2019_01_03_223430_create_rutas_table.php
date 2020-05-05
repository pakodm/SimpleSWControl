<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rutas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clave',100);
            $table->string('nombre_ruta',100);
            $table->unsignedInteger('estado_id');
            $table->text('descripcion_ruta')->nullable();
            $table->string('ruta_inicio')->nullable();
            $table->string('latitud_inicio',35)->nullable();
            $table->string('longitud_inicio',35)->nullable();
            $table->string('ruta_fin')->nullable();
            $table->string('latitud_fin',35)->nullable();
            $table->string('longitud_fin',35)->nullable();
            $table->tinyInteger('disponible')->default('1');
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
        Schema::dropIfExists('rutas');
    }
}
