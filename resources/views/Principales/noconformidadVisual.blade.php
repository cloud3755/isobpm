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

function EditarNC(btn){

  var route = "/noconformidad/"+btn+"/edit";
  $.get(route, function(res){
    $("#btnpro").hide();

    $("#id_nc").val(res.id);
    $("#fecha_nc").val(res.fecha);
    $('#proceso_id_nc option[value="' + res.proceso_id + '"]').attr("selected", "selected");
    $('#producto_id_nc option[value="' + res.producto_id + '"]').attr("selected", "selected");
    $('#id_area_nc option[value="' + res.id_area + '"]').attr("selected", "selected");
    $("#archivoa_nc").val(res.evidenciapertura);
    $("#documento_nc").val(res.documento);
    $("#descripcion_nc").val(res.descripcion);
    $("#acciones_nc").val(res.acciones);
    $('#usuario_responsable_id_nc option[value="' + res.usuario_responsable_id + '"]').attr("selected", "selected");
    $("#fecha_plan_nc").val(res.fecha_plan);
    $("#archivob_nc").val(res.evidencia);
    $("#fecha_cierre_nc").val(res.fecha_cierre);
    $('#estatus_id_nc option[value="' + res.estatus_id + '"]').attr("selected", "selected");
    $("#monto_nc").val(res.monto);

    $("#evidenciaNCMod").attr("href","/storage/noconformidad/" + res.apertura_unic );
    $("#evidenciaNCMod").attr("downloadFile",res.apertura_unic );

    $("#evidenciaCierreMod").attr("href","/storage/noconformidad/" + res.evidencia_unic );
    $("#evidenciaCierreMod").attr("downloadFile",res.evidencia_unic);

  $("#fileinfo_nc").attr("action","/noconformidad/edit/" + res.id );

    if($("#id_ufr").val() != res.usuario_responsable_id ){
       $("#btnpro").show();
      }

  });

}

