@extends('layouts.principal2')

@section('content')



<br><br><br><br><br>
<!-- Registro -->

<!-- inicia formulario a cambiar -->
<div class="container">
  <form method="POST" action="/procesos/store" accept-charset="UTF-8" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <div class="container">
               <div class="form-group form-group-lg">
                 <h2><label for="tipo" class="control-label col-md-12" >Tipo de Proceso:</label></h2>
                   <div class="col-md-6">
                          <input class="form-control input-lg"  disabled="true" id="protipoproc" value="<?=$proceso['tipo']?>" type="Text" placeholder="Nombre del proceso" name="tipo" maxlength="50">
                     </div>
                 </div>

                 <div class="form-group form-group-lg">
                     <h2><label for="Usuario" class="control-label col-md-12">Proceso:</label></h2>
                     <div class="col-md-6">
                         <input class="form-control input-lg"  disabled="true" id="probproces" value="<?=$proceso['proceso']?>" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                     </div>
                 </div>

                 <div class="form-group form-group-lg">
                     <h2>
                     <label for="Usuario" class="control-label col-md-12">
                     Decripcion:
                     </label>
                     </h2>
                     <div class="col-md-6">
                         <textarea class="form-control input-lg"  disabled="true" id = "prodescripcionproces" rows="3" placeholder="Descripcion del proceso" name="descripcion" maxlength="255"><?=$proceso['descripcion']?></textarea>
                     </div>
                 </div>


                 <div class="form-group form-group-lg">
                     <h2><label for="tipo" class="control-label col-md-12" >Responsable</label></h2>
                     <div class="col-md-6">
                       <input class="form-control input-lg"  disabled="true" id="probproces" value="<?=$procesosrelacion->nombre?>" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                     </div>
                 </div>
<!-- termina formulario a cambiar -->

               </div>
              <br><br>
                 <button type="button" class="btnobjetivo" onclick=location="/procesos/visual" data-dismiss="modal" id="btnCloseUpload">Regresar</button>
            </div>
  </form>


</div>
<br><br>


<!-- Tabla -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                Riesgos
                <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i></button>
            </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                  <form>
                      Buscar <input id="searchTerm" type="text" onkeyup="doSearch()" />
                  </form>
                  <br>
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
                        <thead style='background-color: #868889; color:#FFF'>
                            <tr>
                                <th><div class="th-inner sortable both">Actividad</div></th>
                                <th><div class="th-inner sortable both">Riesgo</div></th>
                                <th><div class="th-inner sortable both">Modo de Falla</div></th>
                                <th><div class="th-inner sortable both">Severidad inherente</div></th>
                                <th><div class="th-inner sortable both">Probabilidad inherente</div></th>
                                <th><div class="th-inner sortable both">Controles</div></th>
                                <th><div class="th-inner sortable both">Severidad Residual</div></th>
                                <th><div class="th-inner sortable both">probabilidad Residual</div></th>
                                <th>
                                  <div class="th-inner sortable both">
                                      Modificar
                                  </div>
                                </th>
                            </tr>
                        </thead>
                        <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                        <tbody>
                            <?php foreach ($analisisriesgo2 as $Analisisriesgos2): ?>
                                <tr>
                                    <td><?=$Analisisriesgos2->actividad?></td>
                                    <td><?=$Analisisriesgos2->riesgo_nombre?></td>
                                    <td><?=$Analisisriesgos2->descripcion_modo_falla?></td>
                                    <td><?=$Analisisriesgos2->Severidad?></td>
                                    <td><?=$Analisisriesgos2->probabilidad?></td>
                                    <td><?=$Analisisriesgos2->controles?></td>
                                    <td><?=$Analisisriesgos2->Severidad2?></td>
                                    <td><?=$Analisisriesgos2->probabilidad2?></td>
                                    <td>

                                    <form class="" action="/analisisrisk/destroy/{{ $Analisisriesgos2->id }}" method="post">
                                                  {{ csrf_field() }}
                                                  {{ method_field('DELETE') }}
                                      <button type="button" class="btnobjetivo" data-toggle="modal" data-target="#modaledit<?=$Analisisriesgos2->id?>"><i class="glyphicon glyphicon-pencil"></i> Editar  </button>
                                      <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;" onclick="
return confirm('seguro de eliminar el indicador {{$Analisisriesgos2->actividad}}?')">Eliminar</button>
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

