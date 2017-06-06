@extends('layouts.principal')

@section('content')
@if (session()->has('flash_msg'))
    <div class="alert alert-{{session()->get('flash_type')}}">
        {{session()->get('flash_msg')}}.
    </div>
@endif
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
                    <li><a href="../" style='color:#FFF'> Indicadores</a></li>
                    <li class="active">Version pro</li>
                </ol>
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-right">
            <center>
            <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i> Subir Indicador</button>
            </center>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Indicadores
                </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th>
                            <div class="th-inner sortable both">
                              ID
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Objetivo ID
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
                              Responsable id
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              frecuencia_id
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              unidad
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              logica
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              meta
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Modificacion
                            </div>
                          </th>
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody>
                        <?php foreach ($indicador as $indicado): ?>
                        <tr>
                          <td>
                            <?=$indicado['id']?>
                          </td>
                          <td>
                            <?=$indicado['objetivo_id']?>
                          </td>
                          <td>
                            <?=$indicado['nombre']?>
                          </td>
                          <td>
                            <?=$indicado['descripcion']?>
                          </td>
                          <td>
                            <?=$indicado['usuario_responsable_id']?>
                          </td>
                          <td>
                            <?=$indicado['frecuencia_id']?>
                          </td>
                          <td>
                            <?=$indicado['unidad']?>
                          </td>
                          <td>
                            <?=$indicado['logica']?>
                          </td>
                          <td>
                            <?=$indicado['meta']?>
                          </td>
                          <td>
                          <form class="" action="/indicadores/destroy/{{ $indicado->id }}" method="post">
                                          {{ csrf_field() }}
                                          {{ method_field('DELETE') }}
                            <button type="button" class="btnobjetivo" id="btnpro" style="font-family: Arial;" >Editar</button>
                            <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" >Eliminar</button>
                          </fomr>
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
<br>
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
                            Objetivo:
                        </label>
                        </h2>
                        <div class="col-md-6">
                            <select class="form-control input-lg" name="objetivo_id" id="objetivo_id">
                              <?php foreach ($objetivo as $objetivos): ?>
                                <option value="<?=$objetivos['id']?>"><?=$objetivos['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Indicador:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="nombre" type="Text" placeholder="A que se quiere llegar" name="nombre">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="Usuario" class="control-label col-md-12">
                        Decripcion:
                        </label>
                        </h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "prodescripcionind" rows="3" placeholder="" name="descripcion" id="descripcion">
                            </textarea>
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
                                <option value="<?=$Users['id']?>"><?=$Users['usuario']?></option>
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
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="acceso" type="Text" placeholder="A que se quiere llegar" name="acceso">
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

@stop
