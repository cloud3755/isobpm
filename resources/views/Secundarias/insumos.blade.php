@extends('layouts.principal2')

@section('content')
<br>
<script src="/js/insumosjs.js" charset="utf-8"></script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Insumos</h1>
    </div>
</div>
<center><button type="button" class="btnobjetivo" onclick=location="/proveedores" data-dismiss="modal" id="btnCloseUpload">Regresar</button></center>
<br><br><br><br><br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                Alta de insumos
                <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i></button>
            </div>
        <div class="panel-body">
          <div class="row">
            <div class="table-responsive">
              <form>
                  Buscar <input id="searchTerm" type="text" onkeyup="doSearch()" />
              </form>
              <br>
                <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
                  <thead style='background-color: #868889; color:#FFF'>
                    <tr>
                      <th>  <div class="th-inner sortable both">    Codigo  </div></th>
                      <th>  <div class="th-inner sortable both">    Producto o servicio  </div></th>
                      <th>  <div class="th-inner sortable both">    Descripcion  </div></th>
                      <th>  <div class="th-inner sortable both">    Tipo  </div></th>
                      <th>  <div class="th-inner sortable both">    Archivo de especificaciones  </div></th>
                      <th>  <div class="th-inner sortable both">    Acciones  </div></th>
                      </tr>
                  </thead>
                  <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                  <tbody id = "myTable">
                    <?php foreach ($insumo as $insumos): ?>
                    <tr>
                      <td>  <?=$insumos->id?></td>
                      <td>  <?=$insumos->Producto_o_Servicio?></td>
                      <td>  <?=$insumos->Descripcion?></td>
                      <td>  <?=$insumos->Tipo?></td>
                      <td>  <?=$insumos->archivo?></td>
                      <td>
                      <form class="" action="/insumos/delete/<?=$insumos->id?>" method="post">
                         <a href="/insumo/file/ver/<?=$insumos->id?>" target="_blank" style=\'color:#FFF\'><button type="button" <?php if ($insumos->archivo == 'No se cargo archivo') { echo"disabled";} else {echo"";} ?> class="btnobjetivo"><i class="glyphicon glyphicon-download-alt"></i> Ver archivo </button> </a>
                        <button type="button" class="btnobjetivo" value = "<?=$insumos->id?>" data-toggle="modal" data-target="#modaledit" onclick="Editar(this);"><i class="glyphicon glyphicon-pencil"></i> Editar </button>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <button type="submit" class="btnobjetivo" id="btndelete_<?=$insumos->id?>" style="font-family: Arial;" dataid="<?=$insumos->id?>" onclick="
return confirm('Estas seguro de eliminar el insumo: <?=$insumos->Producto_o_Servicio?>?')"><i class="glyphicon glyphicon-remove"></i> Eliminar</button>
                      </form>

                      </td>

                    </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
            </div>
            <div class="col-md-12 text-center">
              <ul class="pagination pagination-lg pager" id="myPager"></ul>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</div>
</div>

<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title">ALTA DE INSUMO</h3>
            </div>
            <div class="modal-body">
              <form class="" action="/insumos/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <div class="container">
                <div class="form-group form-group-lg">
                    <h2><label for="producto" class="control-label col-md-12">(*) Producto o servicio:</label></h2>
                    <div class="col-sm-9">
                        <input class="form-control input-lg" id="producto" type="Text" placeholder="Nombre" name="producto" required>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2><label for="descripcion" class="control-label col-md-12" >(*) Descripcion:</label></h2>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" id="descripcion" type="Text" placeholder="Agrega una descripcion del producto o servicio" name="descripcion" required>
                  </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2>  <label for="activo" class="control-label col-md-12">(*) Tipo:
                    </label>
                     </h2>
                    <div class="col-md-9">
                        <select class="form-control input-lg" name="tipo" id="tipo">
                          <option value="No critico" selected="selected"> No critico </option>
                          <option value="Critico"> Critico </option>
                        </select>
                    </div>
                </div>


                <div class="form-group form-group-lg">
                    <h2><label for="archivo" class="control-label col-md-12">(*) Archivo de especificaciones:</label></h2>
                    <div class="col-sm-9">
                        <input class="form-control input-lg" id="archivo" type="file" placeholder="Elige el archivo" name="archivo">
                    </div>
                </div>

              </div>
                    <div class="modal-footer">
                    <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">Alta de insumo</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
              </form>
                </div>
            </div>
        </div>
</div>


<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title">ACTUALIZAR INSUMO</h3>
            </div>
            <div class="modal-body">
              <form id="fileinfo" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <input type="hidden" name="eid"  id="eid" >


              <div class="container">
                <div class="form-group form-group-lg">
                    <h2><label for="producto" class="control-label col-md-12">(*) Producto o servicio:</label></h2>
                    <div class="col-md-6 col-sm-9">
                        <input class="form-control input-lg" id="eproducto" type="Text" placeholder="Nombre" name="eproducto" required>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2><label for="descripcion" class="control-label col-md-12" >(*) Descripcion:</label></h2>
                  <div class="col-md-6 col-sm-9">
                    <input class="form-control input-lg" id="edescripcion" type="Text" placeholder="Agrega una descripcion del producto o servicio" name="edescripcion" required>
                  </div>
                </div>


                  <div class="form-group form-group-lg">
                    <h2>  <label for="activo" class="control-label col-md-12">(*) Tipo:
                      </label>
                       </h2>
                      <div class="col-md-6">
                          <select class="form-control input-lg" name="etipo" id="etipo">
                            <option value="No critico" selected="selected"> No critico </option>
                            <option value="Critico"> Critico </option>
                          </select>
                      </div>
                  </div>


                  <div class="form-group form-group-lg">
                      <h2><label for="archivo" class="control-label col-md-12">(*) Cambiar archivo de especificaciones:</label></h2>
                      <div class="col-md-6 col-sm-9">
                          <input class="form-control input-lg" id="earchivo" type="file" placeholder="Elige el archivo" name="earchivo">
                      </div>
                  </div>


              </div>
                    <div class="modal-footer">
            <!--  <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">guardar cambio insumo</button> -->
                        <a class="btn btn-primary" id="actualizar" style="font-family: Arial;">Guardar Cambios</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
                </div>
              </form>
            </div>
        </div>
</div>



<?php
  $dato = json_encode($insumo);
 ?>




@stop
