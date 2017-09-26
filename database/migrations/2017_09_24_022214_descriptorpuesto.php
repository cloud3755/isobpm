<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Descriptorpuesto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('descriptorpuesto', function (Blueprint $table) {


            $table->increments('id');
            $table->integer('id_puesto');
            $table->integer('id_empresa');
            $table->integer('id_area');
            $table->string('personalacargo');
            $table->integer('reportaa');
            $table->string('montovalores');
            $table->string('mision');
            $table->string('funciones');
            $table->string('responsabilidades');
            $table->string('autoridades');
            $table->string('capacitacion');
            $table->string('herramientas');
            $table->string('softwareactivos');
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
        Schema::drop('descriptorpuesto');
    }
}
