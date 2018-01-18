@extends('layouts.principal2')

@section('content')

<!-- Data Tables -->
<link href="/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
<link href="/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">


<!-- Data Tables-->
<script src="/js/plugins/dataTables/jquery-2.1.1.js"></script>
<script src="/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="/js/plugins/dataTables/dataTables.bootstrap.js"></script>

<style>
    body.DTTT_Print {
        background: #fff;

    }
    .DTTT_Print #page-wrapper {
        margin: 0;
        background:#fff;
    }

    button.DTTT_button, div.DTTT_button, a.DTTT_button {
        border: 1px solid #e7eaec;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }
    button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
        border: 1px solid #d2d2d2;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }

    .dataTables_filter label {
        margin-right: 5px;

    }
</style>



<script src="/js/EXCEL/src/jquery.table2excel.js"></script>

<script type="text/javascript">

function deletemod(){

  var x = confirm("Estas seguro de borrar la queja?");

  if (x){

    var route = "/quejas/delete/"+$("#id_q").val();
    $.get(route, function(res){
     location.reload();
    });

}

 return false;


}



function EditarQ(btn){
  var route = "/quejas/"+btn+"/edit";
  $.get(route, function(res){
    $("#id_q").val(res.id);
    $("#efecha_q").val(res.fecha);
    $('#earea_q option[value="' + res.area + '"]').attr("selected", "selected");
    $('#eproceso_id_q option[value="' + res.proceso + '"]').attr("selected", "selected");
    $('#eproducto_id_q option[value="' + res.producto + '"]').attr("selected", "selected");
    $("#emonto_q").val(res.monto);
    $('#ecliente_id_q option[value="' + res.cliente_id + '"]').attr("selected", "selected");
    $("#edescripcion_q").val(res.descripcion);
    $("#earchivoa_q").val(res.archivoqueja);
    $('#eresponsable_q option[value="' + res.usuario_responsable_id + '"]').attr("selected", "selected");
    $("#eacciones_q").val(res.acciones);
    $("#efecha_plan_q").val(res.fecha_plan);
    $("#eevidencia_q").val(res.evidencia);
    $("#earchivoa2_q").val(res.archivoevidencia);
    $("#efecha_cierre_q").val(res.fecha_cierre);
    $('#estatus_id_q option[value="' + res.estatus_id + '"]').attr("selected", "selected");


    $("#evidenciaQuejaMod").attr("href","/storage/quejas/" + res.uniquearchivoqueja );
    $("#evidenciaQuejaMod").attr("downloadFile", res.uniquearchivoqueja  );

    $("#archivoEvidenciaQueja").attr("href","/storage/quejas/"+res.uniquearchivoevidencia );
    $("#archivoEvidenciaQueja").attr("downloadFile",res.uniquearchivoevidencia);

    $("#fileinfo_q").attr("action","/quejas/edit/" + res.id );
  });

}





$(document).ready(function(){


    $('.dataTables-example').dataTable({
      responsive: true,
      "dom": 'T<"clear">lfrtip',
      "tableTools": {
          "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
      }
    });



  $("#excel").click(function(){
  $("#datos").table2excel({
    filename: "Reporte",
    fileext:".xls"
  });
  });



  $("#actualizarq").click(function(){
    var value = $("#id_q").val();
    var route = "/quejas/edit/"+value+"";
    var token = $("#token").val();
    var fd = new FormData(document.getElementById("fileinfo_q"));

    $.ajax({
      url: route,
      headers: {'X-CSRF_TOKEN': token},
      type: 'post',
      data: fd,
      processData: false,  // tell jQuery not to process the data
      contentType: false,
      success: function(){
        alert("Cambios guardados correctamente");
        location.reload();
      }
    });
  });

});


</script>
@if(Session::has('flash_message'))
<script>
alert ('{{Session::get('flash_message')}}')
</script>
@endif
<br><br><br><br><br>
<br><br>

    <!-- <center><MARQUEE WIDTH=50% HEIGHT=60> Este apartado es para quejas</MARQUEE></center> -->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
                <ol class="breadcrumb iso-breadcumb">
                    <li><a href="/mejoras" style='color:#FFF'> Quejas</a></li>
                    <li class="active">Version pro</li>
                </ol>
            </h2>
        </div>
    </div>
  <!--
  primer boton
    <div class="row">
        <div class="col-lg-12 text-right">
            <center>
            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i> Subir Queja</button>
            </center>
        </div>
    </div>
  -->
  <br>

  <div id="msg">

  </div>

  <div class="col-lg-12 text-lefth">
      <button type="button" class="btn btn-success" id="excel">Excel</button>
      <br>
  </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Quejas
                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-floppy-save"></i></button>
                </div>
            <div class="panel-body">
              <div class="table-responsive">

                <div class="dataTable_wrapper">
                    <table width="100%"  class="table table-striped table-bordered table-hover dataTables-example" id="datos">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th><div class="th-inner sortable both">  ID</div></th>
                          <th><div class="th-inner sortable both">  fecha</div></th>
                          <th><div class="th-inner sortable both">  Responsable</div></th>
                          <th><div class="th-inner sortable both">  Descripcion</div></th>
                          <th><div class="th-inner sortable both">  Cliente</div></th>
                          <th><div class="th-inner sortable both">  Fecha compromiso</div></th>
                          <th><div class="th-inner sortable both">  Status</div></th>

                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody id = "myTable">
                        <?php foreach ($relaciontabla as $queja): ?>
                          <tr class="gradeX" data-toggle="modal" data-target="#modaleditq" onclick="EditarQ(<?=$queja->id?>);"> <strong>
                          <td> <?=$queja->id?> </td>
                          <td> <?=$queja->fecha?> </td>
                          <td> <?=$queja->usernombre?> </td>
                          <td> <?=$queja->descripcion?> </td>
                          <td> <?=$queja->clientenombre?> </td>
                          <td> <?=$queja->fecha_plan?> </td>
                          <td> <?=$queja->statusnombre?> </td>
                        </strong>
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
    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h3 class="modal-title">ALTA DE QUEJA</h3>
                </div>
                <div class="modal-body">
                  <form  action="/quejas/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                      <input type="hidden" name="id_compania" value="{{Auth::user()->id_compania}}">
                      <input type="hidden" name="status_id" id="status_id" value="1">
                      <input type="hidden" name="creador_id" id="creador_id" value="{{Auth::user()->id}}">
                      
                    <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Fecha:</label></h3>
                      <input class="form-control input-lg"  type="date" placeholder="Fecha" name="fecha" required="">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Area:</label></h3>
                          <select class="form-control input-lg" name="area" required="">
                            <option value=""></option>
                            <?php foreach ($area as $areas): ?>
                              <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                            <?php endforeach ?>
                          </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Proceso:</label></h3>
                          <select class="form-control input-lg" name="proceso_id">
                            <option value=""></option>
                            <?php foreach ($proceso as $procesos): ?>
                              <option value="<?=$procesos['id']?>"><?=$procesos['proceso']?></option>
                            <?php endforeach ?>
                          </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Producto:</label></h3>
                          <select class="form-control input-lg" name="producto_id">
                            <option value=""></option>
                            <?php foreach ($productos as $producto): ?>
                              <option value="<?=$producto['id']?>"><?=$producto['nombre']?></option>
                            <?php endforeach ?>
                          </select>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <h3><label>Monto:</label></h3>
                            <input class="form-control input-lg" type="text" placeholder="monto" name="monto">
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-5">
                        <h3><label>Cliente:</label></h3>
                          <select class="form-control input-lg" name="cliente_id" required="">
                            <option value=""></option>
                            <?php foreach ($cliente as $clientes): ?>
                              <option value="<?=$clientes['id']?>"><?=$clientes['nombre']?></option>
                            <?php endforeach ?>
                          </select>
                    </div>


                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label>Decripcion de queja:</label></h3>
                            <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Descripcion de la queja" name="descripcion" required=""></textarea>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <h3><label>Archivo de evidencia de queja:</label></h3>
                            <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo1">
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <h3><label>Responsable:</label></h3>
                            <select class="form-control input-lg" name="responsable" required="">
                              <option value=""></option>
                              <?php foreach ($User as $Users): ?>
                                <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label>Acciones:</label></h3>
                            <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Acciones tomadas" name="acciones"></textarea>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <h3><label>Fecha compromiso:</label></h3>
                          <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha_plan">
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <h3><label>Evidencia:</label></h3>
                        <input class="form-control input-lg" id="probproces" type="text" placeholder="evidencia" name="evidencia">
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <h3><label>Archivo de evidencia:</label></h3>
                            <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo2">
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <h3><label>Fecha Cierre:</label></h3>
                      <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha_cierre">
                    </div>

              </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btnaltaindicador" style="font-family: Arial;"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
    </div>



<!-- modal para update -->
<div class="modal fade" id="modaleditq" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title">EDITAR QUEJA</h3>
            </div>
            <div class="modal-body">
              <form id="fileinfo_q"  method="post" accept-charset="UTF-8" enctype="multipart/form-data" action="">
                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <input type="hidden" id="id_q">
                <div class="row">
                  <div class="col-lg-4 col-md-4 col-sm-4">
                    <h3><label>Fecha:</label></h3>
                    <input class="form-control input-lg"  type="date" placeholder="Fecha" name="efecha_q"  id="efecha_q" required="">
                  </div>

                  <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Area:</label></h3>
                        <select class="form-control input-lg" name="earea_q" id="earea_q" required="">
                          <option value=""></option>
                          <?php foreach ($area as $areas): ?>
                            <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                          <?php endforeach ?>
                        </select>
                  </div>

                  <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Proceso:</label></h3>
                        <select class="form-control input-lg" name="eproceso_id_q" id="eproceso_id_q">
                          <option value=""></option>
                          <?php foreach ($proceso as $procesos): ?>
                            <option value="<?=$procesos['id']?>"><?=$procesos['proceso']?></option>
                          <?php endforeach ?>
                        </select>
                  </div>

                  <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Producto:</label></h3>
                        <select class="form-control input-lg" name="eproducto_id_q"  id="eproducto_id_q">
                          <option value=""></option>
                          <?php foreach ($productos as $producto): ?>
                            <option value="<?=$producto['id']?>"><?=$producto['nombre']?></option>
                          <?php endforeach ?>
                        </select>
                  </div>

                  <div class="col-lg-3 col-md-3 col-sm-3">
                      <h3><label>Monto:</label></h3>
                          <input class="form-control input-lg" type="text" placeholder="monto" name="emonto_q" id="emonto_q">
                  </div>

                  <div class="col-lg-5 col-md-5 col-sm-5">
                      <h3><label>Cliente:</label></h3>
                        <select class="form-control input-lg" name="ecliente_id_q"  id="ecliente_id_q" required="">
                          <option value=""></option>
                          <?php foreach ($cliente as $clientes): ?>
                            <option value="<?=$clientes['id']?>"><?=$clientes['nombre']?></option>
                          <?php endforeach ?>
                        </select>
                  </div>


                  <div class="col-lg-12 col-md-12 col-sm-12">
                      <h3><label>Decripcion de queja:</label></h3>
                          <textarea class="form-control" rows="3" placeholder="Descripcion de la queja" name="edescripcion_q" id="edescripcion_q" required=""></textarea>
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-6">
                      <h3><label>Archivo de evidencia de queja:</label></h3>
                      <a id="evidenciaQuejaMod" href="" downloadFile="" style='color:#FFF' title="Ver archivo" target="_blank"> <input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="earchivoa_q" id="earchivoa_q" > </a>
                      <input class="file" id="file-1" type="file" placeholder="Archivo" name="earchivo1_q">
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-6">
                      <h3><label>Responsable:</label></h3>
                          <select class="form-control input-lg" name="eresponsable_q" id="eresponsable_q" required="">
                            <option value=""></option>
                            <?php foreach ($User as $Users): ?>
                              <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                            <?php endforeach ?>
                          </select>
                  </div>

                  <div class="col-lg-12 col-md-12 col-sm-12">
                      <h3><label>Acciones:</label></h3>
                          <textarea class="form-control" rows="3" placeholder="Acciones tomadas" name="eacciones_q" id="eacciones_q"></textarea>
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <h3><label>Fecha compromiso:</label></h3>
                        <input class="form-control input-lg" type="date" placeholder="Fecha" name="efecha_plan_q" id="efecha_plan_q">
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-6">
                      <h3><label>Evidencia:</label></h3>
                      <input class="form-control input-lg" type="text" placeholder="evidencia" name="eevidencia_q" id="eevidencia_q">
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-6">
                      <h3><label>Archivo de evidencia:</label></h3>
                      <a id="archivoEvidenciaQueja" href="" downloadFile="" style='color:#FFF' title="Ver archivo" target="_blank"> <input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="earchivoa2_q" id="earchivoa2_q" ></a>
                      <input class="file" id="file-1" type="file" placeholder="Archivo" name="earchivo2_q">
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <h3><label>Fecha Cierre:</label></h3>
                    <input class="form-control input-lg" type="date" placeholder="Fecha" name="efecha_cierre_q" id="efecha_cierre_q">
                  </div>

                  <div class="col-lg-12 col-md-12 col-sm-12">
                      <h3><label>Status:</label></h3>
                          <select class="form-control input-lg" name="estatus_id_q" id="estatus_id_q">
                            <?php foreach ($estatus as $estatuses): ?>
                              <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                            <?php endforeach ?>
                          </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" id=""  class="btn btn-danger" onclick="deletemod();"><i class="fa fa-trash"></i><br>Eliminar</button>
                  <button type="submit" id="actualizarq"  class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i><br>Editar</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
</div>
<!-- termina modal para update -- >


@stop