<!-- Modal -->
<form action="/analisisrisk/store" method="post" role="form">
<input type="hidden" name="procesos_id" value="<?=$proceso['id']?>">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="modal fade in" id="modalUpload" tabindex="-1" role="dialog" style="">
    <div class="modal-dialog" role="form">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Alta de Analisis de riesgo</h2>
            </div>
            <div class="modal-body">
                <div class="container">
                      <div class="form-group form-group-lg">
                        <div class="form-group form-group-lg">
                            <h2><label for="tipo" class="control-label col-md-12" >Proceso:</label>
                            </h2>
                            <div class="col-md-6">
                                  <input class="form-control input-lg"  disabled="true" id="probproces" value="<?=$proceso['proceso']?>" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-lg"><h2><label for="tipo" class="control-label col-md-12" >Actividad:</label></h2>
                            <div class="col-md-6">
                              <input class="form-control input-lg" id="actividad" type="Text" placeholder="Que actividad se realiza" name="actividad">
                            </div>
                          </div>
                          <div class="form-group form-group-lg">
                              <h2>
                                  <label for="tipo" class="control-label col-md-12" >
                                      Riesgo:
                                  </label>
                              </h2>
                              <div class="col-md-6">
                                  <select class="form-control input-lg" name="riesgo_id" id="riesgo_id">
                                      <?php foreach ($Abcriesgo as $Abcriesgos): ?>
                                          <option value="<?=$Abcriesgos['id']?>"><?=$Abcriesgos['nombre']?></option>
                                      <?php endforeach ?>
                                  </select>
                              </div>
                          </div>
                            <div class="form-group form-group-lg">
                                <h2><label for="Usuario" class="control-label col-md-12">Modo de falla:</label></h2>
                                <div class="col-md-6">
                                  <input class="form-control input-lg" id="descripcion_modo_falla" type="Text" placeholder="Descripcion de la falla" name="descripcion_modo_falla">
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                              <h2><label for="fecha del periodo" class="control-label col-md-12">Severidad inherente:</label></h2>
                              <div class="col-md-6">
                                <select class="form-control input-lg" name="Severidad" id="Severidad">
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group form-group-lg">
                                <h2><label for="fecha del periodo" class="control-label col-md-12">Probabilidad inherente:</label></h2>
                                <div class="col-md-6">
                                  <select class="form-control input-lg" name="probabilidad" id="probabilidad">
                                          <option value="1">1</option>
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                                <h2><label for="fecha del periodo" class="control-label col-md-12">Controles:</label></h2>
                                <div class="col-md-6">
                                    <input class="form-control input-lg" id="controles" type="Text" placeholder="Controles" name="controles">
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                                <h2><label for="fecha del periodo" class="control-label col-md-12">Severidad residual:</label></h2>
                                <div class="col-md-6">
                                  <select class="form-control input-lg" name="Severidad2" id="Severidad2">
                                          <option value="1">1</option>
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                                <h2><label for="fecha del periodo" class="control-label col-md-12">Probabilidad residual:</label></h2>
                                <div class="col-md-6">
                                  <select class="form-control input-lg" name="probabilidad2" id="probabilidad2">
                                          <option value="1">1</option>
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                                <h2><label for="fecha del periodo" class="control-label col-md-12">Area:</label></h2>
                                <div class="col-md-6">
                                  <select class="form-control input-lg" name="id_area" id="id_area" required>
                                    <?php foreach ($area as $areas): ?>
                                        <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                                    <?php endforeach ?>
                                  </select>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnanalisis" style="font-family: Arial;">Alta de Analisis Riesgo</button>
                    <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<!-- Modal para editar -->
