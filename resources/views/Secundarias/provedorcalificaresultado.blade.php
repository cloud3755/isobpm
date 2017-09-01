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
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Resultados evaluaciones</h1>
    </div>
</div>


<center><button type="button" class="btnobjetivo" onclick=location="/proveedores" data-dismiss="modal" id="btnCloseUpload">Regresar</button></center>


</br></br></br></br></br>

<div class="modal-header">
  <center><div id="pruebasjquery" color="red"></div></center>
<!--            <ul class="nav nav-tabs">
    <li class="active"><a href="#">Calificar</a></li>
    <li><a href="#">Historial</a></li>
  </ul>-->
</div>
<div class="modal-body">
  <form id="formulariofiltro" class="form-horizontal" action="/provedores/resultado/filtro" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="container">


  <div class="form-group form-group-md col-sm-12">
    <div class="col-sm-6">
      <h2><label for="proveedor" class="control-label" >(*) Proveedor:</label></h2>
      <select class="form-control" id="proveedor" name="proveedor">
        <option value="0"> Elige proveedor</option>
        <?php foreach ($proveedor as $proveedores): ?>
          <option value="<?=$proveedores->idproveedor?>"> <?=$proveedores->proveedor ?> </option>
        <?php endforeach ?>
      </select>
    </div>

    <div class="col-sm-6">
    <div id="areas">
    <h2><label for="area" class="control-label" >(*) Area que evalua:</label></h2>
    <select class="form-control" id="area" name="area" required>

    </select>
    </div>
    </div>

  </div>

  <div class="form-group form-group-md col-sm-12">



    <div id="fech" class="col-sm-6">
      <h2><label for="fech" class="control-label" >(*) Fecha inicio:</label></h2>
        <input class="form-control" id="fech" type="date" placeholder="Agrega la fecha de calificacion" name="fech" value="<?=substr($yesterday,0,10)?>" required>
    </div>

    <div id="fecha2" class="col-sm-6">
      <h2><label for="fecha2" class="control-label" >(*) Fecha fin:</label></h2>
        <input class="form-control" id="fecha2" type="date" placeholder="Agrega la fecha de calificacion" name="fecha2" value="<?=substr($tomorrow,0,10)?>" required>
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
                                         <td><h3>Lista de insumos</h3></td>
                                         <td></td>
                                         <td><h3>Insumos evaluados</h3></td>
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

                                           </select>
                                       </td>
                                   </tr>
                               </tbody></table>
                           <p></p>
                       </div>

           </div>
       </div>

<!-- lista de insumos select-->
<center><div id="buttonchart" class="form-group form-group-md col-sm-12" >
<!--  <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">pruebacontrolador</button> -->
<button type="button" class="btnobjetivo"  data-dismiss="" id="botonfiltro">Filtrar</button>
</div></center>

</form>


</div>
<center><div id="curve_chart"></div></center>
</div>

<center><div id="tablediv">

<h2><div id="prov"> </div></h2>



  <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="fdatos">
    <thead style='background-color: #868889; color:#FFF'>
      <tr>
        <th>  <div class="th-inner sortable both">    Pedido  </div></th>
        <th>  <div class="th-inner sortable both">    Fecha  </div></th>
        <th>  <div class="th-inner sortable both">    Tiempo  </div></th>
        <th>  <div class="th-inner sortable both">    Calidad  </div></th>
        <th>  <div class="th-inner sortable both">    Servicio  </div></th>
        <th>  <div class="th-inner sortable both">    Costo  </div></th>
        <th>  <div class="th-inner sortable both">    Comentario  </div></th>
        <th>  <div class="th-inner sortable both">    Archivo   </div></th>
        <th>  <div class="th-inner sortable both">    Eliminar   </div></th>
      </tr>
    </thead>
    <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
    <tbody id = "FmyTable">



    </tbody>
  </table>

</div></center>


                    <div class="modal-footer">

                  </div>


@stop
