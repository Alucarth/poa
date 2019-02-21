<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramacionCortoPlazoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programacion_corto_plazo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pmp_id');
            $table->foreign('pmp_id')->references('id')->on('programacion_medio_plazo');
            $table->string('codigo')->nullable();
            $table->string('descripcion');
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
        Schema::dropIfExists('programacion_corto_plazo');
    }
}
