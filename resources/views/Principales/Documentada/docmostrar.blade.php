@extends('layouts.principal2')

@section('content')
<br>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none"><?=$datos['nombre'] ?></h1>
    </div>
</div>

<br><br><br><br><br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                Documentos
                <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i></button>
            </div>
        <div class="panel-body">
          <div class="row">
            <div class="table-responsive">
              <form>
                  Buscar <input id="searchTerm" type="text" onkeyup="doSearch()" />
              </form>
              <br>
                <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
                  <thead style='background-color: #868889; color:#FFF'>
                    <tr>
                      <th>  <div class="th-inner sortable both">    Nombre  </div></th>
                      <th>  <div class="th-inner sortable both">    Documento  </div></th>
                      <th>  <div class="th-inner sortable both">    Tamaño(Bytes)  </div></th>
                      <th>  <div class="th-inner sortable both">    Fecha Modificacion  </div></th>
                      <th>  <div class="th-inner sortable both">    Revision  </div></th>
                      <th>  <div class="th-inner sortable both">    Modificacion  </div></th>
                    </tr>
                  </thead>
                  <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                  <tbody id = "myTable">
                    <?php foreach ($documento as $documentos): ?>
                    <tr>
                      <td>  <?=$documentos->nombre?></td>
                      <td>
                        @IF($documentos->archivo != '')
                        <?=$documentos->archivo?>

                        <a href="/documento/<?=$documentos->id?>" target="_blank" style='color:#FFF'>
                          <button type="button" class="btn btn-default">
                               <span class="glyphicon glyphicon-download-alt"></span>
                          </button>
                        </a>
                        @endif
                      </td>
                      <td>  <?=$documentos->size?></td>
                      <td>  <?=$documentos->updated_at?></td>
                      <td>  <?=$documentos->review?></td>
                      <td>
                        @if(Auth::user()->id == $documentos->id_user OR Auth::user()->perfil != 4)
                        <form class="" action="/documentada/destroy/{{ $documentos->id }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                          <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" onclick="
                            return confirm('Estas seguro de eliminar el documento <?=$documentos->nombre?>?')">Eliminar</button>
                          <button type="button" class="btnobjetivo" value = "<?=$documentos->id?>" data-toggle="modal" data-target="#modaledit" onclick="Editar(this);"><i class="glyphicon glyphicon-pencil"></i> Editar  </button>
                        </form>
                        @endif
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

