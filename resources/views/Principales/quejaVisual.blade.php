@extends('layouts.principal2')

@section('content')

<script src="src/jquery.table2excel.js"></script>

    <div class="row" style="padding: 5px">
        <div class="col-lg-12 text-right">
            <button type="button" class="btn btn-primary" id="btnHelp">?</button>
        </div>
        <div class="col-lg-12" id="divHelp" style="display:none">
            <div class="col-lg-3 col-md-4 col-sm-4 hidden-xs text-center">
                <img src="../../img/help/doc_ext.jpg" class="img-responsive img-thumbnail" />
            </div>
            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                <p>
                    En este apartado se publican los Documentos Externos de la organización, tales como Normas, Contratos,
                    Acuerdos de Servicio y todo aquella documentación requerida y utilizada por la organización para su
                    sistema de Gestión.
                </p>
            </div>
        </div>
    </div><br><br><br><br><br>
    <!-- <center><MARQUEE WIDTH=50% HEIGHT=60> Este apartado es para quejas</MARQUEE></center> -->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
                <ol class="breadcrumb iso-breadcumb">
                    <li><a href="/mejoras" style='color:#FFF'> Quejas</a></li>
                    <li class="active">Version pro</li>
                </ol>
            </h2>
        </div>
    </div>
  <!--
  primer boton
    <div class="row">
        <div class="col-lg-12 text-right">
            <center>
            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i> Subir Queja</button>
            </center>
        </div>
    </div>
  -->
  <br>

  <div id="msg">

  </div>

  <div class="col-lg-12 text-lefth">
      <button type="button" class="btn btn-success" id="excel">Excel</button>
      <br>
  </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Quejas
                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i></button>
                </div>
            <div class="panel-body">
              <div class="table-responsive">
                <div class="dataTable_wrapper">
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th><div class="th-inner sortable both">  ID</div></th>
                          <th><div class="th-inner sortable both">  fecha</div></th>
                          <th><div class="th-inner sortable both">  Responsable</div></th>
                          <th><div class="th-inner sortable both">  Descripcion</div></th>
                          <th><div class="th-inner sortable both">  Cliente</div></th>
                          <th><div class="th-inner sortable both">  Acciones</div></th>
                          <th><div class="th-inner sortable both">  Fecha plan</div></th>
                          <th><div class="th-inner sortable both">  Evidencia</div></th>
                          <th><div class="th-inner sortable both">  Fecha cierre</div></th>
                          <th><div class="th-inner sortable both">  Status</div></th>
                          <th><div class="th-inner sortable both">  Archivo 1</div></th>
                          <th><div class="th-inner sortable both">  Archivo 2</div></th>
                          <th><div class="th-inner sortable both">  Editar / Eliminar</div></th>
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody>
                        <?php foreach ($relaciontabla as $queja): ?>
                        <tr>
                          <td> <?=$queja->id?> </td>
                          <td> <?=$queja->fecha?> </td>
                          <td> <?=$queja->usernombre?> </td>
                          <td> <?=$queja->descripcion?> </td>
                          <td> <?=$queja->clientenombre?> </td>
                          <td> <?=$queja->acciones?> </td>
                          <td> <?=$queja->fecha_plan?> </td>
                          <td> <?=$queja->evidencia?> </td>
                          <td> <?=$queja->fecha_cierre?> </td>
                          <td> <?=$queja->statusnombre?> </td>
                          <td> <?=$queja->archivoqueja?>
                            <a href="/storage/quejas/<?=$queja->uniquearchivoqueja?>" downloadFile="<?=$queja->uniquearchivoqueja?>" target="_blank" style='color:#FFF'>
                              <button type="button" class="btn btn-default">
                                   <span class="glyphicon glyphicon-download-alt"></span>
                              </button>
                            </a>
                         </td>
                         <td>
                           <?=$queja->archivoevidencia?>
                           <a href="/storage/quejas/<?=$queja->uniquearchivoevidencia?>" downloadFile="<?=$queja->uniquearchivoevidencia?>" target="_blank" style='color:#FFF'>
                             <button type="button" class="btn btn-default">
                                  <span class="glyphicon glyphicon-download-alt"></span>
                             </button>
                           </a>
                         </td>
                          <td>
