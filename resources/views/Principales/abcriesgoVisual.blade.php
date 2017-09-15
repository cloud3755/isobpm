@extends('layouts.principal2')

@section('content')

<br>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">RIESGOS</h1>
    </div>
</div>

<br><br><br><br>
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
                <ol class="breadcrumb iso-breadcumb">
                    <li><a href="/riesgos" style='color:#FFF'> Riesgo</a></li>
                    <li class="active">Version pro</li>
                </ol>
            </h2>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    ABC RIESGO
                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-floppy-save"></i></button>
                </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th>
                            <div class="th-inner sortable both">
                              Tipo Riesgo ID
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Nombre
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Descripcion
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Modificacion
                            </div>
                          </th>
                          @if(Auth::user()->perfil != 4)
                          <th>
                            <div class="th-inner sortable both">
                              Eliminacion
                            </div>
                          </th>
                          @endif
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody>
                        <?php foreach ($riesgorelacion as $riesgorel): ?>
                        <tr>

                          <td>
                            <?=$riesgorel->tipo_nombre?>
                          </td>
                          <td>
                            <?=$riesgorel->nombre?>
                          </td>
                          <td>
                            <?=$riesgorel->descripcion?>
                          </td>
                          <td>
                            <button type="button" class="btn btn-primary" id="btnpro" style="font-family: Arial;" data-toggle="modal" data-target="#modaledit<?=$riesgorel->id?>" ><i class="glyphicon glyphicon-edit"></i></button>
                          </td>
                          @if(Auth::user()->perfil != 4)
                          <td>
                            <form class="" action="/abcriesgos/destroy/{{ $riesgorel->id }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                              <button type="submit" class="btn btn-danger" id="btnpro" style="font-family: Arial;" onclick="
                              return confirm('Estas seguro de eliminar el riesgo <?=$riesgorel->nombre?>?')"><i class="fa fa-trash"></i></button>
                            </form>
                          </td>
                          @endif
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

<!-- modal carga nuevo registro -->

    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h3 class="modal-title">ALTA DE ABC RIESGO</h3>
                </div>
                <div class="modal-body">
        <div class="container">
          <form class="" action="/abcriesgos/store" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="tipo" class="col-md-12 control-label" >
                            Tipo Riesgo:
                        </label>
                        </h2>
                        <div class="col-sm-9 col-md-6">
                            <select class="form-control input-lg" name="tipo_id_riesgo" id="objetivoindica">
                              <?php foreach ($Tiporiesgos as $Tiporiesgo): ?>
                                <option value="<?=$Tiporiesgo['id']?>"><?=$Tiporiesgo['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                      <div class="visible-sm">
                        <h2><label type="hidden" class="col-md-12 control_label"></label></h2>
                      </div>
                        <h2><label for="Usuario" class="col-md-12 control_label">Riesgo:</label></h2>
                        <div class="col-sm-9 col-md-6">
                            <input class="form-control input-lg" id="indicador" type="Text" placeholder="Cual es el riesgo" name="riesgo">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="Usuario" class="col-md-12 control_label">
                        Decripcion:
                        </label>
                        </h2>
                        <div class="col-sm-9 col-md-6">
                            <textarea class="form-control" id = "prodescripcionind" rows="3" placeholder="Describe el riesgo" name="descripcion"></textarea>
                        </div>
                    </div>
        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btnobjetivo" style="font-family: Arial;"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</button>
            </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
<!-- termina modal carga nuevo registro -->

<!-- inicia bucle modal edita registro -->

<?php foreach ($riesgorelacion as $riesgorel): ?>
    <div class="modal fade" id="modaledit<?=$riesgorel->id?>" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h3 class="modal-title">EDITAR ABC DE RIESGO</h3>
                </div>
                <div class="modal-body">
        <div class="container">
          <form class="" action="/abcriesgos/edit/<?=$riesgorel->id?>" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="tipo" class="control-label col-md-12" >
                            Tipo Riesgo:
                        </label>
                        </h2>
                        <div class="col-sm-9 col-md-6">
                            <select class="form-control input-lg" name="tipo_id_riesgo" id="objetivoindica">
                              <option value="<?=$riesgorel->tipo_id?>" selected="true"><?=$riesgorel->tipo_nombre?></option>
                              <?php foreach ($Tiporiesgos as $Tiporiesgo): ?>
                                <option value="<?=$Tiporiesgo['id']?>"><?=$Tiporiesgo['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                      <div class="visible-sm">
                        <h2><label type="hidden" class="col-md-12 control_label"></label></h2>
                      </div>
                        <h2><label for="Usuario" class="col-md-12 control_label">Riesgo:</label></h2>
                        <div class="col-sm-9 col-md-6">
                            <input class="form-control input-lg" id="indicador" type="Text" placeholder="Cual es el riesgo" name="riesgo" value="<?=$riesgorel->nombre?>">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="Usuario" class="control-label col-md-12">
                        Decripcion:
                        </label>
                        </h2>
                        <div class="col-sm-9 col-md-6">
                            <textarea class="form-control" id = "prodescripcionind" rows="3" placeholder="Describe el riesgo" name="descripcion"><?=$riesgorel->descripcion?></textarea>
                        </div>
                    </div>
        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnobjetivo" style="font-family: Arial;"><i class="glyphicon glyphicon-edit"></i><br>Editar</button>
            </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
<?php endforeach ?>
<!-- finaliza bucle modal edita registro -->
@stop
