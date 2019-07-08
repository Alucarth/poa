<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStructureProgramAst extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('action_medium_terms', function (Blueprint $table) {

            // $table->unsignedBigInteger('programmatic_structure_id')->nullable();//programacion corto plazo
            // $table->foreign('programmatic_structure_id')->references('id')->on('programmatic_structures');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
