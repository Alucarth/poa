<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('operation_id');
            $table->foreign('operation_id')->references('id')->on('operations');
            $table->string('code')->nullable();
            $table->string('description');
            $table->decimal('meta',8,2);
            $table->decimal('executed',8,2)->nullable(); //todo lo ejecutado se debe comparar con el 100%
            $table->decimal('efficacy',8,2)->nullable();//
            $table->decimal('weighing',8,2)->nullable();
            $table->decimal('weighing_execution',8,2)->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
