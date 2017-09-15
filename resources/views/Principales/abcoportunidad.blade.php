@extends('layouts.principal2')

@section('content')

<br>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">OPORTUNIDADES</h1>
    </div>
</div>

<br><br><br><br>
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
                <ol class="breadcrumb iso-breadcumb">
                    <li><a href="/oportunidades" style='color:#FFF'> Oportunidades</a></li>
                </ol>
            </h2>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    ABC OPORTUNIDAD
                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-floppy-save"></i></button>
                </div>
            <div class="panel-body">
                <div class="row">
                  <div class="table-responsive">
                    <form>
                        Buscar <input id="searchTerm" type="text" onkeyup="doSearch()" />
                    </form>
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover"  id="datos">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th>
                            <div class="th-inner sortable both">
                              Tipo Oportunidad
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Nombre
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Descripcion
                            </div>
                          </th>
                          <th>
                            <div class="th-inner sortable both">
                              Modificacion
                            </div>
                          </th>
                          @if(Auth::user()->perfil != 4)
                          <th>
                            <div class="th-inner sortable both">
                              Eliminacion
                            </div>
                          </th>
                          @endif
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody id = "myTable">
                        <?php foreach ($oportunidadrelacion as $oportunidad1): ?>
                        <tr>

                          <td>
                            <?=$oportunidad1->tipo_nombre?>
                          </td>
                          <td>
                            <?=$oportunidad1->nombre?>
                          </td>
                          <td>
                            <?=$oportunidad1->descripcion?>
                          </td>
                          <td>
                            <button type="button" class="btn btn-primary" value = "<?=$oportunidad1->id?>" data-toggle="modal" data-target="#modaledit" onclick="Editar(this);"><i class="glyphicon glyphicon-edit"></i></button>
                          </td>
                          @if(Auth::user()->perfil != 4)
                          <td>
                            <form class="" action="/abcoportunidades/destroy/{{ $oportunidad1->id }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                              <button type="submit" class="btn btn-danger" id="btnpro" style="font-family: Arial;" onclick="
return confirm('Estas seguro de eliminar la oportunidad <?=$oportunidad1->nombre?>?')"><i class="fa fa-trash"></i></button>
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

<!-- modal carga nuevo registro -->

    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h3 class="modal-title">ALTA DE ABC OPORTUNIDAD</h3>
                </div>
                <div class="modal-body">
        <div class="container">
          <form class="" action="/abcoportunidades/store" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="tipo" class="col-md-12 control-label" >
                            Tipo Oportunidad:
                        </label>
                        </h2>
                        <div class="col-sm-9 col-md-6">
                            <select class="form-control input-lg" name="tipo_id_oportunidad" id="tipo_id_oportunidad">
                              <?php foreach ($Tipooportunidad as $Tipooportunidades): ?>
                                <option value="<?=$Tipooportunidades['id']?>"><?=$Tipooportunidades['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                      <div class="visible-sm">
                        <h2><label type="hidden" class="col-md-12 control_label"></label></h2>
                      </div>
                        <h2><label for="Usuario" class="col-md-12 control_label">Oportunidad:</label></h2>
                        <div class="col-sm-9 col-md-6">
                            <input class="form-control input-lg" id="oportunidad" type="Text" placeholder="Cual es la oportunidad" name="oportunidad">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <h2>
                        <label for="Usuario" class="col-md-12 control_label">
                        Decripcion:
                        </label>
                        </h2>
                        <div class="col-sm-9 col-md-6">
                            <textarea class="form-control" id = "descripcion" rows="3" placeholder="Describe la oportunidad" name="descripcion"></textarea>
                        </div>
                    </div>
        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btnobjetivo" style="font-family: Arial;"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</button>
            </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
<!-- termina modal carga nuevo registro -->

<!-- inicia bucle modal edita registro -->


<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title">ACTUALIZAR DOCUMENTO</h3>
            </div>
            <div class="modal-body">
              <form id="fileinfo" method="post">

              <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
              <input type="hidden" id="id">

                <div class="container">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group form-group-lg">
                                <h2>
                                <label for="tipo" class="col-md-12 control-label" >
                                    Tipo Oportunidad:
                                </label>
                                </h2>
                                <div class="col-sm-9 col-md-6">
                                    <select class="form-control input-lg" name="etipo_id_oportunidad" id="etipo_id_oportunidad">
                                      <?php foreach ($Tipooportunidad as $Tipooportunidades): ?>
                                        <option value="<?=$Tipooportunidades['id']?>"><?=$Tipooportunidades['nombre']?></option>
                                      <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                              <div class="visible-sm">
                                <h2><label type="hidden" class="col-md-12 control_label"></label></h2>
                              </div>
                                <h2><label for="Usuario" class="col-md-12 control_label">Oportunidad:</label></h2>
                                <div class="col-sm-9 col-md-6">
                                    <input class="form-control input-lg" id="eoportunidad" type="Text" placeholder="Cual es la oportunidad" name="eoportunidad">
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                                <h2>
                                <label for="Usuario" class="col-md-12 control_label">
                                Decripcion:
                                </label>
                                </h2>
                                <div class="col-sm-9 col-md-6">
                                    <textarea class="form-control" id = "edescripcion" rows="3" placeholder="Describe la oportunidad" name="edescripcion"></textarea>
                                </div>
                            </div>
                </div>
                <div class="modal-footer">
                  <a class="btn btn-primary" id="actualizar" style="font-family: Arial;"><i class="glyphicon glyphicon-edit"></i><br>Editar</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                </div>
              </form>
          </div>
        </div>
    </div>
</div>
<!-- finaliza bucle modal edita registro -->

<script type="text/javascript">

//Funcion para el edit

function Editar(btn){
  var route = "/abcoportunidades/"+btn.value+"/edit";

  $.get(route, function(res){
    $("#id").val(res.id);
    $('#etipo_id_oportunidad option[value="' + res.tipo_oportunidad_id + '"]').attr("selected", "selected");
    $("#eoportunidad").val(res.nombre);
    $("#edescripcion").val(res.descripcion);
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
    var route = "/abcoportunidades/edit/"+value+"";
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

@stop
