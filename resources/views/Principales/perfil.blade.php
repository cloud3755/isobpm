@extends('layouts.principal2')

@section('content')
<br>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#FFF;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Mi Perfil</h1>
    </div>
</div>

<br><br><br><br><br>
<div class="row">
    <div class="col-lg-12">
        <h3><i class="fa fa-user fa-2x"></i>&nbsp;Información Usuario</h3>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>{{ Auth::user()->usuario }}</div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Usuario</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>{{ Auth::user()->nombre }}</div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Nombre</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>
                          @if(Auth::user()->perfil == 1)
                            Super-Administrador
                          @elseif(Auth::user()->perfil == 2)
                            Partner
                          @elseif(Auth::user()->perfil == 3)
                            Administrador
                          @else
                            Usuario
                          @endif
                        </div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Perfil</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>
                          @if(Auth::user()->telefono)
                            {{Auth::user()->telefono}}
                          @else
                            Sin telefono
                          @endif
                        </div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Teléfono</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>{{ Auth::user()->created_at }}</div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Fecha Creación</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>{{ Auth::user()->updated_at }}</div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Fecha Ultima Actualizacion</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>
                          @if(Auth::user()->status == 1)
                            Pendiente
                          @elseif(Auth::user()->status == 2)
                            Suspendido
                          @else
                            Activo
                          @endif
                        </div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Estatus</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12">
                        <div>
                        <span id='val'>
                            @if(Auth::user()->nombreimagen!=null)
                               {{ Auth::user()->nombreimagen}}
                            @else
                                No se ha subido imagen
                            @endif
                        </span>
                        <form id="form1" method="POST" action="{{ action('AdministradosController@imageUserStore') }}" enctype="multipart/form-data">

                        <input style="display:none;" id="imagen" type="file" name="imagen">
                        <button  id="btnSeleccionarImagen" class="btn btn-default" type="button" value="Seleccione" >Seleccione</button>
                        <button id="btnSubirImagen" class="btn btn-default" type="submit" value="" disabled><i class="fa fa-cloud-upload" aria-hidden="true"></i></button>
                        {{ csrf_field() }}
                        </form>

                        </div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Imagen</span>
                    <span class="pull-right" >
                        @if(Auth::user()->nombreimagen!=null)
                        <img style="width: 50px;height: 50px;"  src="/storage/imagenesusuarios/{{Auth::user()->nombreunicoimagen}}" />

                        @else
                        <img style="width: 50px;height: 50px;"  src="/img/tableCredential images/user.jpg" />
                        @endif
                    </span>
                    <div class="clearfix"></div>
                </div>



        </div>
    </div>
</div>

<div class="row">
  <div class="col-lg-6" >
    <button type="button" class="btn btn-primary" id="btndesempeño" style="font-family: Arial;" name="btndesempeño" data-dismiss="modal" data-toggle="modal" data-target="#modaldesempeño" value="<?=$Users->id?>" onclick="abremodaldesempeño(this)"><i class="glyphicon glyphicon-stats"></i><br>Desempeño</button>
  </div>
</div>


<!-- Modal para mostrar desempeño-->
    <div class="modal fade" id="modaldesempeño" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
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

$('#btnSeleccionarImagen').click(function () {
    $("#imagen").click();
});

$("#imagen").change(function () {
    $('#val').text(document.getElementById("imagen").files[0].name);
    $('#btnSubirImagen').prop('disabled', false);
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



</script>
@stop
