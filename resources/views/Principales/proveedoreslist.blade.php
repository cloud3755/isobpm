@extends('layouts.principal2')

@section('content')
<br>
    <script src="/js/proveedoreslist.js" charset="utf-8"></script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Lista de proveedores</h1>
    </div>
</div>

<center><button type="button" class="btnobjetivo" onclick=location="/proveedores" data-dismiss="modal" id="btnCloseUpload">Regresar</button></center>

<br><br><br><br><br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                Agregar proveedores
                <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i></button>
            </div>
        <div class="panel-body">
          <div class="row">
            <div class="table-responsive">
              <form>
                  Buscar <input id="searchTerm" type="text" onkeyup="doSearch('datos','searchTerm')" />
              </form>
              <br>
                <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
                  <thead style='background-color: #868889; color:#FFF'>
                    <tr>
                      <th>  <div class="th-inner sortable both">    Codigo  </div></th>
                      <th>  <div class="th-inner sortable both">    Nombre proveedor  </div></th>
                      <th>  <div class="th-inner sortable both">    Email  </div></th>
                      <th>  <div class="th-inner sortable both">    Telefono  </div></th>
                      <th>  <div class="th-inner sortable both">    Estatus  </div></th>
                      <th>  <div class="th-inner sortable both">    Acciones  </div></th>

                    </tr>
                  </thead>
                  <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                  <tbody id = "myTable">
                    <?php foreach ($provedor as $proveedors): ?>
                    <tr>
                      <td>  <?=$proveedors->id?></td>
                      <td>  <?=$proveedors->proveedor?></td>
                      <td>  <?=$proveedors->email?></td>
                      <td>  <?=$proveedors->telefono?></td>
                      <td>  <?=$proveedors->activo?></td>
                      <td>

                      <form class="" action="/proveedor/delete/<?=$proveedors['id']?>" method="post">
                        <button type="button" class="btnobjetivo" value = "<?=$proveedors->id?>" name=1 data-toggle="modal" data-target="#modaledit" onclick="Editar(this);"><i class="glyphicon glyphicon-eye-open"></i> Ver </button>
                        <button type="button" class="btnobjetivo" value = "<?=$proveedors->id?>" name=2 data-toggle="modal" data-target="#modaledit" onclick="Editar(this);"><i class="glyphicon glyphicon-pencil"></i> Editar / Alta de documentos </button>
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                        <button type="submit" class="btnobjetivo" id="btndelete_<?=$proveedors['id']?>" style="font-family: Arial;" dataid="<?=$proveedors['id']?>" onclick="
return confirm('Estas seguro de eliminar el proveedor: <?=$proveedors['proveedor']?>?')"><i class="glyphicon glyphicon-remove"></i> Eliminar</button>
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

<!-- modal para carga de nuevo registro -->

<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">ALTA DE PROVEEDOR</h3>
            </div>
            <div class="modal-body">
              <form class="" action="/proveedor/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="container">
                <div class="form-group form-group-lg">
                    <h2><label for="proveedor" class="control-label col-md-12">(*) Proveedor:</label></h2>
                    <div class="col-md-6 col-sm-9">
                        <input class="form-control input-lg" id="proveedor" type="Text" placeholder="Nombre" name="proveedor" required>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2><label for="email" class="control-label col-md-12" >(*) Email:</label></h2>
                  <div class="col-md-6 col-sm-9">
                    <input class="form-control input-lg" id="email" type="Text" placeholder="Agrega un correo electronico" name="email" required>
                  </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="telefono" class="control-label col-md-12">(*) Telefono:</label></h2>
                    <div class="col-md-6 col-sm-9">
                        <input class="form-control input-lg" id="telefono" type="Text" placeholder="Agrega un telefono" name="telefono" required>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2>  <label for="activo" class="control-label col-md-12">Activo:
                    </label>
                     </h2>
                    <div class="col-md-6">
                        <select class="form-control input-lg" name="activo" id="activo">
                          <option value="Activo" selected="selected"> Activo </option>
                          <option value="Inactivo"> Inactivo </option>
                        </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="direccion" class="control-label col-md-12">Direccion:</label></h2>
                    <div class="col-md-6 col-sm-9">
                    <textarea class="form-control input-lg" id = "oireccion" rows="3" name="direccion" maxlength="255"></textarea>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="observaciones" class="control-label col-md-12">Observaciones:</label></h2>
                    <div class="col-md-6 col-sm-9">
                    <textarea class="form-control input-lg" id = "observaciones" rows="3" name="observaciones" maxlength="255"></textarea>
                    </div>
                </div>


