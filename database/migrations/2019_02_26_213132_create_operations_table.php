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
            $table->unsignedBigInteger('action_short_term_id');
            $table->foreign('action_short_term_id')->references('id')->on('action_short_terms');
            $table->unsignedBigInteger('programmatic_operation_id');//programacion corto plazo
            $table->foreign('programmatic_operation_id')->references('id')->on('programmatic_operations');
            $table->string('description');
            $table->string('code')->nullable();
            $table->double('meta',8,2);
            $table->double('executed',8,2)->nullable(); //todo lo ejecutado se debe comparar con el 100%
            $table->double('efficacy',8,2)->nullable();// 
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
