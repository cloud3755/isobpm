<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class insumoscalificados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('insumoscalificados', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('idcalificacion');
      $table->integer('idinsumo');
      $table->integer('idautor');
      $table->integer('idarea');
      $table->integer('idcompañia');
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
      Schema::drop('insumoscalificados');
    }
}
