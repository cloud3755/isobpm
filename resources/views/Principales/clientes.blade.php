@extends('layouts.principal2')

@section('content')
<br>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Clientes</h1>
  </div>
</div>

<br><br><br><br><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Clientes
                    <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i></button>
                </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th>  <div class="th-inner sortable both">    Nombre  </div></th>
                          <th>  <div class="th-inner sortable both">    Correo  </div></th>
                          <th>  <div class="th-inner sortable both">    Telefono  </div></th>
                          <th>  <div class="th-inner sortable both">    Direccion  </div></th>
                          <th>  <div class="th-inner sortable both">    Modificacion  </div></th>
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody>
                        <?php foreach ($cliente as $clientes): ?>
                        <tr>
                          <td>  <?=$clientes['nombre']?></td>
                          <td>  <?=$clientes['correo']?></td>
                          <td>  <?=$clientes['telefono']?></td>
                          <td>  <?=$clientes['direccion']?></td>
                          <td>
                            <form class="" action="/clientes/destroy/{{ $clientes->id }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                              <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" >Eliminar</button>
                              <button type="button" class="btnobjetivo" data-toggle="modal" data-target="#modaledit<?=$clientes['id']?>"><i class="glyphicon glyphicon-pencil"></i> Editar  </button>
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
    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">ALTA DE CLIENTES</h2>
                </div>
                <div class="modal-body">
        <div class="container">
          <form class="" action="/clientes/store" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Nombre:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="nombre" type="Text" placeholder="Nombre" name="nombre" required>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                      <h2><label for="tipo" class="control-label col-md-12" >Correo:</label></h2>
                      <div class="col-md-6">
                        <input class="form-control input-lg" id="correo" type="Text" placeholder="Agregar correo" name="correo" required>
                      </div>
                    </div>
                    <div class="form-group form-group-lg">
                      <h2><label for="Usuario" class="control-label col-md-12">Telefono:</label></h2>
                      <div class="col-md-6">
                        <input class="form-control input-lg" id="telefono" type="number" placeholder="Telefono cliente" name="telefono" required>
                      </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Direccion:</label></h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "direccion" rows="3" placeholder="Direccion del cliente" name="direccion" required></textarea>
                        </div>
                    </div>
        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">Subir Cliente</button>
            </form>
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>

<!-- Modal para editar-->
    <?php foreach ($cliente as $clientes): ?>
    <div class="modal fade" id="modaledit<?=$clientes['id']?>" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">EDITAR CLIENTE</h2>
                </div>
                <form  action="/clientes/edit/<?=$clientes['id']?>" method="post">
                  <div class="modal-body">
                    <div class="container">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                      <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Nombre:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="nombre" type="Text" value = "<?=$clientes['nombre']?>" placeholder="Nombre" name="nombre" required>
                        </div>
                      </div>
                      <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >Correo:</label></h2>
                        <div class="col-md-6">
                          <input class="form-control input-lg" id="correo" type="Text" placeholder="Codigo del producto o servicio" value = "<?=$clientes['correo']?>" name="correo" required>
                        </div>
                      </div>
                      <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Telefono:</label></h2>
                        <div class="col-md-6">
                          <input class="form-control input-lg" id="telefono" type="number" placeholder="Codigo del producto o servicio"  value = "<?=$clientes['telefono']?>" name="telefono" required>
                        </div>
                      </div>
                      <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Direccion:</label></h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "direccion" rows="3" placeholder="Direccion del cliente" name="direccion" required><?=$clientes['direccion']?></textarea>
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

@stop
