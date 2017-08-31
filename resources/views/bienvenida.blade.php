@extends('layouts.principal2')

@section('content')
<div>
    @if(Auth::user()->nombreimagen!=null)
        <img style="width: 80px;height: 80px;"  src="/storage/imagenesusuarios/{{Auth::user()->nombreunicoimagen}}" />
    @else
        <img style="width: 80px;height: 80px;"  src="/img/tableCredential images/user.jpg" />
    @endif

</div>
<div>
<p>bienvenido: <strong>{{Auth::user()->nombre}}</strong><p>
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
                <a data-toggle="collapse" href="#collapseIndicadores">Mis indicadores</a>
                <div id="collapseIndicadores" class="collapse">
                    <ul>
                        @if(count($indicador)<=0)
                            <li class="text-danger">Sin indicadores</li>
                        @else
                            @foreach($indicador as $indica)
                                <li><a href="resultado/registro/{{$indica->id}}">{{$indica->nombre}}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <br>
                <a data-toggle="collapse" href="#collapseProcesos">Mis procesos</a>
                <div id="collapseProcesos" class="collapse">
                    <ul>
                        @if(count($proceso)<=0)
                            <li class="text-danger">Sin procesos</li>
                        @else
                            @foreach($proceso as $pro)
                                <li><a href="resultado/registro/{{$pro->id}}">{{$pro->proceso}}</a></li>
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
                <ul>
                    @if(count($quejas)<=0)
                        <li class="text-danger">Sin quejas</li>
                    @else
                        @foreach($quejas as $queja)
                            <li><a data-toggle="modal" data-target="#modaledit<?=$queja->id?>">{{$queja->descripcion}}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <br>
            <a data-toggle="collapse" href="#collapseAcciones">
            <i class="fa fa-user-times fa-2x"></i>Acciones correctivas</a>
            <div id="collapseAcciones" class="collapse">
                <ul>
                    @if(count($accionesCorrectivas)<=0)
                        <li class="text-danger">Sin Acciones</li>
                    @else
                        @foreach($accionesCorrectivas as $accion)
                            <li><a value = "<?=$accion->id?>" data-toggle="modal" data-target="#modaledit" onclick="Editar(this);">{{$accion->descripcion}}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <br>
            <a data-toggle="collapse" href="#collapseNoConformidades">
            <i class="fa fa-thumbs-o-down fa-2x"></i>No conformidades</a>
            <div id="collapseNoConformidades" class="collapse">
                <ul>
                    @if(count($Noconformidades)<=0)
                        <li class="text-danger">Sin items</li>
                    @else
                        @foreach($Noconformidades as $Noconformidad)
                            <li><a data-toggle="modal" data-target="#modaleditNoconformidad<?=$noconformidad->id?>">{{$Noconformidad->descripcion}}</a></li>
                        @endforeach
                    @endif
                </ul>
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
                            <li><a href="/subiretapa/etapa/{{$mejoras->id}}">{{$mejoras->Proyecto}}</a></li>
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
                        <li><a href="#" class="icon-bar-graph">{{$noticia->Noticia}}</a></li>
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
            <center><button type="button" class="btn btnobjetivo" data-toggle="modal" data-dismiss="modal" data-target="#modalAgregarEvento">Agregar Evento</button></center>
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

