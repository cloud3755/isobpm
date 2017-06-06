<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMejoraetapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mejoraetapas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_mejoras');
            $table->integer('etapa');
            $table->string('descripcion');
            $table->string('archivo');
              $table->string('uniquearchivo');
            $table->date('fecha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mejoraetapas');
    }
}
