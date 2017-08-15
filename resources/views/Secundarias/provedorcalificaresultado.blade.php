@extends('layouts.principal2')

@section('content')

</br>

<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="/js/proveedorresultado.js" charset="utf-8"></script>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Resultados calificaciones</h1>
    </div>
</div>


<center><button type="button" class="btnobjetivo" onclick=location="/proveedores" data-dismiss="modal" id="btnCloseUpload">Regresar</button></center>


</br></br></br></br></br>


            <div class="modal-header">
  <!--            <ul class="nav nav-tabs">
                <li class="active"><a href="#">Calificar</a></li>
                <li><a href="#">Historial</a></li>
              </ul>-->
            </div>
            <div class="modal-body">
            <form id="fileinfo">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="proveedorid" id="proveedorid" value="">
              <input type="hidden" name="insumoid" id="insumoid" value="">
            </form>

              <div class="container">

              <div class="form-group form-group-lg">
                  <h2><label for="proveedor" class="control-label" >(*) Proveedor:</label></h2>
                  <select class="form-control" id="proveedor">
                    <option value="0"> Selecciona un proveedor </option>
                    <?php foreach ($proveedor as $proveedores): ?>
                      <option value="<?=$proveedores->id?>"> <?=$proveedores->proveedor ?> </option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div id="selectinsumos" class="form-group form-group-lg">
                  <h2><label for="insumos" class="control-label" >(*) Insumo:</label></h2>
                    <select class="form-control" id="insumo">

                    </select>
                  </div>




</div>


</div>

<h4><center><div class="form-group form-group-sm" id="checkinputs">
<label class="checkbox-inline"><input class="form-control input-sm" type="checkbox" value="" checked="checked" id="ctiempo"></br></br> Tiempo</label>
<label class="checkbox-inline"><input class="form-control input-sm" type="checkbox" value="" checked="checked" id="ccalidad"></br></br> calidad</label>
<label class="checkbox-inline"><input class="form-control input-sm" type="checkbox" value="" checked="checked" id="cservicio"></br></br> Servicio</label>
<label class="checkbox-inline"><input class="form-control input-sm" type="checkbox" value="" checked="checked" id="ccosto"></br></br> Costo</label></div></center></h4>

<center><div id="curve_chart" class="row" style="height: 500px"></div></center>

<div id="pruebasjquery"></div>
                    <div class="modal-footer">

                  </div>


@stop
