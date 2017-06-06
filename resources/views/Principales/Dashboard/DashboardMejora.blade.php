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

        <br><br><br><br><br><br><br><br>
        <!-- <div id="capaGrafico" class="col-md-12"></div> -->
    <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalresumen">Resumen</button>
      <center>
        <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalqueja"><i class="fa fa-user-times fa-1x"></i> Quejas</button>
        <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalnoconformidad"><i class="fa fa-thumbs-o-down fa-1x"></i> No conformidades</button>
        <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalaccion"><i class="fa fa-shield fa-1x"></i> Acciones</button>
      </center>

      <br>
        <!-- <div id="capaGrafico1"></div>
        <br> -->
        <div id="capaGrafico2"></div>
        <br>
        <div id="capaGrafico3"></div>
        <br>
        <div id="capaGrafico4"></div>


        <div class="modal fade" id="modalresumen" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document" id="modalresumentama">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Resumen del periodo selecionado</h2>
                    </div>
                    <div class="modal-body">
                      <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-red">
                                    <div class="panel-heading">
                                        Resumen
                                    </div>
                                <div class="panel-body">
                                    <div class="dataTable_wrapper">
                                        <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                                          <thead style='background-color: #1E46B3; color:#1E46B3;'>
                                            <tr>
                                              <th><div class="th-inner sortable both">  ID</div></th>
                                              <th><div class="th-inner sortable both">  fecha alta</div></th>
                                              <th><div class="th-inner sortable both">  Indicador</div></th>
                                              <th><div class="th-inner sortable both">  Proceso</div></th>
                                            </tr>
                                          </thead>
                                          <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                                          <tbody>
                                            <tr>
                                              <td>dato</td>
                                              <td>dato</td>
                                              <td>dato</td>
                                              <td>dato</td>
                                            </tr>
                                            <tr>
                                              <td>dato</td>
                                              <td>dato</td>
                                              <td>dato</td>
                                              <td>dato</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                    </div>
                                </div>
                              </div>
                            </div>
                    </div>


                      </div>
                            <div class="modal-footer">
                              <center>  <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button> </center>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalqueja" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Graficar Quejas</h2>
                    </div>
                    <div class="modal-body">
                      <div class="container">
                        <form  action="/mejora/post" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                          <input type="hidden" name="_token" value="{{ csrf_token()}}">
                          <input type="hidden" name="tipo" value="1">

                          <div class="form-group form-group-lg">
                             <h2><label for="Producto" class="control-label col-md-12">Graficar por:</label></h2>
                             <div class="col-md-6">
                               <select class="form-control input-lg" name="tipografico" required="">
                                 <option value="1">Productos</option>
                                 <option value="2">Areas</option>
                                 <option value="3">Procesos</option>
                               </select>
                              </div>
                           </div>

                           <div class="form-group form-group-lg">
                                <h2><label for="Producto" class="control-label col-md-12">Estatus:</label></h2>
                                <div class="col-md-6">
                                  <select class="form-control input-lg" name="statusgrafica">
                                    <option value="0">Todos</option>
                                    <?php foreach ($estatus as $estatu): ?>
                                      <option value="<?=$estatu['id']?>"><?=$estatu['nombre']?></option>
                                    <?php endforeach ?>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                 <h2><label for="Producto" class="control-label col-md-12">Area:</label></h2>
                                 <div class="col-md-6">
                                   <select class="form-control input-lg" name="Area">
                                     <option value="0">Todas</option>
                                     <?php foreach ($area as $areas): ?>
                                       <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                                     <?php endforeach ?>
                                   </select>
                                 </div>
                             </div>

                           <div class="form-group form-group-lg">
                               <h2><label for="tipo" class="control-label col-md-12" >Fecha inicio:</label>
                               </h2>
                               <div class="col-md-6">
                                 <input class="form-control input-lg" id="fechainicio" type="date" name="fechainicio" required="">
                             </div>
                           </div>

                           <div class="form-group form-group-lg">
                             <h2><label for="tipo" class="control-label col-md-12" >Fecha fin:</label>
                             </h2>
                             <div class="col-md-6">
                                 <input class="form-control input-lg" id="fechafin" type="date" name="fechafin" required="">
                             </div>
                           </div>
                         </div>



                            <div class="modal-footer">
                                <button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Graficar</button>
                        </form>
                                <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <div class="modal fade" id="modalaccion" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Graficar Acciones</h2>
                    </div>
                    <div class="modal-body">
                      <div class="container">
                        <form  action="/mejora/post" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                          <input type="hidden" name="_token" value="{{ csrf_token()}}">
                          <input type="hidden" name="tipo" value="3">

                          <div class="form-group form-group-lg">
                             <h2><label for="Producto" class="control-label col-md-12">Graficar por:</label></h2>
                             <div class="col-md-6">
                               <select class="form-control input-lg" name="tipografico" required="">
                                 <option value="1">Productos</option>
                                 <option value="2">Areas</option>
                                 <option value="3">Procesos</option>
                               </select>
                              </div>
                           </div>

                           <div class="form-group form-group-lg">
                                <h2><label for="Producto" class="control-label col-md-12">Estatus:</label></h2>
                                <div class="col-md-6">
                                  <select class="form-control input-lg" name="statusgrafica">
                                    <option value="0">Todos</option>
                                    <?php foreach ($estatus as $estatu): ?>
                                      <option value="<?=$estatu['id']?>"><?=$estatu['nombre']?></option>
                                    <?php endforeach ?>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                 <h2><label for="Producto" class="control-label col-md-12">Area:</label></h2>
                                 <div class="col-md-6">
                                   <select class="form-control input-lg" name="Area">
                                     <option value="0">Todas</option>
                                     <?php foreach ($area as $areas): ?>
                                       <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                                     <?php endforeach ?>
                                   </select>
                                 </div>
                             </div>

                           <div class="form-group form-group-lg">
                               <h2><label for="tipo" class="control-label col-md-12" >Fecha inicio:</label>
                               </h2>
                               <div class="col-md-6">
                                 <input class="form-control input-lg" id="fechainicio" type="date" name="fechainicio" required="">
                             </div>
                           </div>

                           <div class="form-group form-group-lg">
                             <h2><label for="tipo" class="control-label col-md-12" >Fecha fin:</label>
                             </h2>
                             <div class="col-md-6">
                                 <input class="form-control input-lg" id="fechafin" type="date" name="fechafin" required="">
                             </div>
                           </div>
                         </div>



                            <div class="modal-footer">
                                <button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Graficar</button>
                        </form>
                                <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <div class="modal fade" id="modalnoconformidad" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Graficar No confomidades</h2>
                    </div>
                    <div class="modal-body">
                      <div class="container">
                        <form  action="/mejora/post" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                          <input type="hidden" name="_token" value="{{ csrf_token()}}">
                          <input type="hidden" name="tipo" value="2">


                       <div class="form-group form-group-lg">
                          <h2><label for="Producto" class="control-label col-md-12">Graficar por:</label></h2>
                          <div class="col-md-6">
                            <select class="form-control input-lg" name="tipografico" required="">
                              <option value="1">Productos</option>
                              <option value="2">Areas</option>
                              <option value="3">Procesos</option>
                            </select>
                           </div>
                        </div>

                        <div class="form-group form-group-lg">
                             <h2><label for="Producto" class="control-label col-md-12">Estatus:</label></h2>
                             <div class="col-md-6">
                               <select class="form-control input-lg" name="statusgrafica">
                                 <option value="0">Todos</option>
                                 <?php foreach ($estatus as $estatu): ?>
                                   <option value="<?=$estatu['id']?>"><?=$estatu['nombre']?></option>
                                 <?php endforeach ?>
                               </select>
                             </div>
                         </div>

                         <div class="form-group form-group-lg">
                              <h2><label for="Producto" class="control-label col-md-12">Area:</label></h2>
                              <div class="col-md-6">
                                <select class="form-control input-lg" name="Area">
                                  <option value="0">Todas</option>
                                  <?php foreach ($area as $areas): ?>
                                    <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                                  <?php endforeach ?>
                                </select>
                              </div>
                          </div>

                        <div class="form-group form-group-lg">
                            <h2><label for="tipo" class="control-label col-md-12" >Fecha inicio:</label>
                            </h2>
                            <div class="col-md-6">
                              <input class="form-control input-lg" id="fechainicio" type="date" name="fechainicio" required="">
                          </div>
                        </div>

                        <div class="form-group form-group-lg">
                          <h2><label for="tipo" class="control-label col-md-12" >Fecha fin:</label>
                          </h2>
                          <div class="col-md-6">
                              <input class="form-control input-lg" id="fechafin" type="date" name="fechafin" required="">
                          </div>
                        </div>
                      </div>


                            <div class="modal-footer">
                                <button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Graficar</button>
                        </form>
                                <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <?php
          $datoenero = json_encode($quejacount);
          $datoproducto = json_encode($noconformidadcountproductos);
          $datosumproducto = json_encode($noconformidadsumproductos);
          $datotendencia = json_encode($noconformidadtendenciaproducto);
          // $datofebrero = json_encode($quejacountmayo);
          // $datofebrero = json_encode($quejacountjunio);
          // $datofebrero = json_encode($quejacountjulio);
          // $datofebrero = json_encode($quejacountagosto);
          // $datofebrero = json_encode($quejacountseptiembre);
          // $datofebrero = json_encode($quejacountoctubre);
          // $datofebrero = json_encode($quejacountnoviembre);
          // $datofebrero = json_encode($quejacountdiciembre);
         ?>