<!-- lista de insumos -->



                <div class="form-group form-group-lg">
                  <h2><label for="Usuario" class="control-label col-md-12">Lista de insumos:</label></h2>
                  <div class="col-md-6">

                         <div>
                                           <p>
                                           </p><table WIDTH="100%">
                                                   <tbody><tr>
                                                       <td><h3>Insumos no elegidos</h3></td>
                                                       <td></td>
                                                       <td><h3>Insumos elegidos</h3></td>
                                                   </tr>
                                                   <tr>
                                                       <td>
                                                           <select multiple name="listaDisponibles[]"  id="listaDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('listaDisponibles', 'listaSeleccionada');">
                                                             <?php foreach ($insumo as $insumos): ?>
                                                               <option value="<?=$insumos->id?>"> <?=$insumos->Producto_o_Servicio ?> </option>
                                                             <?php endforeach ?>

                                                           </select>

                                                   </td>
                                                   <td>
                                                       <table>
                                                           <tbody><tr>
                                                               <td>
                                                                   <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('listaDisponibles', 'listaSeleccionada');">
                                                               </td>
                                                           </tr>
                                                           <tr>
                                                               <td>
                                                                   <script type="text/javascript">

                                                                   </script>
                                                               </td>
                                                           </tr>
                                                           <tr>
                                                               <td>
                                                               </td>
                                                           </tr>
                                                           <tr>
                                                               <td>
                                                                   <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('listaSeleccionada', 'listaDisponibles');">
                                                               </td>
                                                           </tr>
                                                       </tbody></table>

                                                   </td>

                                                   <td>
                                                       <select multiple name="listaSeleccionada[]" id="listaSeleccionada"  size="7" style="width: 100%;" onclick="agregaSeleccion('listaSeleccionada', 'listaDisponibles');">
                                                       </select>
                                                   </td>
                                               </tr>
                                           </tbody></table>
                                       <p></p>
                                   </div>

                       </div>
                   </div>


<!-- lista de insumos -->

              </div>
                    <div class="modal-footer">
                    <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">Alta de proveedor</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
              </form>
                </div>
            </div>
        </div>
</div>

<!-- modal para carga nuevo registro -->

<!-- modal para actualizacion de registro -->

<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">VER / ACTUALIZAR PROVEEDOR</h3>
            </div>
            <div class="modal-body">
        <form id="fileinfo" class=""  method="post" accept-charset="UTF-8" enctype="multipart/form-data" >
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <input type="hidden" name="eid" id="eid">
              <div class="container" id="containeredit">
                <div class="form-group form-group-lg">
                    <h2><label for="proveedor" class="control-label col-md-12">(*) Proveedor:</label></h2>
                    <div class="col-md-6 col-sm-9">
                        <input class="form-control input-lg" id="eproveedor" type="Text" placeholder="Nombre" name="eproveedor" required>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2><label for="email" class="control-label col-md-12" >(*) Email:</label></h2>
                  <div class="col-md-6 col-sm-9">
                    <input class="form-control input-lg" id="eemail" type="Text" placeholder="Agrega un correo electronico" name="eemail" required>
                  </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="telefono" class="control-label col-md-12">(*) Telefono:</label></h2>
                    <div class="col-md-6 col-sm-9">
                        <input class="form-control input-lg" id="etelefono" type="Text" placeholder="Agrega un telefono" name="etelefono" required>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2>  <label for="activo" class="control-label col-md-12">Activo:
                    </label>
                     </h2>
                    <div class="col-md-6">
                        <select class="form-control input-lg" name="eactivo" id="eactivo">
                          <option value="Activo" selected="selected"> Activo </option>
                          <option value="Inactivo"> Inactivo </option>
                        </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="direccion" class="control-label col-md-12">Direccion:</label></h2>
                    <div class="col-md-6 col-sm-9">
                    <textarea class="form-control input-lg" id = "edireccion" rows="3" name="edireccion" maxlength="255"></textarea>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="observaciones" class="control-label col-md-12">Observaciones:</label></h2>
                    <div class="col-md-6 col-sm-9">
                    <textarea class="form-control input-lg" id = "eobservaciones" rows="3" name="eobservaciones" maxlength="255"></textarea>
                    </div>
                </div>

<!-- lista de insumos select -->

                <div id="selectinsumos" class="form-group form-group-lg">
                  <h2><label for="Usuario" class="control-label col-md-12">Lista de insumos:</label></h2>
                  <div class="col-md-6">

                         <div>
                                           <p>
                                           </p><table WIDTH="100%">
                                                   <tbody><tr>
                                                     <td><h3>Insumos no elegidos</h3></td>
                                                     <td></td>
                                                     <td><h3>Insumos elegidos</h3></td>
                                                   </tr>
                                                   <tr>
                                                       <td>
                                                           <select multiple name="elistaDisponibles[]"  id="elistaDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('elistaDisponibles', 'elistaSeleccionada');">
                                                           </select>

                                                   </td>
                                                   <td>
                                                       <table>
                                                           <tbody><tr>
                                                               <td>
                                                                   <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('elistaDisponibles', 'elistaSeleccionada');">
                                                               </td>
                                                           </tr>
                                                           <tr>
                                                               <td>
                                                                   <script type="text/javascript">

                                                                   </script>
                                                               </td>
                                                           </tr>
                                                           <tr>
                                                               <td>
                                                               </td>
                                                           </tr>
                                                           <tr>
                                                               <td>
                                                                   <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('elistaSeleccionada', 'elistaDisponibles');">
                                                               </td>
                                                           </tr>
                                                       </tbody></table>

                                                   </td>

                                                   <td>
                                                       <select multiple name="elistaSeleccionada[]" id="elistaSeleccionada"  size="7" style="width: 100%;" onclick="agregaSeleccion('elistaSeleccionada', 'elistaDisponibles');">
                                                       </select>
                                                   </td>
                                               </tr>
                                           </tbody></table>
                                       <p></p>
                                   </div>

                       </div>
                   </div>

