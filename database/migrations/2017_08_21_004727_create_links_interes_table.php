<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksInteresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links_interes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_UsuarioCreo');
            $table->string('NombreCorto');
            $table->string('URL');
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
        Schema::drop('links_interes');
    }
}
