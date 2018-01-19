@extends('layouts.principal2')

@section('content')
<link rel="stylesheet" href="Tree/themes/default/style.min.css" />
<div>
    @if(Auth::user()->nombreimagen!=null)
        <img style="width: 80px;height: 80px;"  src="/storage/imagenesusuarios/{{Auth::user()->nombreunicoimagen}}" />
    @else
        <img style="width: 80px;height: 80px;"  src="/img/tableCredential images/user.jpg" />
    @endif

</div>
<div>
<p>bienvenido: <strong>{{Auth::user()->nombre}}</strong><p>
  <input type="hidden" name="Perfil" id="Perfil" value="{{Auth::user()->perfil}}">
</div>
<div >
    <div class="col-sm-4">
        <div class="panel panel-info">
            <div class="panel-heading panel-heading2">Navegar</div>
	        <div class="panel-body panel-body2 PrincipalPanel scrollablePanel PersonalScroll">
                <a data-toggle="collapse" href="#collapseDocumentos">
                <i class="fa fa-file-text fa-2x"></i>Mis documentos</a>
                <div id="collapseDocumentos" class="collapse">
                    <ul>
                        @if(count($documento)<=0)
                            <li class="text-danger">Sin documentos</li>
                        @else
                            @foreach($documento as $doc)
                                <li><a data-token="{{ csrf_token() }}" class="documentosclick" id="{{$doc->id}}" href="#">{{$doc->nombre}}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <br>
                <a data-toggle="collapse" href="#collapseIndicadores">  <i class="fa fa-crosshairs fa-2x"></i>Mis indicadores</a>
                <div id="collapseIndicadores" class="collapse">
                    <ul>
                        @if(count($indicadora)<=0)
                            <li class="text-danger">Sin indicadores</li>
                        @else
                            @foreach($indicadora as $indica)
                                <li><a href="resultado/registro/{{$indica->id}}">{{$indica->nombre}}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <br>
                <a data-toggle="collapse" href="#collapseProcesos">  <i class="fa fa-cogs fa-2x"></i>Mis procesos</a>
                <div id="collapseProcesos" class="collapse">
                    <ul>
                        @if(count($procesoa)<=0)
                            <li class="text-danger">Sin procesos</li>
                        @else
                            @foreach($procesoa as $pro)
                                <li><a href="procesos/registro/{{$pro->id}}">{{$pro->proceso}}</a></li>
                            @endforeach

                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <span></span>
    <div class="col-sm-4">
        <div class="panel panel-info">
            <div class="panel-heading panel-heading2">
                <div id"btnAgregarPendiente">
                Pendientes
            </div>
        </div>
        <div class="panel-body panel-body2 PrincipalPanel scrollablePanel PersonalScroll">
            <a data-toggle="collapse" href="#collapseQuejas">
            <i class="fa fa-user-times fa-2x"></i>Quejas</a>
            <div id="collapseQuejas" class="collapse">
              <div id="jstreequejas">
                <ul>
                    @if(count($quejas)<=0)
                    <li class="text-success">Asignados
                      <ul>
                        <li data-jstree='{"icon":"glyphicon glyphicon-ban-circle"}' class="text-success">Sin quejas</li>
                      </ul>
                    </li>
                    @else
                    <li class="text-danger">Asignados
                      <ul>
                        @foreach($quejas as $queja)
                            <li data-jstree='{"icon":"glyphicon glyphicon-ban-circle"}'><a data-toggle="modal" data-target="#modaleditq" onclick="EditarQ({{$queja->id}},1);">{{$queja->descripcion}}</a></li>
                        @endforeach
                      </ul>
                    </li>
                    @endif
                    @if(count($quejascreados)<=0)
                    <li class="text-success">Creados
                      <ul>
                        <li data-jstree='{"icon":"glyphicon glyphicon-ban-circle"}' class="text-success">Sin quejas</li>
                      </ul>
                    </li>
                    @else
                    <li class="text-danger">Creados
                      <ul>
                        @foreach($quejascreados as $quejascreado)
                            <li data-jstree='{"icon":"glyphicon glyphicon-ban-circle"}'><a data-toggle="modal" data-target="#modaleditq" onclick="EditarQ({{$quejascreado->id}},2);">{{$quejascreado->descripcion}}</a></li>
                        @endforeach
                      </ul>
                    </li>
                    @endif
                </ul>
              </div>
            </div>
            <br>
            <a data-toggle="collapse" href="#collapseAcciones">
            <i class="fa fa-user-times fa-2x"></i>Acciones correctivas</a>
            <div id="collapseAcciones" class="collapse">
              <div id="jstreeacciones">
                <ul>
                    @if(count($accionesCorrectivas)<=0)
                    <li class="text-success">Asignados
                      <ul>
                        <li data-jstree='{"icon":"glyphicon glyphicon-ban-circle"}' class="text-success">Sin Acciones</li>
                      </ul>
                    </li>
                    @else
                    <li class="text-danger">Asignados
                      <ul>
                        @foreach($accionesCorrectivas as $accionesCorrectiva)
                            <li data-jstree='{"icon":"glyphicon glyphicon-ban-circle"}'><a data-toggle="modal" data-target="#modaledit" onclick="Editar({{$accionesCorrectiva->id}},1);">{{$accionesCorrectiva->descripcion}}</a></li>
                        @endforeach
                      </ul>
                    </li>
                    @endif
                    @if(count($accionesCorrectivascreado)<=0)
                    <li class="text-success">Creados
                      <ul>
                        <li data-jstree='{"icon":"glyphicon glyphicon-ban-circle"}' class="text-success">Sin Acciones</li>
                      </ul>
                    </li>
                    @else
                    <li class="text-danger">Creados
                      <ul>
                        @foreach($accionesCorrectivascreado as $accionesCorrectivascreados)
                            <li data-jstree='{"icon":"glyphicon glyphicon-ban-circle"}'><a data-toggle="modal" data-target="#modaledit" onclick="Editar({{$accionesCorrectivascreados->id}},2);">{{$accionesCorrectivascreados->descripcion}}</a></li>
                        @endforeach
                      </ul>
                    </li>
                    @endif
                </ul>
              </div>
            </div>
            <br>
            <a data-toggle="collapse" href="#collapseNoConformidades">
            <i class="fa fa-thumbs-o-down fa-2x"></i>No conformidades</a>
            <div id="collapseNoConformidades" class="collapse">
              <div id="jstree">
                <!-- in this example the tree is populated from inline HTML -->
                <ul>
                  @if(count($Noconformidades)<=0)
                    <li class="text-success">Asignados
                      <ul>
                        <li class="text-success">Sin PNC</li>
                  @else
                  <li class="text-danger">Asignados
                    <ul>
                    @foreach($mesnoconf as $mesnoconfs)
                    <li>{{$mesnoconfs->mes}}
                      <ul>
                      @foreach($dianoconf as $dianoconfs)
                        @if($dianoconfs->mes == $mesnoconfs->mes)
                          <li>{{$dianoconfs->dia}}
                            <ul>
                              @foreach($Noconformidades as $Noconformidad)
                                @if($mesnoconfs->mes == $Noconformidad->mes and $dianoconfs->dia == $Noconformidad->dia)
                                  <li data-jstree='{"icon":"glyphicon glyphicon-ban-circle"}'><a data-toggle="modal" data-target="#modaledit_nc" onclick="EditarNC({{$Noconformidad->id}},{{ Auth::user() }}, 1);">{{$Noconformidad->id}}</a></li>
                                @endif
                              @endforeach
                            </ul>
                          </li>
                          @endif
                        @endforeach
                          </ul>
                        </li>
                        @endforeach
                      @endif
                    </ul>
                  </li>
                  @if(count($Noconformidadescreador)<=0)
                    <li class="text-success">Creados
                      <ul>
                        <li class="text-success">Sin PNC</li>
                  @else
                  <li class="text-danger">Creados
                    <ul>
                    @foreach($mesnoconfcreador as $mesnoconfcreadors)
                    <li>{{$mesnoconfcreadors->mes}}
                      <ul>
                      @foreach($dianoconfcreador as $dianoconfcreadors)
                        @if($dianoconfcreadors->mes == $mesnoconfcreadors->mes)
                          <li>{{$dianoconfcreadors->dia}}
                            <ul>
                              @foreach($Noconformidadescreador as $Noconformidad)
                                @if($mesnoconfcreadors->mes == $Noconformidad->mes and $dianoconfcreadors->dia == $Noconformidad->dia)
                                  <li data-jstree='{"icon":"glyphicon glyphicon-ban-circle"}'><a data-toggle="modal" data-target="#modaledit_nc" onclick="EditarNC({{$Noconformidad->id}}, {{ Auth::user() }}, 2);">{{$Noconformidad->id}}</a></li>
                                @endif
                              @endforeach
                            </ul>
                          </li>
                          @endif
                        @endforeach
                          </ul>
                        </li>
                        @endforeach
                      @endif
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <br>
            <a data-toggle="collapse" href="#collapseProyectos">
            <i class="fa fa-tasks fa-2x"></i>Proyectos</a>
            <div id="collapseProyectos" class="collapse">
                <ul>
                    @if(count($mejorasid)<=0)
                        <li class="text-danger">Sin Proyectos</li>
                    @else
                        @foreach($mejorasid as $mejoras)
                            <li><a href="/subiretapa/etapa/{{$mejoras->id}}">{{$mejoras->proyecto}}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    </div>

