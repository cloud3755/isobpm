<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoconformidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noconformidades', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->integer('proceso_id');
            $table->integer('producto_id');
            $table->string('documento');
              $table->string('evidenciapertura');
              $table->string('apertura_unic');
            $table->text('descripcion');
            $table->integer('usuario_responsable_id');
            $table->string('acciones');
            $table->date('fecha_plan');
            $table->string('evidencia');
              $table->string('evidencia_unic');
            $table->date('fecha_cierre');
            $table->integer('estatus_id');
            $table->double('monto');
            $table->integer('idcompañia')->unsigned();
              $table->integer('id_area')->unsigned();
              $table->integer('creador_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('noconformidades');
    }
}
