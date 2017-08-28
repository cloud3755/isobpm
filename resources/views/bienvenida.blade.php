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
    <div class="col-sm-2">
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
                                <li><a data-toggle="modal" data-target="#modalVerDocumentos" data-token="{{ csrf_token() }}" class="documentosclick" id="{{$doc->nombreunico}}" href="#">{{$doc->nombre}}</a></li>
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
                                <li>{{$indica->nombre}}</li>
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
                                <li><a data-toggle="modal" data-target="#modalVerProcesos" data-token="{{ csrf_token() }}">{{$pro->proceso}}</a></li>
                            @endforeach

                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <span></span>
    <div class="col-sm-6">
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
                            <li><a>{{$queja->descripcion}}</a></li>
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
                            <li><a>{{$accion->descripcion}}</a></li>
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
                            <li><a>{{$Noconformidad->descripcion}}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <br>
            <a data-toggle="collapse" href="#collapseProyectos">
            <i class="fa fa-tasks fa-2x"></i>Proyectos</a>
            <div id="#collapseProyectos" class="collapse">
                <ul>

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
                <button type="hidden" id="mostrarevento" data-toggle="modal" data-target="#modaleventoclick"/>
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
    -->
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




<!-- modal para el el calendario-->


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
                    <div class="container">
                        <form class="form-group" action="/calendarioagenda/store" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group form-group-lg">
                            <h2>
                                <label for="Tituloevento" class="control-label col-md-12" >
                                Titulo del pendiente:
                                </label>
                            </h2>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id = "title" placeholder="Nombre del evento" name="title" style="width:75%;">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2>
                                <label for="all_day" class="control-label col-md-12" >
                                Evento de todo el dia:
                                </label>
                            </h2>
                            <div class="col-md-6">
                              <select class="form-control" id = "all_day"  name="all_day" style="width:75%;">
                                <option selected="selected" value="1">Si</option>
                                <option value="0">No</option>
                              </select>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2>
                                <label for="start" class="control-label col-md-12" >
                                Inicio:
                                </label>
                            </h2>
                            <div class="col-md-6">
                                <input type="datetime-local" class="form-control" id = "start" name="start" value="<?php  echo date ( 'Y-m-d\TH:i' , time()  )?>" style="width:75%;">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2>
                                <label for="end" class="control-label col-md-12" >
                                Fin:
                                </label>
                            </h2>
                            <div class="col-md-6">
                                <input type="datetime-local" class="form-control" id = "end" name="end" value="<?php  echo date ( 'Y-m-d\TH:i' , time()  )?>" style="width:75%;">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2>
                                <label for="color" class="control-label col-md-12" >
                                Color de pendiente:
                                </label>
                            </h2>
                            <div class="col-md-6">
                            <input type="color" id="color" name="color" onchange="clickColor(0, -1, -1, 5)" value="#0099ff" style="width:75%;">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2>
                                <label for="descripcion" class="control-label col-md-12" >
                                Descripcion del pendiente:
                                </label>
                            </h2>
                            <div class="col-md-6">
                            <textarea id="descripcion" name="descripcion" rows="3" style="width:75%;">Agregue descripcion </textarea>
                            </div>
                        </div>
                </div>
                        <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnNoticia" style="font-family: Arial;">Agregar Evento</button>
                        </form>
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        </div>
                    </div>
                </div>
    </div>
</div>

<!-- modal para agregar evento al calendario-->

<!-- modal ver documentos -->
<div  class="modal fade" id="modaleventoclick" tabindex="-1" role="dialog" style="background-color:gray ; width:100%;">
    <div   class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Evento</h2>
            </div>
            <div class="modal-body">
                <p id="infomensaje"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalVerDocumentos" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modalVerDocumentos">&times;</button>
            <h2 class="modal-title"><span id="txtTitulo"></span></h2>
            </div>
            <div class="modal-body">

                <table id="tbVerDocumentos">
                    <tr>
                        <td>Documento:</td>
                        <td id="tdDocumento"></td>
                    <tr>
                    <tr>
                        <td>Descripción:</td>
                        <td id="tdDocumentoDescripcion"></td>
                    <tr>
                    <tr>
                        <td>Ver documento</td>
                        <td><a id="tdVerDocumento" href="#" target="_blank" style="color:#FFF">
                          <button type="button" class="btn btn-default">
                               <span class="glyphicon glyphicon-download-alt"></span>
                          </button>
                        </a></td>
                    <tr>


                </table>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal ver documentos -->

