@extends('layouts.principal2')

@section('content')
<br>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Empresas</h1>
  </div>
</div>

<br><br><br><br><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Empresas
                    <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target="#modalCompany"><i class="glyphicon glyphicon-upload"></i></button>
                </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th>  <div class="th-inner sortable both">    Razon Social  </div></th>
                          <th>  <div class="th-inner sortable both">    Plan  </div></th>
                          <th>  <div class="th-inner sortable both">    Correo  </div></th>
                          <th>  <div class="th-inner sortable both">    Telefono  </div></th>
                          <th>  <div class="th-inner sortable both">    Fecha Alta  </div></th>
                          <th>  <div class="th-inner sortable both">    Status  </div></th>
                          <th>  <div class="th-inner sortable both">    Modificacion  </div></th>
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody>
                        <?php foreach ($empresa as $empresas): ?>
                        <tr>
                          <td>  <?=$empresas['razonSocial']?></td>
                          <td>  <?=$empresas['id_plan']?></td>
                          <td>  <?=$empresas['correo']?></td>
                          <td>  <?=$empresas['telefono']?></td>
                          <td>  <?=$empresas['fecha']?></td>
                          <td>  <?=$empresas['status_id']?></td>
                          <td>
                            <form class="" action="/empresas/destroy/{{ $empresas->id }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                              <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" onclick="
return confirm('Estas seguro de eliminar la empresa <?=$empresas->['razonSocial']?>?')">Eliminar</button>
                              <button type="button" class="btnobjetivo" data-toggle="modal" data-target="#modaledit<?=$empresas['id']?>"><i class="glyphicon glyphicon-pencil"></i> Editar  </button>
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

<!--Nuevo modal para empresas -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalCompany">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h2 class="modal-title">ALTA DE EMPRESA</h2>
          </div>
          <form class="" action="/empresas/store" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="hTitleEmpresa"></h4>
            </div>
            <div class="modal-body" style="padding: 0px 20px 20px 20px">
                <div class="row">
                            <div class="col-lg-6 col-md-6">
                                  <label style="font-weight: bold">(*) Empresa:</label>
                                  <input type="text" class="form-control" id="razonSocial" name="razonSocial" />
                              </div>
                              <div class="col-lg-6 col-md-6">
                                  <label style="font-weight: bold">Domicilio:</label>
                                  <input type="text" class="form-control" id="domicilio" name="domicilio"/>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                  <label style="font-weight: bold">(*) Correo:</label>
                                  <input type="text" class="form-control" id="correo" name="correo" />
                              </div>
                              <div class="col-lg-6 col-md-6">
                                  <label style="font-weight: bold">Teléfono:</label>
                                  <input type="text" class="form-control" id="telefono" name="telefono" />
                              </div>
                              <div class="col-lg-12">
                                  <label style="font-weight: bold">(*) Rubro:</label>
                                  <textarea class="form-control" id="rubro" name="rubro" placeholder="Máximo 250 caracteres" maxlength="250"></textarea>
                              </div>
                              <div class="col-lg-12">
                                  <label style="font-weight: bold">Uso:</label>
                                  <textarea class="form-control" id="txtUsoEmpresa" name="uso" placeholder="Maximo 250 caracteres" maxlength="250"></textarea>
                              </div>
                              <div class="col-lg-8 col-md-8 col-sm-8">
                                  <label style="font-weight: bold">Logo: <i>No mayor a 512KB</i></label>
                                  <input type="file" class="form-control" name= "img" id="img" />
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-4">
                                  <img class="img-responsive" id="logoEmpresa" style="max-height: 50px" src="img/logo-isolution.png" />
                              </div>
                              <div class="col-lg-6 col-md-6">
                                  <label style="font-weight: bold">Estatus:</label>
                                  <select class="form-control" name="status_id" id="status_id">
                                      <option value="1">Pendiente</option>
                                      <option value="2">Suspendido</option>
                                      <option value="3">Activo</option>
                                  </select>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                  <label style="font-weight: bold">Plan:</label>
                                  <select class="form-control" name="id_plan" id="id_plan">
                                      <option value="1">Básico (5GB)</option>
                                      <option value="2">Intermedio (20GB)</option>
                                      <option value="3">Premium (50GB)</option>
                                  </select>
                              </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">Subir Empresa</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
<!--Para el editar -->
    <?php foreach ($empresa as $empresas): ?>
    <div class="modal fade" id="modaledit<?=$empresas['id']?>" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">EDITAR EMPRESA</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <form  action="/empresas/edit/<?=$empresas['id']?>" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                        <div class="col-lg-6 col-md-6">
                                <label style="font-weight: bold">(*) Empresa:</label>
                                <input type="text" class="form-control" id="razonSocial" value="<?=$empresas['razonSocial']?>" name="razonSocial" />
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label style="font-weight: bold">Domicilio:</label>
                                <input type="text" class="form-control" id="domicilio" value="<?=$empresas['domicilio']?>" name="domicilio"/>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label style="font-weight: bold">(*) Correo:</label>
                                <input type="text" class="form-control" id="correo" value="<?=$empresas['correo']?>" name="correo" />
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label style="font-weight: bold">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" value="<?=$empresas['telefono']?>"  name="telefono" />
                            </div>
                            <div class="col-lg-12">
                                <label style="font-weight: bold">(*) Rubro:</label>
                                <textarea class="form-control" id="rubro" name="rubro" placeholder="Máximo 250 caracteres" maxlength="250"><?=$empresas['rubro']?></textarea>
                            </div>
                            <div class="col-lg-12">
                                <label style="font-weight: bold">(*) Uso:</label>
                                <textarea class="form-control" id="txtUsoEmpresa" name="uso" placeholder="Maximo 250 caracteres" maxlength="250"><?=$empresas['uso']?></textarea>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <label style="font-weight: bold">Logo: <i>No mayor a 512KB</i></label>
                                <input type="file" class="form-control" name= "img" id="img" />
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <img class="img-responsive" id="logoEmpresa" style="max-height: 50px" src="img/logo-isolution.png" />
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label style="font-weight: bold">Estatus:</label>
                                <select class="form-control" name="status_id" id="status_id">
                                    <option value="1">Pendiente</option>
                                    <option value="2">Suspendido</option>
                                    <option value="3">Activo</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label style="font-weight: bold">Plan:</label>
                                <select class="form-control" name="id_plan" id="id_plan">
                                    <option value="1">Básico (5GB)</option>
                                    <option value="2">Intermedio (20GB)</option>
                                    <option value="3">Premium (50GB)</option>
                                </select>
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

@stop
