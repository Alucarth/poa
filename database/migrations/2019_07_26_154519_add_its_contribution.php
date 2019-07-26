<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItsContribution extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tasks', function (Blueprint $table) {
            $table->boolean('its_contribution')->default(true);
        });
        Schema::table('specific_tasks', function (Blueprint $table) {
            $table->boolean('its_contribution')->default(true);
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
