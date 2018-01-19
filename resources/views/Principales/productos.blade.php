@extends('layouts.principal2')

@section('content')
<br>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Productos & Servicios</h1>
  </div>
</div>

<br><br><br><br><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Productos y/o Servicios
                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-floppy-save"></i></button>
                </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                      <thead style='background-color: #868889; color:#FFF'>
                          <th>  <div class="th-inner sortable both">    Codigo  </div></th>
                          <th>  <div class="th-inner sortable both">    Nombre  </div></th>
                          <th>  <div class="th-inner sortable both">    Descripcion  </div></th>
                          <th>  <div class="th-inner sortable both">    Editar  </div></th>
                          <th>  <div class="th-inner sortable both">    Eliminar  </div></th>
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody>
                        <?php foreach ($producto as $productos): ?>
                        <tr>
                          <td>  <?=$productos['codigo']?></td>
                          <td>  <?=$productos['nombre']?></td>
                          <td>  <?=$productos['descripcion']?></td>
                          <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaledit<?=$productos['id']?>"><i class="glyphicon glyphicon-edit"></i>  </button>
                          </td>
                          <td>
                            <form class="" action="/productos/destroy/{{ $productos->id }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                              <button type="submit" class="btn btn-danger" id="btnpro" style="font-family: Arial;" ><i class="fa fa-trash"></i></button>
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
                    <h2 class="modal-title">ALTA DE PRODUCTO O SERVICIO</h2>
                </div>
                <div class="modal-body">
        <div class="container">
          <form class="" action="/productos/store" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group form-group-lg">
                        <h2><label for="tipo" class="control-label col-md-12" >    Codigo:</label></h2>
                        <div class="col-md-6">
                          <input class="form-control input-lg" id="codigo" type="Text" placeholder="Codigo del producto o servicio" name="codigo">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Nombre:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="nombre" type="Text" placeholder="Nombre" name="nombre">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Decripcion:</label></h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "prodescripcionind" rows="3" placeholder="Descripcion del producto o servicio" name="descripcion"></textarea>
                        </div>
                    </div>
        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success" id="btnobjetivo"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</button>
            </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>


    <?php foreach ($producto as $productos): ?>
    <div class="modal fade" id="modaledit<?=$productos['id']?>" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">EDITAR DE PRODUCTO O SERVICIO</h2>
                </div>
                <div class="modal-body">
                  <div class="container">
                    <form  action="/productos/edit/<?=$productos['id']?>" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                    <div class="form-group form-group-lg">
                      <h2><label for="tipo" class="control-label col-md-12" >    Codigo:</label></h2>
                      <div class="col-md-6">
                        <input class="form-control input-lg" id="codigo" type="Text" placeholder="Codigo del producto o servicio" value = "<?=$productos['codigo']?>" name="codigo">

                      </div>
                      </div>
                      <div class="form-group form-group-lg">
                      <h2><label for="Usuario" class="control-label col-md-12">Nombre:</label></h2>
                      <div class="col-md-6">
                          <input class="form-control input-lg" id="nombre" type="Text" value = "<?=$productos['nombre']?>" placeholder="Nombre" name="nombre">
                      </div>
                      </div>
                      <div class="form-group form-group-lg">
                      <h2><label for="Usuario" class="control-label col-md-12">Decripcion:</label></h2>
                      <div class="col-md-6">
                          <textarea class="form-control" id = "prodescripcionind" rows="3" placeholder="Descripcion del producto o servicio" value = "" name="descripcion"><?=$productos['descripcion']?></textarea>
                      </div>
                      </div>

                    </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnaltaindicador" style="font-family: Arial;"><i class="glyphicon glyphicon-edit"></i><br>Editar</button>
                    </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <?php endforeach?>

@stop
