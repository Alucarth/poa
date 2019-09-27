<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnityAtribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('action_short_terms', function (Blueprint $table)
        {
            $table->unsignedBigInteger('unity_id')->nullable();
            $table->foreign('unity_id')->references('id')->on('unities');
        });
        Schema::table('operations', function (Blueprint $table)
        {
            $table->unsignedBigInteger('unity_id')->nullable();
            $table->foreign('unity_id')->references('id')->on('unities');
        });
        Schema::table('tasks', function (Blueprint $table)
        {
            $table->unsignedBigInteger('unity_id')->nullable();
            $table->foreign('unity_id')->references('id')->on('unities');
        });
        Schema::table('specific_tasks', function (Blueprint $table)
        {
            $table->unsignedBigInteger('unity_id')->nullable();
            $table->foreign('unity_id')->references('id')->on('unities');
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

        Schema::table('action_short_terms', function (Blueprint $table) {
            $table->dropColumn('unity_id');
        });

        Schema::table('operations', function (Blueprint $table) {
            $table->dropColumn('unity_id');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('unity_id');
        });

        Schema::table('specific_tasks', function (Blueprint $table) {
            $table->dropColumn('unity_id');
        });
    }
}
