@extends('layouts.principal2')

@section('content')
<script src="/js/EXCEL/src/jquery.table2excel.js"></script>

<script type="text/javascript">

function EditarNC(btn){
  var route = "/noconformidad/"+btn.value+"/edit";
  $.get(route, function(res){
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

  });

}



//Funciones para la tabla
$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 7,
            showPrevNext: false,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);

    var listElement = $this;
    var perPage = settings.perPage;
    var children = listElement.children();
    var pager = $('.pager');

    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }

    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }

    var numItems = children.size();
    var numPages = Math.ceil(numItems/perPage);

    pager.data("curr",0);

    if (settings.showPrevNext){
        $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
    }

    var curr = 0;
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }

    if (settings.showPrevNext){
        $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
    }

    pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
      pager.children().eq(1).addClass("active");

    children.hide();
    children.slice(0, perPage).show();

    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });

    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }

    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }

    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;

        children.css('display','none').slice(startAt, endOn).show();

        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }

        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }

        pager.data("curr",page);
        pager.children().removeClass("active");
        pager.children().eq(page+1).addClass("active");

    }
};

$(document).ready(function(){

  $("#excel").click(function(){
  $("#datos").table2excel({
    filename: "ReporteNC",
    fileext:".xls"
  });
  });

  $('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:10});

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

function doSearch()
{
  var tableReg = document.getElementById('datos');
  var searchText = document.getElementById('searchTerm').value.toLowerCase();
  var cellsOfRow="";
  var found=false;
  var compareWith="";

  // Recorremos todas las filas con contenido de la tabla
  for (var i = 1; i < tableReg.rows.length; i++)
  {
    cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
    found = false;
    // Recorremos todas las celdas
    for (var j = 0; j < cellsOfRow.length-1 && !found; j++)
    {
      compareWith = cellsOfRow[j].innerHTML.toLowerCase();
      // Buscamos el texto en el contenido de la celda
      if (searchText.length == 0 || (compareWith.indexOf(searchText) > -1))
      {
        found = true;
      }
    }
    if(found)
    {
      tableReg.rows[i].style.display = '';
    } else {
      // si no ha encontrado ninguna coincidencia, esconde la
      // fila de la tabla
      tableReg.rows[i].style.display = 'none';
    }
  }
}

</script>


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
                <form>
                    Buscar <input id="searchTerm" type="text" onkeyup="doSearch()" />
                </form>
                <div class="dataTable_wrapper">
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th>  <div class="th-inner sortable both">    id  </div></th>
                          <th>  <div class="th-inner sortable both">    fecha  </div></th>
                          <th>  <div class="th-inner sortable both">    Descripcion  </div></th>
                          <th>  <div class="th-inner sortable both">    Responsable  </div></th>
                         <th>  <div class="th-inner sortable both">    Fecha Plan  </div></th>
                          <th>  <div class="th-inner sortable both">    Evidencia  </div></th>
                          <th>  <div class="th-inner sortable both">    Evidencia Apertura  </div></th>
                          <th>  <div class="th-inner sortable both">    Fecha cierre  </div></th>
                          <th>  <div class="th-inner sortable both">    Status  </div></th>
                          <th>  <div class="th-inner sortable both">    Creador  </div></th>
                          <th>  <div class="th-inner sortable both">    Editar  </div></th>
                          <th>  <div class="th-inner sortable both">  Eliminar</div></th>
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody id = "myTable">
                        <?php foreach ($relaciontabla as $noconformidad): ?>
                        <tr>
                          <td>  <?=$noconformidad->id?> </td>
                          <td>  <?=$noconformidad->fecha?> </td>
                          <td>  <?=$noconformidad->descripcion?></td>
                          <td>  <?=$noconformidad->usuarionombre?></td>
                          <td>  <?=$noconformidad->fecha_plan?></td>
                          <td>  <?=$noconformidad->evidencia?>
                            @IF($noconformidad->evidencia != '')
                            <a href="/storage/noconformidad/<?=$noconformidad->evidencia_unic?>" downloadFile="<?=$noconformidad->evidencia_unic?>" style='color:#FFF'>
                              <button type="button" class="btn btn-warning">
                                   <i class="glyphicon glyphicon-cloud-download"></i>
                              </button>
                            </a>
                            @endif
                          </td>
                          <td>  <?=$noconformidad->evidenciapertura?>
                            @IF($noconformidad->evidenciapertura != '')
                            <a href="/storage/noconformidad/<?=$noconformidad->apertura_unic?>" downloadFile="<?=$noconformidad->apertura_unic?>" style='color:#FFF'>
                              <button type="button" class="btn btn-warning">
                                   <i class="glyphicon glyphicon-cloud-download"></i>
                              </button>
                            </a>
                            @endif
                          </td>
                          <td>  <?=$noconformidad->fecha_cierre?></td>
                          <td>  <?=$noconformidad->estatusnombre?></td>
                          <td>  <?=$noconformidad->creador?></td>
                          <td>
                            <button type="button" class="btn btn-primary" value = "<?=$noconformidad->id?>" data-toggle="modal" data-target="#modaledit_nc" onclick="EditarNC(this);"><i class="glyphicon glyphicon-edit"></i></button>
                          </td>
                          <td>
<!-- se creara un bucle para generar los n modales necesarios para la edicion de datos -->
                              <form class="" action="/noconformidad/delete/<?=$noconformidad->id?>" method="post">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger" id="btnpro" style="font-family: Arial;" onclick="
  return confirm('Estas seguro de eliminar la queja numero: <?=$noconformidad->id?>?')"><i class="fa fa-trash"></i></button>
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
                        <h3><label>Status:</label></h3>
                            <select class="form-control input-lg" name="estatus_id" id="estatus_id">
                              <?php foreach ($estatus as $estatuses): ?>
                                <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                              <?php endforeach ?>
                            </select>
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
                    <form id="fileinfo_nc" method="post">
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
                        <input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="archivoa_nc" id="archivoa_nc" >
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
                        <input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="archivob_nc" id="archivob_nc" >
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
                          <a class="btn btn-primary" id="actualizar_nc" style="font-family: Arial;"><i class="glyphicon glyphicon-edit"></i><br>Editar</a>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
    </div>

@stop
