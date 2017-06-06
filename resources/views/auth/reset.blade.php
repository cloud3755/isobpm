@extends('layouts.BaseLogin')

@section("content")
  <h1>Restaurar password</h1>

  <form  action="/password/reset" role="form" method="post">

              {{csrf_field()}}
        <div class="form-grup">
          <input type="hidden" name="token" value="{{ $token }}">
          <div class="form-group">
            <label for="">Correo</label>
            <input type="text" class="form-control" name="email" value ="{{ old('email') }}" placeholder="Tu correo electronico" required>
          </div>
          <div class="form-group">
            <label for="">contraseña</label>
            <input type="password" class="form-control" name="password" placeholder="*******" minlength="6" required>
          </div>
          <div class="form-group">
            <label for="">confirmar contraseña</label>
            <input type="password" class="form-control" name="password_confirmation" placeholder="*******" minlength="6" required>
          </div>
        </div>
        <br>
        <center><button type="submit" class="btn btn-primary">Restablescer</button></center>
  </form>
@stop
