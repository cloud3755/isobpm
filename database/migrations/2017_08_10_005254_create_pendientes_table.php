<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_UsuarioCreo');
            $table->integer('id_UsuarioAsignado');
            $table->boolean('Terminado');
            $table->string('pendiente');
            $table->date('fecha_creacion');
            $table->date('fecha_limite');
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
        Schema::drop('pendientes');
    }
}
