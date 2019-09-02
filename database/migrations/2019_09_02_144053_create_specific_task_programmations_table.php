<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecificTaskProgrammationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specific_task_programmations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('programming_id');
            $table->foreign('programming_id')->references('id')->on('programmings');
            $table->unsignedInteger('specific_task_id');
            $table->foreign('specific_task_id')->references('id')->on('specific_tasks');
            $table->decimal('meta',14,2);
            $table->decimal('executed',14,2)->nullable();//ejecucion
            $table->decimal('efficacy',14,2)->nullable();//porcentaje de eficiencia
            $table->decimal('weighing',14,2)->nullable();//ponderacion
            $table->decimal('weighing_execution',14,2)->nullable();
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
        Schema::dropIfExists('specific_task_programmations');
    }
}
