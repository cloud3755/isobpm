@extends('layouts.principal2')

@section('content')



<br><br><br><br><br>
<!-- Registro -->

<!-- inicia formulario a cambiar -->
<div class="container">
  <form method="POST" action="/procesos/store" accept-charset="UTF-8" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <div class="container">
               <div class="form-group form-group-lg">
                 <h2><label for="tipo" class="control-label col-md-12" >Tipo de Proceso:</label></h2>
                   <div class="col-md-6">
                          <input class="form-control input-lg"  disabled="true" id="protipoproc" value="<?=$proceso['tipo']?>" type="Text" placeholder="Nombre del proceso" name="tipo" maxlength="50">
                     </div>
                 </div>

                 <div class="form-group form-group-lg">
                     <h2><label for="Usuario" class="control-label col-md-12">Proceso:</label></h2>
                     <div class="col-md-6">
                         <input class="form-control input-lg"  disabled="true" id="probproces" value="<?=$proceso['proceso']?>" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                     </div>
                 </div>

                 <div class="form-group form-group-lg">
                     <h2>
                     <label for="Usuario" class="control-label col-md-12">
                     Decripcion:
                     </label>
                     </h2>
                     <div class="col-md-6">
                         <textarea class="form-control input-lg"  disabled="true" id = "prodescripcionproces" rows="3" placeholder="Descripcion del proceso" name="descripcion" maxlength="255"><?=$proceso['descripcion']?></textarea>
                     </div>
                 </div>


                 <div class="form-group form-group-lg">
                     <h2><label for="tipo" class="control-label col-md-12" >Responsable</label></h2>
                     <div class="col-md-6">
                       <input class="form-control input-lg"  disabled="true" id="probproces" value="<?=$procesosrelacion->nombre?>" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                     </div>
                 </div>
<!-- termina formulario a cambiar -->

               </div>
              <br><br>
                 <button type="button" class="btnobjetivo" onclick=location="/procesos/visual" data-dismiss="modal" id="btnCloseUpload">Regresar</button>
            </div>
  </form>


</div>
<br><br>


<!-- Tabla -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                Riesgos
                <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i></button>
            </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                  <form>
                      Buscar <input id="searchTerm" type="text" onkeyup="doSearch()" />
                  </form>
                  <br>
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
                        <thead style='background-color: #868889; color:#FFF'>
                            <tr>
                                <th><div class="th-inner sortable both">Actividad</div></th>
                                <th><div class="th-inner sortable both">Riesgo</div></th>
                                <th><div class="th-inner sortable both">Modo de Falla</div></th>
                                <th><div class="th-inner sortable both">Severidad inherente</div></th>
                                <th><div class="th-inner sortable both">Probabilidad inherente</div></th>
                                <th><div class="th-inner sortable both">Controles</div></th>
                                <th><div class="th-inner sortable both">Severidad Residual</div></th>
                                <th><div class="th-inner sortable both">probabilidad Residual</div></th>
                                <th>
                                  <div class="th-inner sortable both">
                                      Modificar
                                  </div>
                                </th>
                                <th>
                                  <div class="th-inner sortable both">
                                      Eliminar
                                  </div>
                                </th>
                            </tr>
                        </thead>
                        <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                        <tbody id = "myTable">
                            <?php foreach ($analisisriesgo2 as $Analisisriesgos2): ?>
                                <tr>
                                    <td><?=$Analisisriesgos2->actividad?></td>
                                    <td><?=$Analisisriesgos2->riesgo_nombre?></td>
                                    <td><?=$Analisisriesgos2->descripcion_modo_falla?></td>
                                    <td><?=$Analisisriesgos2->Severidad?></td>
                                    <td><?=$Analisisriesgos2->probabilidad?></td>
                                    <td><?=$Analisisriesgos2->controles?></td>
                                    <td><?=$Analisisriesgos2->Severidad2?></td>
                                    <td><?=$Analisisriesgos2->probabilidad2?></td>
                                    <td>
                                      <button type="button" class="btnobjetivo" value = "<?=$Analisisriesgos2->id?>" data-toggle="modal" data-target="#modaledit" onclick="Editar(this);"><i class="glyphicon glyphicon-pencil"></i> Editar  </button>
                                    </td>
                                    <td>
                                       <form class="" action="/analisisrisk/destroy/{{ $Analisisriesgos2->id }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                        <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;" onclick="
                                        return confirm('seguro de eliminar el indicador {{$Analisisriesgos2->actividad}}?')">Eliminar</button>
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

