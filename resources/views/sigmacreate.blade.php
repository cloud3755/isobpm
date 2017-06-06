@extends('layouts.principal2')

@section('content')

<br>

      <div class="row" id="descripcion">
          <div class="col-md-12" id="titulo"><center>Proyecto <?=$mejorarelacion->tipo?></center></div>
      </div>
    <form class="" action="/modificar/lean/<?=$mejorarelacion->id?>" method="post">
          <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
      <div class="row" id="primero">
        <div class="col-md-3" id="fecha">Proyecto</div>
        <div class="col-md-9" id="datofecha">
          <input class="form-control" type="text" name="proyecto" value="<?=$mejorarelacion->proyecto?>">
        </div>
      </div>

      <div class="row" id="primero">
				<div class="col-md-3" id="creador">Impacto</div>
				<div class="col-md-3">

					<select class="form-control input-lg" name="impacto" id="proresponsableob">
            <option value="<?=$mejorarelacion->impacto?>">Actual <?=$mejorarelacion->nombreimpacto?></option>
					 <?php foreach ($impacto as $impactos): ?>
						 <option value="<?=$impactos['id']?>"> <?=$impactos['nombre']?> </option>
					 <?php endforeach ?>
				 </select>

			  </div>
			  <div class="col-md-3" id="fecha">Responsable</div>
				<div class="col-md-3" id="datofecha">

					<select class="form-control input-lg" name="responsable_id" id="proresponsableob">
            <option value="<?=$mejorarelacion->responsable_id?>">Actual <?=$mejorarelacion->usernombre?></option>
					 <?php foreach ($User as $Users): ?>
						 <option value="<?=$Users['id']?>"> <?=$Users['nombre']?> </option>
					 <?php endforeach ?>
				 </select>

			  </div>
			</div>

      <div class="row" id="segundo">
        <div class="col-md-2" id="creador">Beneficio real</div>
        <div class="col-md-3">
          <textarea class="form-control" name="beneficioreal" rows="1" cols="40" placeholder="Beneficio real"><?=$mejorarelacion->beneficioreal?></textarea>
        </div>
        <div class="col-md-3" id="creador">Beneficio plan</div>
          <div class="col-md-3">
            <textarea class="form-control" name="beneficioplan" rows="1" cols="40" placeholder="Beneficio plan"><?=$mejorarelacion->beneficioplan?></textarea>
          </div>
      </div>

      <div class="row" id="segundo">
        <div class="col-md-3" id="fecha">Fecha</div>
        <div class="col-md-3">
          <input class="form-control" name="fechaactual" type="text" readonly value="<?=$mejorarelacion->fechaactual?>" size="10"/>
        </div>
        <div class="col-md-3" id="fecha">Estatus</div>
        <div class="col-md-3" id="datofecha">

          <select class="form-control input-lg" name="estatus_id">
            <?php foreach ($estatu as $estatus): ?>
              <option value="<?=$estatus['id']?>"> <?=$estatus['nombre']?> </option>
            <?php endforeach ?>
          </select>

        </div>
      </div>

      <div class="row"  id="descripcion">

        <div class="col-md-12" id="creador"><center>Descripcion</center></div>
      </div>
      <br>
      <div class="row">
          <div class="col-sm-3 col-md-11 ">
              <textarea class="form-control" rows="9" name="descripcion"><?=$mejorarelacion->descripcion?></textarea>
          </div>
      </div>

      <div class="form-group form-group-lg">
        <h2><label for="Usuario" class="control-label col-md-12">Agregar a equipo:</label></h2>
        <div class="col-md-12">

              <select class="form-control multi-select"  multiple="multiple" name="lista_de_accesos[]" id="lista_de_accesos" width="100%" multiple data-actions-box="true">

                <?php foreach ($User as $users): ?>
                      <option value="<?=$users->id?>"> <?=$users->nombre ?> </option>
                <?php endforeach ?>

               </select>
        <h2><label for="Usuario" class="control-label col-md-12">Lista actual:</label></h2>
               <select class="form-control multi-select"  multiple="multiple" name="lista_de_accesos2[]" id="lista_de_accesos" width="100%" multiple data-actions-box="true" >

                 <?php foreach ($listadeequipo as $lista): ?>
                       <option value="<?=$lista->id?>" selected="true"> <?=$lista->nombre ?> </option>
                 <?php endforeach ?>

                </select>
        </div>
      </div>
      <br>
      <center><button type="submit" class="btn btn-info">Modificar</button></venter>
        <br>
  </form>

      <br>
      <div class="row">
          <div class="col-lg-12">
              <div class="panel panel-red">
                  <div class="panel-heading">
										DEFINIR
                      <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modaldr"><i class="glyphicon glyphicon-upload"></i></button>
                  </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <div class="dataTable_wrapper">
                      <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                        <thead style='background-color: #868889; color:#FFF'>
                          <tr>
                            <th><div class="th-inner sortable both">  ID</div></th>
                            <th><div class="th-inner sortable both">  ETAPA</div></th>
                            <th><div class="th-inner sortable both">  DESCRIPCION</div></th>
                            <th><div class="th-inner sortable both">  ARCHIVO</div></th>
                            <th><div class="th-inner sortable both">  FECHA</div></th>
                            <th><div class="th-inner sortable both">  Eliminar</div></th>
                          </tr>
                        </thead>
                        <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                        <tbody>
                        <?php foreach ($relaciontabla as $etapa): ?>
                          @if($etapa->idetapa == 5)
                          <tr>
                            <td> <?=$etapa->id?> </td>
                            <td> DEFINIR </td>
                            <td> <?=$etapa->descripcion?> </td>
                            <td> <?=$etapa->archivo?>
                              @if($etapa->uniquearchivo != null)
                                  <a href="/storage/mejoras/<?=$etapa->uniquearchivo?>" downloadFile="<?=$etapa->uniquearchivo?>" target="_blank" style='color:#FFF'>
                                    <button type="button" class="btn btn-default">
                                      <span class="glyphicon glyphicon-download-alt"></span>
                                    </button>
                              @endif
                            </td>
                            <td> <?=$etapa->fecha?> </td>
                            <td>
                              <form class="" action="/etapa/eliminaretapa/<?=$etapa->id?>" method="post">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}
                                <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" onclick="
  return confirm('Estas seguro de eliminar la queja numero: <?=$etapa->id?>?')">Eliminar</button>
                              </form>
                            </td>
                          </tr>
                          @endif
                        <?php endforeach ?>
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
  </div>

  <br>
  <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-red">
              <div class="panel-heading">
								MEDIR
                  <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i></button>
              </div>
          <div class="panel-body">
            <div class="table-responsive">
              <div class="dataTable_wrapper">
                  <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                    <thead style='background-color: #868889; color:#FFF'>
                      <tr>
                        <th><div class="th-inner sortable both">  ID</div></th>
                        <th><div class="th-inner sortable both">  ETAPA</div></th>
                        <th><div class="th-inner sortable both">  DESCRIPCION</div></th>
                        <th><div class="th-inner sortable both">  ARCHIVO</div></th>
                        <th><div class="th-inner sortable both">  FECHA</div></th>
                        <th><div class="th-inner sortable both">  Eliminar</div></th>
                      </tr>
                    </thead>
                    <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                    <tbody>
                      <?php foreach ($relaciontabla as $etapa): ?>
                        @if($etapa->idetapa == 6)
                        <tr>
                          <td> <?=$etapa->id?> </td>
                          <td> MEDIR </td>
                          <td> <?=$etapa->descripcion?> </td>
                          <td> <?=$etapa->archivo?>
                            @if($etapa->uniquearchivo != null)
                                <a href="/storage/mejoras/<?=$etapa->uniquearchivo?>" downloadFile="<?=$etapa->uniquearchivo?>" target="_blank" style='color:#FFF'>
                                  <button type="button" class="btn btn-default">
                                    <span class="glyphicon glyphicon-download-alt"></span>
                                  </button>
                            @endif
                          </td>
                          <td> <?=$etapa->fecha?> </td>
                          <td>
                            <form class="" action="/etapa/eliminaretapa/<?=$etapa->id?>" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                              <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" onclick="
