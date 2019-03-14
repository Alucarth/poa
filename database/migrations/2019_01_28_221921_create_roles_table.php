<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('roles', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('name');
        //     $table->string('description');
        //     $table->string('custom_label1')->nullable();
        //     $table->string('custom_label2')->nullable();
        //     $table->string('custom_label3')->nullable();
        //     $table->string('custom_label4')->nullable();
        //     $table->string('custom_label5')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('roles');
    }
}
