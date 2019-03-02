<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('indicators', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedInteger('action_short_term_id')->nullable();//programacion corto plazo
        //     $table->foreign('action_short_term_id')->references('id')->on('action_short_terms');
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
        // Schema::dropIfExists('indicators');
    }
}
