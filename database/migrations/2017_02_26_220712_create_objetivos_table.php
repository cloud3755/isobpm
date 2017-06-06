<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjetivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetivos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_objetivo_id')->unsigned();
            $table->string('nombre');
            $table->text('descripcion');
            $table->date('fecha');
            $table->integer('usuario_responsable_id')->unsigned();
            $table->integer('usuario_creador_id')->unsigned();
            $table->integer('id_compania');

  //          $table->foreign('tipo_objetivo_id')->references('id')->on('tipo_objetivos')->onDelete('cascade');
  //          $table->foreign('usuario_responsable_id')->references('id')->on('users')->onDelete('cascade');
  //          $table->foreign('usuario_creador_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('objetivos');
    }
}