<span></span>
<div class="col-sm-4">

    <div class="panel panel-info panelNoticias">
        <div class="panel-heading panel-heading2">Noticias
        @if(Auth::user()->perfil != 4)
                        <i data-toggle="modal" data-target="#modalAgregarNoticia" class="fa fa-plus-square-o" aria-hidden="true"></i>
        @endif
        </div>
        <div class="panel-body panel-body2">
            <div class="scrollablePanel PersonalScroll" style="border:1px solid #002858;max-height: 15vh">

                    @foreach ($noticiasw as $noticia)
                      <li><a class="icon-bar-graph" data-toggle="modal" data-target="#modaleditnoticia" onclick="EditarNot({{$noticia->id}});">{{$noticia->titulo}}</a></li>
                    @endforeach

            </div>
        </div>
    </div>

    <div class="panel panel-info panelNoticias">
        <div class="panel-heading panel-heading2">Links de interes
        @if(Auth::user()->perfil != 4)
            <i data-toggle="modal" data-target="#modalAgregarLink" class="fa fa-plus-square-o" aria-hidden="true"></i>
        @endif
        </div>
        <div class="panel-body panel-body2">
            <div class="scrollablePanel PersonalScroll" style="border:1px solid #002858;max-height: 15vh">
                <li><a href="http://moodleisobpm.com/" class="icon-bar-graph">ISOBPM moodle</a></li>
                @foreach ($Link as $link)
                        <li><a href="{{$link->URL}}" class="icon-bar-graph">{{$link->NombreCorto}}</a></li>
                @endforeach
            </div>
        </div>
    </div>

