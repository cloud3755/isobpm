@extends('layouts.principal2')

@section('content')

<br><br><br><br><br>
<br><br>
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
              <div class="table-responsive">
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
                          <th>  <div class="th-inner sortable both">    Creador  </div></th>
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
                            @IF($noconformidad->evidencia != '')
                            <a href="/storage/noconformidad/<?=$noconformidad->evidencia_unic?>" downloadFile="<?=$noconformidad->evidencia_unic?>" style='color:#FFF'>
                              <button type="button" class="btn btn-default">
                                   <span class="glyphicon glyphicon-download-alt"></span>
                              </button>
                            </a>
                            @endif
                          </td>
                          <td>  <?=$noconformidad->evidenciapertura?>
                            @IF($noconformidad->evidenciapertura != '')
                            <a href="/storage/noconformidad/<?=$noconformidad->apertura_unic?>" downloadFile="<?=$noconformidad->apertura_unic?>" style='color:#FFF'>
                              <button type="button" class="btn btn-default">
                                   <span class="glyphicon glyphicon-download-alt"></span>
                              </button>
                            </a>
                            @endif
                          </td>
                          <td>  <?=$noconformidad->fecha_cierre?></td>
                          <td>  <?=$noconformidad->estatusnombre?></td>
                          <td>  <?=$noconformidad->creador?></td>
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
</div>
    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h2 class="modal-title">ALTA DE NO CONFORMIDADES</h2>
                </div>
                <div class="modal-body">
                    <form  action="/noconformidad/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                      <input type="hidden" name="id_area" value="{{ Auth::user()->id_area }}">
                      <input type="hidden" name="id_compania" value="{{Auth::user()->id_compania}}">
                    <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Fecha:</label></h3>
                          <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha" required="">
                    </div>

                      <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Proceso:</label></h3>
                          <select class="form-control input-lg" name="proceso_id" id="proceso_id">
                            <option value="50"></option>
                            <?php foreach ($Proceso as $Procesos): ?>
                              <option value="<?=$Procesos['id']?>"><?=$Procesos['proceso']?></option>
                            <?php endforeach ?>
                          </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Producto:</label></h3>
                          <select class="form-control input-lg" name="producto_id" id="producto_id">
                            <option value="21"></option>
                            <?php foreach ($Producto as $Productos): ?>
                              <option value="<?=$Productos['id']?>"><?=$Productos['nombre']?></option>
                            <?php endforeach ?>
                          </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Area:</label></h3>
                            <select class="form-control input-lg" name="id_area" id="id_area">
                              <option value="2"></option>
                              <?php foreach ($area as $areas): ?>
                                <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <h3><label>Evidencia no conformidad:</label></h3>
                            <input class="form-control input-lg" id="documento" type="file" placeholder="evidenciapertura" name="archivo1">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label>Documento:</label></h3>
                            <input class="form-control input-lg" id="documento" type="text" placeholder="Documento" name="documento">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label> Decripcion:</label></h3>
                            <textarea class="form-control" id = "descripcion" rows="3" name="descripcion" placeholder="Descripcion No conformidad" required=""></textarea>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label> Acciones:</label></h3>
                            <textarea class="form-control" id = "acciones" name = "acciones" rows="3" placeholder="Acciones a Realizar"></textarea>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Responsable:</label></h3>
                            <select class="form-control input-lg" name="usuario_responsable_id" id="usuario_responsable_id" required="">
                              <option value=""></option>
                              <?php foreach ($User as $Users): ?>
                                <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Fecha plan:</label></h3>
                          <input class="form-control input-lg" id="fecha_plan" type="date" placeholder="Fecha del Plan" name="fecha_plan">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Evidencia de cierre:</label></h3>
                            <input class="form-control input-lg" id="evidencia" type="file" placeholder="Evidencia del cierre" name="archivo2">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Fecha Cierre:</label></h3>
                          <input class="form-control input-lg" id="fecha_cierre" type="date" placeholder="Fecha para el cierre" name="fecha_cierre">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Status:</label></h3>
                            <select class="form-control input-lg" name="estatus_id" id="estatus_id">
                              <?php foreach ($estatus as $estatuses): ?>
                                <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Monto:</label></h3>
                          <input class="form-control input-lg" id="monto" type="text" placeholder="Monto de la no conformidad" name="monto" required="">
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h2 class="modal-title">EDITAR NO CONFORMIDAD</h2>
                </div>
                <div class="modal-body">
                  <form  action="/noconformidad/edit/<?=$Noconformidad['id']?>" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                      <input type="hidden" name="id_compania" value="{{Auth::user()->id_compania}}">

                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Fecha:</label></h3>
                            <input class="form-control input-lg" type="date" placeholder="Fecha"  value = "<?=$Noconformidad['fecha']?>" name="fecha">
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Proceso:</label></h3>
                            <select class="form-control input-lg" name="proceso_id" id="proceso_id">
                              <?php foreach ($Proceso as $Procesos): ?>
                                @if($Procesos->id == $Noconformidad->proceso_id)
                                  <option value="<?=$Procesos['id']?>" selected><?=$Procesos['proceso']?></option>
                                @else
                                  <option value="<?=$Procesos['id']?>"><?=$Procesos['proceso']?></option>
                                @endif
                              <?php endforeach ?>
                            </select>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4">
                          <h3><label>Producto:</label></h3>
                            <select class="form-control input-lg" name="producto_id" id="producto_id">
                              <?php foreach ($Producto as $Productos): ?>
                                @if($Productos->id == $Noconformidad->producto_id)
                                    <option value="<?=$Productos['id']?>" selected><?=$Productos['nombre']?></option>
                                @else
                                    <option value="<?=$Productos['id']?>"><?=$Productos['nombre']?></option>
                                @endif
                              <?php endforeach ?>
                            </select>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4">
                          <h3><label>Area:</label></h3>
                              <select class="form-control input-lg" name="id_area" id="id_area">
                                <?php foreach ($area as $areas): ?>
                                  @if($areas->id == $Noconformidad->id_area)
                                    <option value="<?=$areas['id']?>"selected><?=$areas['nombre']?></option>
                                  @else
                                    <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                                  @endif
                                <?php endforeach ?>
                              </select>
                      </div>

                      <div class="col-lg-8 col-md-8 col-sm-8">
                          <h3><label>Evidencia no conformidad:</label></h3>
                              <input class="form-control input-lg" id="documento" type="file" value = "" name="archivo1">
                      </div>

                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h3><label>Documento:</label></h3>
                              <input class="form-control input-lg" id="documento" type="text" value="<?=$Noconformidad['documento']?>" name="documento">
                      </div>

                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h3><label> Decripcion:</label></h3>
                              <textarea class="form-control" id = "descripcion" rows="3" name="descripcion" placeholder="Descripcion No conformidad"><?=$Noconformidad['descripcion']?></textarea>
                      </div>

                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label> Acciones:</label></h3>
                        <textarea class="form-control" id = "acciones" name = "acciones" rows="3" placeholder="Acciones a Realizar"><?=$Noconformidad['acciones']?></textarea>
                      </div>

                      <div class="col-lg-6 col-md-6 col-sm-6">
                          <h3><label>Responsable:</label></h3>
                              <select class="form-control input-lg" name="usuario_responsable_id" id="usuario_responsable_id">
                                <?php foreach ($User as $Users): ?>
                                  @if($Users->id == $Noconformidad->usuario_responsable_id)
                                    <option value="<?=$Users['id']?>" selected><?=$Users['nombre']?></option>
                                  @else
                                    <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                                  @endif
                                <?php endforeach ?>
                              </select>
                      </div>


                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <h3><label>Fecha plan:</label></h3>
                            <input class="form-control input-lg" id="fecha_plan" type="date" value = "<?=$Noconformidad['fecha_plan']?>" placeholder="Fecha del Plan" name="fecha_plan">
                      </div>

                      <div class="col-lg-8 col-md-8 col-sm-8">
                          <h3><label>Evidencia de cierre: <?=$Noconformidad['evidenciapertura']?></label></h3>
                              <input class="form-control input-lg" id="evidencia" type="file" value = "<?=$Noconformidad['evidencia']?>" placeholder="Evidencia del cierre" name="archivo2">
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Fecha Cierre:</label></h3>
                            <input class="form-control input-lg" id="fecha_cierre" type="date" value = "<?=$Noconformidad['fecha_cierre']?>" placeholder="Fecha para el cierre" name="fecha_cierre">
                      </div>
                      @if($Noconformidad->creador_id == Auth::user()->id or Auth::user()->perfil <= 3)
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <h2><label>Status:</label></h2>
                        <select class="form-control input-lg" name="estatus_id" id="estatus_id">
                          <?php foreach ($estatus as $estatuses): ?>
                            @if($estatuses->id == $Noconformidad->estatus_id)
                            <option value="<?=$estatuses['id']?>" selected><?=$estatuses['nombre']?></option>
                            @else
                            <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                            @endif
                          <?php endforeach ?>
                        </select>
                      </div>
                      @else
                        <input type="hidden" name="estatus_id" id="estatus_id" value="<?=$Noconformidad->estatus_id?>">
                      @endif

                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <h2><label>Monto:</label></h2>
                            <input class="form-control input-lg" id="monto" type="text" value = "<?=$Noconformidad['monto']?>" placeholder="Monto de la no conformidad" name="monto">
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
