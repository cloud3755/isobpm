<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvidenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidencias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_accioncorrectiva');
            $table->integer('id_responsable');
            $table->string('accionarealizar');
            $table->string('descripcion');
            $table->string('archivo_html1',100);
            $table->string('archivo_html2',100);
            $table->string('nombreunicoarchivo1',100);
            $table->string('nombreunicoarchivo2',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('evidencias');
    }
}
