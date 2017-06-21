@extends('layouts.principal2')

@section('content')
<br><br><br><br><br><br><br>
        <div class="container">
            <form action="/objetivos/edit/<?=$id?>" method="post" role="form" id="formularioobjetivo">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="creador_id" value="{{Auth::user()->id}}">
              <div class="form-group form-group-lg">
                <div class="form-group form-group-lg">
                    <h2>
                      <label for="User" class="control-label col-md-12" >
                        Tipo de Objetivo actual: <?=$tipoactual['nombre'] ?>
                      </label>
                    </h2>
                  </br>
                  <h2>
                    <label for="User" class="control-label col-md-12" >
                      Nuevo tipo objetivo:
                    </label>
                  </h2>
                    <div class="col-md-6">
                        <select class="form-control input-lg" name="tipo_objetivo_id" id="tipo_objetivo_id">
                          <option value="<?=$tipoactual['id']?>" selected="true"><?=$tipoactual['nombre']?></option>
                            <?php foreach ($tipoobjetivo as $tipoobjetiv): ?>
                                <option value="<?=$tipoobjetiv['id'] ?>"><?=$tipoobjetiv['nombre']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                  </div>
                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Objetivo:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="nombre" value="<?=$registro['nombre']?>" type="Text" placeholder="A que se quiere llegar" name="nombre">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2>
                            <label for="Usuario" class="control-label col-md-12">
                                Decripcion:
                            </label>
                        </h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "descripcion" rows="3" name="descripcion"><?=$registro['descripcion']?></textarea>
                        </div>
                    </div>



                    <div class="form-group form-group-lg">
                        <h2>
                          <label for="tipo" class="control-label col-md-12" >
                            Responsable actual:
                          </label>
                        </h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" disabled="true" id="aux" value="<?=$responsableactual['nombre'] ?>" type="text" placeholder="fecha" name="aux">
                        </div>
                      </br>
                      <h2>
                        <label for="tipo" class="control-label col-md-12" >
                          Nuevo responsable:
                        </label>
                      </h2>
                        <div class="col-md-6">
                            <select class="form-control input-lg" name="usuario_responsable_id" id="usuario_responsable_id">
                              <option value="<?=$responsableactual['id']?>" selected="true"><?=$responsableactual['nombre']?></option>
                                <?php foreach ($User as $us): ?>
                                    <option value="<?=$us['id'] ?>"><?=$us['nombre']?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                      </div>
                      <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;" >Guardar cambios</button>
                      <button type="button" class="btnobjetivo" onclick=location="/objetivos/visual" data-dismiss="modal" id="btnCloseUpload">Regresar</button>
                </div>
              </form>
              @if(Auth::user()->perfil <= 3)
              <form class="" action="/objetivos/destroy/<?=$registro['id']?>" method="post">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                <button type="submit" class="btnprocesoform" id="btndelete_<?=$registro['id']?>" style="font-family: Arial;" dataid="<?=$registro['id']?>" onclick="
