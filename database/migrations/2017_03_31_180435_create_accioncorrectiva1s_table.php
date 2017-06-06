<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccioncorrectiva1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accioncorrectiva1s', function (Blueprint $table) {
          $table->increments('id');
          $table->date('fechaalta');
          $table->integer('id_proceso');
          $table->integer('producto_id');
          $table->string('documento',80);
            $table->string('uniquedocumento',50);
          $table->string('descripcion',300);
          $table->integer('responsable_id');
          $table->string('porque1',200);
          $table->string('porque2',200);
          $table->string('accioncorrectiva',300);
          $table->date('fechaaccion');
          $table->string('respuestaaccion');
          $table->string('evidencia',80);
            $table->string('uniqueevidencia',50);
          $table->date('fechacierre');
          $table->string('criterio',300);
          $table->integer('estatus_id');
          $table->integer('creador_id');
          $table->integer('indicador_id');
          $tabke->double('monto');
          $table->integer('idcompañia')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accioncorrectiva1s');
    }
}
