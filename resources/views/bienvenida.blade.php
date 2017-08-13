@extends('layouts.principal2')

@section('content')

<br><br><br>
<center>
    <div>
        <table>
            <tr>
                <td>
                    <table class="table">
                        <tr>
                            <td >
                                <img style="width: 150px;height: 150px;"  src=" /img/tableCredential images/user.jpg" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="border: 1px solid #002858">
                                    <center>
                                        Noticias
                                            <?php foreach ($noticiasw as $noticia): ?>
                                            <li><a href="#" class="icon-bar-graph"><?=$noticia->Noticia?></a></li>
                                            <?php endforeach ?>
                                    </center>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img style="width: 150px;height: 150px;" src=" /img/tableCredential images/calendar.png" data-toggle="modal" data-target="#modalcalendario" onclick="#modalcalendario"/>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                <table class="table">
                    <tr style="border-bottom: 1px solid #002858">
                        <td>
                        <i class="fa fa-file-text fa-5x"></i>
                        <span>Mis Documentos</span>
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid #002858">
                        <td>
                            <i class="fa fa fa-bar-chart fa-5x"></i>
                            <span>Mis Indicadores</span>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #002858">
                        <td>
                            <i class="fa fa-code-fork fa-5x"></i>
                            <span>Mis Procesos</span>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #002858">
                        <td>
                            <i class="fa fa fa-edit fa-5x"></i>
                            <span>Mis Pendientes</span>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
        </table>


    </div>
</center>
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
                      <div>RIESGOS & OPORTUNIDADES</div>
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


@stop