<?php foreach ($analisisriesgo2 as $Analisisriesgos2): ?>
<div class="modal fade" id="modaledit<?=$Analisisriesgos2->id?>" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">EDITAR ANALISIS DE RIESGO</h2>
            </div>
            <form  action="/analisisrisk/edit/<?=$Analisisriesgos2->id?>" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token()}}">
              <input type="hidden" name="procesos_id" value="<?=$proceso['id']?>">
              <div class="modal-body">
                <div class="container">
                  <div class="form-group form-group-lg">
                      <h2><label for="tipo" class="control-label col-md-12" >Proceso:</label></h2>
                      <div class="col-md-6">
                            <input class="form-control input-lg"  disabled="true" id="probproces" value="<?=$proceso['proceso']?>" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                          </select>
                      </div>
                  </div>
                  <div class="form-group form-group-lg"><h2><label for="tipo" class="control-label col-md-12" >Actividad:</label></h2>
                      <div class="col-md-6">
                        <input class="form-control input-lg" id="actividad" type="Text" placeholder="Que actividad se realiza" name="actividad" value="<?=$Analisisriesgos2->actividad?>">
                      </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <h2>
                            <label for="tipo" class="control-label col-md-12" >
                                Riesgo:
                            </label>
                        </h2>
                        <div class="col-md-6">
                            <select class="form-control input-lg" name="riesgo_id" id="riesgo_id">
                                <?php foreach ($Abcriesgo as $Abcriesgos): ?>
                                   @if($Analisisriesgos2->riesgo_id == $Abcriesgos['id'] )
                                    <option selected value="<?=$Abcriesgos['id']?>"><?=$Abcriesgos['nombre']?></option>
                                    @else
                                    <option value="<?=$Abcriesgos['id']?>"><?=$Abcriesgos['nombre']?></option>
                                    @endif
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                      <div class="form-group form-group-lg">
                          <h2><label for="Usuario" class="control-label col-md-12">Modo falla:</label></h2>
                          <div class="col-md-6">
                            <input class="form-control input-lg" id="descripcion_modo_falla" type="Text" placeholder="Descripcion de la falla" name="descripcion_modo_falla" value="<?=$Analisisriesgos2->descripcion_modo_falla?>">
                          </div>
                      </div>
                      <div class="form-group form-group-lg">
                        <h2><label for="fecha del periodo" class="control-label col-md-12">Severidad inherente:</label></h2>
                        <div class="col-md-6">
                          <select class="form-control input-lg" name="Severidad" id="Severidad">
                            @if($Analisisriesgos2->Severidad == 1 )
                              <option value="1" selected>1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              @else
                                @if($Analisisriesgos2->Severidad == 2 )
                                  <option value="1">1</option>
                                  <option value="2" selected>2</option>
                                  <option value="3">3</option>
                                @else
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3" selected>3</option>
                                @endif
                             @endif
                          </select>
                        </div>
                      </div>
                      <div class="form-group form-group-lg">
                          <h2><label for="fecha del periodo" class="control-label col-md-12">Probabilidad inherente:</label></h2>
                          <div class="col-md-6">
                            <select class="form-control input-lg" name="probabilidad" id="probabilidad">
                              @if($Analisisriesgos2->probabilidad == 1 )
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                @else
                                  @if($Analisisriesgos2->probabilidad == 2 )
                                    <option value="1">1</option>
                                    <option value="2" selected>2</option>
                                    <option value="3">3</option>
                                  @else
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3" selected>3</option>
                                  @endif
                               @endif
                            </select>
                          </div>
                      </div>
                      <div class="form-group form-group-lg">
                          <h2><label for="fecha del periodo" class="control-label col-md-12">Controles:</label></h2>
                          <div class="col-md-6">
                              <input class="form-control input-lg" id="controles" type="Text" placeholder="Controles" name="controles" value="<?=$Analisisriesgos2->controles?>">
                          </div>
                      </div>
                      <div class="form-group form-group-lg">
                          <h2><label for="fecha del periodo" class="control-label col-md-12">Severidad residual:</label></h2>
                          <div class="col-md-6">
                            <select class="form-control input-lg" name="Severidad2" id="Severidad2">
                              @if($Analisisriesgos2->Severidad2 == 1 )
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                @else
                                  @if($Analisisriesgos2->Severidad2 == 2 )
                                    <option value="1">1</option>
                                    <option value="2" selected>2</option>
                                    <option value="3">3</option>
                                  @else
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3" selected>3</option>
                                  @endif
                               @endif
                            </select>
                          </div>
                      </div>
                      <div class="form-group form-group-lg">
                          <h2><label for="fecha del periodo" class="control-label col-md-12">Probabilidad residual:</label></h2>
                          <div class="col-md-6">
                            <select class="form-control input-lg" name="probabilidad2" id="probabilidad2">
                              @if($Analisisriesgos2->probabilidad2 == 1 )
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                @else
                                  @if($Analisisriesgos2->probabilidad2 == 2 )
                                    <option value="1">1</option>
                                    <option value="2" selected>2</option>
                                    <option value="3">3</option>
                                  @else
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3" selected>3</option>
                                  @endif
                               @endif
                            </select>
                          </div>
                      </div>
                      <div class="form-group form-group-lg">
                          <h2><label for="fecha del periodo" class="control-label col-md-12">Area:</label></h2>
                          <div class="col-md-6">
                            <select class="form-control input-lg" name="id_area" id="id_area">
                              <?php foreach ($area as $areas): ?>
                                @if($Analisisriesgos2->id_area == $areas['id'])
                                  <option selected value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                                 @else
                                  <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                                 @endif
                              <?php endforeach ?>
                            </select>
                          </div>
                      </div>

                </div>


                    <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnEditCli" style="font-family: Arial;">Editar Registro</button>
                        <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
                </div>
              </form>
            </div>
        </div>
</div>

<?php endforeach?>


@Stop
