<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('action_short_term');
            $table->foreign('action_short_term')->references('id')->on('action_short_terms');
            $table->string('description');
            $table->double('meta',8,2);
            $table->double('executed',8,2); //todo lo ejecutado se debe comparar con el 100%
            $table->double('efficacy',8,2);// 
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
        Schema::dropIfExists('operations');
    }
}
