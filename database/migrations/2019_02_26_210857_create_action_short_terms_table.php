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
            $table->unsignedBigInteger('programmatic_structure_id')->nullable();//programacion corto plazo
            $table->foreign('programmatic_structure_id')->references('id')->on('programmatic_structures');
            $table->string('code')->nullable();
            $table->string('description');
            $table->string('unidad_de_medida');
            $table->string('producto_esperado');//viene del mediano plzo
            $table->string('linea_base')->nullable();
            $table->decimal('meta',14,2);
            $table->decimal('executed',14,2)->nullable();
            $table->decimal('efficacy',14,2)->nullable();//la suma de todas las
            $table->decimal('weighing',14,2)->nullable();
            $table->decimal('weighing_execution',14,2)->nullable();
            // $table->boolean('its_contrution')->default(true); //si contribuye a la meta
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
        Schema::dropIfExists('action_short_terms');
    }
}
