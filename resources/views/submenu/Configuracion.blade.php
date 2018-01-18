@extends('layouts.principal2')

@section('content')


<!-- Switchery -->
<script src="js/switchery.js"></script>
<script>
  $(document).ready(function(){

    var elem_1 = document.querySelector('.js-switch1');
    var switchery_1 = new Switchery(elem_1, { color: '#428bca' });

    var elem_2 = document.querySelector('.js-switch2');
    var switchery_2 = new Switchery(elem_2, { color: '#428bca' });

    var elem_3 = document.querySelector('.js-switch3');
    var switchery_3 = new Switchery(elem_3, { color: '#428bca' });
});
</script>
<link href="css/switchery.css" rel="stylesheet">

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Configuración</h1>
  </div>
</div>
<center>
@if(Session::has('flash_message'))
<script>
alert ('{{Session::get('flash_message')}}')
</script>

@endif
</center>

<br>

  <div class="row">
  <div class="col-md-1"></div>
    <div class="panel panel-primary col-md-10" >
      <div class="panel-heading text-center"><strong>Activar/Desactivar Mensajeria E-mail</strong></div>
      <div class="panel-body"></div>
<form method="post" action="/config">
  <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <center>
      <ul class="mainMenu left">
      <li>


              <center>

                  <img class="imagesOfficeBar" src="/img/navBar office style images/quejas.png"/>
                  <br>
                  <strong>
                  Quejas
                </strong>
                    <br>
                  <input type="checkbox" class="js-switch1" name="mensajesQuejas" <?php  if($usuarios->empresas->mensajesQuejas == 1 ){echo("checked");} ?> />
                <br>
              </center>


      </li>
      <li>


              <center>

                  <img class="imagesOfficeBar" src="/img/navBar office style images/noconformidades.jpg"/>
                  <br>
                  <strong>
                  No Conformidades
                  </strong>
                  <br>
                <input type="checkbox" class="js-switch2"  name="mensajesNC" <?php if($usuarios->empresas->mensajesNC == 1 ){echo("checked");}  ?>/>
              <br>
              </center>

      </li>
      <li>


              <center>

                  <img class="imagesOfficeBar" src="/img/navBar office style images/accionescorrectivas.jpg"/>
                  <br>
                  <strong>
                  Acciones Correctivas
                  </strong>
                  <br>
                <input type="checkbox" class="js-switch3" name="mensajesAC" <?php if($usuarios->empresas->mensajesAC == 1 ){echo("checked");} ?>/>
              <br>
              </center>

      </li>
</ul>
<br>
<br>
<button type="submit" class="btn btn-success" id="btnaltaindicador" style="font-family: Arial;" ><i class="glyphicon glyphicon-floppy-save"><br>Guardar</i></button>
</center>
</form>
<br>
    </div>
    <div class="col-md-1"></div>
  </div>

@stop
