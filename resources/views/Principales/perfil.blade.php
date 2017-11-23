@extends('layouts.principal2')

@section('content')
<br>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#FFF;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Mi Perfil</h1>
    </div>
</div>

<br>
<div class="row">
    <div class="col-lg-12">
      <center>                      <span class="" >
                              @if(Auth::user()->nombreimagen!=null)
                              <img style="width: 50px;height: 50px;"  src="/storage/imagenesusuarios/{{Auth::user()->nombreunicoimagen}}" />

                              @else
                              <img style="width: 50px;height: 50px;"  src="/img/tableCredential images/user.jpg" />
                              @endif
                          </span><h3> {{ Auth::user()->usuario }} </h3></center>
    </div>
</div>
<br>
<div class="row">
<div class="col-sm-2"></div>
  <div class="col-sm-3">
       <h4><label class="label btn-primary" for="personalACargo"> Nombre: </label></h4>
       <label class="" for="personalACargo"> {{ Auth::user()->nombre }} </label>
  </div>
  <div class="col-sm-3">
       <h4><label class="label btn-primary" for="personalACargo"> Perfil: </label></h4>
       <label class="" for="personalACargo">                           @if(Auth::user()->perfil == 1)
                                   Super-Administrador
                                 @elseif(Auth::user()->perfil == 2)
                                   Partner
                                 @elseif(Auth::user()->perfil == 3)
                                   Administrador
                                 @else
                                   Usuario
                                 @endif</label>
  </div>
  <div class="col-sm-3">
       <h4><label class="label btn-primary" for="personalACargo"> Telefono: </label></h4>
       <label class="" for="personalACargo">  @if(Auth::user()->telefono)
                                   {{Auth::user()->telefono}}
                                 @else
                                   Sin telefono
                                 @endif</label>
  </div>
</div>
<br>
<div class="row">
<div class="col-sm-2"></div>
  <div class="col-sm-3">
       <h4><label class="label btn-primary" for="personalACargo"> Fecha Creación </label></h4>
       <label class="" for="personalACargo">  {{ Auth::user()->created_at }}</label>
  </div>
  <div class="col-sm-3">
       <h4><label class="label btn-primary" for="personalACargo"> Estatus: </label></h4>
       <label class="" for="personalACargo">                           @if(Auth::user()->status == 1)
                                   Pendiente
                                 @elseif(Auth::user()->status == 2)
                                   Suspendido
                                 @else
                                   Activo
                                 @endif
                               </label>
  </div>

  <div class="col-sm-3">
       <h4><label class="label btn-primary" for="personalACargo"> Imagen: </label></h4>
       <label class="" id="val" for="personalACargo">
           @if(Auth::user()->nombreimagen!=null)
              {{ Auth::user()->nombreimagen}}
           @else
               No se ha subido imagen
           @endif
       </label>
  </div>

</div>

<br>
<div class="row">
  <div class="col-sm-2"></div>
<div class="col-sm-3">
  <form id="form1" method="POST" action="{{ action('AdministradosController@imageUserStore') }}" enctype="multipart/form-data">

  <input style="display:none;" id="imagen" type="file" name="imagen">
  <button  id="btnSeleccionarImagen" class="btn btn-primary" type="button" value="Seleccione" ><i class="fa fa-file-photo-o" aria-hidden="true"> </i><br>Seleccionar imagen</button>
  <button id="btnSubirImagen" class="btn btn-primary" type="submit" value="" disabled><i class="fa fa-cloud-upload" aria-hidden="true"></i><br>Guardar imagen</button>
  {{ csrf_field() }}
  </form>
       </div>

  <div class="col-lg-3">
    <button type="button" class="btn btn-primary" id="btndesempeño" style="font-family: Arial;" name="btndesempeño" data-dismiss="modal" data-toggle="modal" data-target="#modaldesempeño" value="<?=$Users->id?>" onclick="abremodaldesempeño(this)"><i class="glyphicon glyphicon-stats"></i><br>Desempeño</button>
  </div>

</div>