return confirm('Estas seguro de eliminar el proceso <?=$registro['nombre']?>?')"><i class="glyphicon glyphicon-remove"></i> Eliminar</button>
              </form>
              @endif
              <div class="row">
                  <div class="col-lg-12">
                      <div class="panel panel-red" id="tablaobjetivo">
                          <div class="panel-heading">
                              Indicadores

                              <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i> </button>

                          </div>
                      <div class="panel-body">
                          <div class="dataTable_wrapper">
                              <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                                <thead style='background-color: #868889; color:#FFF'>
                                  <tr>
                                    <th><div class="th-inner sortable both">Objetivo ID</div></th>
                                    <th><div class="th-inner sortable both">Nombre</div></th>
                                    <th><div class="th-inner sortable both">Descripcion</div></th>
                                    <th><div class="th-inner sortable both">Responsable id</div></th>
                                    <th><div class="th-inner sortable both">frecuencia_id</div></th>
                                    <th><div class="th-inner sortable both">unidad</div></th>
                                    <th><div class="th-inner sortable both">logica</div></th>
                                    <th><div class="th-inner sortable both">meta</div></th>
                                    <th><div class="th-inner sortable both">Modificacion</div></th>
                                  </tr>
                                </thead>
                                <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                                <tbody>
                                  <?php foreach ($indicadorrelacion as $indicadorrel): ?>
                                  <td><?=$indicadorrel->indicadoresobjetivo?></td>
                                  <td><?=$indicadorrel->nombreindicador?></td>
                                  <td><?=$indicadorrel->descripcionindicador?></td>
                                  <td><?=$indicadorrel->userindicador?></td>
                                  <td><?=$indicadorrel->frecuenciaindicador?></td>
                                  <td><?=$indicadorrel->simboloindicador?></td>
                                  <td><?=$indicadorrel->logicaindicador?></td>
                                  <td><?=$indicadorrel->indicadormeta?></td>
                                  <td><form class="" action="/indicadores/destroy/{{ $indicadorrel->id }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}

                                      <button type="button" class="btnobjetivo" data-toggle="modal" data-target="#modaledit<?=$indicadorrel->id?>">Editar</button>
                                      <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" onclick="
        return confirm('Estas seguro de eliminar el indicador <?=$indicadorrel->nombreindicador?>?')">Eliminar</button>
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
        <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">ALTA DE INDICADOR</h2>
                    </div>
            <div class="modal-body">
            <div class="container">
              <form class="" action="/indicadores/store" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group form-group-lg">
                            <h2>
                            <label for="tipo" class="control-label col-md-12" >
                                Objetivo: <?=$registro['nombre']?>
                            </label>
                            </h2>
                            <div class="col-md-6">
                                <input class="form-control input-lg" readonly="readonly" id="objetivo_id" value = "<?=$registro['id']?>" type="Text" placeholder="A que se quiere llegar" name="objetivo_id">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2><label for="Usuario" class="control-label col-md-12">Indicador:</label></h2>
                            <div class="col-md-6">
                                <input class="form-control input-lg" id="nombre" type="Text" placeholder="Nombre indicador" name="nombre">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2>
                            <label for="Usuario" class="control-label col-md-12">
                            Decripcion:
                            </label>
                            </h2>
                            <div class="col-md-6">
                                <textarea class="form-control" id = "prodescripcionind" rows="3" placeholder="" name="descripcion" id="descripcion"></textarea>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2>
                            <label for="tipo" class="control-label col-md-12" >
                                Responsable:
                            </label>
                            </h2>
                            <div class="col-md-6">
                                <select class="form-control input-lg" name="usuario_responsable_id" id="usuario_responsable_id">
                                  <?php foreach ($User as $Users): ?>
                                    <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2>
                            <label for="tipo" class="control-label col-md-12" >
                                Frecuencia:
                            </label>
                            </h2>
                            <div class="col-md-6">
                                <select class="form-control input-lg" name="frecuencia_id" id="frecuencia_id">
                                  <?php foreach ($frecuencias as $frecuencia): ?>
                                    <option value="<?=$frecuencia['id']?>"><?=$frecuencia['nombre']?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                            <h2>
                            <label for="tipo" class="control-label col-md-12" >
                                Unidad:
                            </label>
                            </h2>
                            <div class="col-md-6">
                                <select class="form-control input-lg" name="unidad" id="unidad">
                                  <?php foreach ($unidades as $unidad): ?>
                                    <option value="<?=$unidad['id']?>"><?=$unidad['simbolo']?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2>
                            <label for="tipo" class="control-label col-md-12" >
                                Valor de indicador:
                            </label>
                            </h2>
                            <div class="col-md-6">
                                <select class="form-control input-lg" name="logica" id="logica">
                                  <?php foreach ($logica as $logicas): ?>
                                    <option value="<?=$logicas['id']?>"><?=$logicas['simbolo']?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2><label for="Usuario" class="control-label col-md-12">Meta:</label></h2>
                            <div class="col-md-6">
                                <input class="form-control input-lg" id="meta" type="Text" placeholder="meta" name="meta">
                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                          <h2><label for="Usuario" class="control-label col-md-12">Acceso:</label></h2>
                          <div class="col-md-12">

                                    <select class="form-control multi-select"  multiple="multiple" name="lista_de_acceso[]" id="lista_de_distribucion" width="100%" multiple data-actions-box="true" >
                                   <?php foreach ($User as $Users): ?>
                                     <option value="<?=$Users['id']?>"> <?=$Users['nombre']?> </option>
                                   <?php endforeach ?>
                                 </select>

                               </div>
                           </div>

                      </div>


                  <div class="modal-footer">
                              <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">Alta de indicador</button>
                        </form>
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
                </div>
              </div>
            </div>
        </div>


        <!-- modal para update -->

        <?php foreach ($indicadorrelacion as $indicadorrel): ?>
          <div class="modal fade" id="modaledit<?=$indicadorrel->id?>" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h2 class="modal-title">Modificar Indicador</h2>
                      </div>
              <div class="modal-body">
              <div class="container">
                <form class="" action="/indicadores/edit/<?=$indicadorrel->id?>" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="form-group form-group-lg">
                              <h2>
                              <label for="tipo" class="control-label col-md-12" >
                                  Objetivo: <?=$indicadorrel->indicadoresobjetivo?>
                              </label>
                              </h2>
                              <div class="col-md-6">
                                  <input class="form-control input-lg" readonly="readonly" id="objetivo_id" value = "<?=$indicadorrel->objetivo_id?>" type="hidden" placeholder="A que se quiere llegar" name="objetivo_id">
                              </div>
                          </div>
                          <div class="form-group form-group-lg">
                              <h2><label for="Usuario" class="control-label col-md-12">Indicador:</label></h2>
                              <div class="col-md-6">
                                  <input class="form-control input-lg" id="nombre" type="Text" placeholder="Nombre indicador" name="nombre", value="<?=$indicadorrel->nombreindicador?>">
                              </div>
                          </div>
                          <div class="form-group form-group-lg">
                              <h2>
                              <label for="Usuario" class="control-label col-md-12">
                              Decripcion:
                              </label>
                              </h2>
                              <div class="col-md-6">
                                  <textarea class="form-control" id = "prodescripcionind" rows="3" placeholder="" name="descripcion" id="descripcion"><?=$indicadorrel->descripcionindicador?></textarea>
                              </div>
                          </div>
                          <div class="form-group form-group-lg">
                              <h2>
                              <label for="tipo" class="control-label col-md-12" >
                                  Responsable:
                              </label>
                              </h2>
                              <div class="col-md-6">
                                  <select class="form-control input-lg" name="usuario_responsable_id" id="usuario_responsable_id">
                                    <?php foreach ($User as $Users): ?>
                                      @if($indicadorrel->user_id == $Users->id)
                                        <option value="<?=$Users['id']?>" selected><?=$Users['nombre']?></option>
                                      @else
                                        <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                                      @endif
                                    <?php endforeach ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group form-group-lg">
                              <h2>
                              <label for="tipo" class="control-label col-md-12" >
                                  Frecuencia:
                              </label>
                              </h2>
                              <div class="col-md-6">
                                  <select class="form-control input-lg" name="frecuencia_id" id="frecuencia_id"º>
                                    <option selected="true" value="<?=$indicadorrel->frecuencia_id?>"><?=$indicadorrel->frecuenciaindicador?></option>
                                    <?php foreach ($frecuencias as $frecuencia): ?>
                                      <option value="<?=$frecuencia['id']?>"><?=$frecuencia['nombre']?></option>
                                    <?php endforeach ?>
                                  </select>
                              </div>
                          </div>

                          <div class="form-group form-group-lg">
                              <h2>
                              <label for="tipo" class="control-label col-md-12" >
                                  Unidad:
                              </label>
                              </h2>
                              <div class="col-md-6">
                                  <select class="form-control input-lg" name="unidad" id="unidad">
                                    <option selected="true" value="<?=$indicadorrel->unidad_id?>"><?=$indicadorrel->simboloindicador?></option>
                                    <?php foreach ($unidades as $unidad): ?>
                                      <option value="<?=$unidad['id']?>"><?=$unidad['simbolo']?></option>
                                    <?php endforeach ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group form-group-lg">
                              <h2>
                              <label for="tipo" class="control-label col-md-12" >
                                  Valor de indicador:
                              </label>
                              </h2>
                              <div class="col-md-6">
                                  <select class="form-control input-lg" name="logica" id="logica">
                                    <option selected="true" value="<?=$indicadorrel->logicas_id?>"><?=$indicadorrel->logicaindicador?></option>
                                    <?php foreach ($logica as $logicas): ?>
                                      <option value="<?=$logicas['id']?>"><?=$logicas['simbolo']?></option>
                                    <?php endforeach ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group form-group-lg">
                              <h2><label for="Usuario" class="control-label col-md-12">Meta:</label></h2>
                              <div class="col-md-6">
                                  <input class="form-control input-lg" id="meta" type="Text" placeholder="meta" name="meta" value="<?=$indicadorrel->indicadormeta?>">
                              </div>
                          </div>

                        </div>
                        <input class="form-control input-lg" readonly="readonly" id="objetivo_id" value = "<?=$indicadorrel->acceso?>" type="hidden" name="lista_de_acceso">

                    <div class="modal-footer">
                                <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">Guardar cambios</button>
                          </form>
                                  <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                      </div>
                  </div>
                </div>
              </div>
          </div>

        <?php endforeach?>


        <!-- termina modal para update -- >




@Stop