return confirm('Estas seguro de eliminar la queja numero: <?=$etapa->id?>?')">Eliminar</button>
                            </form>
                          </td>
                        </tr>
                        @endif
                      <?php endforeach ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <br>
  <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-red">
              <div class="panel-heading">
								ANALIZAR
                  <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalek"><i class="glyphicon glyphicon-upload"></i></button>
              </div>
          <div class="panel-body">
            <div class="table-responsive">
              <div class="dataTable_wrapper">
                  <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                    <thead style='background-color: #868889; color:#FFF'>
                      <tr>
                        <th><div class="th-inner sortable both">  ID</div></th>
                        <th><div class="th-inner sortable both">  ETAPA</div></th>
                        <th><div class="th-inner sortable both">  DESCRIPCION</div></th>
                        <th><div class="th-inner sortable both">  ARCHIVO</div></th>
                        <th><div class="th-inner sortable both">  FECHA</div></th>
                        <th><div class="th-inner sortable both">  Eliminar</div></th>
                      </tr>
                    </thead>
                    <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                    <tbody>
                      <?php foreach ($relaciontabla as $etapa): ?>
                        @if($etapa->idetapa == 7)
                        <tr>
                          <td> <?=$etapa->id?> </td>
                          <td> ANALIZAR </td>
                          <td> <?=$etapa->descripcion?> </td>
                          <td> <?=$etapa->archivo?>
                            @if($etapa->uniquearchivo != null)
                                <a href="/storage/mejoras/<?=$etapa->uniquearchivo?>" downloadFile="<?=$etapa->uniquearchivo?>" target="_blank" style='color:#FFF'>
                                  <button type="button" class="btn btn-default">
                                    <span class="glyphicon glyphicon-download-alt"></span>
                                  </button>
                            @endif
                          </td>
                          <td> <?=$etapa->fecha?> </td>
                          <td>
                          <form class="" action="/etapa/eliminaretapa/<?=$etapa->id?>" method="post">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}
                            <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" onclick="