<!--
    <div class="row">
      <div class="col-lg-3 col-md-6" >
          <div class="panel panel-doc" id="divPartnersPending">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-xs-3">
                          <i class="fa fa-file-text fa-5x"></i>
                      </div>
                      <div class="col-xs-9 text-right">
                          <div class="huge" id="divPartnersNumber"></div>
                          <div>INF. DOCUMENTADA</div>
                      </div>
                  </div>
              </div>
              <a href="/infdocumentada" class="pf">
                  <div class="panel-footer">
                      <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                  </div>
              </a>
          </div>
      </div>

      <div class="col-lg-3 col-md-6" >
          <div class="panel panel-obj" id="divPartnersPending">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-xs-3">
                          <i class="fa fa-crosshairs fa-5x"></i>
                      </div>
                      <div class="col-xs-9 text-right">
                          <div class="huge" id="divPartnersNumber"></div>
                          <div>OBJETIVOS & INDICADORES</div>
                      </div>
                  </div>
              </div>
              <a href="/objetivosindicadores" class="pf">
                  <div class="panel-footer">
                      <span class="pull-left" id="spPartnersPending"><?=$objetivo->count();?> en base</span>
                      <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                  </div>
              </a>
          </div>
      </div>


    <div class="col-lg-3 col-md-6" >
        <div class="panel panel-pro" id="divCompaniesPending">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-3">
                      <i class="fa fa-cogs fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                      <div class="huge" id="divCompaniesNumber"></div>
                      <div>PROCESOS</div>
                  </div>
              </div>
          </div>
          <a href="/procesos/visual" class="pf">
              <div class="panel-footer">
                    <span class="pull-left" id="spCompaniesPending"><?=$proceso->count();?> en base</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
              </div>
          </a>
      </div>
    </div>


    <div class="col-lg-3 col-md-6" >
      <div class="panel panel-ris" id="divCompaniesPending">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-3">
                      <i class="fa fa-exclamation-triangle fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                      <div class="huge" id="divCompaniesNumber"></div>
                      <div>RIESGOS</div>
                  </div>
              </div>
          </div>
          <a href="/riesgos" class="pf">
              <div class="panel-footer">
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
              </div>
          </a>
      </div>
    </div>

    <div class="col-lg-3 col-md-6" >
      <div class="panel panel-ris" id="divCompaniesPending">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-3">
                      <i class="fa fa-exclamation-triangle fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                      <div class="huge" id="divCompaniesNumber"></div>
                      <div>OPORTUNIDADES</div>
                  </div>
              </div>
          </div>
          <a href="/oportunidades" class="pf">
              <div class="panel-footer">
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
              </div>
          </a>
      </div>
    </div>

    <div class="col-lg-3 col-md-6" >
      <div class="panel panel-mej" id="divCompaniesPending">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-3">
                      <i class="fa fa-line-chart  fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                      <div class="huge" id="divCompaniesNumber"></div>
                      <div>MEJORA</div>
                  </div>
              </div>
          </div>
          <a href="/mejoras" class="pf">
              <div class="panel-footer">
                  <span class="pull-left" id="spCompaniesPending">Quejas: <?=$quejas->count();?></span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
              </div>
          </a>
      </div>
    </div>

    <div class="col-lg-3 col-md-6" >
      <div class="panel panel-mej" id="divCompaniesPending">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-3">
                      <i class="fa fa-line-chart  fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                      <div class="huge" id="divCompaniesNumber"></div>
                      <div>SEP</div>
                  </div>
              </div>
          </div>
          <a href="/proveedores" class="pf">
            <!--  <div class="panel-footer">
                  <span class="pull-left" id="spCompaniesPending">Quejas: </span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
              </div> -->
            <a href="/proveedores">
              <div class="panel-footer">
                <span class="pull-left" id="spCompaniesPending">Proveedores: <?=$cuentaproveedor ?></span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
          </a>
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
        <button type="submit" class="btnobjetivo" id="btnEditCli" style="font-family: Arial;">Seleccionar</button>
      </form>
    </div>
  </div>
@endif

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
                        <button type="submit" class="btnobjetivo" id="btnNoticia" style="font-family: Arial;">Agregar Evento</button>
                        </form>
                            <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        </div>
                    </div>
                </div>
    </div>
</div>

<!-- modal para agregar evento al calendario-->

<!-- modal ver evento -->
<div  class="modal fade" id="modaleventoclick" tabindex="-1" role="dialog" style="background-color:gray ; width:100%;">
    <div   class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title" id="TituloEvento">Evento</h2>
            </div>
            <div class="modal-body">
                <p id="MensajeEvento"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- modal ver evento -->

@if(Auth::user()->perfil != 4)

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
                <button type="submit" class="btnobjetivo" id="btnAgregarLink">Agregar link</button>
                </form>
                <button type="button" class="btnobjetivo" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
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
                            <h2><label for="descripcionNoticia" class="control-label">Noticia:</label></h2>
                            <textarea class="form-control" id="descripcionNoticia" rows="3" placeholder="Noticia" name="descripcionNoticia"></textarea>
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btnobjetivo" id="btnNoticia">Agregar Noticia</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@endif

<!-- modal ver procesos -->

