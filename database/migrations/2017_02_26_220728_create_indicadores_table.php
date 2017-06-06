<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicadores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('objetivo_id')->unsigned();
            $table->string('nombre');
            $table->string('descripcion');
            $table->integer('usuario_responsable_id')->unsigned();
            $table->integer('frecuencia_id')->unsigned();
            $table->integer('unidad')->unsigned();
            $table->integer('logica')->unsigned();
            $table->float('meta');
            $table->string('acceso');

//            $table->foreign('objetivo_id')->references('id')->on('objetivos')->onDelete('cascade');
//            $table->foreign('usuario_responsable_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('frecuencia_id')->references('id')->on('frecuencias')->onDelete('cascade');
//            $table->foreign('unidad')->references('id')->on('unidades')->onDelete('cascade');
//            $table->foreign('logica')->references('id')->on('logicas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('indicadores');
    }
}
