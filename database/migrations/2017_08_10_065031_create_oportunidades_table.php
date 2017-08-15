<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOportunidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oportunidades', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('procesos_id');
          $table->string('actividad',255);
          $table->integer('oportunidad_id');
          $table->string('modo_falla',60);
          $table->string('descripcion_modo_falla');
          $table->string('esfuerzo',15);
          $table->string('impacto',15);
          $table->integer('oportunidad_potencial');
          $table->string('controles');
          $table->string('esfuerzo2',15);
          $table->string('impacto2',15);
          $table->integer('oportunidad_real');
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
        Schema::drop('oportunidades');
    }
}
