<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstaladoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instaladores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_proveedor');
            $table->double('costo_instalacion',8,2)->default('0');
            $table->double('costo_retiro',8,2)->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instaladores');
    }
}
