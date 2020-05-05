<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUsersAddTipoAddActivo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('id_tipo_usuario')->default('0');
            $table->tinyInteger('activo')->default('1');
        });

        Schema::table('presupuesto_detalles', function (Blueprint $table) {
            $table->tinyInteger('borrado')->default('0');
            $table->unsignedInteger('id_usuario_modifico')->nullable();
            $table->foreign('id_presupuesto')->references('id')->on('presupuesto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('id_tipo_usuario');
            $table->dropColumn('activo');
        });

        Schema::table('presupuesto_detalles', function ($table) {
            $table->dropColumn('borrado');
            $table->dropColumn('id_usuario_modifico');
            $table->dropForeign(['id_presupuesto']);
        });
    }
}
