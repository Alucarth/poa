<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('years', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('action_medium_term_id');
            $table->foreign('action_medium_term_id')->references('id')->on('action_medium_terms');
            $table->integer('year');
            $table->double('meta',8,2);
            $table->double('excecuted',8,2)->nullable();
            $table->double('efficacy',8,2)->nullable(); //sumado todos los years deben dar el 100%
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
        Schema::dropIfExists('years');
    }
}
