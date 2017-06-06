<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ListaIndicadoresProcesos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('lista_indicadores_procesos', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('id_indicador');
        $table->string('id_proceso',50);
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
        Schema::drop('lista_indicadores_procesos');
    }
}
