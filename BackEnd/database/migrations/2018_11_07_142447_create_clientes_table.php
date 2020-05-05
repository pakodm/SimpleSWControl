<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->string('razon_social');
            $table->string('rfc');
            $table->string('calle',250)->nullable();
            $table->string('num_exterior',30)->nullable();
            $table->string('num_interior',30)->nullable();
            $table->string('colonia',200)->nullable();
            $table->string('ciudad',200)->nullable();
            $table->string('estado',200)->nullable();
            $table->string('cp',10)->nullable();
            $table->string('correo_electronico',250);
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
        Schema::dropIfExists('clientes');
    }
}