<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title">ALTA DE DOCUMENTO</h3>
            </div>
            <div class="modal-body">
                <form class="" action="/documentada/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id_tipo" value="<?=$datos['id'] ?>">
                    <input type="hidden" name="lista[]" id="lista" />
                    <div class="form-container">
                            <table>
                                <tr>
                                    <td>
                                        <p class="modal-label">(*) Nombre:</p>
                                    </td>
                                    <td>
                                        <input class="modal-input" id="nombre" type="Text" placeholder="Nombre" name="nombre" required>
                                    </td>
                                    <td>
                                        <p class="modal-label">(*) Descripcion:</p>
                                    </td>
                                    <td>
                                        <input class="modal-input" id="descripcion" type="Text" placeholder="descripcion del archivo" name="descripcion" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="modal-label">(*) Archivo:</p>
                                    </td>
                                    <td colspan="2">
                                        <input class="modal-input" id="archivo" type="file" placeholder="Elige el archivo" name="archivo" required>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </table>
                        </div>
                                <center>
                                    <p class="modal-label">Lista de accesos:</p>
                                
                                        <div>
                                            <p>
                                            </p><table>
                                                <tbody>
                                                    <tr>
                                                        <td>Usuarios no elegidos</td>
                                                        <td></td>
                                                        <td>Usuarios elegidos</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <select multiple name="listaUsuariosDisponibles[]" id="listaUsuariosDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('listaUsuariosDisponibles', 'lista_de_accesos');">
                                                                <?php foreach ($User as $Users): ?>
                                                                <option value="<?=$Users['id']?>"> <?=$Users['nombre']?> </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('listaUsuariosDisponibles', 'lista_de_accesos');">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('lista_de_accesos', 'listaUsuariosDisponibles');">
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <select multiple="multiple" name="lista_de_accesos[]" id="lista_de_accesos" size="7" style="width: 100%;" onclick="agregaSeleccion('lista_de_accesos','listaUsuariosDisponibles');"></select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <p></p>
                                        </div>
                                </center>
                                
                            
                            <!--
                                  <h2><label for="Usuario" class="control-label col-md-12">(*) Nombre:</label></h2>
                                  <div class="col-md-6 col-sm-9">
                                      <input class="form-control input-lg" id="nombre" type="Text" placeholder="Nombre" name="nombre" required>
                                  </div>
                              </div>
                              <div class="form-group form-group-lg">
                                <h2><label for="tipo" class="control-label col-md-12" >(*) Descripcion:</label></h2>
                                <div class="col-md-6 col-sm-9">
                                  <input class="form-control input-lg" id="descripcion" type="Text" placeholder="Agrega una descripcion del archivo" name="descripcion" required>
                                </div>
                              </div>
                              <div class="form-group form-group-lg">
                                <h2><label for="Usuario" class="control-label col-md-12">(*) Archivo:</label></h2>
                                <div class="col-md-6 col-sm-9">
                                  <input class="form-control input-lg" id="archivo" type="file" placeholder="Elige el archivo" name="archivo" required>
                                </div>
                              </div>

                              <div class="form-group form-group-lg">
                                <h2><label for="Usuario" class="control-label col-md-12">Lista de accesos:</label></h2>
                                <div class="col-md-12">


                                       <div>
                                                         <p>
                                                             </p><table>
                                                                 <tbody><tr>
                                                                     <td>Usuarios no elegidos</td>
                                                                     <td></td>
                                                                     <td>Usuarios elegidos</td>
                                                                 </tr>
                                                                 <tr>
                                                                     <td>
                                                                         <select multiple name="listaUsuariosDisponibles[]"  id="listaUsuariosDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('listaUsuariosDisponibles', 'lista_de_accesos');">
                                                                           <?php foreach ($User as $Users): ?>
                                                                             <option value="<?=$Users['id']?>"> <?=$Users['nombre']?> </option>
                                                                           <?php endforeach ?>
                                                                         </select>

                                                                 </td>
                                                                 <td>
                                                                     <table>
                                                                         <tbody><tr>
                                                                             <td>
                                                                                 <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('listaUsuariosDisponibles', 'lista_de_accesos');">
                                                                             </td>
                                                                         </tr>
                                                                         <tr>
                                                                             <td>

                                                                           </td>
                                                                         </tr>
                                                                         <tr>
                                                                             <td>
                                                                             </td>
                                                                         </tr>
                                                                         <tr>
                                                                             <td>
                                                                                 <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('lista_de_accesos', 'listaUsuariosDisponibles');">
                                                                             </td>
                                                                         </tr>
                                                                     </tbody></table>

                                                                 </td>

                                                                 <td>
                                                                     <select multiple="multiple" name="lista_de_accesos[]"  id="lista_de_accesos" size="7" style="width: 100%;" onclick="agregaSeleccion('lista_de_accesos','listaUsuariosDisponibles');">

                                                                     </select>
                                                                 </td>
                                                             </tr>
                                                         </tbody></table>
                                                     <p></p>
                                                 </div>


                                </div>
                              </div>
                            </div>
                            -->
                            <div class="modal-footer">
                                <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">Subir Documento</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                            </div>
                </form>
            </div>
        </div>
    </div>
