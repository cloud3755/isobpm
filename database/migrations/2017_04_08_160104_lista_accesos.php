<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ListaAccesos extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('lista_accesos', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('id_usuario');
        $table->string('id_indicador',50);
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
      Schema::drop('lista_accesos');        //
  }
}
