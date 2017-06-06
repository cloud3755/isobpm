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
                    <li><a href="../" style='color:#FFF'> Quejas</a></li>
                    <li class="active">Version</li>
                </ol>
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-right">
            <center>
            <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i> Subir Queja</button>
            </center>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Quejas
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
                              fecha
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Cliente
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Descripcion
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Responsable
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Acciones
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Fecha plan
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Evidencia
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Fecha cierre
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Status
                            </div>
                          </th>
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody>
                        <?php foreach ($quejas as $queja): ?>
                        <tr>
                          <td>
                            <?=$queja['id']?>
                          </td>
                          <td>
                            <?=$queja['fecha']?>
                          </td>
                          <td>
                            <?=$queja['cliente_id']?>
                          </td>
                          <td>
                            <?=$queja['descripcion']?>
                          </td>
                          <td>
                            <?=$queja['usuario_responsable_id']?>
                          </td>
                          <td>
                            <?=$queja['acciones']?>
                          </td>
                          <td>
                            <?=$queja['fecha_plan']?>
                          </td>
                          <td>
                            <?=$queja['evidencia']?>
                          </td>
                          <td>
                            <?=$queja['fecha_cierre']?>
                          </td>
                          <td>
                            <?=$queja['estatus_id']?>
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
    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">ALTA DE QUEJA</h2>
                </div>
                <div class="modal-body">
                  <div class="container">
                    <form  action="/quejas/store" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg" id="fecha" type="date" placeholder="Fecha" name="fecha">
                      </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Cliente:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="indicador" type="Text" placeholder="cliente que levanta la queja" name="cliente_id">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="Usuario" class="control-label col-md-12">
                        Decripcion:
                        </label>
                        </h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="" name="descripcion">
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Responsable:</label></h2>
                        <div class="col-md-6">
                            <select class="form-control input-lg" name="responsable" id="responsable">
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
                            <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="" name="acciones">
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha plan:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg" id="fecha" type="date" placeholder="Fecha" name="fecha_plan">
                      </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Evidencia:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="probproces" type="text" placeholder="evidencia" name="evidencia">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                      <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha Cierre:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg" id="fecha" type="date" placeholder="Fecha" name="fecha_cierre">
                      </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Status:</label></h2>
                        <div class="col-md-6">
                            <select class="form-control input-lg" name="status_id" id="responsable">
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

@stop
