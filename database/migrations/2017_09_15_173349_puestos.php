<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Puestos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('puestos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parentId')->nullable();
            $table->string('nombrepuesto');
            $table->integer('id_compania');
            $table->string('cadenadescendencia');
            $table->integer('nivel')->nullable();
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
        Schema::drop('puestos');
    }
}
