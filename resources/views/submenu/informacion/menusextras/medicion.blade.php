@extends('layouts.principal2')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Equipo De Medicion</h1>
  </div>
</div>

<br><br><br><br><br><br><br><br><br>

  <div class="row">
      <div class="col-lg-3 col-md-6" >
          <div class="panel" id="divPartnersPending" style="Background-color: #0070B0">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-xs-3">
                          <i class="fa fa-5x"></i>
                      </div>
                      <div class="col-xs-9 text-right">
                          <div class="huge" id="divPartnersNumber"></div>
                          <div>EQUIPO DE MED Y PBA</div>
                      </div>
                  </div>
              </div>
              <a href="/documentada/47" class="pf">
                  <div class="panel-footer">
                      <span class="pull-left" id="spPartnersPending">en base</span>
                      <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                  </div>
              </a>
          </div>
      </div>

      <div class="col-lg-3 col-md-6" >
          <div class="panel" id="divPartnersPending" style="Background-color: #0070B0">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-xs-3">
                          <i class="fa fa-5x"></i>
                      </div>
                      <div class="col-xs-9 text-right">
                          <div class="huge" id="divPartnersNumber"></div>
                          <div>PROGRAMA DE CALIBRACIÒN</div>
                      </div>
                  </div>
              </div>
              <a href="/documentada/46" class="pf">
                  <div class="panel-footer">
                      <span class="pull-left" id="spPartnersPending">en base</span>
                      <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                  </div>
              </a>
          </div>
      </div>


  </div>

@stop