function deletemod(){

  var x = confirm("Estas seguro de borrar la no conformidad?");

  if (x){

    var route = "/noconformidad/delete/"+$("#id_nc").val();
    $.get(route, function(res){
     location.reload();
    });

}

 return false;


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
      filename: "ReporteNC",
      fileext:".xls"
    });
    });


  $("#actualizar_nc").click(function(){
    var value = $("#id_nc").val();
    var route = "/noconformidad/edit/"+value+"";
    var token = $("#token").val();
    var fd = new FormData(document.getElementById("fileinfo_nc"));

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
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
                <ol class="breadcrumb iso-breadcumb">
                    <li><a href="/mejoras" style='color:#FFF'> No Conformidad</a></li>
                    <li class="active">Version pro</li>
                </ol>
            </h2>
        </div>
    </div>
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
                    No conformidades
                    <button type="button" class="btn btn-success btn-xs" id="" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-floppy-save"></i></button>
                </div>
            <div class="panel-body">
              <div class="table-responsive">

                <div class="dataTable_wrapper">
                    <table width="100%" class="table table-striped table-bordered table-hover dataTables-example" id="datos">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th>  <div class="th-inner sortable both">    id  </div></th>
                          <th>  <div class="th-inner sortable both">    fecha  </div></th>
                          <th>  <div class="th-inner sortable both">    Descripcion  </div></th>
                          <th>  <div class="th-inner sortable both">    Responsable  </div></th>
                         <th>  <div class="th-inner sortable both">    Fecha Plan  </div></th>

                          <th>  <div class="th-inner sortable both">    Fecha cierre  </div></th>
                          <th>  <div class="th-inner sortable both">    Status  </div></th>
                          <th>  <div class="th-inner sortable both">    Creador  </div></th>

                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody id = "myTable">
                        <?php foreach ($relaciontabla as $noconformidad): ?>
                        <tr class="gradeX" data-toggle="modal" data-target="#modaledit_nc" ondblclick="EditarNC(<?=$noconformidad->id?>);"> <strong>
                          <td>  <?=$noconformidad->id?> </td>
                          <td>  <?=$noconformidad->fecha?> </td>
                          <td>  <?=$noconformidad->descripcion?></td>
                          <td>  <?=$noconformidad->usuarionombre?></td>
                          <td>  <?=$noconformidad->fecha_plan?></td>

                          <td>  <?=$noconformidad->fecha_cierre?></td>
                          <td>  <?=$noconformidad->estatusnombre?></td>
                          <td>  <?=$noconformidad->creador?></td>

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
                    <h2 class="modal-title">ALTA DE NO CONFORMIDADES</h2>
                </div>
                <div class="modal-body">
                    <form  action="/noconformidad/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                      <input type="hidden" name="id_area" value="{{ Auth::user()->id_area }}">
                      <input type="hidden" name="id_compania" value="{{Auth::user()->id_compania}}">
                      <input type="hidden" name="id_ufr" id="id_ufr" value="{{Auth::user()->id}}">
                      <input type="hidden" name="estatus_id" id="estatus_id" value="1">

                    <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Fecha:</label></h3>
                          <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha" required="">
                    </div>

                      <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Proceso:</label></h3>
                          <select class="form-control input-lg" name="proceso_id" id="proceso_id">
                            <option value="50"></option>
                            <?php foreach ($Proceso as $Procesos): ?>
                              <option value="<?=$Procesos['id']?>"><?=$Procesos['proceso']?></option>
                            <?php endforeach ?>
                          </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Producto:</label></h3>
                          <select class="form-control input-lg" name="producto_id" id="producto_id">
                            <option value="21"></option>
                            <?php foreach ($Producto as $Productos): ?>
                              <option value="<?=$Productos['id']?>"><?=$Productos['nombre']?></option>
                            <?php endforeach ?>
                          </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Area:</label></h3>
                            <select class="form-control input-lg" name="id_area" id="id_area">
                              <option value="2"></option>
                              <?php foreach ($area as $areas): ?>
                                <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <h3><label>Evidencia no conformidad:</label></h3>
                            <input class="form-control input-lg" id="documento" type="file" placeholder="evidenciapertura" name="archivo1">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label>Documento:</label></h3>
                            <input class="form-control input-lg" id="documento" type="text" placeholder="Documento" name="documento">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label> Decripcion:</label></h3>
                            <textarea class="form-control" id = "descripcion" rows="3" name="descripcion" placeholder="Descripcion No conformidad" required=""></textarea>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label> Acciones:</label></h3>
                            <textarea class="form-control" id = "acciones" name = "acciones" rows="3" placeholder="Acciones a Realizar"></textarea>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Responsable:</label></h3>
                            <select class="form-control input-lg" name="usuario_responsable_id" id="usuario_responsable_id" required="">
                              <option value=""></option>
                              <?php foreach ($User as $Users): ?>
                                <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Fecha plan:</label></h3>
                          <input class="form-control input-lg" id="fecha_plan" type="date" placeholder="Fecha del Plan" name="fecha_plan">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Evidencia de cierre:</label></h3>
                            <input class="form-control input-lg" id="evidencia" type="file" placeholder="Evidencia del cierre" name="archivo2">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Fecha Cierre:</label></h3>
                          <input class="form-control input-lg" id="fecha_cierre" type="date" placeholder="Fecha para el cierre" name="fecha_cierre">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Monto:</label></h3>
                          <input class="form-control input-lg" id="monto" type="text" placeholder="Monto de la no conformidad" name="monto" required="">
                    </div>
        </div>


                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success" id="btnaltaindicador" style="font-family: Arial;" ><i class="glyphicon glyphicon-floppy-save"><br>Agregar</i></button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
    </div>

    <div class="modal fade" id="modaledit_nc" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h2 class="modal-title">EDITAR NO CONFORMIDADES</h2>
                </div>
                <div class="modal-body">
                    <form id="fileinfo_nc" method="post" accept-charset="UTF-8" enctype="multipart/form-data" action="">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                      <input type="hidden" id="id_nc">
                    <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Fecha:</label></h3>
                          <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha_nc" id="fecha_nc" required="">
                    </div>

                      <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Proceso:</label></h3>
                          <select class="form-control input-lg" name="proceso_id_nc" id="proceso_id_nc">
                            <option value="50"></option>
                            <?php foreach ($Proceso as $Procesos): ?>
                              <option value="<?=$Procesos['id']?>"><?=$Procesos['proceso']?></option>
                            <?php endforeach ?>
                          </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Producto:</label></h3>
                          <select class="form-control input-lg" name="producto_id_nc" id="producto_id_nc">
                            <option value="21"></option>
                            <?php foreach ($Producto as $Productos): ?>
                              <option value="<?=$Productos['id']?>"><?=$Productos['nombre']?></option>
                            <?php endforeach ?>
                          </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Area:</label></h3>
                            <select class="form-control input-lg" name="id_area_nc" id="id_area_nc">
                              <option value="2"></option>
                              <?php foreach ($area as $areas): ?>
                                <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <h3><label>Evidencia no conformidad:</label></h3>

                        <a id="evidenciaNCMod" href="" downloadFile="" style='color:#FFF' title="Ver archivo" target="_blank"><input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="archivoa_nc" id="archivoa_nc" > </a>
                        <input class="file" id="archivo1_nc" type="file" placeholder="Archivo" name="archivo1_nc">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label>Documento:</label></h3>
                            <input class="form-control input-lg" id="documento_nc" type="text" placeholder="Documento" name="documento_nc">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label> Decripcion:</label></h3>
                            <textarea class="form-control" id = "descripcion_nc" rows="3" name="descripcion_nc" placeholder="Descripcion No conformidad" required=""></textarea>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label> Acciones:</label></h3>
                            <textarea class="form-control" id = "acciones_nc" name = "acciones_nc" rows="3" placeholder="Acciones a Realizar"></textarea>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Responsable:</label></h3>
                            <select class="form-control input-lg" name="usuario_responsable_id_nc" id="usuario_responsable_id_nc" required="">
                              <option value=""></option>
                              <?php foreach ($User as $Users): ?>
                                <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Fecha plan:</label></h3>
                          <input class="form-control input-lg" id="fecha_plan_nc" type="date" placeholder="Fecha del Plan" name="fecha_plan_nc">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Evidencia de cierre:</label></h3>
                        <a id="evidenciaCierreMod" href="" downloadFile="" style='color:#FFF' title="Ver archivo" target="_blank"><input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="archivob_nc" id="archivob_nc" ></a>
                        <input class="file" id="archivo2_nc" type="file" placeholder="Evidencia del cierre" name="archivo2_nc">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Fecha Cierre:</label></h3>
                          <input class="form-control input-lg" id="fecha_cierre_nc" type="date" placeholder="Fecha para el cierre" name="fecha_cierre_nc">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Status:</label></h3>
                            <select class="form-control input-lg" name="estatus_id_nc" id="estatus_id_nc">
                              <?php foreach ($estatus as $estatuses): ?>
                                <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Monto:</label></h3>
                          <input class="form-control input-lg" id="monto_nc" type="text" placeholder="Monto de la no conformidad" name="monto_nc" required="">
                    </div>
        </div>


                        <div class="modal-footer">
           <button type="button" class="btn btn-danger" id="btnpro" style="font-family: Arial;" onclick="deletemod();"><i class="fa fa-trash"></i><br>Borrar</button>

                         <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i><br>Editar</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                        </div>
                      </form>




                    </div>
                </div>
            </div>
    </div>

@stop
