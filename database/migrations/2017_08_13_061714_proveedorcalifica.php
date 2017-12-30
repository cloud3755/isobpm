<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class proveedorcalifica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('proveedorcalificas', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('idproveedor');
      $table->string('pedido');
      $table->integer('tiempo');
      $table->integer('calidad');
      $table->integer('servicio');
      $table->integer('costo');
      $table->integer('idautor');
      $table->integer('idarea');
      $table->integer('idcompania');
      $table->string('archivo');
      $table->string('nombreunico');
      $table->integer('size');
      $table->date('fechacalificacion');
      $table->string('comentarioevaluacion');
      $table->string('obstiempo');
      $table->string('obscalidad');
      $table->string('obsservicio');
      $table->string('obscosto');
      $table->integer('proyecto_id');
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
        Schema::drop('Proveedorcalificas');
    }
}
