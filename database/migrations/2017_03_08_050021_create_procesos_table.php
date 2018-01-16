<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procesos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo',20);
            $table->string('proceso',50);
            $table->string('descripcion',255);
            $table->integer('usuario_responsable_id')->unsigned();
        //    $table->foreign('usuario_responsable_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('rev',50);
            $table->string('detalle_de_rev',255);
            $table->string('archivo_html',100);
            $table->string('indicadores',50);
            $table->string('puestos',50);
            $table->string('insumos',50);
            $table->string('documento',50);
            $table->string('activo',50);
            $table->string('lista_de_distribucion',50);
            $table->string('nombreunicoarchivo',100);
            $table->integer('idcompañia')->unsigned();
            $table->integer('creador_id');
            $table->string('Takt')->nullable();
            $table->string('Yield')->nullable();
            $table->string('RTY')->nullable();
            $table->string('DPMO')->nullable();
            $table->string('Sigma')->nullable();
            $table->string('Persona')->nullable();
            $table->string('Maquina')->nullable();
            $table->string('dinero')->nullable();
            $table->string('SLA1')->nullable();
            $table->string('SLA2')->nullable();
            $table->string('SLA3')->nullable();
            $table->string('Mes')->nullable();
            $table->string('demandamen')->nullable();
            $table->string('diasmes')->nullable();
            $table->string('turnosdia')->nullable();
            $table->string('turnoshora')->nullable();
            $table->string('horades')->nullable();
            $table->string('Tiemposeg')->nullable();
            $table->string('Tiempomin')->nullable();
            $table->string('taktseg')->nullable();
            $table->integer('tipoarchivo')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps(); // created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('procesos');
    }
}