<!-- Modal -->
<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title">Alta de Analisis de riesgo</h3>
            </div>
            <div class="modal-body">
              <form  action="/analisisrisk/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{ csrf_token()}}">
                  <input type="hidden" name="procesos_id" value="<?=$proceso['id']?>">
                <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h3><label for="tipo" class="control-label" >Proceso:</label></h3>
                  <input class="form-control input-lg"  disabled="true" id="probproces" value="<?=$proceso['proceso']?>" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h3><label for="tipo" class="control-label" >Actividad:</label></h3>
                  <input class="form-control input-lg" id="actividad" type="Text" placeholder="Que actividad se realiza" name="actividad">
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5">
                  <h3><label for="tipo" class="control-label" >Riesgo:</label></h3>
                  <select class="form-control input-lg" name="riesgo_id" id="riesgo_id">
                      <?php foreach ($Abcriesgo as $Abcriesgos): ?>
                          <option value="<?=$Abcriesgos['id']?>"><?=$Abcriesgos['nombre']?></option>
                      <?php endforeach ?>
                  </select>
                </div>

                <div class="col-lg-7 col-md-7 col-sm-7">
                  <h3><label for="Usuario" class="control-label" >Modo de falla:</label></h3>
                  <input class="form-control input-lg" id="descripcion_modo_falla" type="Text" placeholder="Descripcion de la falla" name="descripcion_modo_falla">
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h3><label for="Usuario" class="control-label" >Severidad inherente:</label></h3>
                  <select class="form-control input-lg" name="Severidad" id="Severidad">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h3><label for="Usuario" class="control-label" >Probabilidad inherente:</label></h3>
                  <select class="form-control input-lg" name="probabilidad" id="probabilidad">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                  <h3><label for="Usuario" class="control-label" >Controles:</label></h3>
                  <input class="form-control input-lg" id="controles" type="Text" placeholder="Controles" name="controles">
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3">
                  <h3><label for="Usuario" class="control-label" >Severidad residual:</label></h3>
                  <select class="form-control input-lg" name="Severidad2" id="Severidad2">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3">
                  <h3><label for="Usuario" class="control-label" >Probabilidad residual:</label></h3>
                  <select class="form-control input-lg" name="probabilidad2" id="probabilidad2">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h3><label for="tipo" class="control-label" >Area:</label></h3>
                  <select class="form-control input-lg" name="id_area" id="id_area" required>
                    <?php foreach ($area as $areas): ?>
                        <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                    <?php endforeach ?>
                  </select>
                </div>


                </div>
              <div class="modal-footer">
                  <button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Alta de Analisis Riesgo</button>
                  <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
              </div>
              </form>
            </div>
          </div>
      </div>
</div>


<!-- Modal para editar -->

<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title">ACTUALIZAR RIESGO</h3>
            </div>
            <div class="modal-body">
              <form id="fileinfo" method="post">

              <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
              <input type="hidden" id="id">

                <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h3><label for="tipo" class="control-label" >Proceso:</label></h3>
                  <input class="form-control input-lg"  disabled="true" id="eproceso" value="<?=$proceso['proceso']?>" type="Text" placeholder="Nombre del proceso" name="eproceso" maxlength="50">
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h3><label for="tipo" class="control-label" >Actividad:</label></h3>
                  <input class="form-control input-lg" id="eactividad" type="Text" placeholder="Que actividad se realiza" name="eactividad">
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5">
                  <h3><label for="tipo" class="control-label" >Riesgo:</label></h3>
                  <select class="form-control input-lg" name="eriesgo_id" id="eriesgo_id">
                      <?php foreach ($Abcriesgo as $Abcriesgos): ?>
                          <option value="<?=$Abcriesgos['id']?>"><?=$Abcriesgos['nombre']?></option>
                      <?php endforeach ?>
                  </select>
                </div>

                <div class="col-lg-7 col-md-7 col-sm-7">
                  <h3><label for="Usuario" class="control-label" >Modo de falla:</label></h3>
                  <input class="form-control input-lg" id="edescripcion_modo_falla" type="Text" placeholder="Descripcion de la falla" name="edescripcion_modo_falla">
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h3><label for="Usuario" class="control-label" >Severidad inherente:</label></h3>
                  <select class="form-control input-lg" name="eSeveridad" id="eSeveridad">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h3><label for="Usuario" class="control-label" >Probabilidad inherente:</label></h3>
                  <select class="form-control input-lg" name="eprobabilidad" id="eprobabilidad">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                  <h3><label for="Usuario" class="control-label" >Controles:</label></h3>
                  <input class="form-control input-lg" id="econtroles" type="Text" placeholder="Controles" name="econtroles">
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3">
                  <h3><label for="Usuario" class="control-label" >Severidad residual:</label></h3>
                  <select class="form-control input-lg" name="eSeveridad2" id="eSeveridad2">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3">
                  <h3><label for="Usuario" class="control-label" >Probabilidad residual:</label></h3>
                  <select class="form-control input-lg" name="eprobabilidad2" id="eprobabilidad2">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                  <h3><label for="tipo" class="control-label" >Area:</label></h3>
                  <select class="form-control input-lg" name="eid_area" id="eid_area" required>
                    <?php foreach ($area as $areas): ?>
                        <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                    <?php endforeach ?>
                  </select>
                </div>


              </div>

              <div class="modal-footer">
              <a class="btn btn-primary" id="actualizar" style="font-family: Arial;">Guardar Cambios</a>
                  <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
              </div>
            </form>
        </div>
      </div>
  </div>
</div>


<script type="text/javascript">

//Funcion para el edit

function Editar(btn){
  var route = "/analisisrisk/"+btn.value+"/edit";

  $.get(route, function(res){
    $("#id").val(res.id);
    $("#eactividad").val(res.actividad);
    $('#eriesgo_id option[value="' + res.riesgo_id + '"]').attr("selected", "selected");
    $("#edescripcion_modo_falla").val(res.descripcion_modo_falla);
    $('#eSeveridad option[value="' + res.Severidad + '"]').attr("selected", "selected");
    $('#eprobabilidad option[value="' + res.probabilidad + '"]').attr("selected", "selected");
    $("#econtroles").val(res.controles);
    $('#eSeveridad2 option[value="' + res.Severidad2 + '"]').attr("selected", "selected");
    $('#eprobabilidad2 option[value="' + res.probabilidad2 + '"]').attr("selected", "selected");
    $('#eid_area option[value="' + res.id_area + '"]').attr("selected", "selected");


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

  $('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:10});

  $("#actualizar").click(function(){
    var value = $("#id").val();
    var route = "/analisisrisk/edit/"+value+"";
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


@Stop