<br>
<div class="row">
  <div class="col-lg-12">
      <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#FFF;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Mis archivos</h1>
  </div>

      <div class="col-lg-12">
          <div class="panel panel-red">
              <div class="panel-heading">
                  Archivos
                  <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-floppy-save"></i></button>
              </div>
          <div class="panel-body">
            <div class="row">
              <div class="table-responsive">
                <form>
                    Buscar <input id="searchTerm" type="text" onkeyup="doSearch()" />
                </form>
                <br>
            <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="fdatos">
              <thead style='background-color: #868889; color:#FFF'>
                <tr>
                  <th>  <div class="th-inner sortable both">    Nombre  </div></th>
                  <th>  <div class="th-inner sortable both">    Tamaño  </div></th>
                  <th>  <div class="th-inner sortable both">    Archivo  </div></th>
                  <th>  <div class="th-inner sortable both">    Eliminar  </div></th>
                </tr>
              </thead>
              <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
              <tbody id = "FmyTable">
                <?php foreach ($archivos as $archivo): ?>
                <tr>
                  <td><?=$archivo->nombre?></td>
                    <td><?=$archivo->size?></td>
                    <td>
                      <a href="/perfil/file/ver/<?=$archivo->id?>" target="_blank" style=\'color:#FFF\'><button type="button" <?php if ($archivo->archivo == 'No se cargo archivo') { echo"disabled";} else {echo"";} ?> class="btn btn-warning"><i class="glyphicon glyphicon-cloud-download"></i></button> </a>
                    </td>
                      <td><form class="form-inline" action="/perfil/file/delete/<?=$archivo->id?>" method="delete"> <input type="hidden" name="_token" value="{{{ csrf_token() }}}"> <button type="submit" class="btn btn-danger" id="btndelete_<?=$archivo->id?>" style="font-family: Arial;" dataid=<?=$archivo->id?>
                        onclick="return confirm('Estas seguro de eliminar el archivo?')"><i class="fa fa-trash"></i></button></form>
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



<!-- Modal para Documentos-->
<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title">ALTA DE DOCUMENTO</h3>
            </div>
            <div class="modal-body">
              <form class="" action="/guardararchivosperfil1" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="container">
                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Nombre:</label></h2>
                    <div class="col-md-6 col-sm-9">
                        <input class="form-control input-lg" id="nombrearchivo" type="Text" placeholder="Nombre" name="nombrearchivo" required>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Archivo:</label></h2>
                    <div class="col-md-6 col-sm-9">
                        <input id="fileusr" type="file" name="fileusr[]" multiple="multiple" required>
                    </div>
                </div>
              </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success" id="btnobjetivo"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
</div>

<!-- Final Modal Documentos-->


<!-- Modal para mostrar desempeño-->
    <div class="modal fade" id="modaldesempeño" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title">DESEMPEÑO DE USUARIO</h2>
                </div>
                <div class="modal-body">
                  <form class="" action="" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="iddesempeño" id="iddesempeño" value="">
                    <div class="row">
                      <center>
                      <div class="col-lg-2">
                          <label style="font-weight: bold">Periodo:</label>
                          <input type="month" class="form-control" id="periodo" name="periodo" />
                      </div>
                      <div class="col-lg-2">
                        <button type="button" class="btn btn-primary" id="btnbuscadesempeño" style="font-family: Arial;" name="btnbuscadesempeño" onclick="buscadesempeño()"><i class="glyphicon glyphicon-search"></i><br>Buscar</button>
                      </div>
                      <div class="col-lg-4">
                        <label  class="control-label" for="sumaponderado">Suma ponderados:</label>
                        <h4 id="labelponderado">  </h4>
                      </div>
                      <div class="col-lg-4">
                        <label  class="control-label" for="sumaponderado">Resultado del periodo:</label>
                        <h4 id="labelresultado">  </h4>
                      </div>
                      </center>
                    </div>
                    <br>
                    <div class="row" id="tablecontainer">
                      <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
                        <thead style='background-color: #868889; color:#FFF'>
                          <tr>
                            <th>  <div class="th-inner sortable both">    Indicador  </div></th>
                            <th>  <div class="th-inner sortable both">    Periodo  </div></th>
                            <th>  <div class="th-inner sortable both">    Ponderacion  </div></th>
                            <th>  <div class="th-inner sortable both">    Resultado  </div></th>
                            <th>  <div class="th-inner sortable both">    Logica  </div></th>
                            <th>  <div class="th-inner sortable both">    Meta  </div></th>
                            <th>  <div class="th-inner sortable both">    Cumple  </div></th>
                          </tr>
                        </thead>
                       <tbody id = "tablaindicadores">

                      </tbody>
                     </table>

                    </div>
                        <div class="modal-footer">

                        </div>
                      </form>
                    </div>
                </div>
            </div>
    </div>
<!-- Fin del modal para mostrar desempeño-->



<script>

$('#btnSubirImagen').hide();

$('#btnSeleccionarImagen').click(function () {
    $("#imagen").click();
});

$("#imagen").change(function () {
    $('#val').text(document.getElementById("imagen").files[0].name);
    $('#btnSubirImagen').prop('disabled', false);
    $('#btnSubirImagen').show();
});