<!-- se creara un bucle para generar los n modales necesarios para la edicion de datos -->
                            <form id="formeliminar" action="/quejas/delete/<?=$queja->id?>" method="post">
                              @if(Auth::user()->perfil != 4)
                              <input type="hidden" name="_token" value="{{{ csrf_token() }}}" id="token">
                              <button type="submit" class="borrar"  style="font-family: Arial;"  onclick="
return confirm('Estas seguro de eliminar la queja numero: <?=$queja->id?>?')"><i class="glyphicon glyphicon-remove"></i>Eliminar</button>
@endif
<button type="button" class="btnobjetivo" data-toggle="modal" data-target="#modaledit<?=$queja->id?>"><i class="glyphicon glyphicon-pencil"></i> Editar  </button>
                            </form>
                          </td>

                        </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>
</div>
</div>
    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">ALTA DE QUEJA</h2>
                </div>
                <div class="modal-body">
                  <div class="container">
                    <form  action="/quejas/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                      <input type="hidden" name="id_compania" value="{{Auth::user()->id_compania}}">

                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg"  type="date" placeholder="Fecha" name="fecha" required="">
                      </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Area:</label></h2>
                        <div class="col-md-6">

                          <select class="form-control input-lg" name="area" required="">
                            <option value=""></option>
                            <?php foreach ($area as $areas): ?>
                              <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                            <?php endforeach ?>
                          </select>

                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Proceso:</label></h2>
                        <div class="col-md-6">
                          <select class="form-control input-lg" name="proceso_id">
                            <option value=""></option>
                            <?php foreach ($proceso as $procesos): ?>
                              <option value="<?=$procesos['id']?>"><?=$procesos['proceso']?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Producto:</label></h2>
                        <div class="col-md-6">
                          <select class="form-control input-lg" name="producto_id">
                            <option value=""></option>
                            <?php foreach ($productos as $producto): ?>
                              <option value="<?=$producto['id']?>"><?=$producto['nombre']?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Monto:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" type="text" placeholder="monto" name="monto">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Cliente:</label></h2>
                        <div class="col-md-6">
                          <select class="form-control input-lg" name="cliente_id" required="">
                            <option value=""></option>
                            <?php foreach ($cliente as $clientes): ?>
                              <option value="<?=$clientes['id']?>"><?=$clientes['nombre']?></option>
                            <?php endforeach ?>
                          </select>

                        </div>
                    </div>


                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="Usuario" class="control-label col-md-12">
                          Decripcion de queja:
                        </label>
                        </h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Descripcion de la queja" name="descripcion" required=""></textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Archivo de evidencia de queja:</label></h2>
                        <div class="col-md-6">
                            <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo1">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12"  >Responsable:</label></h2>
                        <div class="col-md-6">
                            <select class="form-control input-lg" name="responsable" required="">
                              <option value=""></option>
                              <?php foreach ($User as $Users): ?>
                                <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="Usuario" class="control-label col-md-12">
                        Acciones:
                        </label>
                        </h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Acciones tomadas" name="acciones"></textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha plan:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha_plan">
                      </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Evidencia:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="probproces" type="text" placeholder="evidencia" name="evidencia">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Archivo de evidencia:</label></h2>
                        <div class="col-md-6">
                            <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo2">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha Cierre:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha_cierre">
                      </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Status:</label></h2>
                        <div class="col-md-6">
                            <select class="form-control input-lg" name="status_id">
                              <?php foreach ($estatus as $estatuses): ?>
                                <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                    </div>

        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Alta de Queja</button>
                    </form>
                            <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>



<!-- modal para update -->

