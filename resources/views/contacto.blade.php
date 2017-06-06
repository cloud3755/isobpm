@extends('layouts.BaseLogin')

@section("content")
  <h1>Enviar Datos</h1>

  <form  action="/mail" method="post" role="form">

              {{csrf_field()}}
        <div class="form-grup">
            <label for="">Nombre</label>
            <input type="text" class="form-control" name="nombre" placeholder="escribe el nombre">
        </div>

        <div class="form-grup">
            <label for="">Correo</label>
            <input type="text" class="form-control" name="email" placeholder="Tu correo electronico">
        </div>

        <div class="form-grup">
            <label for="">Descripcion</label>
            <textarea name="descripcion" rows="8" cols="35"  placeholder="escribe la descripcion"></textarea>
        </div>
        <br>

        <center><button type="submit" class="btn btn-primary">send</button></center>
  </form>
@stop
