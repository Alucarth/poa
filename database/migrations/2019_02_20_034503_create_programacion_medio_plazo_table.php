<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramacionMedioPlazoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programacion_medio_plazo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->nullable();
            $table->integer('pilar');
            $table->integer('meta');
            $table->integer('resultado');
            $table->integer('accion');
            $table->string('descripcion');
            $table->enum('tipo', ['Proceso', 'Apoyo'])->default('Proceso')->nullable();
            $table->string('resultado_intermedio');
            $table->string('linea_base');
            $table->string('indicador_resultado_intermedio');
            $table->string('alcance_meta');
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
        Schema::dropIfExists('programacion_medio_plazo');
    }
}
