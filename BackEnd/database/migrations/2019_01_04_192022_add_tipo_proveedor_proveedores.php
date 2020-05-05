<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoProveedorProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proveedors', function($table) {
            $table->unsignedInteger('tipo_proveedor_id');
            $table->string('nombre_comercial')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proveedors', function($table) {
            $table->dropColumn('tipo_proveedor_id');
            $table->dropColumn('nombre_comercial');
        });
    }
}
