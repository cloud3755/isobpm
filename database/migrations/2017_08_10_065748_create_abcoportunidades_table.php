<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbcoportunidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abcoportunidades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_oportunidad_id')->unsigned();
            $table->string('nombre');
            $table->text('descripcion');
            $table->integer('id_compania');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('abcoportunidades');
    }
}
