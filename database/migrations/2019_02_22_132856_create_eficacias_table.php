<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEficaciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eficacias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pmp_id');
            $table->foreign('pmp_id')->references('id')->on('programacion_medio_plazo'); 
            $table->string('alcance');
            $table->string('ejecutado');
            $table->string('eficacia');
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
        Schema::dropIfExists('eficacias');
    }
}
