@extends('layouts.principal2')

@section('content')
<script src="/js/EXCEL/src/jquery.table2excel.js"></script>

<script type="text/javascript">

function EditarQ(btn){
  var route = "/quejas/"+btn.value+"/edit";
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
    filename: "Reporte",
    fileext:".xls"
  });
  });

  $('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:10});

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
                <form>
                    Buscar <input id="searchTerm" type="text" onkeyup="doSearch()" />
                </form>
                <div class="dataTable_wrapper">
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th><div class="th-inner sortable both">  ID</div></th>
                          <th><div class="th-inner sortable both">  fecha</div></th>
                          <th><div class="th-inner sortable both">  Responsable</div></th>
                          <th><div class="th-inner sortable both">  Descripcion</div></th>
                          <th><div class="th-inner sortable both">  Cliente</div></th>
                          <th><div class="th-inner sortable both">  Acciones</div></th>
                          <th><div class="th-inner sortable both">  Fecha plan</div></th>
                          <th><div class="th-inner sortable both">  Evidencia</div></th>
                          <th><div class="th-inner sortable both">  Fecha cierre</div></th>
                          <th><div class="th-inner sortable both">  Status</div></th>
                          <th><div class="th-inner sortable both">  Archivo 1</div></th>
                          <th><div class="th-inner sortable both">  Archivo 2</div></th>
                          <th><div class="th-inner sortable both">  Editar</div></th>
                          @if(Auth::user()->perfil != 4)
                            <th><div class="th-inner sortable both">  Eliminar</div></th>
                          @endif
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody id = "myTable">
                        <?php foreach ($relaciontabla as $queja): ?>
                        <tr>
                          <td> <?=$queja->id?> </td>
                          <td> <?=$queja->fecha?> </td>
                          <td> <?=$queja->usernombre?> </td>
                          <td> <?=$queja->descripcion?> </td>
                          <td> <?=$queja->clientenombre?> </td>
                          <td> <?=$queja->acciones?> </td>
                          <td> <?=$queja->fecha_plan?> </td>
                          <td> <?=$queja->evidencia?> </td>
                          <td> <?=$queja->fecha_cierre?> </td>
                          <td> <?=$queja->statusnombre?> </td>
                          <td>
                            @IF($queja->archivoqueja != '')
                            <?=$queja->archivoqueja?>
                            <a href="/storage/quejas/<?=$queja->uniquearchivoqueja?>" downloadFile="<?=$queja->uniquearchivoqueja?>" target="_blank" style='color:#FFF'>
                              <button type="button" class="btn btn-default">
                                   <span class="glyphicon glyphicon-download-alt"></span>
                              </button>
                            </a>
                            @endif
                         </td>
                         <td>
                           @IF($queja->archivoevidencia != '')
                           <?=$queja->archivoevidencia?>
                           <a href="/storage/quejas/<?=$queja->uniquearchivoevidencia?>" downloadFile="<?=$queja->uniquearchivoevidencia?>" target="_blank" style='color:#FFF'>
                             <button type="button" class="btn btn-default">
                                  <span class="glyphicon glyphicon-download-alt"></span>
                             </button>
                           </a>
                           @endif
                         </td>
                         <td>
                           <button type="button" class="btn btn-primary" value = "<?=$queja->id?>" data-toggle="modal" data-target="#modaleditq" onclick="EditarQ(this);"><i class="glyphicon glyphicon-edit"></i></button>
                         </td>
                         @if(Auth::user()->perfil != 4)
                         <td>
                           <!-- se creara un bucle para generar los n modales necesarios para la edicion de datos -->
                           <form id="formeliminar" action="/quejas/delete/<?=$queja->id?>" method="post">
                             <input type="hidden" name="_token" value="{{{ csrf_token() }}}" id="token">
                             <button type="submit" class="btn btn-danger"  style="font-family: Arial;"  onclick="
                             return confirm('Estas seguro de eliminar la queja numero: <?=$queja->id?>?')"><i class="fa fa-trash"></i></button>
                           </form>
                         </td>
                         @endif

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
                      <h3><label>Fecha plan:</label></h3>
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

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <h3><label>Status:</label></h3>
                            <select class="form-control input-lg" name="status_id">
                              <?php foreach ($estatus as $estatuses): ?>
                                <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                              <?php endforeach ?>
                            </select>
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
              <form id="fileinfo_q" method="post">
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
                      <input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="earchivoa_q" id="earchivoa_q" >
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
                    <h3><label>Fecha plan:</label></h3>
                        <input class="form-control input-lg" type="date" placeholder="Fecha" name="efecha_plan_q" id="efecha_plan_q">
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-6">
                      <h3><label>Evidencia:</label></h3>
                      <input class="form-control input-lg" type="text" placeholder="evidencia" name="eevidencia_q" id="eevidencia_q">
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-6">
                      <h3><label>Archivo de evidencia:</label></h3>
                      <input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="earchivoa2_q" id="earchivoa2_q" >
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
                  <a class="btn btn-primary" id="actualizarq" style="font-family: Arial;"><i class="glyphicon glyphicon-edit"></i><br>Editar</a>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
</div>
<!-- termina modal para update -- >


@stop
