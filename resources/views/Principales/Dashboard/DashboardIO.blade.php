@extends('layouts.principal2')

@section('content')

<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!--
        <div id="grafica"></div>
        <div id="grafica1"></div>
        <div id="grafica2"></div>
-->
<div class="row">
  <form action="/Dashboard" method="post" role="form">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="col-lg-12">
    <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Indicador Graficado: @if($ultimo) <?=$ultimo->nombre?>@else Sin seleccionar @endif </h1>
  </div>
  <div class="col-md-4" id="">
    <h2><label for="Usuario" class="control-label col-md-12">Indicador:</label></h2>
    <select class="form-control input-lg" name="selectindicador" id="selectindicador">
      <?php foreach ($indicador as $indicadores): ?>
        <option value="<?=$indicadores->id;?>"><?=$indicadores->nombre;?></option>
      <?php endforeach ?>
    </select>
  </div>
  <div class="form-group form-group-lg">
    <h2><label for="tipo" class="control-label col-md-12" >Fecha inicio:</label>
    </h2>
    <div class="col-md-4">
      <input class="form-control input-lg" id="fechainicio" type="date" name="fechainicio">
    </select>
  </div>
</div>
<div class="form-group form-group-lg">
  <h2><label for="tipo" class="control-label col-md-12" >Fecha fin:</label>
  </h2>
  <div class="col-md-4">
    <input class="form-control input-lg" id="fechafin" type="date" name="fechafin">
  </select>
</div>
</div>
<br>
<div class="col-md-4">
  <button type="submit" class="btnobjetivo" style="font-family: Arial;" >Graficar</button>
</div>
</form>
</div>
<div>
  <label><h2>@if($ultimo) Meta: <?=$ultimo->meta?> @else Sin meta @endif</h2></label>
</div>
  <div id="grafico2"></div>
  <br>
  <div id="capaGrafico"></div>
  <div id="area"></div>
        <?php
          $dato = json_encode($resultado);
         ?>
<script>

google.load('visualization', '1.0', {'packages':['corechart']});

// Cuando la API de Visualización de Google está cargada llama a la función dibujaGrafico.
google.setOnLoadCallback(dibujaGrafico);
google.setOnLoadCallback(grafico2);
google.setOnLoadCallback(area);

document.getElementById("selectindicador").value = document.getElementById("selectindicador").selectedIndex=0;

// Llama a la función que crea y rellena la tabla,
// crea el gráfico de quesitos, la pasa los datos y
// lo dibuja.
function dibujaGrafico() {

  // Crea la tabla de datos.
    var variable = eval(<?php echo $dato ?>);
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'years');
    data.addColumn('number', 'RESULTADOS');
    for(i = 0; i < variable.length; i++)
      data.addRow([variable[i].mes, variable[i].valor]);
    // Create and draw the visualization.
    new google.visualization.ColumnChart(document.getElementById('capaGrafico')).
      draw(data, {});
}

function enviar(){
  var indicador = document.getElementById("selectindicador").value;
  window.location.href = "/Dashboard/"+ indicador;
}

function grafico2() {

  // Crea la tabla de datos.
    var variable = eval(<?php echo $dato ?>);
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'years');
    data.addColumn('number', 'RESULTADOS');

    for(i = 0; i < variable.length; i++)
      data.addRow([variable[i].mes, variable[i].valor]);

    // Create and draw the visualization.
    new google.visualization.LineChart(document.getElementById('grafico2')).
      draw(data, {colors: ['#e0440e']});
}

function area() {

  // Crea la tabla de datos.
    var variable = eval(<?php echo $dato ?>);
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'years');
    data.addColumn('number', 'RESULTADOS');

    for(i = 0; i < variable.length; i++)
      data.addRow([variable[i].mes, variable[i].valor]);

    // Create and draw the visualization.
    new google.visualization.AreaChart(document.getElementById('area')).
      draw(data, {colors: ['#FFFF00']});
}
</script>
</script>

@stop