<!-- lista de insumos select-->

<div id="listtinsumos" class="form-group form-group-sm">
  <h2><label for="listinsumos" class="control-label col-md-12">Lista de insumos asociados al proveedor:</label></h2>
<div class="col-md-6">
  <ul class="list-group" id="elist">
<li class="list-group-item" id="elistitem"><center><h5>0</h5></center></li>

  </ul>
</div>
</div>
              </div>
                    <div class="modal-footer" id="footer">
                    <button name="documentosalta" type="button" class="btnobjetivo" id="documentosalta" value = "" data-toggle="modal" data-dismiss="modal" data-target="#modalarchivos" onclick="Archivo(this);"><i class="glyphicon glyphicon-pencil"></i> Alta / Baja documentos</button>
                    <!--     <button type="submit" class="act" id="act" style="font-family: Arial;">Guardar cambio insumo</button> -->
                    <button name="guardacambios" type="button" class="btnobjetivo" id="guardacambios" style="font-family: Arial;"><i class="glyphicon glyphicon-pencil"></i>Guardar cambios</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
              </form>
                </div>
            </div>
        </div>
</div>


<!-- modal para actualizacion de registro -->


<!-- modal alta archivos -->


<div class="modal fade" id="modalarchivos" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Alta archivos proveedor</h3>
            </div>
            <div class="modal-body">
<form  id="fileup" method="post" accept-charset="UTF-8" enctype="multipart/form-data" class="form-inline">

              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="fid" id="fid">

              <div class="form-group form-group-lg">
                  <h2><label for="nombrearchivo" class="control-label">(*) Nombre del archivo:</label></h2>
                  <div class="col-md-10">
                      <input class="form-control input-lg " width="100%" id="snombrearchivo" type="Text" placeholder="Agrega el nombre del archivo" name="snombrearchivo" required>
                  </div>
              </div>
              <div class="form-group form-group-lg">
                  <h2><label for="archivo" class="control-label">(*) Archivo:</label></h2>
                  <div class="col-md-10">
                      <input class="form-control input-lg" id="archivo" type="file" placeholder="Elige el archivo" name="archivo" required>
                  </div>
              </div>
<!--<progress id="progress" value="0" visible="false"></progress> -->
<div class="form-group form-group-lg">
<h2><label for="boton" class="control-label"></label></h2>
  <div class="col-md-12">
<button name="guardadoc" type="button" class="btnobjetivo" id="guardadoc" style="font-family: Arial;"><i class="glyphicon glyphicon-upload"></i> Cargar Archivo </button>

<!--  <button name="documentosalta" type="submit" class="btnobjetivo btn-lg" id="documentosalta" value = "" data-toggle="modal" data-target="#modalarchivos" onclick=""><i class="glyphicon glyphicon-upload"></i> Cargar Archivo </button>-->
</div>
</div>
</form>


<div class="modal-body">
  <div clas="etiquetamodal">
  <center><h2><label for="boton" class="control-label">Lista de archivos</label></h2></center>
  </div>
   <div id="contieneTablaArchivo" name="contieneTablaArchivo" class="modal-body">

<div class="panel-body">
  <div class="row">
    <div class="table-responsive">
      <br>
      <form>
          Buscar <input id="fsearchTerm" type="text" onkeyup="doSearch('datos','fsearchTerm')" />
      </form>
      <br>
        <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="fdatos">
          <thead style='background-color: #868889; color:#FFF'>
            <tr>
              <th>  <div class="th-inner sortable both">    Nombre  </div></th>
              <th>  <div class="th-inner sortable both">    Archivo  </div></th>
              <th>  <div class="th-inner sortable both">    Tamaño  </div></th>
              <th>  <div class="th-inner sortable both">    Acciones  </div></th>

            </tr>
          </thead>
          <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
          <tbody id = "FmyTable">



          </tbody>
        </table>
    </div>
    <div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="FmyPager"></ul>
    </div>
  </div>
</div>



   </div>
</div>
                    <div class="modal-footer" id="footer">


                    <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>
</div>




<!-- modal alta archivos -->



<?php
  $dato = json_encode($provedor);
 ?>




@stop
