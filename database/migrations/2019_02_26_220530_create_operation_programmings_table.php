<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationProgrammingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_programmings', function (Blueprint $table) { //programacion de las operaciones
            $table->increments('id');
            $table->unsignedInteger('operation_id');
            $table->foreign('operation_id')->references('id')->on('operations');
            $table->unsignedInteger('month_id');
            $table->foreign('month_id')->references('id')->on('months');
            $table->decimal('meta',14,2);
            $table->decimal('executed',14,2)->nullable();
            $table->decimal('efficacy',14,2)->nullable();//la suma de todas las
            $table->decimal('weighing',14,2)->nullable();
            $table->decimal('weighing_execution',14,2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operation_programmings');
    }
}
