<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>BIENVENIDO A ISOBPM</title>

    <!--estilo de bootstrap-->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    {{-- Estilos personalizados --}}
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/login.css">

  </head>
  <body>
    <div class="container">
            <div class="card card-container">
                <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
                <img id="profile-img" class="profile-img-card" src="/img/logo-isolution.png" />
                <p id="profile-name" class="profile-name-card"></p>
                  @yield('content')
            </div><!-- /card-container -->
        </div><!-- /container -->
  </body>
</html>
