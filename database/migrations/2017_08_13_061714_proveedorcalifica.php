<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Proveedorcalifica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Proveedorcalifica', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('idproveedor');
      $table->integer('idinsumo');
      $table->string('pedido');
      $table->integer('tiempo');
      $table->integer('calidad');
      $table->integer('servicio');
      $table->integer('costo');
      $table->timestamps();  //
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Proveedorcalifica');
    }
}
