@extends('layouts.principal2')

@section('content')
<br>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Areas</h1>
  </div>
</div>

<br><br><br><br><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Areas
                    <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i></button>
                </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th>  <div class="th-inner sortable both">    Nombre  </div></th>
                          <th>  <div class="th-inner sortable both">    Modificacion  </div></th>
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody>
                        <?php foreach ($area as $areas): ?>
                        <tr>
                          <td>  <?=$areas['nombre']?></td>
                          <td>
                            <form class="" action="/areas/destroy/{{ $areas->id }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                              <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" >Eliminar</button>
                              <button type="button" class="btnobjetivo" data-toggle="modal" data-target="#modaledit<?=$areas['id']?>"><i class="glyphicon glyphicon-pencil"></i> Editar  </button>
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
                    <h2 class="modal-title">ALTA DE AREA</h2>
                </div>
                <div class="modal-body">
        <div class="container">
          <form class="" action="/areas/store" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Nombre:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="nombre" type="Text" placeholder="Nombre" name="nombre" required>
                        </div>
                    </div>
        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">Subir Area</button>
            </form>
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>


    <?php foreach ($area as $areas): ?>
    <div class="modal fade" id="modaledit<?=$areas['id']?>" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">EDITAR AREA</h2>
                </div>
                <div class="modal-body">
                  <div class="container">
                    <form  action="/areas/edit/<?=$areas['id']?>" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                      <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Nombre:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="nombre" type="Text" value = "<?=$areas['nombre']?>" placeholder="Nombre" name="nombre" required>
                        </div>
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