<!-- modales de quejas -->
<?php foreach ($quejas as $queja): ?>
<div class="modal fade" id="modaledit<?=$queja['id']?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">ALTA DE QUEJA</h2>
            </div>
            <div class="modal-body">
              <div class="container">
                <form  action="/quejas/edit/<?=$queja['id']?>" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <div class="form-group form-group-lg">
                  <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha:</label></h2>
                  <div class="col-md-6">
                      <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha" value ="<?=$queja['fecha']?>">
                  </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Area:</label></h2>
                    <div class="col-md-6">
                      <select class="form-control input-lg" name="area" required="">
                        <?php foreach ($Areas as $area): ?>
                          @if($area->id == $queja->area)
                           <option value="<?=$areas['id']?>" selected><?=$area['nombre']?></option>
                          @endif
                          <option value="<?=$area['id']?>"><?=$area['nombre']?></option>
                        <?php endforeach ?>
                      </select>

                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Proceso:</label></h2>
                    <div class="col-md-6">
                      <select class="form-control input-lg" name="proceso_id">
                        <?php foreach ($proceso as $procesos): ?>
                          @if($procesos->id == $queja->proceso)
                           <option value="<?=$procesos['id']?>" selected><?=$procesos['proceso']?></option>
                          @endif
                          <option value="<?=$procesos['id']?>"><?=$procesos['proceso']?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Producto:</label></h2>
                    <div class="col-md-6">
                      <select class="form-control input-lg" name="producto_id">

                        <?php foreach ($productos as $producto): ?>
                          @if($producto->id == $queja->producto)
                            <option value="<?=$producto['id']?>"  selected><?=$producto['nombre']?></option>
                          @endif
                          <option value="<?=$producto['id']?>"><?=$producto['nombre']?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Cliente:</label></h2>
                    <div class="col-md-6">

                      <select class="form-control input-lg" name="cliente_id">
                        <?php foreach ($cliente as $clientes): ?>
                          <option value="<?=$clientes['id']?>"><?=$clientes['nombre']?></option>
                        <?php endforeach ?>
                      </select>

                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12">
                    Decripcion de Queja:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Descripcion de la queja" name="descripcion"><?=$queja['descripcion']?></textarea>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="tipo" class="control-label col-md-12" >Archivo de evidencia de queja: <br><?=$queja['archivoqueja']?></label></h2>
                    <div class="col-md-6">
                        <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo1">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="tipo" class="control-label col-md-12" >Responsable:</label></h2>
                    <div class="col-md-6">
                        <select class="form-control input-lg" name="responsable">
                          <?php foreach ($User as $Users): ?>
                            <option value="<?=$Users['id']?>"><?=$Users['usuario']?></option>
                          <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12">
                    Acciones:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <textarea class="form-control" id = "prodescripcionque" rows="3" placeholder="Acciones tomadas" name="acciones"><?=$queja['acciones']?></textarea>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha plan:</label></h2>
                  <div class="col-md-6">
                      <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha_plan" value="<?=$queja['fecha_plan']?>">
                  </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Evidencia:</label></h2>
                    <div class="col-md-6">
                        <input class="form-control input-lg" id="probproces" type="text" placeholder="evidencia" name="evidencia" value="<?=$queja['evidencia']?>">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="tipo" class="control-label col-md-12" >Archivo de evidencia de queja: <br> <?=$queja['archivoevidencia']?> </label></h2>
                    <div class="col-md-6">
                        <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo2">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha Cierre:</label></h2>
                  <div class="col-md-6">
                      <input class="form-control input-lg" type="date" placeholder="Fecha" name="fecha_cierre" value="<?=$queja['fecha_cierre']?>">
                  </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="tipo" class="control-label col-md-12" >Status:</label></h2>
                    <div class="col-md-6">
                        <select class="form-control input-lg" name="status_id">
                          <?php foreach ($estatus as $estatuses): ?>
                            <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                          <?php endforeach ?>
                        </select>
                    </div>
                </div>

    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Editar Queja</button>
                </form>
                        <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
</div>

<?php endforeach?>

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
                      <a class="btn btn-primary" id="actualizar" style="font-family: Arial;">Guardar Cambios</a>
                      <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
                  </form>
                </div>
            </div>
          </div>
    </div>
<!-- modales acciones correctivas -->