<script>

google.load('visualization', '1.0', {'packages':['corechart']});

// Cuando la API de Visualización de Google está cargada llama a la función dibujaGrafico.
google.setOnLoadCallback(dibujaGrafico);
google.setOnLoadCallback(dibujaGrafico2);
google.setOnLoadCallback(dibujaGrafico3);
google.setOnLoadCallback(dibujaGrafico4);
// google.setOnLoadCallback(grafico2);
// google.setOnLoadCallback(area);

// Llama a la función que crea y rellena la tabla,
// crea el gráfico de quesitos, la pasa los datos y
// lo dibuja.
function dibujaGrafico() {

  // Crea la tabla de datos.
    var datoeneroa = eval(<?php echo $datoenero ?>);
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Mes');
    data.addColumn('number', 'Total de quejas');
    var mes = 'Sin mes';
    for(i = 0; i < datoeneroa.length; i++){
      //el primero es atrasados y segundo proceso
      //Enero
      //console.log(i);
      if (datoeneroa[i].mes == 1) {mes = 'Enero';}
      else if (datoeneroa[i].mes == 2) {mes = 'Febrero';}
      else if (datoeneroa[i].mes == 3) {mes = 'Marzo';}
      else if (datoeneroa[i].mes == 4) {mes = 'Abril';}
      else if (datoeneroa[i].mes == 5) {mes = 'Mayo';}
      else if (datoeneroa[i].mes == 6) {mes = 'Junio';}
      else if (datoeneroa[i].mes == 7) {mes = 'Julio';}
      else if (datoeneroa[i].mes == 8) {mes = 'Agosto';}
      else if (datoeneroa[i].mes == 9) {mes = 'Septiembre';}
      else if (datoeneroa[i].mes == 10) {mes = 'Octubre';}
      else if (datoeneroa[i].mes == 11) {mes = 'Noviembre';}
      else if (datoeneroa[i].mes == 12) {mes = 'Diciembre';}

      data.addRow([mes,datoeneroa[i].total]);
    }

    // Create and draw the visualization.
    new google.visualization.ColumnChart(document.getElementById('capaGrafico1')).
      draw(data, {});
}


