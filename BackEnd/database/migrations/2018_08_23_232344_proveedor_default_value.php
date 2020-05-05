<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProveedorDefaultValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proveedors', function (Blueprint $table) {
            $table->string('calle')->nullable()->change();
            $table->string('num_exterior')->nullable()->change();
            $table->string('num_interior')->nullable()->change();
            $table->string('colonia')->nullable()->change();
            $table->string('ciudad')->nullable()->change();
            $table->string('estado')->nullable()->change();
            $table->string('cp')->nullable()->change();
        });

        Schema::table('contacto_proveedors', function (Blueprint $table) {
            $table->string('telefono_fijo')->nullable()->change();
            $table->string('telefono_movil')->nullable()->change();
            $table->string('correo_electronico')->nullable()->change();
        });

        Schema::table('empresas', function (Blueprint $table) {
            $table->string('calle')->nullable()->change();
            $table->string('num_exterior')->nullable()->change();
            $table->string('num_interior')->nullable()->change();
            $table->string('colonia')->nullable()->change();
            $table->string('ciudad')->nullable()->change();
            $table->string('estado')->nullable()->change();
            $table->string('cp')->nullable()->change();
            $table->string('correo_electronico')->nullable()->change();
        });

        Schema::table('campanias', function (Blueprint $table) {
            $table->dateTime('fecha_fin')->nullable()->change();
        });

        Schema::table('orden_compras', function (Blueprint $table) {
            $table->text('observaciones')->nullable()->change();
            $table->unsignedInteger('id_usuario_autoriza')->nullable()->change();
            $table->dateTime('fecha_autorizacion')->nullable()->change();
        });

        Schema::table('orden_compra_detalles', function (Blueprint $table) {
            $table->unsignedInteger('id_plaza')->nullable()->change();
            $table->text('direccion_ruta')->nullable()->change();
            $table->text('periodo_medio')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