<div class="panel panel-info panelEventos">
    <div class="panel-heading panel-heading2">Eventos</div>
        <div class="panel-body panel-body2">
            <div class="scrollablePanel PersonalScroll calendar" style="max-height: 33vh">

            <center><button type="button" class="btn btn-success" data-toggle="modal" data-dismiss="modal" data-target="#modalAgregarEvento"><i class="glyphicon glyphicon-floppy-save"></i> Agregar</button></center>
                <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
                <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
                <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
            </div>
        </div>
    </div>
</div>
</div>
<!--
                                            <?php foreach ($noticiasw as $noticia): ?>
                                            <li><a href="#" class="icon-bar-graph"><?=$noticia->Noticia?></a></li>
                                            <?php endforeach ?>

-->
      </div>
    </div>
</div>

    </div>
@if(Auth::user()->perfil == 1 or Auth::user()->perfil == 2)
  <div class="Row">
    <div class="form-group form-group-lg">
      <form  action="/cambioempresa/edit" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        <h2><label for="tipo" class="control-label col-md-12" >Selecciona una empresa:</label></h2>
        <div class="col-md-6">
            <select class="form-control input-lg" name="empresa" id= "empresa">
              <option value="0" selected>Sin Empresa</option>
              <?php foreach ($empresa as $empresas): ?>
                <option value="<?=$empresas['id']?>"><?=$empresas['razonSocial']?></option>
              <?php endforeach ?>
            </select>
        </div>
        <div class="col-md-6">
          <button type="submit" class="btnobjetivo" id="btnEditCli" style="font-family: Arial;">Seleccionar</button>
      </div>
      </form>
    </div>
  </div>
@endif
<button id="btn_modalversion" type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalversion" style="border:0px; width:0px; height:0px;"></button>

  </div>
</div>




<!-- modal para el el calendario


<div class="modal fade" id="modalcalendario" role="application" style="background-color:gray">
<div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center><h2 class="modal-title">Calendario de pendientes</h2></center></br>
                <center><button type="button" class="btn btnobjetivo" data-toggle="modal" data-dismiss="modal" data-target="#modalAgregarEvento" onclick="#modalAgregarEvento">Agregar Evento</button></center>
            </div>
                <div class="modal-body">

                      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                      <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
                      <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
                      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>


                            {!! $calendar->calendar() !!}
                            {!! $calendar->script() !!}

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
        </div>
</div>
</div>
<!-- modal para el el calendario-->

<!-- modal para agregar evento al calendario-->

