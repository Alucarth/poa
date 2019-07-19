<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammaticOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programmatic_operations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('programmatic_structure_id')->nullable();//programacion corto plazo
            $table->foreign('programmatic_structure_id')->references('id')->on('programmatic_structures');
            $table->string('code');
            $table->string('description');
            $table->bigInteger('da');
            $table->bigInteger('ue');
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
        Schema::dropIfExists('programmatic_operations');
    }
}
