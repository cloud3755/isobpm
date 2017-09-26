<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Perfilpuesto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('perfilpuesto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_puesto');
            $table->string('rangoedad');
            $table->integer('sexo');
            $table->string('otrosreq');
            $table->string('conocimientos');
            $table->string('educacion');
            $table->string('formacion');
            $table->string('habilidades');
            $table->string('experiencias');
            $table->integer('id_compania');
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
        //
          Schema::drop('perfilpuesto');
    }
}
