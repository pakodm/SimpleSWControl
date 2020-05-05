<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactoProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacto_proveedors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_proveedor');
            $table->string('nombre_contacto');
            $table->string('telefono_fijo');
            $table->string('telefono_movil');
            $table->string('correo_electronico');
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
        Schema::dropIfExists('contacto_proveedors');
    }
}
