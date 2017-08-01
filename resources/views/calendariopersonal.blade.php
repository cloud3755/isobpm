@extends('layouts.principal2')

@section('content')

<br><br><br>
<center>



<!-- script que pone calendario-->
<div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
<style>

#calendar {
width: inherit;
margin: 0 auto;
}

</style>

      {!! $calendar->calendar() !!}
      {!! $calendar->script() !!}

</div>
<!-- script que pone calendario-->


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

          </a>
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

        </div>
        <button type="submit" class="btnobjetivo" id="btnEditCli" style="font-family: Arial;">Seleccionar</button>
      </form>
    </div>
  </div>
@endif

  </div>
</div>


<!-- modal para el el calendario-->


<div class="modal fade" id="modalcalendario" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <center><h2 class="modal-title">Agenda de pendientes</h2></center>
            </div>
                <div class="modal-body">
                    <div class="container">
                      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                      <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
                      <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
                      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
                      <style>
                          /* ... */
                      </style>

                            {!! $calendar->calendar() !!}
                            {!! $calendar->script() !!}
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- modal para el el calendario-->

<!-- modal para agregar evento al calendario-->

<div class="modal fade" id="modalAgregarEvento" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Agregar Evento</h2>
            </div>
                <div class="modal-body">
                    <div class="container">
                        <form class="" action="/administrados/noticiastore" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group form-group-lg">
                            <h2>
                                <label for="Noticia" class="control-label col-md-12" >
                                Noticia
                                </label>
                            </h2>
                            <div class="col-md-6">
                                <textarea class="form-control" id = "descripcionNoticia" rows="3" placeholder="Noticia" name="descripcionNoticia"></textarea>
                            </div>
                        </div>
                </div>
                        <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnNoticia" style="font-family: Arial;">Agregar Noticia</button>
            </form>
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        </div>
                    </div>
                </div>
    </div>
</div>

<!-- modal para agregar evento al calendario-->



@stop
