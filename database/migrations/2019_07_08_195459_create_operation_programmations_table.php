<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationProgrammationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_programmations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('programmatic_operation_id');//programacion corto plazo
            $table->foreign('programmatic_operation_id')->references('id')->on('programmatic_operations');
            $table->unsignedBigInteger('operation_id');//programacion corto plazo
            $table->foreign('operation_id')->references('id')->on('operations');
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
        Schema::dropIfExists('operation_programmations');
    }
}
