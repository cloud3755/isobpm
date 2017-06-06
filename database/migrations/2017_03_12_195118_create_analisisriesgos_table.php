<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalisisriesgosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analisisriesgos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('procesos_id');
            $table->string('actividad',255);
            $table->integer('riesgo_id');
            $table->string('modo_falla',60);
            $table->string('descripcion_modo_falla');
            $table->string('Severidad',15);
            $table->string('probabilidad',15);
            $table->integer('riesgo_inherente');
            $table->string('controles');
            $table->string('Severidad2',15);
            $table->string('probabilidad2',15);
            $table->integer('riesgo_residual');
            $table->integer('idcompañia')->unsigned();
            $table->integer('id_area')->unsigned();
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('analisisriesgos');
    }
}
