<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionShortTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_short_terms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('year_id');
            $table->foreign('year_id')->references('id')->on('years');
            $table->string('code')->nullable();
            $table->string('description');
            $table->double('meta',8,2);
            $table->double('executed',8,2);
            $table->double('efficacy',8,2);//la suma de todas las 
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
        Schema::dropIfExists('action_short_terms');
    }
}
