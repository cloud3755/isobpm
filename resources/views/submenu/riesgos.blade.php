@extends('layouts.principal2')

@section('content')


<br>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">RIESGOS</h1>
    </div>
</div>

<br><br><br><br>

      <div class="col-lg-3 col-md-6" >
          <div class="panel panel-ris" id="divPartnersPending">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-xs-3">
                          <i class="fa fa-exclamation-triangle fa-5x"></i>
                      </div>
                      <div class="col-xs-9 text-right">
                          <div class="huge" id="divPartnersNumber"></div>
                          <div>ABC RIESGOS</div>
                      </div>
                  </div>
              </div>
              <a href="/abcriesgos/create" class="pf">
                  <div class="panel-footer">
                      <span class="pull-left" id="spPartnersPending"> en base</span>
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
                      <i class="fa fa-cogs fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                      <div class="huge" id="divCompaniesNumber"></div>
                      <div>ANALISIS DE RIESGO</div>
                  </div>
              </div>
          </div>
          <a href="/riesgos/create" class="pf">
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
                      <i class="fa fa-thermometer-three-quarters  fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                      <div class="huge" id="divCompaniesNumber"></div>
                      <div>MAPA DE CALOR</div>
                  </div>
              </div>
          </div>
          <a href="/mapadecalor" class="pf">
              <div class="panel-footer">
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
              </div>
          </a>
      </div>
    </div>

    </div>
  </div>
</div>
@stop
