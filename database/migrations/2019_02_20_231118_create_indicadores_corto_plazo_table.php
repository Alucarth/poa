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
        //consultar  
        // Schema::create('indicadores_corto_plazo', function (Blueprint $table) { 
        //     $table->increments('id');
        //     $table->unsignedInteger('programacion_corto_plazo_id')->nullable();//programacion corto plazo
        //     $table->foreign('programacion_corto_plazo_id')->references('id')->on('programacion_corto_plazo');
        //     $table->string('descripcion');
        //     $table->string('unidad_de_medida');
        //     $table->string('linea_base')->nullable();
        //     $table->double('meta',8,2);
        //     $table->string('producto_esperado');//viene del mediano plzo
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('indicadores_corto_plazo');
    }
}
