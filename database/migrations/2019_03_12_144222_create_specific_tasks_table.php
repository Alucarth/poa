<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecificTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specific_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('programming_id');
            $table->foreign('programming_id')->references('id')->on('programmings');
            $table->string('code')->nullable();
            $table->string('description');
            $table->decimal('meta',14,2);
            $table->decimal('executed',14,2)->nullable();
            $table->decimal('efficacy',14,2)->nullable();//la
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
        Schema::dropIfExists('specific_tasks');
    }
}