<!-- modales no conformidades -->
    <?php foreach ($Noconformidades as $Noconformidad): ?>
    <div class="modal fade" id="modaledit<?=$Noconformidad['id']?>" tabindex="-1" role="dialog" accept-charset="UTF-8" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h2 class="modal-title">EDITAR NO CONFORMIDAD</h2>
                </div>
                <div class="modal-body">
                  <form  action="/noconformidad/edit/<?=$Noconformidad['id']?>" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                      <input type="hidden" name="id_compania" value="{{Auth::user()->id_compania}}">

                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Fecha:</label></h3>
                            <input class="form-control input-lg" type="date" placeholder="Fecha"  value = "<?=$Noconformidad['fecha']?>" name="fecha">
                      </div>
                    
                      <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Proceso:</label></h3>
                            <select class="form-control input-lg" name="proceso_id" id="proceso_id">
                              <?php foreach ($Proceso as $Procesos): ?>
                                @if($Procesos->id == $Noconformidad->proceso_id)
                                  <option value="<?=$Procesos['id']?>" selected><?=$Procesos['proceso']?></option>
                                @else
                                  <option value="<?=$Procesos['id']?>"><?=$Procesos['proceso']?></option>
                                @endif
                              <?php endforeach ?>
                            </select>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4">
                          <h3><label>Producto:</label></h3>
                            <select class="form-control input-lg" name="producto_id" id="producto_id">
                              <?php foreach ($productos as $producto): ?>
                                @if($producto->id == $Noconformidad->producto_id)
                                    <option value="<?=$producto['id']?>" selected><?=$producto['nombre']?></option>
                                @else
                                    <option value="<?=$producto['id']?>"><?=$producto['nombre']?></option>
                                @endif
                              <?php endforeach ?>
                            </select>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4">
                          <h3><label>Area:</label></h3>
                              <select class="form-control input-lg" name="id_area" id="id_area">
                                <?php foreach ($area as $areas): ?>
                                  @if($areas->id == $Noconformidad->id_area)
                                    <option value="<?=$areas['id']?>"selected><?=$areas['nombre']?></option>
                                  @else
                                    <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                                  @endif
                                <?php endforeach ?>
                              </select>
                      </div>

                      <div class="col-lg-8 col-md-8 col-sm-8">
                          <h3><label>Evidencia no conformidad:</label></h3>
                              <input class="form-control input-lg" id="documento" type="file" value = "" name="archivo1">
                      </div>

                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h3><label>Documento:</label></h3>
                              <input class="form-control input-lg" id="documento" type="text" value="<?=$Noconformidad['documento']?>" name="documento">
                      </div>

                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h3><label> Decripcion:</label></h3>
                              <textarea class="form-control" id = "descripcion" rows="3" name="descripcion" placeholder="Descripcion No conformidad"><?=$Noconformidad['descripcion']?></textarea>
                      </div>

                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3><label> Acciones:</label></h3>
                        <textarea class="form-control" id = "acciones" name = "acciones" rows="3" placeholder="Acciones a Realizar"><?=$Noconformidad['acciones']?></textarea>
                      </div>

                      <div class="col-lg-6 col-md-6 col-sm-6">
                          <h3><label>Responsable:</label></h3>
                              <select class="form-control input-lg" name="usuario_responsable_id" id="usuario_responsable_id">
                                <?php foreach ($User as $Users): ?>
                                  @if($Users->id == $Noconformidad->usuario_responsable_id)
                                    <option value="<?=$Users['id']?>" selected><?=$Users['nombre']?></option>
                                  @else
                                    <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                                  @endif
                                <?php endforeach ?>
                              </select>
                      </div>


                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <h3><label>Fecha plan:</label></h3>
                            <input class="form-control input-lg" id="fecha_plan" type="date" value = "<?=$Noconformidad['fecha_plan']?>" placeholder="Fecha del Plan" name="fecha_plan">
                      </div>

                      <div class="col-lg-8 col-md-8 col-sm-8">
                          <h3><label>Evidencia de cierre: <?=$Noconformidad['evidenciapertura']?></label></h3>
                              <input class="form-control input-lg" id="evidencia" type="file" value = "<?=$Noconformidad['evidencia']?>" placeholder="Evidencia del cierre" name="archivo2">
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3><label>Fecha Cierre:</label></h3>
                            <input class="form-control input-lg" id="fecha_cierre" type="date" value = "<?=$Noconformidad['fecha_cierre']?>" placeholder="Fecha para el cierre" name="fecha_cierre">
                      </div>
                      @if($Noconformidad->creador_id == Auth::user()->id or Auth::user()->perfil <= 3)
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <h2><label>Status:</label></h2>
                        <select class="form-control input-lg" name="estatus_id" id="estatus_id">
                          <?php foreach ($estatus as $estatuses): ?>
                            @if($estatuses->id == $Noconformidad->estatus_id)
                            <option value="<?=$estatuses['id']?>" selected><?=$estatuses['nombre']?></option>
                            @else
                            <option value="<?=$estatuses['id']?>"><?=$estatuses['nombre']?></option>
                            @endif
                          <?php endforeach ?>
                        </select>
                      </div>
                      @else
                        <input type="hidden" name="estatus_id" id="estatus_id" value="<?=$Noconformidad->estatus_id?>">
                      @endif

                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <h2><label>Monto:</label></h2>
                            <input class="form-control input-lg" id="monto" type="text" value = "<?=$Noconformidad['monto']?>" placeholder="Monto de la no conformidad" name="monto">
                      </div>
                    </div>


                        <div class="modal-footer">
                            <button type="submit" class="btnobjetivo" id="btnEditCli" style="font-family: Arial;">Editar Registro</button>
                    </form>
                            <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <?php endforeach?>
<!-- modales no conformidades -->
<button style="display:none;" id="mostrarevento" data-toggle="modal" data-target="#modaleventoclick"/>

<!--script cargar datos modales-->
    <script type="text/javascript">

function Editar(btn){
      var route = "/accioncorrectiva/"+btn.value+"/edit";
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



        var select = document.getElementById('listaAreasSeleccionadas');

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



    var select = document.getElementById('elistaSeleccionada');

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
    </script>
<!--script cargar datos modales-->
@stop
