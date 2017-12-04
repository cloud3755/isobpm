<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSipocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sipocs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('S');
            $table->string('I');
            $table->string('P');
            $table->string('O');
            $table->string('C');
            $table->integer('id_proceso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sipocs');
    }
}