function buscadesempeño() {

if ($("#periodo").val() == "")
{
  return false;
}

$("#labelresultado").empty();
$("#labelponderado").empty();
$("#tablaindicadores").empty();

var route = "/usuarios/desempeno/" + $("#iddesempeño").val() + "/" + $("#periodo").val();

$.get(route, function(res){

 var ponderado = 0
 var resultado = 0
 var conseguido = ""

    for (var i = 0; i < res.length; i++) {

    ponderado = ponderado + res[i].ponderacion

  switch(res[i].logica) {
      case '=':
          if(res[i].resultado == res[i].meta) {
          conseguido = "SI";
          } else {
          conseguido = "NO";
          }
          $("#tablaindicadores").append('<tr><td><center>'+res[i].indicador+'</center></td><td><center>'+res[i].periodo+'</center></td><td><center>'+res[i].ponderacion+'</center></td><td><center>'+res[i].resultado+'</center></td><td><center>'+res[i].logica+'</center></td><td><center>'+res[i].meta+
          '</center></td><td><center>'+ conseguido + '</center></td></tr>');

          if(res[i].resultado == res[i].meta) {
            resultado = resultado + res[i].ponderacion;
          }

                   break;

       case '<>':
           if(res[i].resultado != res[i].meta) {
          conseguido =  "SI";
           }
           else {
          conseguido =  "NO";
          }
           $("#tablaindicadores").append('<tr><td><center>'+res[i].indicador+'</center></td><td><center>'+res[i].periodo+'</center></td><td><center>'+res[i].ponderacion+'</center></td><td><center>'+res[i].resultado+'</center></td><td><center>'+res[i].logica+'</center></td><td><center>'+res[i].meta+
           '</center></td><td><center>'+ conseguido + '</center></td></tr>');

           if(res[i].resultado != res[i].meta) {
             resultado = resultado + res[i].ponderacion;
           }

                    break;

        case '>':
            if(res[i].resultado > res[i].meta) {
              conseguido = "SI";
            }
            else {
              conseguido = "NO";
            }
            $("#tablaindicadores").append('<tr><td><center>'+res[i].indicador+'</center></td><td><center>'+res[i].periodo+'</center></td><td><center>'+res[i].ponderacion+'</center></td><td><center>'+res[i].resultado+'</center></td><td><center>'+res[i].logica+'</center></td><td><center>'+res[i].meta+
            '</center></td><td><center>'+ conseguido + '</center></td></tr>');

            if(res[i].resultado > res[i].meta) {
              resultado = resultado + res[i].ponderacion;
            }

                     break;

         case '<':
             if(res[i].resultado < res[i].meta) {
               conseguido = "SI";
              }
              else {
                conseguido = "NO";
              }
             $("#tablaindicadores").append('<tr><td><center>'+res[i].indicador+'</center></td><td><center>'+res[i].periodo+'</center></td><td><center>'+res[i].ponderacion+'</center></td><td><center>'+res[i].resultado+'</center></td><td><center>'+res[i].logica+'</center></td><td><center>'+res[i].meta+
             '</center></td><td><center>'+ conseguido + '</center></td></tr>');

             if(res[i].resultado < res[i].meta) {
               resultado = resultado + res[i].ponderacion;
             }

                      break;

          case '>=':
              if(res[i].resultado >= res[i].meta) {
                conseguido = "SI";
              }
              else {
                conseguido = "NO";
              }
              $("#tablaindicadores").append('<tr><td><center>'+res[i].indicador+'</center></td><td><center>'+res[i].periodo+'</center></td><td><center>'+res[i].ponderacion+'</center></td><td><center>'+res[i].resultado+'</center></td><td><center>'+res[i].logica+'</center></td><td><center>'+res[i].meta+
              '</center></td><td><center>'+ conseguido + '</center></td></tr>');

              if(res[i].resultado >= res[i].meta) {
                resultado = resultado + res[i].ponderacion;
              }

                       break;

           case '<=':
              if(res[i].resultado <= res[i].meta) {
                 conseguido = "SI";
                }
                else {
                  conseguido = "NO";
                }
               $("#tablaindicadores").append('<tr><td><center>'+res[i].indicador+'</center></td><td><center>'+res[i].periodo+'</center></td><td><center>'+res[i].ponderacion+'</center></td><td><center>'+res[i].resultado+'</center></td><td><center>'+res[i].logica+'</center></td><td><center>'+res[i].meta+
               '</center></td><td><center>'+ conseguido + '</center></td></tr>');

               if(res[i].resultado <= res[i].meta) {
                 resultado = resultado + res[i].ponderacion;
               }

                        break;


    }
}
$("#labelponderado").append(ponderado + " %");
$("#labelresultado").append(resultado + " %");

  });

}

function abremodaldesempeño(btn) {

$("#iddesempeño").val(btn.value);

}

function doSearch()
{
  var tableReg = document.getElementById('fdatos');
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
