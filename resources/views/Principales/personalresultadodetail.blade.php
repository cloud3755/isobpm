@extends('layouts.principal2')

@section('content')

</br>

<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="/js/personalresultsdetail.js" charset="utf-8"></script>

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






<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Detalle de resultados del personal</h1>
    </div>
</div>


<center><button type="button" class="btnobjetivo" onclick=location="/admin" data-dismiss="modal" id="btnCloseUpload">Regresar</button></center>


</br>

<div class="modal-header">
  <center><div id="pruebasjquery" color="red"></div></center>
<!--            <ul class="nav nav-tabs">
    <li class="active"><a href="#">Calificar</a></li>
    <li><a href="#">Historial</a></li>
  </ul>-->
</div>
<div class="modal-body">
  <form id="formulariofiltro" class="form-horizontal" action="/resultsdetail/filtro" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="uprofile" id="uprofile" value="{{ Auth::user()->perfil }}">
  <div class="container">



  <div class="row">

    <div id="fech" class="col-sm-6">
      <h2><label for="fech" class="control-label" >(*) Mes inicio:</label></h2>
        <input class="form-control" id="fech" type="month" placeholder="Agrega la fecha de calificacion" name="fech" value="<?=$iniciostr?>" >
    </div>

    <div id="fecha2" class="col-sm-6">
      <h2><label for="fecha2" class="control-label" >(*) Mes fin:</label></h2>
        <input class="form-control" id="fecha2" type="month" placeholder="Agrega la fecha de calificacion" name="fecha2" value="<?=$finalstr?>" >
    </div>
  </div>

  <div class="row">
<center><div id="buttonchart" class="form-group form-group-md col-sm-12" >
 <!--<button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">pruebacontrolador</button> -->
<br>
<button type="button" class="btnobjetivo"  data-dismiss="" id="botonfiltro" >Filtrar periodo</button>
</div></center>
</div>
</form>


</div>


<div class="row">

  <div class="table-responsive">
    <form>
        Buscar <input id="searchTerm" type="text" onkeyup="doSearch()" />
    </form>
    <div class="dataTable_wrapper">
        <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
          <thead style='background-color: #868889; color:#FFF'>
            <tr>
              <th><div class="th-inner sortable both">  Area</div></th>
              <th><div class="th-inner sortable both">  Puesto</div></th>
              <th><div class="th-inner sortable both">  Nombre</div></th>
              <th><div class="th-inner sortable both">  Indicador</div></th>
              <th><div class="th-inner sortable both">  Periodo</div></th>
              <th><div class="th-inner sortable both">  Ponderacion</div></th>
              <th><div class="th-inner sortable both">  Meta</div></th>
              <th><div class="th-inner sortable both">  Logica</div></th>
              <th><div class="th-inner sortable both">  Resultado obtenido</div></th>
              <th><div class="th-inner sortable both">  Resultado ponderado</div></th>
            </tr>
          </thead>
          <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
          <tbody id = "myTable">
            <?php foreach ($other as $ot): ?>
            <tr>
              <td> <?=$ot->area?> </td>
              <td> <?=$ot->nombrepuesto?> </td>
              <td> <?=$ot->nombre?> </td>
              <td> <?=$ot->indicador?> </td>
              <td> <?=$ot->periodo?> </td>
              <td> <?=$ot->ponderacion?> </td>
              <td> <?=$ot->meta?> </td>
              <td> <?=$ot->logica?> </td>
              <td> <?=$ot->resultado?> </td>
              <td> <?=$ot->obtenido?> </td>

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



                    <div class="modal-footer">

                  </div>


@stop