function dibujaGrafico2() {

  // Crea la tabla de datos.
    var datoeneroa = eval(<?php echo $datoproducto ?>);
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Mes');
    data.addColumn('number', 'Cantidad');
    var mes = 'Sin mes';
    for(i = 0; i < datoeneroa.length; i++){
      //el primero es atrasados y segundo proceso
      //Enero
      //console.log(i);
      if (datoeneroa[i].mes == 1) {
        mes = 'Enero';
            // data.addRow([mes+' '+datoeneroa[0].nombreproducto,datoeneroa[0].total]);
            // data.addRow([mes+' '+datoeneroa[1].nombreproducto,datoeneroa[1].total]);
      }
      else if (datoeneroa[i].mes == 2) {mes = 'Febrero';}
      else if (datoeneroa[i].mes == 3) {mes = 'Marzo';}
      else if (datoeneroa[i].mes == 4) {mes = 'Abril';}
      else if (datoeneroa[i].mes == 5)
      {
        mes = 'Mayo';
        // data.addRow([mes+datoeneroa[i].area,datoeneroa[i].total]);
      }
      else if (datoeneroa[i].mes == 6) {mes = 'Junio';}
      else if (datoeneroa[i].mes == 7) {mes = 'Julio';}
      else if (datoeneroa[i].mes == 8) {mes = 'Agosto';}
      else if (datoeneroa[i].mes == 9) {mes = 'Septiembre';}
      else if (datoeneroa[i].mes == 10) {mes = 'Octubre';}
      else if (datoeneroa[i].mes == 11) {mes = 'Noviembre';}
      else if (datoeneroa[i].mes == 12) {mes = 'Diciembre';}

      // data.addRow([mes,datoeneroa[i].total]);
      data.addRow([datoeneroa[i].nombreproducto,datoeneroa[i].total]);
    }

    // Create and draw the visualization.
    new google.visualization.ColumnChart(document.getElementById('capaGrafico2')).
      draw(data, {});
}