<div class="modal fade" id="modalAgregarEvento" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Agregar pendiente</h2>
            </div>
                <div class="modal-body">

                        <form class="form-group" action="/calendarioagenda/store" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="form-group form-group-md col-lg-12">
                            <div class="col-lg-6">
                                <h3><label for="Tituloevento" class="control-label" >Titulo del pendiente:</label></h3>
                                <input class="form-control input-lg" type="text" class="form-control" id = "title" placeholder="Nombre del evento" name="title">
                            </div>
                            <div class="col-lg-6">
                                <h3><label for="all_day" class="control-label">Todo el dia:</label></h3>
                                <select class="form-control input-lg" id = "all_day"  name="all_day">
                                    <option selected="selected" value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-md col-lg-12">
                            <div class="col-lg-6">
                                <h2><label for="start" class="control-label">Inicio:</label></h2>
                                <input type="datetime-local" class="form-control input-md" id = "start" name="start" value="<?php  echo date ( 'Y-m-d\TH:i' , time()  )?>">
                            </div>
                            <div class="col-lg-6">
                                <h2><label for="end" class="control-label"> Fin:</label></h2>
                                <input type="datetime-local" class="form-control input-md" id = "end" name="end" value="<?php  echo date ( 'Y-m-d\TH:i' , time()  )?>">
                            </div>
                        </div>
                        <div class="form-group form-group-md col-lg-12">
                            <div class="col-lg-6">
                                <h2><label for="color" class="control-label">Color de pendiente:</label></h2>
                                <input class="form-control input-md" type="color" id="color" name="color" onchange="clickColor(0, -1, -1, 5)" value="#0099ff" >
                            </div>
                            <div class="col-lg-6">
                                <h2><label for="descripcion" class="control-label">Descripcion del pendiente:</label></h2>
                                <textarea id="descripcion" name="descripcion" rows="3" class="form-control input-md"></textarea>
                            </div>
                        </div>
                        <center>
                        <h2>Elegir areas</h2>
                        <table>
                            <tbody>
                                <tr>
                                    <td>Areas no elegidas</td>
                                    <td></td>
                                    <td>Areas elegidas</td>
                                </tr>
                                <tr>
                                    <td>
                                        <select multiple name="listaAreas[]" id="listaAreas" size="7" style="width: 100%;" onclick="agregaSeleccion('listaAreas', 'listaAreasSeleccionadas');">
                                            @foreach ($Areas as $Area): ?>

                                            <option value = "{{$Area->id}}" > {{$Area->nombre}} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('listaAreas', 'listaAreasSeleccionadas');">
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
                                                        <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('listaAreasSeleccionadas', 'listaAreas');">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <select multiple="multiple" name="listaAreasSeleccionadas[]" id="listaAreasSeleccionadas" size="7" style="width: 100%;" onclick="agregaSeleccion('listaAreasSeleccionadas','listaAreas');"></select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </center>
                </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success" id="btnNoticia"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</button>
                        </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                        </div>
                    </div>
                </div>
    </div>
</div>

<!-- modal para agregar evento al calendario-->

<!-- modal ver evento -->
<div  class="modal fade" id="modaleventoclick" tabindex="-1" role="dialog">
    <div   class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title" id="TituloEvento">Evento</h2>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="fileinfo_eve" method="post">
                  <input type="hidden" name="_token" value="{{ csrf_token()}}">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <p id="MensajeEvento"></p>
                    <p style="visibility:hidden" id="id_eve"></p>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              @if(Auth::user()->perfil != 4)
                <a class="btn btn-danger" id="eliminarevento" style="font-family: Arial;"><i class="fa fa-trash"></i><br>Eliminar</a>
              @endif
              <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- modal ver evento -->

@if(Auth::user()->perfil != 4)

<!-- modal Agregar link -->
<div class="modal fade" id="modalAgregarLink" tabindex="-1" role="dialog" style="background-color:gray">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Agregar Link</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="{{ action('AdministradosController@LinkStore') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group form-group-md col-lg-12">
                            <div class="col-lg-6">
                                <h2><label for="Url" class="control-label">Link:<br><br></label></h2>
                                <input class="form-control input-md" type="text" name="Url" placeholder"Texto a mostrar" id="Url" required>
                            </div>
                            <div class="col-lg-6">
                                <h2><label for="NombreCorto" class="control-label">Nombre a mostrar:</label></h2>
                                <input class="form-control input-md" type="text" name="NombreCorto" placeholder"Dirección" id="NombreCorto" required>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btnAgregarLink"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal Agregar Noticia -->
<div class="modal fade" id="modalAgregarNoticia" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Agregar Noticia</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                <form action="{{ action('AdministradosController@noticiastore') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-lg-12">
                        <h2><label for="titulonoticia" class="control-label">Titulo:</label></h2>
                        <input class="form-control" id="titulonoticia" rows="3" placeholder="Titulo" name="titulonoticia" required></input>
                    </div>
                    <div class="col-lg-12">
                        <h2><label for="descripcionNoticia" class="control-label">Noticia:</label></h2>
                        <textarea class="form-control" id="descripcionNoticia" rows="3" placeholder="Noticia" name="descripcionNoticia" required></textarea>
                    </div>
                    <div class="col-lg-12">
                        <h2><label for="descripcionNoticia" class="control-label">Visible hasta::</label></h2>
                        <input type="date" class="form-control" id="fecha_hasta" rows="3" name="fecha_hasta" required></input>
                    </div>
                    <center>
                        <h2>Elegir areas</h2>
                        <table>
                            <tbody>
                                <tr>
                                    <td>Areas no elegidas</td>
                                    <td></td>
                                    <td>Areas elegidas</td>
                                </tr>
                                <tr>
                                    <td>
                                        <select multiple name="nlistaAreas[]" id="nlistaAreas" size="7" style="width: 100%;" onclick="agregaSeleccion('nlistaAreas', 'nlistaAreasSeleccionadas');">
                                            @foreach ($Areas as $Area): ?>

                                            <option value = "{{$Area->id}}" > {{$Area->nombre}} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('nlistaAreas', 'nlistaAreasSeleccionadas');">
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
                                                        <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('nlistaAreasSeleccionadas', 'nlistaAreas');">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <select multiple="multiple" name="nlistaAreasSeleccionadas[]" id="nlistaAreasSeleccionadas" size="7" style="width: 100%;" onclick="agregaSeleccion('nlistaAreasSeleccionadas','nlistaAreas');" required></select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btnNoticia"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endif

