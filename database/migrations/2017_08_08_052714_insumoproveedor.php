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
      Schema::create('insumpoproveedor', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('idproveedor');
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
        Schema::drop('insumpoproveedor');
    }
}
