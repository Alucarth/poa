<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicadoresCortoPlazoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicadores_corto_plazo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pcp_id')->nullable();//programacion corto plazo
            $table->foreign('pcp_id')->references('id')->on('programacion_corto_plazo');
            $table->string('descripcion');
            $table->string('unidad_de_medida');
            $table->string('linea_base');
            $table->string('meta');
            $table->string('resultado_intermedio');//viene del mediano plzo
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
        Schema::dropIfExists('indicadores_corto_plazo');
    }
}