<!-- modal ver procesos -->
<!-- modal ver noticia -->

<div class="modal fade" id="modaleditnoticia" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title">Noticia</h3>
            </div>
            <div class="modal-body">
              <form id="fileinfo_not" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <input type="hidden" id="id_not">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <h3><label>Titulo:</label></h3>
                    <input class="form-control input-lg"  type="text" placeholder="Titulo" name="titulo_not"  id="titulo_not" required="">
                  </div>

                  <div class="col-lg-12 col-md-12 col-sm-12">
                      <h3><label> Decripcion:</label></h3>
                          <textarea class="form-control" id = "noticia__not" rows="3" name="noticia__not" placeholder="Descripcion Noticia" required=""></textarea>
                  </div>

                </div>
                <div class="modal-footer">
                  @if(Auth::user()->perfil != 4)
                  <a class="btn btn-danger" id="eliminarnoticia" style="font-family: Arial;"><i class="fa fa-trash"></i><br>Eliminar</a>
                  @endif
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
</div>

<div class="modal fade" id="modalversion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
              <center>
                <h2 class="modal-title">ISObpm</h2>
              </center>
            </div>
            <div class="modal-body">
              <form>
                <div class="row" style="height: 460px;">
                  <div id="pagina1">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <p align="center" ><font size=6 color="#0167FF" >Nueva Versión</font></p>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <p><font size=5>
                          En esta nueva versión de ISObpm encontrarás una imagen totalmente renovada tanto en su navegación como en contenido, así como Módulos adicionales que ayudarán en la Operación de tu Sistema de Gestión.
                          <br>
                          <br>
                          ° Módulo de Inicio
                          <br>
                          ° Módulo de Proveedores
                          <br>
                          ° Módulo de Oportunidades
                          <br>
                        </font>
                       </p>
                    </div>
                  </div>
                <div id="pagina2" style="display:none;">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <p align="center" ><font size=6 color="#0167FF" >Nueva Página de Inicio</font></p>
                    <img src="/img/version/v2.png" style="width: 100%; height: 100%; float: left; margin-right:5px" />
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <p><font size=5>
                      En esta página de inicio personalizada por usuario podrás identificar tu principal información del Sistema de Gestión, así como un nuevo calendario de actividades, Noticias, y Links
                        <br>
                      </font>
                     </p>
                  </div>
                </div>
                <div id="pagina3" style="display:none;">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <p align="center" ><font size=6 color="#0167FF" >Nuevo Módulo de Proveedores</font></p>
                    <img src="/img/version/v3.png" style="width: 100%; height: 100%; float: left; margin-right:5px" />
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <p><font size=5>
                      En este nuevo módulo de Proveedores podrás dar de alta tu catálogo de suministros, tu catalogo de proveedores, y podrás realizar la evaluación de estos proveedores. También tendrás acceso a un Dashboard de reportes de resultados de las evaluaciones a tus proveedores.
                        <br>
                      </font>
                     </p>
                  </div>
                </div>
                <div id="pagina4" style="display:none;">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <p align="center" ><font size=6 color="#0167FF" >Nuevo Módulo de Oportunidades</font></p>
                    <img src="/img/version/v1.png" style="width: 80%; height: 50%; float: left; margin-right:5px" />
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <p><font size=5>
                      En este módulo de Oportunidades podrás generar tu catalogo de Oportunidades,
                       y realizar la identificación y análisis de oportunidades de tus procesos
                       desde su arquitectura. Además podrás acceder a un mapa de calor con la
                       identificación y clasificación de las oportunidades detectadas en el análisis.
                      </font>
                     </p>
                  </div>
                </div>
                </div>
                <center>
                <ul class="pagination">
                  <li id="lip1" class="active" ><a onClick="pagina1();">1</a></li>
                  <li id="lip2"><a onClick="pagina2();">2</a></li>
                  <li id="lip3"><a onClick="pagina3();">3</a></li>
                  <li id="lip4"><a onClick="pagina4();">4</a></li>
                </ul>
                </center>
              </form>
            </div>
          </div>
        </div>
</div>

<!-- modales de quejas -->
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
                          <?php foreach ($Areas as $areas): ?>
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
                      <input class="file" id="file-2" type="file" placeholder="Archivo" name="earchivo2_q">
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
<!-- modales de quejas -->
<!-- modales acciones correctivas -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h3 class="modal-title">ACTUALIZAR ACCION CORRECTIVA</h3>
                </div>
                <div class="modal-body">
                  <form id="fileinfo" method="post">
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
                                  <?php foreach ($productos as $producto): ?>
                                    <option value="<?=$producto['id']?>"><?=$producto['nombre']?></option>
                                  <?php endforeach ?>
                                </select>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <h2><label>Area:</label></h2>
                                <select class="form-control input-lg" name="eid_area" id="eid_area" required="">
                                  <option value=""></option>
                                  <?php foreach ($Areas as $areas): ?>
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
                                <input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="earchivoa" id="earchivoa" >
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
                                <input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="earchivoe" id="earchivoe" >
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
                      <a class="btn btn-primary" id="actualizar" style="font-family: Arial;"><i class="glyphicon glyphicon-edit"></i><br>Editar</a>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                    </div>
                  </form>
                </div>
            </div>
          </div>
    </div>
