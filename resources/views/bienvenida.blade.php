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
                                <img style="width: 150px;height: 150px;" src=" /img/tableCredential images/calendar.png" />
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

@stop
