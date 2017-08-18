@extends('layouts.BaseLogin')

@section('content')
  {!! Form::open(['route' => 'admin.auth.login', 'method' => 'POST' ])  !!}
    @if(Session::has('mensaje_error'))
      <p style="color:#FF0000";><strong> {{ Session::get('mensaje_error') }}</strong></p>
    @endif
    <div class="form-group">
      {!! Form::email('email', null, ['class' => 'form-control','placeholder' => "Ejemplo@mail.com" ]) !!}
    </div>

    <div class="form-group">
      {!! Form::password('password', ['class' => 'form-control','placeholder' => "************" ]) !!}
    </div>

    <div class="form-group">
      {!! Form::submit('Acceder', ['class' => 'btn btn-lg btn-primary btn-block btn-signin' ]) !!}
    </div>
  {!! Form::close() !!}
  <div class="form-group">
    <a href= "/password/email"  id="contacto">Olvidaste tu contraseña?</a>
  </div>
  <div class="form-group">
    <a href= "/contacto"  id="contacto">Contactanos</a>
  </div>
@stop
