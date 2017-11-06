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
            $table->integer('id_compania');
            $table->string('usuario', 60);
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
            $table->integer('id_area');
            $table->string('empresa');
            $table->string('nombreunicoimagen');
            $table->string('nombreimagen');
            $table->integer('id_puesto');
            $table->integer('id_jefe')->nullable();
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
