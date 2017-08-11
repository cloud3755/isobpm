<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Insumoproveedor extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('insumoprovedor', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('idinsumo');
    $table->integer('idproveedor');
    $table->integer('id_compania');
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
      Schema::drop('insumoprovedor');
  }
}
