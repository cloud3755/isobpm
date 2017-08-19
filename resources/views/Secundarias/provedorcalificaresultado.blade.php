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
  <form class="form-horizontal" action="/provedores/califica/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="proveedorid" id="proveedorid" value="">
  <input type="hidden" name="insumoid" id="insumoid" value="">
  <div class="container">


  <div class="form-group form-group-md col-sm-12">
    <div class="col-sm-6">
      <h2><label for="proveedor" class="control-label" >(*) Proveedor:</label></h2>
      <select class="form-control" id="proveedor">
        <option value="0"> Todos los proveedores</option>
        <?php foreach ($proveedor as $proveedores): ?>
          <option value="<?=$proveedores->id?>"> <?=$proveedores->proveedor ?> </option>
        <?php endforeach ?>
      </select>
    </div>

    <div class="col-sm-6">
    <div id="areas">
    <h2><label for="area" class="control-label" >(*) Area que califica:</label></h2>
    <select class="form-control" id="area" name="area" required>
    <option value="0"> Selecciona el area que califica</option>

    <?php foreach ($area as $areas): ?>
    <option value="<?=$areas->id?>"> <?=$areas->nombre ?> </option>
    <?php endforeach ?>

    </select>
    </div>
    </div>

  </div>

  <div class="form-group form-group-md col-sm-12">



    <div id="fech" class="col-sm-6">
      <h2><label for="fech" class="control-label" >(*) Fecha inicio:</label></h2>
        <input class="form-control" id="fech" type="date" placeholder="Agrega la fecha de calificacion" name="fech" value="<?php echo date("Y-m-d");?>" required>
    </div>

    <div id="fecha2" class="col-sm-6">
      <h2><label for="fecha2" class="control-label" >(*) Fecha fin:</label></h2>
        <input class="form-control" id="fecha2" type="date" placeholder="Agrega la fecha de calificacion" name="fecha2" value="<?php echo date("Y-m-d");?>" required>
    </div>
  </div>

<!-- lista de insumos select -->

    <div id="selectinsumos" class="form-group form-group-md col-sm-12">
      <h2><label for="Usuario" class="control-label">Lista de insumos:</label></h2>
      <div class="col-sm-12">

             <div>
                               <p>
                               </p><table WIDTH="100%">
                                       <tbody><tr>
                                         <td><h3>Insumos no elegidos</h3></td>
                                         <td></td>
                                         <td><h3>Insumos elegidos</h3></td>
                                       </tr>
                                       <tr>
                                           <td>
                                               <select multiple name="elistaDisponibles[]"  id="elistaDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('elistaDisponibles', 'elistaSeleccionada');">
                                               </select>

                                       </td>
                                       <td>
                                           <table>
                                               <tbody><tr>
                                                   <td>
                                                       <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('elistaDisponibles', 'elistaSeleccionada');">
                                                   </td>
                                               </tr>
                                               <tr>
                                                   <td>
                                                       <script type="text/javascript">

                                                       </script>
                                                   </td>
                                               </tr>
                                               <tr>
                                                   <td>
                                                   </td>
                                               </tr>
                                               <tr>
                                                   <td>
                                                       <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('elistaSeleccionada', 'elistaDisponibles');">
                                                   </td>
                                               </tr>
                                           </tbody></table>

                                       </td>

                                       <td>
                                           <select multiple name="elistaSeleccionada[]" id="elistaSeleccionada" required size="7" style="width: 100%;" onclick="agregaSeleccion('elistaSeleccionada', 'elistaDisponibles');">
                                             <?php foreach ($insumo as $insumos): ?>
                                               <option value="<?=$insumos->id?>" selected="selected"> <?=$insumos->Producto_o_Servicio ?> </option>
                                             <?php endforeach ?>
                                           </select>
                                       </td>
                                   </tr>
                               </tbody></table>
                           <p></p>
                       </div>

           </div>
       </div>

<!-- lista de insumos select-->


<center><div id="curve_chart" class="row" style="height: 500px"></div></center>

<div id="pruebasjquery"></div>

</div>
</div>

                    <div class="modal-footer">

                  </div>


@stop