<!-- modales acciones correctivas -->

<!-- modales no conformidades -->
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
                        <?php foreach ($proceso as $Procesos): ?>
                          <option value="<?=$Procesos['id']?>"><?=$Procesos['proceso']?></option>
                        <?php endforeach ?>
                      </select>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4">
                    <h3><label>Producto:</label></h3>
                      <select class="form-control input-lg" name="producto_id_nc" id="producto_id_nc">
                        <option value="21"></option>
                        <?php foreach ($productos as $producto): ?>
                          <option value="<?=$producto['id']?>"><?=$producto['nombre']?></option>
                        <?php endforeach ?>
                      </select>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4">
                    <h3><label>Area:</label></h3>
                        <select class="form-control input-lg" name="id_area_nc" id="id_area_nc">
                          <option value="2"></option>
                          <?php foreach ($Areas as $areas): ?>
                            <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                          <?php endforeach ?>
                        </select>
                </div>

                <div class="col-lg-8 col-md-8 col-sm-8">
                    <h3><label>Evidencia no conformidad:</label></h3>
                    <input class="form-control" type="text" placeholder="Archivo anterior ninguno" readonly name="archivoa_nc" id="archivoa_nc" >
                    <input class="file" id="archivo1_nc" type="file" placeholder="Archivo" name="archivo1_nc" id="archivo1_nc">
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
                    <input class="file" id="archivo2_nc" type="file" placeholder="Evidencia del cierre" name="archivo2_nc" id ="archivo2_nc">
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



<!-- modales no conformidades -->
<button style="display:none;" id="mostrarevento" data-toggle="modal" data-target="#modaleventoclick"/>

