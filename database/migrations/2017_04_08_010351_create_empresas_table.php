<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_plan');
            $table->string('razonSocial');
            $table->string('domicilio');
            $table->string('correo');
            $table->string('telefono',30);
            $table->string('rubro');
            $table->string('uso');
            $table->string('codigo');
            $table->date('fecha');
            $table->integer('status_id');
            $table->double('cuota_usada', 15, 8);
            $table->string('img');
            $table->integer('id_creador');
            $table->integer('mensajesQuejas');
            $table->integer('mensajesNC');
            $table->integer('mensajesAC');

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
        Schema::drop('empresas');
    }
}