return confirm('Estas seguro de eliminar la queja numero: <?=$etapa->id?>?')">Eliminar</button>
                          </form>
                        </td>
                        </tr>
                        @endif
                      <?php endforeach ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <br>
  <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-red">
              <div class="panel-heading">
								MEJORAR
                  <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalcm"><i class="glyphicon glyphicon-upload"></i></button>
              </div>
          <div class="panel-body">
            <div class="table-responsive">
              <div class="dataTable_wrapper">
                  <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                    <thead style='background-color: #868889; color:#FFF'>
                      <tr>
                        <th><div class="th-inner sortable both">  ID</div></th>
                        <th><div class="th-inner sortable both">  ETAPA</div></th>
                        <th><div class="th-inner sortable both">  DESCRIPCION</div></th>
                        <th><div class="th-inner sortable both">  ARCHIVO</div></th>
                        <th><div class="th-inner sortable both">  FECHA</div></th>
                        <th><div class="th-inner sortable both">  Eliminar</div></th>
                      </tr>
                    </thead>
                    <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                    <tbody>
                      <?php foreach ($relaciontabla as $etapa): ?>
                        @if($etapa->idetapa == 8)
                        <tr>
                          <td> <?=$etapa->id?> </td>
                          <td> MEJORAR </td>
                          <td> <?=$etapa->descripcion?> </td>
                          <td> <?=$etapa->archivo?>
                            @if($etapa->uniquearchivo != null)
                                <a href="/storage/mejoras/<?=$etapa->uniquearchivo?>" downloadFile="<?=$etapa->uniquearchivo?>" target="_blank" style='color:#FFF'>
                                  <button type="button" class="btn btn-default">
                                    <span class="glyphicon glyphicon-download-alt"></span>
                                  </button>
                            @endif
                          </td>
                          <td> <?=$etapa->fecha?> </td>
                          <td>
                          <form class="" action="/etapa/eliminaretapa/<?=$etapa->id?>" method="post">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}
                            <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" onclick="
return confirm('Estas seguro de eliminar la queja numero: <?=$etapa->id?>?')">Eliminar</button>
                          </form>
                        </td>
                        </tr>
                        @endif
                      <?php endforeach ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

	<br>
  <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-red">
              <div class="panel-heading">
								CONTROLAR
                  <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalc"><i class="glyphicon glyphicon-upload"></i></button>
              </div>
          <div class="panel-body">
            <div class="table-responsive">
              <div class="dataTable_wrapper">
                  <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                    <thead style='background-color: #868889; color:#FFF'>
                      <tr>
                        <th><div class="th-inner sortable both">  ID</div></th>
                        <th><div class="th-inner sortable both">  ETAPA</div></th>
                        <th><div class="th-inner sortable both">  DESCRIPCION</div></th>
                        <th><div class="th-inner sortable both">  ARCHIVO</div></th>
                        <th><div class="th-inner sortable both">  FECHA</div></th>
                        <th><div class="th-inner sortable both">  Eliminar</div></th>
                      </tr>
                    </thead>
                    <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                    <tbody>
                      <?php foreach ($relaciontabla as $etapa): ?>
                        @if($etapa->idetapa == 9)
                        <tr>
                          <td> <?=$etapa->id?> </td>
                          <td> CONTROLAR </td>
                          <td> <?=$etapa->descripcion?> </td>
                          <td> <?=$etapa->archivo?>
                            @if($etapa->uniquearchivo != null)
                                <a href="/storage/mejoras/<?=$etapa->uniquearchivo?>" downloadFile="<?=$etapa->uniquearchivo?>" target="_blank" style='color:#FFF'>
                                  <button type="button" class="btn btn-default">
                                    <span class="glyphicon glyphicon-download-alt"></span>
                                  </button>
                            @endif
                          </td>
                          <td> <?=$etapa->fecha?> </td>
                          <td>
                            <form class="" action="/etapa/eliminaretapa/<?=$etapa->id?>" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                              <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" onclick="
