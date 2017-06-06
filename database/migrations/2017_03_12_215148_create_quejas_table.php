<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuejasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quejas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->integer('cliente_id');
            $table->text('descripcion');
            $table->integer('usuario_responsable_id');
            $table->string('acciones');
              $table->string('archivoqueja');
              $table->string('uniquearchivoqueja');
              $table->string('archivoevidencia');
              $table->string('uniquearchivoevidencia');
            $table->date('fecha_plan');
            $table->string('evidencia');
            $table->date('fecha_cierre');
            $table->integer('estatus_id');
            $table->integer('idcompañia')->unsigned();
            $table->integer('area');
            $table->integer('proceso');
            $table->integer('producto');
            $table->double('monto');
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('quejas');
    }
}
