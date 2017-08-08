<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Proveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('proveedores', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('id_compania');
      $table->string('proveedor', 60);
      $table->string('email');
      $table->string('telefono');
      $table->string('activo');
      $table->string('direccion');
      $table->string('observaciones');
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
      Schema::drop('proveedores');
    }
}