<!-- modal ver procesos -->

<div class="modal fade" id="modalVerProcesos" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modalVerDocumentos">&times;</button>
            <h2 class="modal-title"><span id="txtTitulo"></span></h2>
            </div>
            <div class="modal-body">

                <table >
                    <tr>
                        <td>Proceso:</td>
                        <td id="tdProceso"></td>
                        <td>Tipo de proceso:</td>
                        <td id="tdProcesoTipo"></td>
                    </tr>
                    <tr>
                        <td>Descripción:</td>
                        <td colspan="3" id="tdProcesoDescripcion"></td>
                    </tr>
                    <tr>
                        <td>Responsable:</td>
                        <td id="tdProcesoResponsable"></td>

                    </tr>

                    <tr>
                        <td>Revisión:</td>
                        <td id="tdProcesoRevision"></td>
                        <td>Detalle de revisión:</td>
                        <td id="tdProcesoDetalleRevision"></td>
                    </tr>
                    <tr>
                        <td>Indicadores:</td>
                        <td id="tdProcesoArchivoHtml"></td>
                    </tr>

                    <tr>
                        <td>Ver HTML</td>
                        <td><a id="tdVerProcesoDocumento" href="#" target="_blank" style="color:#FFF">
                          <button type="button" class="btn btn-default">
                               <span class="glyphicon glyphicon-download-alt"></span>
                          </button>
                        </a></td>
                    <tr>


                </table>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@if(Auth::user()->perfil != 4)
<div class="modal fade" id="modalAgregarPendiente" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Alta de pendiente</h3>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{ action('AdministradosController@pendienteStore') }}" enctype="multipart/form-data">
                 {{ csrf_field() }}
                <table>
                    <tr>
                        <td>Responsable:</td>
                        <td>
                        <select class="form-control input-lg" name="id_UsuarioAsignado" id="id_UsuarioAsignado">
                                @foreach($User as $Users)
                                <option value="{{$Users->id}}">{{$Users->nombre}}</option>
                                @endforeach
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Pendiente:</td>
                        <td><textarea class="form-control input-lg" placeholder="Pendiente" name="Pendiente" id="Pendiente" required></textarea></td>
                    </tr>
                    <tr>
                        <td>Fecha limite:</td>
                        <td>
                            <input class="form-control input-lg" type="date" placeholder="Fecha" name="fechalimite" id="fechalimite" required>
                        </td>
                    </tr>
                </table>


            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-default">Guardar</button>

            </form>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
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

                <form action="{{ action('AdministradosController@noticiastore') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    Noticia
                <textarea class="form-control" id = "descripcionNoticia" rows="3" placeholder="Noticia" name="descripcionNoticia"></textarea>
                <table>
                    <tbody>
                        <tr>
                            <td>Areas no elegidas</td>
                            <td></td>
                            <td>Areas elegidas</td>
                        </tr>
                        <tr>
                            <td>
                                <select multiple name="listaAreas[]" id="listaAreas" size="7" style="width: 100%;"onclick="agregaSeleccion('listaAreas', 'listaAreasSeleccionadas');">
                                    @foreach ($Areas as $Area): ?>
                                    <option value="{{$Area->id}}"> {{$Area->nombre}} </option>
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btnobjetivo" id="btnNoticia">Agregar Noticia</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
    </div>
</div>


@endif

<!-- modal ver procesos -->

<!--script cargar datos modales-->
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
            nombreunico: $(this).attr("id")
            }
            ev.preventDefault();
            $.ajax({
            type: "POST",
            url: '/DocumentoInicio',
            data: data,
            success: function( msg ) {
                $('#tdDocumento').text(msg["Documento"]);
                $('#tdDocumentoDescripcion').text(msg["Descripcion"]);
                $('#tdVerDocumento').attr('href', 'documento/'+msg["link"]);
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
