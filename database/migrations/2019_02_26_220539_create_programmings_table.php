<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programmings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('operation_programming_id')->nullable();
            $table->foreign('operation_programming_id')->references('id')->on('operation_programmings');
            $table->unsignedInteger('task_id');
            $table->foreign('task_id')->references('id')->on('tasks');
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
        Schema::dropIfExists('programmings');
    }
}
