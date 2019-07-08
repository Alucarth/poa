<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionMediumTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_medium_terms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('programmatic_structure_id')->nullable();//programacion a mediano plazoç
            $table->foreign('programmatic_structure_id')->references('id')->on('programmatic_structures');
            $table->string('code')->nullable();
            $table->integer('pilar');
            $table->integer('meta');
            $table->integer('resultado');
            $table->integer('accion');
            $table->string('description');
            $table->enum('tipo', ['Proceso', 'Apoyo'])->default('Proceso')->nullable();
            $table->string('resultado_intermedio');
            $table->string('linea_base')->nullable();
            $table->string('indicador_resultado_intermedio');
            $table->decimal('alcance_meta',14,2);
            $table->decimal('executed',14,2)->nullable();
            $table->decimal('efficacy',14,2)->nullable();
            $table->decimal('weighing',14,2)->nullable();
            $table->decimal('weighing_execution',14,2)->nullable();
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
        Schema::dropIfExists('action_medium_terms');
    }
}
