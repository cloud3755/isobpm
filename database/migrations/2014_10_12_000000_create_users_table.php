<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('id_compania');
            $table->increments('usuario');
            $table->string('password', 60);
            $table->rememberToken();
            $table->string('nombre');
            $table->string('perfil');
            $table->string('email')->unique();
            $table->string('telefono');
            $table->timestamps();
            $table->string('status');
            $table->string('quota');
            $table->string('num_com');
            $table->string('direccion');
            $table->string('descripcion');
            $table->boolean('primero');
            $table->dateTime('cambio_password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
