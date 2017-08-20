@extends('layouts.principal2')

@section('content')

</br>
<script src="/js/proveedorescalifica.js" charset="utf-8"></script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Califica proveedores</h1>
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
                    <option value="0"> Selecciona un proveedor a calificar</option>
                    <?php foreach ($proveedor as $proveedores): ?>
                      <option value="<?=$proveedores->id?>"> <?=$proveedores->proveedor ?> </option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="col-sm-6">
                  <h2><label for="fecha" class="control-label" >(*) Fecha de calificacion:</label></h2>
                    <input class="form-control" id="fechacalificacion" type="date" placeholder="Agrega la fecha de calificacion" name="fechacalificacion" value="<?php echo date("Y-m-d");?>" required>
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
                                                       </select>
                                                   </td>
                                               </tr>
                                           </tbody></table>
                                       <p></p>
                                   </div>

                       </div>
                   </div>

<!-- lista de insumos select-->

<div class="form-group form-group-md col-sm-12">

  <div class="col-sm-4">
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

  <div class="col-sm-4">
        <div id="pedidos">
          <h2><label for="pedidos" class="control-label" >(*) Pedido:</label></h2>
            <input class="form-control pedido" id="pedido" type="Text" placeholder="Agrega un identificador del pedido" name="pedido" required>
        </div>
  </div>

  <div class="col-sm-4">
    <div id="archivos">
      <div class="form-group form-group-md col-sm-12">
          <h2><label for="archivo" class="control-label">(*) Archivo:</label></h2>
              <input class="form-control input-lg" id="archivo" type="file" placeholder="Elige el archivo" name="archivo">
      </div>
    </div>
  </div>
</div>

            <div  id="radios">
              <div class="">
                  <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Que calificacion le otorgas al proveedor en los siguientes rubros:</h1>
              </div>
  <div class="row">
    <div class="col-lg-6">
    <h2><label for="tiempo" class="control-label" >Tiempo:</label></h2>
    <div class="form-group">
      <h3>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="1"></br></br> 1
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="2"></br></br>2
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="3"></br></br>3
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="4"></br></br>4
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="5"></br></br>5
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="6"></br></br>6
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="7"></br></br>7
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="8"></br></br>8
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="9"></br></br>9
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="10" checked="checked"></br></br>10
              </label>
            </h3>
    </div>
  </div>
  <div class="col-lg-6">
    <h2><label for="calidad" class="control-label" >Calidad:</label></h2>
    <div class="form-group">
      <h3>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="1"></br></br> 1
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="2"></br></br>2
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="3"></br></br>3
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="4"></br></br>4
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="5"></br></br>5
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="6"></br></br>6
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="7"></br></br>7
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="8"></br></br>8
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="9"></br></br>9
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="10" checked="checked"></br></br>10
              </label>
            </h3>
    </div>
  </div>
</div>
  <div class="row">
  <div class="col-lg-6">
    <h2><label for="servicio" class="control-label" >Servicio:</label></h2>
    <div class="form-group">
      <h3>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="1"></br></br> 1
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="2"></br></br>2
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="3"></br></br>3
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="4"></br></br>4
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="5"></br></br>5
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="6"></br></br>6
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="7"></br></br>7
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="8"></br></br>8
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="9"></br></br>9
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="10" checked="checked"></br></br>10
              </label>
            </h3>
    </div>
    </div>
    <div class="col-lg-6">
    <h2><label for="costo" class="control-label" >Costo:</label></h2>
    <div class="form-group">
      <h3>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="1"></br></br> 1
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="2"></br></br>2
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="3"></br></br>3
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="4"></br></br>4
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="5"></br></br>5
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="6"></br></br>6
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="7"></br></br>7
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="8"></br></br>8
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="9"></br></br>9
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="10" checked="checked"></br></br>10
              </label>
            </h3>
    </div>
</div>
            </div>
              </div>
              </div>
                    <div class="modal-footer">
                    <button type="submit" class="btnobjetivo" id="btnsubmit" style="font-family: Arial;">Guardar calificacion</button>
                  </div>
              </form>
              </div>




@stop
