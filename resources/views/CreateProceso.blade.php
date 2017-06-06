@extends('layouts.principal')

@section('content')
<div class="row" style="padding: 5px">
    <div class="col-lg-12 text-right">
        <button type="button" class="btn btn-primary" id="btnHelp">?</button>
    </div>
    <div class="col-lg-12" id="divHelp" style="display:none">
        <div class="col-lg-3 col-md-4 col-sm-4 hidden-xs text-center">
            <img src="/img/help/doc_ext.jpg" class="img-responsive img-thumbnail" />
        </div>
        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
            <p>
                En este apartado se depositan y visualizan los distintos procesos.
             </p>
        </div>
    </div>
</div><br><br><br><br><br>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
            <ol class="breadcrumb iso-breadcumb">
                <li><a href="../" style='color:#FFF'>Procesos Pro</a></li>
                <li class="active">Vista Procesos</li>
            </ol>
        </h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 text-right">
        <center>
        <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i> Agregar proceso  </button>
        </center>
    </div>
</div>
</br>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
            <center>
                Procesos
            </center>
            </div>

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProOb">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th>
                            <div class="th-inner sortable both">
                              Tipo
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Proceso
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
                              Revisado
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Detalle revision
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Archivo HTML
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Indicadores
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Lista de distribucion
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Acciones
                            </div>
                          </th>
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody>
                        <?php foreach ($proceso as $process): ?>
                        <tr>
                          <td>
                            <?=$process['tipo']?>
                          </td>
                          <td>
                            <?=$process['proceso']?>
                          </td>
                          <td>
                            <?=$process['descripcion']?>
                          </td>
                          <td>
                            <?=$process['usuario_responsable_id']?>
                          </td>
                          <td>
                            <?=$process['rev']?>
                          </td>
                          <td>
                            <?=$process['detalle_de_rev']?>
                          </td>
                          <td>
                            <?=$process['archivo_html']?>
                          </td>
                          <td>
                            <?=$process['indicadores']?>
                          </td>
                          <td>
                            <?=$process['lista_de_distribucion']?>
                          </td>
                          <td>
<!-- se creara un bucle para generar los n modales necesarios para la edicion de datos -->
                            <button type="button" class="btnobjetivo" data-toggle="modal" data-target="#modalupdate<?=$process['id']?>"><i class="glyphicon glyphicon-pencil"></i> Editar  </button>
                            <form class="" action="/procesos/delete/<?=$process['id']?>" method="post">
                              <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                              <button type="submit" class="btnobjetivo" id="btndelete_<?=$process['id']?>" style="font-family: Arial;" dataid="<?=$process['id']?>" onclick="
return confirm('Estas seguro de eliminar el proceso <?=$process['proceso']?>?')"><i class="glyphicon glyphicon-remove"></i>Eliminar</button>
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


 <form method="POST" action="/procesos/store" accept-charset="UTF-8" enctype="multipart/form-data">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" style="background-color:gray">
            <div class="modal-dialog" role="form">
                <div class="modal-content">
                    <div class="modal-header">

                        <h2 class="modal-title">Alta de proceso</h2>
                    </div>
                    <div class="modal-body">
            <div class="container">
                <div class="form-group form-group-lg">
                    <label for="tipo" class="control-label col-md-12" >
                        Tipo de Proceso:
                    </label>
                    <div class="col-md-6">
                        <select class="form-control input-lg" name="tipo" id="protipoproc">
                          <?php foreach ($tipoproceso as $tipoprocess): ?>
                            <option value="<?=$tipoprocess['nombreproceso']?>"> <?=$tipoprocess['nombreproceso']?> </option>
                          <?php endforeach ?>

                        </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Proceso:</label></h2>
                    <div class="col-md-6">
                        <input class="form-control input-lg" id="probproces" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12">
                    Decripcion:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <textarea class="form-control input-lg" id = "prodescripcionproces" rows="3" placeholder="Descripcion del proceso" name="descripcion" maxlength="255"></textarea>
                    </div>
                </div>


                <div class="form-group form-group-lg">
                    <h2>
                    <label for="tipo" class="control-label col-md-12" >
                        Responsable:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <select class="form-control input-lg" name="usuario_responsable_id" id="proresponsableob">
                          <?php foreach ($User as $Users): ?>
                            <option value="<?=$Users['usuario']?>"> <?=$Users['usuario']?> </option>
                          <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label for="tipo" class="control-label col-md-12" >
                        Revisado:
                    </label>
                    <div class="col-md-6">
                        <select class="form-control input-lg" name="rev" id="protipoOb">
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12">
                    Detalle de Revision:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <textarea class="form-control" id = "prodescripcionproce" rows="3" placeholder="Detalle de rev" name="detalle_de_rev" maxlength="255"></textarea>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Archivo HTML:</label></h2>
                    <div class="col-md-6">
                        <input class="form-control input-lg" id="probproces" type="file" accept=".zip" placeholder="file" name="file">
                    </div>
                </div>


        <div class="form-group form-group-lg">
         <h2><label for="Usuario" class="control-label col-md-12">Indicadores:</label></h2>
                    <div class="col-md-6">
                        <input class="form-control input-lg" id="probproces" type="Text" placeholder="Nombre del indicador" name="indicadores" maxlength="50">
                    </div>
                </div>


                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Lista de distribucion:</label></h2>
                    <div class="col-md-6">
                        <input class="form-control input-lg" id="probproces" type="Text" placeholder="lista de distribucion" name="lista_de_distribucion">
                    </div>
                </div>


          </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        <button type="submit" value="file" class="btnobjetivo" id="btnaltaproceso" style="font-family: Arial;">Alta de Proceso</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
</form>



