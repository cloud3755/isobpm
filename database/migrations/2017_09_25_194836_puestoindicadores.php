<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Puestoindicadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('puestoindicadores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_puesto');
            $table->integer('id_indicadores');
            $table->double('ponderacion');
            $table->integer('id_compania');
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
        Schema::drop('puestoindicadores');
    }
}
