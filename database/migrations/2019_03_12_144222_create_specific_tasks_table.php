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
            $table->double('meta',8,2);
            $table->double('executed',8,2)->nullable();
            $table->double('efficacy',8,2)->nullable();//la
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
        Schema::dropIfExists('specific_tasks');
    }
}
