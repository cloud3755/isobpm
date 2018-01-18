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
@if(Session::has('flash_message'))
<script>
alert ('{{Session::get('flash_message')}}')
</script>
@endif

<br><br><br><br><br><br><br><br>
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
                <ol class="breadcrumb iso-breadcumb">
                    <li><a href="/mejoras" downloadFile="58e66b9a4f84c.pdf" style='color:#FFF'> Acciones correctivas</a></li>
                </ol>
            </h2>
        </div>
    </div>
    <!--
    <div class="row">
        <div class="col-lg-12 text-right">
            <center>
            <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i> Subir Accion</button>
            </center>
        </div>
    </div>
  -->
    <br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Accion
                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-floppy-save"></i></button>
                </div>
            <div class="panel-body">
              <div class="table-responsive">

                <div class="dataTable_wrapper">
                    <table width="100%"  class="table table-striped table-bordered table-hover dataTables-example" id="datos">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th><div class="th-inner sortable both">  ID</div></th>
                          <th><div class="th-inner sortable both">  fecha alta</div></th>
                          <th><div class="th-inner sortable both">  Descripcion</div></th>
                          <th><div class="th-inner sortable both">  Responsable</div></th>
                          <th><div class="th-inner sortable both">  Fecha de accion</div></th>

                          <th><div class="th-inner sortable both">  Status</div></th>
                          <th><div class="th-inner sortable both">  Subir evidencia</div></th>

                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody id = "myTable">
                        <?php foreach ($relaciontabla as $accioncorrectivas): ?>
                        <tr class="gradeX"> <strong>
                          <td data-toggle="modal" data-target="#modaledit" onclick="Editar(<?=$accioncorrectivas->id?>);" title="Editar"> <?=$accioncorrectivas->id?> </td>
                          <td data-toggle="modal" data-target="#modaledit" onclick="Editar(<?=$accioncorrectivas->id?>);" title="Editar"> <?=$accioncorrectivas->fechaalta?> </td>
                          <td data-toggle="modal" data-target="#modaledit" onclick="Editar(<?=$accioncorrectivas->id?>);" title="Editar"> <?=$accioncorrectivas->descripcion?> </td>
                          <td data-toggle="modal" data-target="#modaledit" onclick="Editar(<?=$accioncorrectivas->id?>);" title="Editar"> <?=$accioncorrectivas->usernombre?> </td>
                          <td data-toggle="modal" data-target="#modaledit" onclick="Editar(<?=$accioncorrectivas->id?>);" title="Editar"> <?=$accioncorrectivas->fechaaccion?> </td>
                          <td data-toggle="modal" data-target="#modaledit" onclick="Editar(<?=$accioncorrectivas->id?>);" title="Editar"> <?=$accioncorrectivas->statusnombre?> </td>
                        <td></a>

            <!-- se creara un bucle para generar los n modales necesarios para la edicion de datos -->
                          <form class="" action="/subirevidencia/evidencia/<?=$accioncorrectivas->id?>">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                            <input type="hidden" name="responsable_id" value="<?=$accioncorrectivas->responsable_id?>">
                              <button type="submit" class="btn btn-info" ><i class="glyphicon glyphicon-pencil"></i></button>
                          </form>
                        </td>
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
                    <h2 class="modal-title">ALTA DE ACCION CORRECTIVA</h2>
                </div>
                <div class="modal-body">
                    <form  action="/accioncorrectiva/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                      <input type="hidden" name="creador_id" value="{{Auth::user()->id}}">
                      <input type="hidden" name="id_compania" value="{{Auth::user()->id_compania}}">
                      <input type="hidden" name="estatus_id" id="estatus_id" value="1">

                    <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Fecha Alta:</label></h3>
                          <input class="form-control input-lg" id="fechaalta" type="date" placeholder="Fecha" name="fechaalta" required="">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Indicador:</label></h3>
                            <select class="form-control input-lg" name="indicador_id" id="indicador_id">
                              <option value=""></option>
                              <?php foreach ($indicador as $indicadores): ?>
                                <option value="<?=$indicadores->id?>"><?=$indicadores->nombre?></option>
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
                            <?php foreach ($producto as $productos): ?>
                              <option value="<?=$productos['id']?>"><?=$productos['nombre']?></option>
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

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Monto:</label></h3>
                            <input class="form-control input-lg" type="text" placeholder="monto" name="monto">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Documento:</label></h3>
                            <input class="form-control input-lg" id="documento" type="Text" placeholder="S/N" name="documento" >
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <h3><label>Archivo de Accion correctiva:</label></h3>
                            <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo1">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label> Decripcion:</label></h3>
                            <textarea class="form-control" id = "descripcion" rows="3" placeholder="Descripcion de la accion correctiva" name="descripcion" required=""></textarea>
                    </div>


                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Responsable:</label></h3>
                            <select class="form-control input-lg" name="responsable_id" id="responsable_id" required="">
                              <?php foreach ($User as $Users): ?>
                                <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <h3><label for="Usuario" class="control-label col-md-12">
                        Analisis de causa
                        </label></h3>
                            <textarea class="form-control" id = "porque1" rows="3" placeholder="Acciones tomadas" name="analisis"></textarea>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label>
                        Accion correctiva
                        </label></h3>
                            <textarea class="form-control" id = "accion" rows="3" placeholder="Acciones tomadas" name="accioncorrectiva"></textarea>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h3><label>Fecha Accion:</label></h3>
                          <input class="form-control input-lg" id="fechaaccion" type="date" placeholder="Fecha" name="fechaaccion">
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <h3>
                        <label>
                          Evidencia de accion correctiva:
                        </label>
                        </h3>
                            <textarea class="form-control" id = "respuestaaccion" rows="3" placeholder="Acciones tomadas" name="evidenciaaccion"></textarea>
                    </div>

                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <h3><label for="tipo" class="control-label col-md-12" >Archivo de evidencia:</label></h3>
                            <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo2">
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-5">
                      <h3><label for="fecha requerimiento" class="control-label col-md-12">Fecha Cierre:</label></h3>
                          <input class="form-control input-lg" id="fechacierre" type="date" placeholder="Fecha" name="fechacierre">
                    </div>
        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btnaltaindicador" style="font-family: Arial;"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</button>
                    </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>


    <!--Modulo de Editar -->
    <div class="modal fade" id="modaledit" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h3 class="modal-title">ACTUALIZAR ACCION CORRECTIVA</h3>
                </div>
                <div class="modal-body">
                  <form id="fileinfo" method="post" accept-charset="UTF-8" enctype="multipart/form-data" action="" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                    <input type="hidden" id="id">
                    <input type="hidden" id="creador" value="{{ Auth::user()->id }} ">
                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-4">
                            <h2><label for="Usuario" class="control-label">Fecha Alta:</label></h2>
                                <input class="form-control input-lg" id="efechaalta" type="date" name="efechaalta" required>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <h2><label>Indicador:</label></h2>
                                <select class="form-control input-lg" name="eindicador_id" id="eindicador_id" required="">
                                  <option value=""></option>
                                  <?php foreach ($indicador as $indicadores): ?>
                                    <option value="<?=$indicadores->id?>"><?=$indicadores->nombre?></option>
                                  <?php endforeach ?>
                                </select>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <h2><label>Proceso:</label></h2>
                                <select class="form-control input-lg" name="eproceso_id" id="eproceso_id" required="">
                                  <option value=""></option>
                                  <?php foreach ($proceso as $procesos): ?>
                                    <option value="<?=$procesos['id']?>"><?=$procesos['proceso']?></option>
                                  <?php endforeach ?>
                                </select>
                        </div>


                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <h2><label>Producto:</label></h2>
                                <select class="form-control input-lg" name="eproducto_id" id="eproducto_id" required="">
                                  <option value=""></option>
                                  <?php foreach ($producto as $productos): ?>
                                    <option value="<?=$productos['id']?>"><?=$productos['nombre']?></option>
                                  <?php endforeach ?>
                                </select>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <h2><label>Area:</label></h2>
                                <select class="form-control input-lg" name="eid_area" id="eid_area" required="">
                                  <option value=""></option>
                                  <?php foreach ($area as $areas): ?>
                                    <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                                  <?php endforeach ?>
                                </select>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <h2><label>Monto:</label></h2>
                            <input class="form-control input-lg" type="text" placeholder="Monto" name="emonto" id="emonto">
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <h2><label>Documento:</label></h2>
                                <input class="form-control input-lg" id="edocumento" type="Text" placeholder="S/N" name="edocumento" >
                        </div>

                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <h3><label>Archivo de Accion correctiva:</label></h3>
                                <a id="earchivoaa" href="" downloadFile="" style='color:#FFF' title="Ver archivo" target="_blank"><input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="earchivoa" id="earchivoa" ></a>
                                <input class="file" type="file" placeholder="Archivo" name="archivoa" id="archivoa">
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h2><label> Decripcion:</label></h2>
                                <textarea class="form-control" id = "edescripcion" rows="3" placeholder="Descripcion de la accion correctiva" name="edescripcion" required=""></textarea>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <h2><label>Responsable:</label></h2>
                                <select class="form-control input-lg" name="eresponsable_id" id="eresponsable_id" required="">
                                  <?php foreach ($User as $Users): ?>
                                    <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                                  <?php endforeach ?>
                                </select>
                        </div>

                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <h2><label for="Usuario" class="control-label col-md-12">
                            Analisis de causa
                          </label></h2>
                                <textarea class="form-control" id = "eanalisis" rows="3" placeholder="Acciones tomadas" name="eanalisis"></textarea>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h2><label>
                            Accion correctiva
                          </label></h2>
                                <textarea class="form-control" id = "eaccioncorrectiva" rows="3" placeholder="Acciones tomadas" name="eaccioncorrectiva"></textarea>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h2><label>Fecha Accion:</label></h2>
                              <input class="form-control input-lg" id="efechaaccion" type="date" placeholder="Fecha" name="efechaaccion">
                        </div>

                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <h2>
                            <label>
                              Evidencia de accion correctiva:
                            </label>
                          </h2>
                                <textarea class="form-control" id = "eevidenciaaccion" rows="3" placeholder="Acciones tomadas" name="eevidenciaaccion"></textarea>
                        </div>

                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <h2><label>Archivo de evidencia:</label></h2>
                                  <a id="earchivoea" href="" downloadFile="" style='color:#FFF' title="Ver archivo" target="_blank"> <input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="earchivoe" id="earchivoe" > </a>
                                <input class="file" type="file" placeholder="Archivo" name="archivoe" id="archivoe">
                        </div>


                        <div class="col-lg-5 col-md-5 col-sm-5">
                          <h2><label for="Usuario" class="control-label">Fecha Cierre:</label></h2>
                              <input class="form-control input-lg" id="efechacierre" type="date" name="efechacierre" required>
                        </div>

                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h2><label>Status:</label></h2>
                              <select class="form-control input-lg" name="eestatus" id="eestatus" required="">
                                <?php foreach ($estatus as $estatuses): ?>
                                  <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                                <?php endforeach ?>
                              </select>
                      </div>

                    </div>
                    <div class="modal-footer">
                      <!--<button type="button" id=""  class="btn btn-danger" onclick="deletemod();"><i class="fa fa-trash"></i><br>Eliminar</button>-->
                      <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i><br>Editar</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                    </div>
                  </form>
                </div>
            </div>
          </div>
    </div>


    <script type="text/javascript">


    function deletemod(){

      var x = confirm("Estas seguro de borrar la accion correctiva?");

      if (x){

        var route = "/quejas/delete/"+$("#id").val();
        $.get(route, function(res){
         location.reload();
        });

    }

     return false;


    }


    function Editar(btn){
      var route = "/accioncorrectiva/"+btn+"/edit";
      $.get(route, function(res){
        $("#efechaalta").val(res.fechaalta);
        $('#eindicador_id option[value="' + res.indicador_id + '"]').attr("selected", "selected");
        $('#eproceso_id option[value="' + res.id_proceso + '"]').attr("selected", "selected");
        $('#eproducto_id option[value="' + res.producto_id + '"]').attr("selected", "selected");
        $('#eid_area option[value="' + res.area + '"]').attr("selected", "selected");
        $("#emonto").val(res.monto);
        $("#edocumento").val(res.documento);
        $("#earchivoa").val(res.porque2);
        $("#edescripcion").val(res.descripcion);
        $('#eresponsable_id option[value="' + res.responsable_id + '"]').attr("selected", "selected");
        $("#eanalisis").val(res.porque1);
        $("#eaccioncorrectiva").val(res.accioncorrectiva);
        $("#efechaaccion").val(res.fechaaccion);
        $("#eevidenciaaccion").val(res.respuestaaccion);

        $("#earchivoe").val(res.evidencia);
        $("#efechacierre").val(res.fechacierre);
        $("#id").val(res.id);
        $('#eestatus option[value="' + res.estatus_id + '"]').attr("selected", "selected");

        var creador = document.getElementById('creador').value;

        if (creador == res.responsable_id) {
          $("#efechaalta").attr('disabled','disabled');
          $("#eindicador_id").attr('disabled','disabled');
          $("#eproceso_id").attr('disabled','disabled');
          $("#eproducto_id").attr('disabled','disabled');
          $("#eid_area").attr('disabled','disabled');
          $("#emonto").attr('disabled','disabled');
          $("#edocumento").attr('disabled','disabled');
          $("#archivoa").attr('disabled','disabled');
          $("#edescripcion").attr('disabled','disabled');
          $("#eresponsable_id").attr('disabled','disabled');
          $("#efechacierre").attr('disabled','disabled');
          $("#eestatus").attr('disabled','disabled');
        }

        $("#earchivoaa").attr("href","/storage/accioncorrectiva/" + res.uniquedocumento );
        $("#earchivoaa").attr("downloadFile", res.uniquedocumento  );

        $("#earchivoea").attr("href","/storage/accioncorrectiva/"+res.uniqueevidencia );
        $("#earchivoea").attr("downloadFile",res.uniqueevidencia);

        $("#fileinfo").attr("action","/accioncorrectiva/edit/" + res.id );


      });

    }






    $(document).ready(function(){

      $("#fileinfo").submit(function(e) {
        e.preventDefault();

          $("#fileinfo").find('input, textarea, button, select').prop('disabled', false);

         this.submit();
     });



      $('.dataTables-example').dataTable({
        responsive: true,
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
        }
      });


      $("#actualizar").click(function(){
        var value = $("#id").val();
        var route = "/accioncorrectiva/edit/"+value+"";
        var token = $("#token").val();
        var fd = new FormData(document.getElementById("fileinfo"));

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
@stop
