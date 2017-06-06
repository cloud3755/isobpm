@extends('layouts.principal2')

@section('content')

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
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
                <ol class="breadcrumb iso-breadcumb">
                    <li><a href="/mejoras" style='color:#FFF'> No Conformidad</a></li>
                    <li class="active">Version pro</li>
                </ol>
            </h2>
        </div>
    </div>
<br><br><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    No conformidades
                    <button type="button" class="btn btn-green btn-xs" id="" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i></button>
                </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th>  <div class="th-inner sortable both">    fecha  </div></th>
                          <th>  <div class="th-inner sortable both">    Proceso  </div></th>
                          <th>  <div class="th-inner sortable both">    Producto  </div></th>
                          <th>  <div class="th-inner sortable both">    Documento  </div></th>
                          <th>  <div class="th-inner sortable both">    Descripcion  </div></th>
                          <th>  <div class="th-inner sortable both">    Responsable  </div></th>
                          <th>  <div class="th-inner sortable both">    Acciones  </div></th>
                          <th>  <div class="th-inner sortable both">    Fecha Plan  </div></th>
                          <th>  <div class="th-inner sortable both">    Evidencia  </div></th>
                          <th>  <div class="th-inner sortable both">    Evidencia Apertura  </div></th>
                          <th>  <div class="th-inner sortable both">    Fecha cierre  </div></th>
                          <th>  <div class="th-inner sortable both">    Status  </div></th>
                          <th>  <div class="th-inner sortable both">    Monto  </div></th>
                          <th>  <div class="th-inner sortable both">  Editar / Eliminar</div></th>
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody>
                        <?php foreach ($relaciontabla as $noconformidad): ?>
                        <tr>
                          <td>  <?=$noconformidad->fecha?> </td>
                          <td>  <?=$noconformidad->procesonombre?></td>
                          <td>  <?=$noconformidad->productonombre?></td>
                          <td>  <?=$noconformidad->documento?></td>
                          <td>  <?=$noconformidad->descripcion?></td>
                          <td>  <?=$noconformidad->usuarionombre?></td>
                          <td>  <?=$noconformidad->acciones?></td>
                          <td>  <?=$noconformidad->fecha_plan?></td>
                          <td>  <?=$noconformidad->evidencia?>
                            <a href="/storage/noconformidad/<?=$noconformidad->evidencia_unic?>" downloadFile="<?=$noconformidad->evidencia_unic?>" style='color:#FFF'>
                              <button type="button" class="btn btn-default">
                                   <span class="glyphicon glyphicon-download-alt"></span>
                              </button>
                            </a>
                          </td>
                          <td>  <?=$noconformidad->evidenciapertura?>
                            <a href="/storage/noconformidad/<?=$noconformidad->apertura_unic?>" downloadFile="<?=$noconformidad->apertura_unic?>" style='color:#FFF'>
                              <button type="button" class="btn btn-default">
                                   <span class="glyphicon glyphicon-download-alt"></span>
                              </button>
                            </a>
                          </td>
                          <td>  <?=$noconformidad->fecha_cierre?></td>
                          <td>  <?=$noconformidad->estatusnombre?></td>
                          <td>  <?=$noconformidad->monto?></td>
                          <td>