</div>



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
              <input type="hidden" name="id_tipo" value="<?=$datos['id'] ?>" id="id_tipo" >
              <input type="hidden" id="id">
              <div class="container">
                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">(*) Nombre:</label></h2>
                    <div class="col-md-6 col-sm-9">
                        <input class="form-control input-lg" id="enombre" type="Text" placeholder="Nombre" name="enombre" required>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                  <h2><label for="tipo" class="control-label col-md-12" >(*) Descripcion:</label></h2>
                  <div class="col-md-6 col-sm-9">
                    <input class="form-control input-lg" id="edescripcion" type="Text" placeholder="Agrega una descripcion del archivo" name="edescripcion" required>
                  </div>
                </div>
                <div class="form-group form-group-lg">
                  <h2><label for="Usuario" class="control-label col-md-12">(*) Archivo:</label></h2>
                  <div class="col-md-6 col-sm-9">
                    <input class="form-control input-lg" id="earchivo" type="Text" readonly name="earchivo">
                    <input class="form-control input-lg" id="aarchivo" type="file" placeholder="Elige el archivo" name="aarchivo">
                    <progress id="progress" value="0"></progress>
                  </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2><label for="Usuario" class="control-label col-md-12">Lista de accesos:</label></h2>
                  <div class="col-md-12">

                    <div>
                                      <p>
                                          </p><table>
                                              <tbody><tr>
                                                  <td>Usuarios no elegidos</td>
                                                  <td></td>
                                                  <td>Usuarios elegidos</td>
                                              </tr>
                                              <tr>
                                                  <td>
                                                      <select multiple name="elistaUsuariosDisponibles[]"  id="elistaUsuariosDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('elistaUsuariosDisponibles', 'elista_de_accesos');">

                                                      </select>

                                              </td>
                                              <td>
                                                  <table>
                                                      <tbody><tr>
                                                          <td>
                                                              <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('elistaUsuariosDisponibles', 'elista_de_accesos');">
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <td>
                                                              <script type="text/javascript">
                                                                  function agregaSeleccion(origen, destino) {
                                                                      obj = document.getElementById(origen);
                                                                      if (obj.selectedIndex == -1)
                                                                          return;

                                                                      for (i = 0; opt = obj.options[i]; i++)
                                                                          if (opt.selected) {
                                                                              valor = opt.value; // almacenar value
                                                                              txt = obj.options[i].text; // almacenar el texto
                                                                              obj.options[i] = null; // borrar el item si está seleccionado
                                                                              obj2 = document.getElementById(destino);

                                                                              opc = new Option(txt, valor,"defaultSelected");
                                                                              eval(obj2.options[obj2.options.length] = opc);
                                                                          }

                                                                          var select = document.getElementById('lista_de_accesos');

                                                                          for ( var i = 0, l = select.options.length, o; i < l; i++ )
                                                                          {
                                                                            o = select.options[i];
                                                                              o.selected = true;
                                                                          }
                                                                          var select = document.getElementById('elista_de_accesos');

                                                                          for ( var i = 0, l = select.options.length, o; i < l; i++ )
                                                                          {
                                                                            o = select.options[i];
                                                                              o.selected = true;
                                                                          }


                                                                      }

                                                                      function agregaTodo(origen, destino) {
                                                                          obj = document.getElementById(origen);
                                                                          obj2 = document.getElementById(destino);
                                                                          aux = obj.options.length;
                                                                          for (i = 0; i < aux; i++) {
                                                                              aux2 = 0;
                                                                              opt = obj.options[aux2];
                                                                          valor = opt.value; // almacenar value
                                                                          txt = obj.options[aux2].text; // almacenar el texto
                                                                          obj.options[aux2] = null; // borrar el item si está seleccionado

                                                                          opc = new Option(txt, valor,"defaultSelected");
                                                                          eval(obj2.options[obj2.options.length] = opc);
                                                                      }
                                                                      var select = document.getElementById('lista_de_accesos');

                                                                      for ( var i = 0, l = select.options.length, o; i < l; i++ )
                                                                      {
                                                                        o = select.options[i];
                                                                          o.selected = true;
                                                                      }
                                                                      var select = document.getElementById('elista_de_accesos');

                                                                      for ( var i = 0, l = select.options.length, o; i < l; i++ )
                                                                      {
                                                                        o = select.options[i];
                                                                          o.selected = true;
                                                                      }
                                                                  }

                                                              </script>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <td>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <td>
                                                              <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('elista_de_accesos', 'elistaUsuariosDisponibles');">
                                                          </td>
                                                      </tr>
                                                  </tbody></table>

                                              </td>

                                              <td>
                                                  <select multiple name="elista_de_accesos[]" id="elista_de_accesos"  size="7" style="width: 100%;" onclick="agregaSeleccion('elista_de_accesos', 'elistaUsuariosDisponibles');">

                                                  </select>
                                              </td>
                                          </tr>
                                      </tbody></table>
                                  <p></p>
                              </div>

                  </div>
                </div>

              </div>
                    <div class="modal-footer">
                    <a class="btn btn-primary" id="actualizar" style="font-family: Arial;">Guardar Cambios</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
                </div>
              </form>
            </div>
        </div>
</div>



<?php
  $dato = json_encode($documento);
 ?>

<script type="text/javascript">

//funcion para acomodar el modal

    var childs = $('.form-container').length;
    var porc = ((100/childs-1));
    $('.form-container ' + 'td *').css('width', (porc+'%'));
    $('.form-container ' + 'td *').css('font-size', ((porc*.020)+'vw'));


//Funcion para el edit

function Editar(btn){
  var route = "/documentada/"+btn.value+"/edit";

  $.get(route, function(res){
    $("#enombre").val(res.nombre);
    $("#id").val(res.id);
    $("#edescripcion").val(res.descripcion);
    $("#earchivo").val(res.archivo);
  });


  var route = route+"2";
  $("#elista_de_accesos").empty();

  $.get(route, function(res){
    for (var i = 0; i < res.length; i++) {
      $("#elista_de_accesos").append('<option value="'+res[i].id+'">'+res[i].nombre+'</option>');

    }

    var select = document.getElementById('elista_de_accesos');

    for ( var i = 0, l = select.options.length, o; i < l; i++ )
    {
      o = select.options[i];
        o.selected = true;
    }

  });

  var route = route+"3";
  $("#elistaUsuariosDisponibles").empty();

  $.get(route, function(res){
    for (var i = 0; i < res.length; i++) {
      $("#elistaUsuariosDisponibles").append('<option value="'+res[i].id+'">'+res[i].nombre+'</option>');

    }
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
    var route = "/documentada/edit/"+value+"";
    var token = $("#token").val();
    var fd = new FormData(document.getElementById("fileinfo"));
    var progressBar = document.getElementById("progress");

    $.ajax({
      url: route,
      headers: {'X-CSRF_TOKEN': token},
      type: 'post',
      data: fd,
      processData: false,  // tell jQuery not to process the data
      contentType: false,
      xhr: function() {
        var xhr = $.ajaxSettings.xhr();
        xhr.upload.onprogress = function(e) {
          progressBar.max = e.total;
          progressBar.value = e.loaded;
            console.log(Math.floor(e.loaded / e.total *100) + '%');
        };
        return xhr;
      },
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
