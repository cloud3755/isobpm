@extends('layouts.BaseLogin')

@section("content")
  <h1>Restaurar</h1>

  <form  action="/password/email" role="form" method="post">

              {{csrf_field()}}
        <div class="form-grup">
            <label for="">Correo:</label>
            <input type="text" class="form-control" name="email" placeholder="Tu correo electronico">
        </div>
        <br>
        <center><button type="submit" class="btn btn-primary" onclick="
return confirm('Se te enviara un correo, con el link para la restauracion de tu contraseña')">Enviar link</button></center>
  </form>
@stop
