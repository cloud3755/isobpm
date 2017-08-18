<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Insumos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('insumos', function (Blueprint $table) {
          $table->increments('id');
          $table->string('Producto_o_Servicio');
          $table->string('Descripcion');
          $table->string('Tipo');
          $table->string('idcompañia');
          $table->string('archivo');
          $table->string('nombreunico');
          $table->integer('size');
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
       Schema::drop('insumos');
    }
}