function dibujaGrafico3() {

  // Crea la tabla de datos.
    var datoeneroa = eval(<?php echo $datosumproducto ?>);
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Mes');
    data.addColumn('number', 'Costo');
    var mes = 'Sin mes';
    for(i = 0; i < datoeneroa.length; i++){
      //el primero es atrasados y segundo proceso
      //Enero
      //console.log(i);
      if (datoeneroa[i].mes == 1) {mes = 'Enero';}
      else if (datoeneroa[i].mes == 2) {mes = 'Febrero';}
      else if (datoeneroa[i].mes == 3) {mes = 'Marzo';}
      else if (datoeneroa[i].mes == 4) {mes = 'Abril';}
      else if (datoeneroa[i].mes == 5) {mes = 'Mayo';}
      else if (datoeneroa[i].mes == 6) {mes = 'Junio';}
      else if (datoeneroa[i].mes == 7) {mes = 'Julio';}
      else if (datoeneroa[i].mes == 8) {mes = 'Agosto';}
      else if (datoeneroa[i].mes == 9) {mes = 'Septiembre';}
      else if (datoeneroa[i].mes == 10) {mes = 'Octubre';}
      else if (datoeneroa[i].mes == 11) {mes = 'Noviembre';}
      else if (datoeneroa[i].mes == 12) {mes = 'Diciembre';}

      data.addRow([datoeneroa[i].nombreproducto,datoeneroa[i].total]);
    }

    // Create and draw the visualization.
    new google.visualization.ColumnChart(document.getElementById('capaGrafico3')).
      draw(data, {});
}

function dibujaGrafico4() {

  // Crea la tabla de datos.
    var datoeneroa = eval(<?php echo $datotendencia ?>);
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Mes');
    data.addColumn('number', 'Tendencia');
    var mes = 'Sin mes';
    for(i = 0; i < datoeneroa.length; i++){
      //el primero es atrasados y segundo proceso
      //Enero
      //console.log(i);
      if (datoeneroa[i].mes == 1) {mes = 'Enero';}
      else if (datoeneroa[i].mes == 2) {mes = 'Febrero';}
      else if (datoeneroa[i].mes == 3) {mes = 'Marzo';}
      else if (datoeneroa[i].mes == 4) {mes = 'Abril';}
      else if (datoeneroa[i].mes == 5) {mes = 'Mayo';}
      else if (datoeneroa[i].mes == 6) {mes = 'Junio';}
      else if (datoeneroa[i].mes == 7) {mes = 'Julio';}
      else if (datoeneroa[i].mes == 8) {mes = 'Agosto';}
      else if (datoeneroa[i].mes == 9) {mes = 'Septiembre';}
      else if (datoeneroa[i].mes == 10) {mes = 'Octubre';}
      else if (datoeneroa[i].mes == 11) {mes = 'Noviembre';}
      else if (datoeneroa[i].mes == 12) {mes = 'Diciembre';}

      data.addRow([mes,datoeneroa[i].total]);
    }

    // Create and draw the visualization.
    new google.visualization.LineChart(document.getElementById('capaGrafico4')).
      draw(data, {});
}


</script>

@stop
