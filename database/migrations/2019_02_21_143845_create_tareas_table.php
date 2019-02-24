<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('operacion_id');
            $table->foreign('operacion_id')->references('id')->on('operaciones'); 
            $table->string('descripcion');
            $table->string('meta');
            $table->timestamps();
            //se registro una tabla denomidada programaciones que almacena el valor de los meses
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tareas');
    }
}
