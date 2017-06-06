<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMejorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mejoras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            $table->integer('id_compania');
            $table->string('proyecto');
            $table->integer('responsable_id');
            $table->string('impacto');
              $table->string('desripcion');
              $table->string('listaequipo');
            $table->float('beneficioplan');
            $table->float('beneficioreal');
            $table->date('fechaactual');
            $table->integer('estatus_id');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mejoras');
    }
}
