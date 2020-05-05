<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuesto', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_cliente');
            $table->unsignedInteger('id_campania')->nullable();
            $table->string('nombre_publicidad',250);
            $table->unsignedInteger('duracion');
            $table->unsignedInteger('tipo_duracion'); // dias, semanas, meses
            $table->dateTime('fecha_inicio');
            $table->double('venta_neta',18,2);
            $table->double('costo_neto',18,2);
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
        Schema::dropIfExists('presupuesto');
    }
}