<!-- se creara un bucle para generar los n modales necesarios para la edicion de datos -->
                              <form class="" action="/noconformidad/delete/<?=$noconformidad->id?>" method="post">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}
                                <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" onclick="
  return confirm('Estas seguro de eliminar la queja numero: <?=$noconformidad->id?>?')">Eliminar</button>
                                <button type="button" class="btnobjetivo" data-toggle="modal" data-target="#modaledit<?=$noconformidad->id?>"><i class="glyphicon glyphicon-pencil"></i> Editar  </button>
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
    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">ALTA DE NO CONFORMIDADES</h2>
                </div>
                <div class="modal-body">
                  <div class="container">
                    <form  action="/noconformidad/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                      <input type="hidden" name="id_area" value="{{ Auth::user()->id_area }}">
                      <input type="hidden" name="id_compania" value="{{Auth::user()->id_compania}}">
                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha" required="">
                      </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Proceso:</label></h2>
                        <div class="col-md-6">
                          <select class="form-control input-lg" name="proceso_id" id="proceso_id">
                            <option value="50"></option>
                            <?php foreach ($Proceso as $Procesos): ?>
                              <option value="<?=$Procesos['id']?>"><?=$Procesos['proceso']?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Producto:</label></h2>
                        <div class="col-md-6">
                          <select class="form-control input-lg" name="producto_id" id="producto_id">
                            <option value="21"></option>
                            <?php foreach ($Producto as $Productos): ?>
                              <option value="<?=$Productos['id']?>"><?=$Productos['nombre']?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Area:</label></h2>
                        <div class="col-md-6">
                            <select class="form-control input-lg" name="id_area" id="id_area">
                              <option value="2"></option>
                              <?php foreach ($area as $areas): ?>
                                <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Evidencia no conformidad:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="documento" type="file" placeholder="evidenciapertura" name="archivo1">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Documento:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="documento" type="text" placeholder="Documento" name="documento">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12"> Decripcion:</label>
                        </h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "descripcion" rows="3" name="descripcion" placeholder="Descripcion No conformidad" required=""></textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Responsable:</label></h2>
                        <div class="col-md-6">
                            <select class="form-control input-lg" name="usuario_responsable_id" id="usuario_responsable_id" required="">
                              <option value=""></option>
                              <?php foreach ($User as $Users): ?>
                                <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12"> Acciones:</label></h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "acciones" name = "acciones" rows="3" placeholder="Acciones a Realizar"></textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha plan:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg" id="fecha_plan" type="date" placeholder="Fecha del Plan" name="fecha_plan">
                      </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Evidencia de cierre:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="evidencia" type="file" placeholder="Evidencia del cierre" name="archivo2">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha Cierre:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg" id="fecha_cierre" type="date" placeholder="Fecha para el cierre" name="fecha_cierre">
                      </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Status:</label></h2>
                        <div class="col-md-6">
                            <select class="form-control input-lg" name="estatus_id" id="estatus_id">
                              <?php foreach ($estatus as $estatuses): ?>
                                <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                      <h2><label for="Monto" class="control-label col-md-12">Monto:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg" id="monto" type="text" placeholder="Monto de la no conformidad" name="monto" required="">
                      </div>
                    </div>
        </div>


                        <div class="modal-footer">
                          <button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;" >Alta de No Conformidad</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
    </div>

    <?php foreach ($Noconformidades as $Noconformidad): ?>
    <div class="modal fade" id="modaledit<?=$Noconformidad['id']?>" tabindex="-1" role="dialog" accept-charset="UTF-8" enctype="multipart/form-data">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">EDITAR NO CONFORMIDAD</h2>
                </div>
                <div class="modal-body">
                  <div class="container">
                    <form  action="/noconformidad/edit/<?=$Noconformidad['id']?>" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                      <input type="hidden" name="id_compania" value="{{Auth::user()->id_compania}}">

                      <div class="form-group form-group-lg">
                        <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" type="date" placeholder="Fecha"  value = "<?=$Noconformidad['fecha']?>" name="fecha">
                        </div>
                      </div>

                      <div class="form-group form-group-lg">
                          <h2><label for="Usuario" class="control-label col-md-12">Proceso:</label></h2>
                          <div class="col-md-6">
                            <select class="form-control input-lg" name="proceso_id" id="proceso_id">
                              <?php foreach ($Proceso as $Procesos): ?>
                                <option value="<?=$Procesos['id']?>"><?=$Procesos['proceso']?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                      </div>

                      <div class="form-group form-group-lg">
                          <h2><label for="Usuario" class="control-label col-md-12">Producto:</label></h2>
                          <div class="col-md-6">
                            <select class="form-control input-lg" name="producto_id" id="producto_id">
                              <?php foreach ($Producto as $Productos): ?>
                                @if($Productos->id == $Noconformidad->producto_id)
                                    <option value="<?=$Productos['id']?>"><?=$Productos['nombre']?></option>
                                @endif
                                <option value="<?=$Productos['id']?>"><?=$Productos['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                      </div>

                      <div class="form-group form-group-lg">
                          <h2><label for="tipo" class="control-label col-md-12" >Area:</label></h2>
                          <div class="col-md-6">
                              <select class="form-control input-lg" name="id_area" id="id_area">
                                <?php foreach ($area as $areas): ?>
                                  @if($areas->id == $Noconformidad->id_area)
                                    <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                                  @endif
                                  <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                                <?php endforeach ?>
                              </select>
                          </div>
                      </div>

                      <div class="form-group form-group-lg">
                          <h2><label for="Usuario" class="control-label col-md-12">Evidencia de no conformidad:</label></h2>
                          <div class="col-md-6">
                              <input class="form-control input-lg" id="documento" type="file" value = "" name="archivo1">
                          </div>
                      </div>

                      <div class="form-group form-group-lg">
                          <h2><label for="Usuario" class="control-label col-md-12">Documento:</label></h2>
                          <div class="col-md-6">
                              <input class="form-control input-lg" id="documento" type="text" placeholder="<?=$Noconformidad['documento']?>" name="documento">
                          </div>
                      </div>

                      <div class="form-group form-group-lg">
                          <h2><label for="Usuario" class="control-label col-md-12"> Decripcion:</label>
                          </h2>
                          <div class="col-md-6">
                              <textarea class="form-control" id = "descripcion" rows="3" name="descripcion" placeholder="Descripcion No conformidad"><?=$Noconformidad['descripcion']?></textarea>
                          </div>
                      </div>

                      <div class="form-group form-group-lg">
                          <h2><label for="tipo" class="control-label col-md-12" >Responsable:</label></h2>
                          <div class="col-md-6">
                              <select class="form-control input-lg" name="usuario_responsable_id" id="usuario_responsable_id">
                                <?php foreach ($User as $Users): ?>
                                  @if($Users->id == $Noconformidad->usuario_responsable_id)
                                    <option value="<?=$Users['id']?>"><?=$Users['usuario']?></option>
                                  @endif
                                  <option value="<?=$Users['id']?>"><?=$Users['usuario']?></option>
                                <?php endforeach ?>
                              </select>
                          </div>
                      </div>

                      <div class="form-group form-group-lg">
                          <h2><label for="Usuario" class="control-label col-md-12"> Acciones:</label></h2>
                          <div class="col-md-6">
                              <textarea class="form-control" id = "acciones" name = "acciones" rows="3" placeholder="Acciones a Realizar"><?=$Noconformidad['acciones']?></textarea>
                          </div>
                      </div>

                      <div class="form-group form-group-lg">
                        <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha plan:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="fecha_plan" type="date" value = "<?=$Noconformidad['fecha_plan']?>" placeholder="Fecha del Plan" name="fecha_plan">
                        </div>
                      </div>

                      <div class="form-group form-group-lg">
                          <h2><label for="Usuario" class="control-label col-md-12">Evidencia de cierre: <?=$Noconformidad['evidenciapertura']?></label></h2>
                          <div class="col-md-6">
                              <input class="form-control input-lg" id="evidencia" type="file" value = "<?=$Noconformidad['evidencia']?>" placeholder="Evidencia del cierre" name="archivo2">
                          </div>
                      </div>

                      <div class="form-group form-group-lg">
                        <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha Cierre:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="fecha_cierre" type="date" value = "<?=$Noconformidad['fecha_cierre']?>" placeholder="Fecha para el cierre" name="fecha_cierre">
                        </div>
                      </div>

                      <div class="form-group form-group-lg">
                          <h2><label for="tipo" class="control-label col-md-12" >Status:</label></h2>
                          <div class="col-md-6">
                              <select class="form-control input-lg" name="estatus_id" id="estatus_id">
                                <?php foreach ($estatus as $estatuses): ?>
                                  @if($estatuses->id == $Noconformidad->estatus_id)
                                    <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                                  @endif
                                  <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                                <?php endforeach ?>
                              </select>
                          </div>
                      </div>

                      <div class="form-group form-group-lg">
                        <h2><label for="Monto" class="control-label col-md-12">Monto:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="monto" type="text" value = "<?=$Noconformidad['monto']?>" placeholder="Monto de la no conformidad" name="monto">
                        </div>
                      </div>
                    </div>


                        <div class="modal-footer">
                            <button type="submit" class="btnobjetivo" id="btnEditCli" style="font-family: Arial;">Editar Registro</button>
                    </form>
                            <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <?php endforeach?>

@stop
