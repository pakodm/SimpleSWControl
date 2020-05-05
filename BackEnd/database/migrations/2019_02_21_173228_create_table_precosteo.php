<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePrecosteo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precosteo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_presupuesto');
            $table->string('carroceria',150)->nullable();
            $table->double('comision_ejecutivo',8,2)->default('0');
            $table->double('comisiones_externas',8,2)->default('0');
            $table->double('costo_instalacion',8,2)->default('0');
            $table->double('costo_m2',8,2)->default('0');
            $table->double('costo_renta_mensual',8,2)->default('0');
            $table->double('costo_retiro',8,2)->default('0');
            $table->unsignedInteger('entidad_fed');
            $table->double('factor_merma',8,2)->default('0');
            $table->dateTime('fecha_instalacion')->nullable();
            $table->dateTime('fecha_pago_instalacion')->nullable();
            $table->double('gasto_envios',8,2)->default('0');
            $table->unsignedInteger('id_impresor');
            $table->unsignedInteger('id_instalador');
            $table->unsignedInteger('id_permisionario');
            $table->unsignedInteger('id_ruta');
            $table->unsignedInteger('id_tipo_material');
            $table->double('metros_por_unidad',8,2)->default('0');
            $table->string('num_economico', 50)->nullable();
            $table->string('placas', 50)->nullable();
            $table->double('precio_renta_mensual',8,2)->default('0');
            $table->double('reparaciones',8,2)->default('0');
            $table->unsignedInteger('tipo_medio');
            $table->tinyInteger('borrado')->default('0');
            $table->unsignedInteger('id_usuario_modifico')->nullable();
            $table->foreign('id_presupuesto')->references('id')->on('presupuesto')->onDelete('cascade');
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
        Schema::table('precosteo', function ($table) {
            $table->dropForeign(['id_presupuesto']);
        });
        Schema::dropIfExists('precosteo');
    }
}
