<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->string('razon_social');
            $table->string('rfc');
            $table->string('calle');
            $table->string('num_exterior');
            $table->string('num_interior');
            $table->string('colonia');
            $table->string('ciudad');
            $table->string('estado');
            $table->string('cp');
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
        Schema::dropIfExists('proveedors');
    }
}
