@extends('layouts.principal2')

@section('content')

</br>

<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="/js/personalresults.js" charset="utf-8"></script>




<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Resultados del personal</h1>
    </div>
</div>


<center><button type="button" class="btnobjetivo" onclick=location="/admin" data-dismiss="modal" id="btnCloseUpload">Regresar</button></center>


</br>

<div class="modal-header">
  <center><div id="pruebasjquery" color="red"></div></center>
<!--            <ul class="nav nav-tabs">
    <li class="active"><a href="#">Calificar</a></li>
    <li><a href="#">Historial</a></li>
  </ul>-->
</div>
<div class="modal-body">
  <form id="formulariofiltro" class="form-horizontal" action="/personal/resultado/filtro" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="uprofile" id="uprofile" value="{{ Auth::user()->perfil }}">
  <div class="container">

<div class="row">
  <div class="form-group form-group-md col-sm-3">
  </div>
    <div class="col-sm-6">
      <h2><label for="proveedor" class="control-label" >(*) Usuario:</label></h2>
      <select class="form-control" id="usuario" name="usuario">
        <?php foreach ($users as $user): ?>
          <option value="<?=$user->id?>"> <?=$user->nombre ?> </option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="form-group form-group-md col-sm-3">
    </div>

  </div>

  <div class="row">

    <div id="fech" class="col-sm-6">
      <h2><label for="fech" class="control-label" >(*) Mes inicio:</label></h2>
        <input class="form-control" id="fech" type="month" placeholder="Agrega la fecha de calificacion" name="fech" value="" >
    </div>

    <div id="fecha2" class="col-sm-6">
      <h2><label for="fecha2" class="control-label" >(*) Mes fin:</label></h2>
        <input class="form-control" id="fecha2" type="month" placeholder="Agrega la fecha de calificacion" name="fecha2" value="" >
    </div>
  </div>

  <div class="row">
<center><div id="buttonchart" class="form-group form-group-md col-sm-12" >
 <!--<button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">pruebacontrolador</button> -->
<br>
<button type="button" class="btnobjetivo"  data-dismiss="" id="botonfiltro" >Filtrar</button>
</div></center>
</div>
</form>


</div>

<center><div id="curve_chart"></div></center>
</div>



                    <div class="modal-footer">

                  </div>


@stop
