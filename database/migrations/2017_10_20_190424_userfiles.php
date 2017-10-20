<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Userfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
     Schema::create('userfiles', function (Blueprint $table) {
        $table->increments('id');
        $table->string('nombre');
        $table->string('archivo');
        $table->string('nombreunico');
        $table->integer('size');
        $table->integer('id_user')->unsigned();
        $table->integer('id_compania')->unsigned();
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
         Schema::create('userfiles');
    }
}