<!--script cargar datos modales-->
  <script src="Tree/jstree.min.js"></script>
    <script type="text/javascript">
    //funcion de Tree para que arranque
    $(function () {
      // 6 create an instance when the DOM is ready
      $('#jstree').jstree();
      $('#jstreequejas').jstree();
      $('#jstreeacciones').jstree();

      // 8 interact with the tree - either way is OK
      /*$('button').on('click', function () {
        $('#jstree').jstree(true).select_node('child_node_1');
        $('#jstree').jstree('select_node', 'child_node_1');
        $.jstree.reference('#jstree').select_node('child_node_1');
      });*/
    });
    function pagina1()
    {
      document.getElementById("lip1").className = "active";
      document.getElementById("lip2").className = "";
      document.getElementById("lip3").className = "";
      document.getElementById("lip4").className = "";
      $('#pagina1').show();
      $('#pagina2').hide();
      $('#pagina3').hide();
      $('#pagina4').hide();
    }
    function pagina2()
    {
      document.getElementById("lip1").className = "active";
      document.getElementById("lip2").className = "active";
      document.getElementById("lip3").className = "";
      document.getElementById("lip4").className = "";
      $('#pagina1').hide();
      $('#pagina2').show();
      $('#pagina4').hide();
      $('#pagina3').hide();
    }
    function pagina3()
    {
      document.getElementById("lip1").className = "active";
      document.getElementById("lip2").className = "active";
      document.getElementById("lip3").className = "active";
      document.getElementById("lip4").className = "";
      $('#pagina1').hide();
      $('#pagina2').hide();
      $('#pagina3').show();
      $('#pagina4').hide();
    }
    function pagina4()
    {
      document.getElementById("lip1").className = "active";
      document.getElementById("lip2").className = "active";
      document.getElementById("lip3").className = "active";
      document.getElementById("lip4").className = "active";
      $('#pagina1').hide();
      $('#pagina2').hide();
      $('#pagina3').hide();
      $('#pagina4').show();
    }

    function EditarNC(btn, responsable, bandeja){
      var route = "/noconformidad/"+btn+"/edit";
      $.get(route, function(res){
        $("#fileinfo_nc").find('input, textarea, button, select').prop('disabled', false);
        $("#estatus_id_nc").find('option').prop('disabled', false);
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
        $("#monto_nc").val(res.monto);

        $('#estatus_id_nc option[value="' + res.estatus_id + '"]').attr("selected", "selected");
        $('#estatus_id_nc option[value="6"]').attr("disabled", "disabled");
        var Perfil = document.getElementById('Perfil').value;
        if (Perfil== 4) {
          if (bandeja == 1) {
            if (res.estatus_id == 1 || res.estatus_id == 5) {
              $("#fecha_nc").attr("disabled", "disabled");
              $("#proceso_id_nc").attr("disabled", "disabled");
              $("#producto_id_nc").attr("disabled", "disabled");
              $("#id_area_nc").attr("disabled", "disabled");

              $("#archivo1_nc").attr("disabled", "disabled");
              $("#documento_nc").attr("disabled", "disabled");
              $("#descripcion_nc").attr("disabled", "disabled");
              $("#usuario_responsable_id_nc").attr("disabled", "disabled");

              $('#estatus_id_nc option[value="1"]').attr("disabled", "disabled");
              $('#estatus_id_nc option[value="3"]').attr("disabled", "disabled");
              $('#estatus_id_nc option[value="5"]').attr("disabled", "disabled");
            }
          }else {
            $("#acciones_nc").attr("disabled", "disabled");
            $("#fecha_plan_nc").attr("disabled", "disabled");
            $("#fecha_cierre_nc").attr("disabled", "disabled");
            $("#archivo2_nc").attr("disabled", "disabled");

            if (res.estatus_id == 1 || res.estatus_id == 5) {
              $('#estatus_id_nc').attr("disabled", "disabled");
            }else if (res.estatus_id == 2) {
              $('#estatus_id_nc option[value="1"]').attr("disabled", "disabled");
              $('#estatus_id_nc option[value="2"]').attr("disabled", "disabled");
              $('#estatus_id_nc option[value="4"]').attr("disabled", "disabled");
            }else if (res.estatus_id == 4) {
              $('#estatus_id_nc option[value="2"]').attr("disabled", "disabled");
              $('#estatus_id_nc option[value="4"]').attr("disabled", "disabled");
              $('#estatus_id_nc option[value="5"]').attr("disabled", "disabled");
            }
          }
        }
      });

    }

    function Editar(btn, bandeja){
      var route = "/accioncorrectiva/"+btn+"/edit";
      $.get(route, function(res){
        $("#fileinfo").find('input, textarea, button, select').prop('disabled', false);
        $("#eestatus").find('option').prop('disabled', false);
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

        var Perfil = document.getElementById('Perfil').value;
        if (Perfil== 4) {

          if (bandeja == 1) {
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
            $('#eestatus option[value="1"]').attr("disabled", "disabled");
            $('#eestatus option[value="3"]').attr("disabled", "disabled");
            $('#eestatus option[value="5"]').attr("disabled", "disabled");
            $('#eestatus option[value="6"]').attr("disabled", "disabled");
          }else {
            $("#eanalisis").attr('disabled','disabled');
            $("#eaccioncorrectiva").attr('disabled','disabled');
            $("#efechaaccion").attr('disabled','disabled');
            $("#eevidenciaaccion").attr('disabled','disabled');
            $("#archivoe").attr('disabled','disabled');
            $("#efechacierre").attr('disabled','disabled');
            if (res.estatus_id == 1 || res.estatus_id == 5 || res.estatus_id == 6) {
              $('#eestatus').attr("disabled", "disabled");
            }else if (res.estatus_id == 2) {
              $('#eestatus option[value="1"]').attr("disabled", "disabled");
              $('#eestatus option[value="2"]').attr("disabled", "disabled");
              $('#eestatus option[value="4"]').attr("disabled", "disabled");
              $('#eestatus option[value="3"]').attr("disabled", "disabled");
            }else if (res.estatus_id == 4) {
              $('#eestatus option[value="2"]').attr("disabled", "disabled");
              $('#eestatus option[value="3"]').attr("disabled", "disabled");
              $('#eestatus option[value="4"]').attr("disabled", "disabled");
              $('#eestatus option[value="5"]').attr("disabled", "disabled");
              $('#eestatus option[value="6"]').attr("disabled", "disabled");
            }
          }

        }

      });

    }

    function EditarQ(btn, bandeja){
      var route = "/quejas/"+btn+"/edit";
      $.get(route, function(res){
        $("#fileinfo_q").find('input, textarea, button, select').prop('disabled', false);
        $("#estatus_id_q").find('option').prop('disabled', false);
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
        var Perfil = document.getElementById('Perfil').value;
        console.log(Perfil);
        if (Perfil == 4) {

          if (bandeja == 1) {
            $("#efecha_q").attr('disabled','disabled');
            $("#earea_q").attr('disabled','disabled');
            $("#eproceso_id_q").attr('disabled','disabled');
            $("#eproducto_id_q").attr('disabled','disabled');
            $("#emonto_q").attr('disabled','disabled');
            $("#ecliente_id_q").attr('disabled','disabled');
            $("#edescripcion_q").attr('disabled','disabled');
            $("#file-1").attr('disabled','disabled');
            $("#eresponsable_q").attr('disabled','disabled');

            $('#estatus_id_q option[value="1"]').attr("disabled", "disabled");
            $('#estatus_id_q option[value="3"]').attr("disabled", "disabled");
            $('#estatus_id_q option[value="5"]').attr("disabled", "disabled");
            $('#estatus_id_q option[value="6"]').attr("disabled", "disabled");
          }else {
            $("#eacciones_q").attr('disabled','disabled');
            $("#efecha_plan_q").attr('disabled','disabled');
            $("#eevidencia_q").attr('disabled','disabled');
            $("#file-2").attr('disabled','disabled');
            $("#efecha_cierre_q").attr('disabled','disabled');

            if (res.estatus_id == 1 || res.estatus_id == 5 || res.estatus_id == 6) {
              $('#estatus_id_q').attr("disabled", "disabled");
            }else if (res.estatus_id == 2) {
              $('#estatus_id_q option[value="1"]').attr("disabled", "disabled");
              $('#estatus_id_q option[value="2"]').attr("disabled", "disabled");
              $('#estatus_id_q option[value="4"]').attr("disabled", "disabled");
              $('#estatus_id_q option[value="3"]').attr("disabled", "disabled");
            }else if (res.estatus_id == 4) {
              $('#estatus_id_q option[value="2"]').attr("disabled", "disabled");
              $('#estatus_id_q option[value="3"]').attr("disabled", "disabled");
              $('#estatus_id_q option[value="4"]').attr("disabled", "disabled");
              $('#estatus_id_q option[value="5"]').attr("disabled", "disabled");
              $('#estatus_id_q option[value="6"]').attr("disabled", "disabled");
            }
          }
        }
      });

    }

    function EditarNot(btn){
      var route = "/noticia/"+btn+"/edit";
      $.get(route, function(res){
        $("#id_not").val(res.id);
        $("#titulo_not").val(res.titulo);
        $("#noticia__not").val(res.Noticia);
      });

    }

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



        var select = document.getElementById(destino);

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



    var select = document.getElementById(destino);

    for ( var i = 0, l = select.options.length, o; i < l; i++ )
    {
      o = select.options[i];
        o.selected = true;
    }

}

      $(function () {
        $('.documentosclick').click(function(ev)
        {
            var data = {
            _token:$(this).data('token'),
            idDoc: $(this).attr("id")
            }
            ev.preventDefault();
            $.ajax({
            type: "POST",
            url: '/DocumentoInicio',
            data: data,
            success: function( msg ) {
                window.open('documento/'+msg["link"],"", "width=500,height=500");
            },
             error: function (data) {
                console.log('Error:', data);
            }
        });
        });

        $('.Procesosclick').click(function(ev)
        {
            var data = {
            _token:$(this).data('token'),
            idDoc: $(this).attr("id")
            }
            ev.preventDefault();
            $.ajax({
            type: "POST",
            url: '/retornarProceso',
            data: data,
            success: function( msg ) {
                window.open(msg["link"],"", "width=500,height=500");
            },
             error: function (data) {
                console.log('Error:', data);
            }
            });
        }
        );
      });

      $(document).ready(function(){

        $(function () { $('#jstree_demo_div').jstree(); });

        $("#btn_modalversion").click();

        $("#actualizar").click(function(){
          $("#fileinfo").find('input, textarea, button, select').prop('disabled', false);
          $("#eestatus").find('option').prop('disabled', false);
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

        $("#actualizarq").click(function(){
          $("#fileinfo_q").find('input, textarea, button, select').prop('disabled', false);
          $("#estatus_id_q").find('option').prop('disabled', false);
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

        $("#actualizar_nc").click(function(){
          $("#fileinfo_nc").find('input, textarea, button, select').prop('disabled', false);
          $("#estatus_id_nc").find('option').prop('disabled', false);
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

        $("#eliminarnoticia").click(function(){
          var value = $("#id_not").val();
          var titulo = $("#titulo_not").val();
          var token = $("#token").val();
          var fd = new FormData(document.getElementById("fileinfo_nc"));
          var route = "/noticias/delete/"+value+"";
          var isGood=confirm('Estas seguro de eliminar la noticia: '+titulo+'?');

          if (isGood) {
            $.ajax({
              url: route,
              headers: {'X-CSRF_TOKEN': token},
              type: 'post',
              data: fd,
              processData: false,  // tell jQuery not to process the data
              contentType: false,
              success: function(){
                alert("Noticia eliminada");
                location.reload();
              }
              });
            } else {
              alert('No se borro la noticia');
            }

        });

        $("#eliminarevento").click(function(){
          var value = $("#id_eve").text();
          var titulo = $("#TituloEvento").text();
          var token = $("#token").val();
          var fd = new FormData(document.getElementById("fileinfo_eve"));
          var route = "/evento/delete/"+value+"";
          var isGood=confirm('Estas seguro de eliminar la evento: '+titulo+'?');

          if (isGood) {
            $.ajax({
              url: route,
              headers: {'X-CSRF_TOKEN': token},
              type: 'post',
              data: fd,
              processData: false,  // tell jQuery not to process the data
              contentType: false,
              success: function(){
                alert("Evento eliminado");
                location.reload();
              }
              });
            } else {
              alert('No se borro el evento');
            }

        });

      });
    </script>
<!--script cargar datos modales-->
@stop