return confirm('Estas seguro de eliminar la queja numero: <?=$etapa->id?>?')">Eliminar</button>
                            </form>
                          </td>
                        </tr>
                        @endif
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

  <div class="modal fade" id="modaldr" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h2 class="modal-title">DEFINIR</h2>
              </div>
              <div class="modal-body">
                <div class="container">
                  <form  action="/lean/guardar" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token()}}">
                    <input type="hidden" name="idmejora" value="<?=$mejorarelacion->id?>">
                    <input type="hidden" name="etapa" value="5">

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Archivo de proyecto:</label></h2>
                        <div class="col-md-6">
                            <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo" required="">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="Usuario" class="control-label col-md-12">
                        Descripcion:
                        </label>
                        </h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Acciones tomadas" name="descripcion" required=""></textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg"  type="date" placeholder="Fecha" name="fecha" required="">
                      </div>
                    </div>

                </div>
                      <div class="modal-footer">
                          <button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Alta de Etapa</button>
                  </form>
                          <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
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
                  <h2 class="modal-title">MEDIR</h2>
              </div>
              <div class="modal-body">
                <div class="container">
                  <form  action="/lean/guardar" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token()}}">
                    <input type="hidden" name="idmejora" value="<?=$mejorarelacion->id?>">
                    <input type="hidden" name="etapa" value="6">

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Archivo de proyecto:</label></h2>
                        <div class="col-md-6">
                            <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="Usuario" class="control-label col-md-12">
                        Descripcion:
                        </label>
                        </h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Acciones tomadas" name="descripcion" required=""></textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg"  type="date" placeholder="Fecha" name="fecha" required="">
                      </div>
                    </div>

                </div>


                      <div class="modal-footer">
                          <button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Alta de Etapa</button>
                  </form>
                          <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </div>

  <div class="modal fade" id="modalek" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h2 class="modal-title">ANALIZAR</h2>
              </div>
              <div class="modal-body">
                <div class="container">
                  <form  action="/lean/guardar" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token()}}">
                    <input type="hidden" name="idmejora" value="<?=$mejorarelacion->id?>">
                    <input type="hidden" name="etapa" value="7">

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Archivo de proyecto:</label></h2>
                        <div class="col-md-6">
                            <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="Usuario" class="control-label col-md-12">
                        Descripcion:
                        </label>
                        </h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Acciones tomadas" name="descripcion" required=""></textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg"  type="date" placeholder="Fecha" name="fecha" required="">
                      </div>
                    </div>

                </div>
                      <div class="modal-footer">
                          <button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Alta de Etapa</button>
                  </form>
                          <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                      </div>
                  </div>
              </div>
          </div>
  </div>
</div>

  <div class="modal fade" id="modalcm" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h2 class="modal-title">MEJORAR</h2>
              </div>
              <div class="modal-body">
                <div class="container">
                  <form  action="/lean/guardar" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token()}}">
                    <input type="hidden" name="idmejora" value="<?=$mejorarelacion->id?>">
                    <input type="hidden" name="etapa" value="8">

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Archivo de proyecto:</label></h2>
                        <div class="col-md-6">
                            <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="Usuario" class="control-label col-md-12">
                        Descripcion:
                        </label>
                        </h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Acciones tomadas" name="descripcion" required=""></textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg"  type="date" placeholder="Fecha" name="fecha" required="">
                      </div>
                    </div>

                </div>
                      <div class="modal-footer">
                          <button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Alta de Etapa</button>
                  </form>
                          <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                      </div>
                  </div>
              </div>
          </div>
  </div>
</div>

	<div class="modal fade" id="modalc" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
					<div class="modal-content">
							<div class="modal-header">
									<h2 class="modal-title">CONTROLAR</h2>
							</div>
							<div class="modal-body">
								<div class="container">
									<form  action="/lean/guardar" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
										<input type="hidden" name="_token" value="{{ csrf_token()}}">
										<input type="hidden" name="idmejora" value="<?=$mejorarelacion->id?>">
										<input type="hidden" name="etapa" value="9">

										<div class="form-group form-group-lg">
												<h2><label for="tipo" class="control-label col-md-12" >Archivo de proyecto:</label></h2>
												<div class="col-md-6">
														<input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo">
												</div>
										</div>

										<div class="form-group form-group-lg">
												<h2>
												<label for="Usuario" class="control-label col-md-12">
												Descripcion:
												</label>
												</h2>
												<div class="col-md-6">
														<textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Acciones tomadas" name="descripcion" required=""></textarea>
												</div>
										</div>

										<div class="form-group form-group-lg">
											<h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha:</label></h2>
											<div class="col-md-6">
													<input class="form-control input-lg"  type="date" placeholder="Fecha" name="fecha" required="">
											</div>
										</div>

								</div>
											<div class="modal-footer">
													<button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Alta de Etapa</button>
									</form>
													<button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
											</div>
									</div>
							</div>
					</div>
	</div>
@stop