<!--     aqui empieza el formulario que edita -->
<!--     aqui se genera un bucle para generar los modales necesarios -->
<?php foreach ($proceso as $process): ?>

<form method="POST" action="/procesos/edit/<?=$process['id']?>" accept-charset="UTF-8" enctype="multipart/form-data">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <div class="modal fade" id="modalupdate<?=$process['id']?>" tabindex="-1" role="dialog" style="background-color:gray">
           <div class="modal-dialog" role="form">
               <div class="modal-content">
                   <div class="modal-header">
                       <h2 class="modal-title">¿Deseas actualizar el proceso?</h2>
                   </div>
                   <div class="modal-body">
           <div class="container">
               <div class="form-group form-group-lg">
                   <label for="tipo" class="control-label col-md-12" >
                       Tipo de Proceso:
                   </label>
                   <div class="col-md-6">
                       <select class="form-control input-lg" name="tipo" id="protipoproc">
                         <?php foreach ($tipoproceso as $tipoprocess): ?>
                           <option value="<?=$tipoprocess['nombreproceso']?>"> <?=$tipoprocess['nombreproceso']?> </option>
                         <?php endforeach ?>

                       </select>
                   </div>
               </div>

               <div class="form-group form-group-lg">
                   <h2><label for="Usuario" class="control-label col-md-12">Proceso:</label></h2>
                   <div class="col-md-6">
                       <input class="form-control input-lg" id="probproces" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50" value ="<?=$process['proceso']?>">
                   </div>
               </div>

               <div class="form-group form-group-lg">
                   <h2>
                   <label for="Usuario" class="control-label col-md-12">
                   Decripcion:
                   </label>
                   </h2>
                   <div class="col-md-6">
                       <textarea class="form-control input-lg" id = "prodescripcionproces" rows="3" placeholder="Descripcion del proceso" maxlength="255" name="descripcion"><?=$process['descripcion']?></textarea>
                   </div>
               </div>


               <div class="form-group form-group-lg">
                   <h2>
                   <label for="tipo" class="control-label col-md-12" >
                       Responsable:
                   </label>
                   </h2>
                   <div class="col-md-6">
                       <select class="form-control input-lg" name="usuario_responsable_id" id="proresponsableob">
                         <?php foreach ($User as $Users): ?>
                           <option value="<?=$Users['usuario']?>"> <?=$Users['usuario']?> </option>
                         <?php endforeach ?>
                       </select>
                   </div>
               </div>

               <div class="form-group form-group-lg">
                   <label for="tipo" class="control-label col-md-12" >
                       Revisado:
                   </label>
                   <div class="col-md-6">
                       <select class="form-control input-lg" name="rev" id="protipoOb">
                           <option value="1">Si</option>
                           <option value="0">No</option>
                       </select>
                   </div>
               </div>

               <div class="form-group form-group-lg">
                   <h2>
                   <label for="Usuario" class="control-label col-md-12">
                   Detalle de Revision:
                   </label>
                   </h2>
                   <div class="col-md-6">
                       <textarea class="form-control" id = "prodescripcionproce" rows="3" placeholder="Detalle de rev" name="detalle_de_rev" maxlength="255"><?=$process['detalle_de_rev']?> </textarea>
                   </div>
               </div>

               <div class="form-group form-group-lg">
                   <h2><label for="Usuario" class="control-label col-md-12">Archivo HTML: </br>
                     <div class="col-md-6">
                     <input class="form-control input-lg" id="probproces" type="Text" placeholder="nombredelarchivohtml" name="filetext" disabled="disabled" value ="<?=$process['archivo_html']?>">
                     <input class="form-control input-lg" id="probproces" type="file" accept=".zip" placeholder="<?=$process['archivo_html']?>" name="file" >
                   </div>
               </div>



       <div class="form-group form-group-lg">
        <h2><label for="Usuario" class="control-label col-md-12">Indicadores:</label></h2>
                   <div class="col-md-6">
                       <input class="form-control input-lg" id="probproces" type="Text" placeholder="Nombre del indicador" name="indicadores" maxlength="50" value="<?=$process['indicadores']?>">
                   </div>
               </div>


               <div class="form-group form-group-lg">
                   <h2><label for="Usuario" class="control-label col-md-12">Lista de distribucion:</label></h2>
                   <div class="col-md-6">
                       <input class="form-control input-lg" id="probproces" type="Text" placeholder="lista de distribucion" name="lista_de_distribucion" value="<?=$process['lista_de_distribucion']?>">
                   </div>
               </div>


         </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                       <button type="submit" value="file" class="btnobjetivo" id="btnaltaproceso" style="font-family: Arial;">Actualizar Proceso</button>
                   </div>
               </div>
           </div>
       </div>
     </div>
</form>

<?php endforeach ?>

<!--     aqui termina el formulario que edita -->


<!--aqui va la seccion de ajax que manda los datos al controlador-->

<script type="text/javascript">
/*
  $(document).ready(function(){
    $("#btnaltaobjetivo").on("click", function(){
      $.ajax({
        type:'post',
        url: '/store',
        data:{
          'txt_tipo_objetivo_id' : $("#tipo_objetivo_id").val(),
          'txt_nombre' : $("#nombre").val(),
          'txt_descripcion' : $("#descripcion").val(),
          'txt_fecha' : $("#fecha").val(),
          'txt_usuario_responsable_id' : $("#usuario_responsable_id").val(),
          //'txt_usuario_creador_id' : $("#usuario_creador_id").val()
        },
        succes: function(data){
          swal("Version pro!", "Se guardo correctamente",  "success");
        }
      });

    });
  });
  */
/*

*/
$(document).ready(function(){
$("#btnaltaproceso").on("click", function(){
  swal("Version pro!", "Se guardo correctamente",  "success");
});
});
</script>


@stop