<?php foreach ($quejas as $queja): ?>
<div class="modal fade" id="modaledit<?=$queja['id']?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">ALTA DE QUEJA</h2>
            </div>
            <div class="modal-body">
              <div class="container">
                <form  action="/quejas/edit/<?=$queja['id']?>" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <div class="form-group form-group-lg">
                  <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha:</label></h2>
                  <div class="col-md-6">
                      <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha" value ="<?=$queja['fecha']?>">
                  </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Area:</label></h2>
                    <div class="col-md-6">
                      <select class="form-control input-lg" name="area" required="">
                        <?php foreach ($area as $areas): ?>
                          @if($areas->id == $queja->area)
                           <option value="<?=$areas['id']?>" selected><?=$areas['nombre']?></option>
                          @endif
                          <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                        <?php endforeach ?>
                      </select>

                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Proceso:</label></h2>
                    <div class="col-md-6">
                      <select class="form-control input-lg" name="proceso_id">
                        <?php foreach ($proceso as $procesos): ?>
                          @if($procesos->id == $queja->proceso)
                           <option value="<?=$procesos['id']?>" selected><?=$procesos['proceso']?></option>
                          @endif
                          <option value="<?=$procesos['id']?>"><?=$procesos['proceso']?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Producto:</label></h2>
                    <div class="col-md-6">
                      <select class="form-control input-lg" name="producto_id">

                        <?php foreach ($productos as $producto): ?>
                          @if($producto->id == $queja->producto)
                            <option value="<?=$producto['id']?>"  selected><?=$producto['nombre']?></option>
                          @endif
                          <option value="<?=$producto['id']?>"><?=$producto['nombre']?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Cliente:</label></h2>
                    <div class="col-md-6">

                      <select class="form-control input-lg" name="cliente_id">
                        <?php foreach ($cliente as $clientes): ?>
                          <option value="<?=$clientes['id']?>"><?=$clientes['nombre']?></option>
                        <?php endforeach ?>
                      </select>

                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12">
                    Decripcion de Queja:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Descripcion de la queja" name="descripcion"><?=$queja['descripcion']?></textarea>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="tipo" class="control-label col-md-12" >Archivo de evidencia de queja: <br><?=$queja['archivoqueja']?></label></h2>
                    <div class="col-md-6">
                        <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo1">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="tipo" class="control-label col-md-12" >Responsable:</label></h2>
                    <div class="col-md-6">
                        <select class="form-control input-lg" name="responsable">
                          <?php foreach ($User as $Users): ?>
                            <option value="<?=$Users['id']?>"><?=$Users['usuario']?></option>
                          <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12">
                    Acciones:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Acciones tomadas" name="acciones"><?=$queja['acciones']?></textarea>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha plan:</label></h2>
                  <div class="col-md-6">
                      <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha_plan" value="<?=$queja['fecha_plan']?>">
                  </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Evidencia:</label></h2>
                    <div class="col-md-6">
                        <input class="form-control input-lg" id="probproces" type="text" placeholder="evidencia" name="evidencia" value="<?=$queja['evidencia']?>">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="tipo" class="control-label col-md-12" >Archivo de evidencia de queja: <br> <?=$queja['archivoevidencia']?> </label></h2>
                    <div class="col-md-6">
                        <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo2">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha Cierre:</label></h2>
                  <div class="col-md-6">
                      <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha_cierre" value="<?=$queja['fecha_cierre']?>">
                  </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="tipo" class="control-label col-md-12" >Status:</label></h2>
                    <div class="col-md-6">
                        <select class="form-control input-lg" name="status_id">
                          <?php foreach ($estatus as $estatuses): ?>
                            <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                          <?php endforeach ?>
                        </select>
                    </div>
                </div>

    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Editar Queja</button>
                </form>
                        <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
</div>

<?php endforeach?>


<!-- termina modal para update -- >

<script>

$("#excel").click(function(){
$("#tblProIn").table2excel({
  filename: "Reporte"
});
});

</script>

@stop
