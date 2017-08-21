@extends('layouts.principal2')

@section('content')

<br><br><br><br><br><br><br><br><br>
  <div class="row">
      <div class="col-lg-3 col-md-6" >
          <div class="panel panel-obj" id="divPartnersPending">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-xs-3">
                          <i class="fa fa-crosshairs fa-5x"></i>
                      </div>
                      <div class="col-xs-9 text-right">
                          <div class="huge" id="divPartnersNumber"></div>
                          <div>OBJETIVOS</div>
                      </div>
                  </div>
              </div>
              <a href="/objetivos/visual" class="pf">
                  <div class="panel-footer">
                      <span class="pull-left" id="spPartnersPending"><?=$objetivo->count();?> en base</span>
                      <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                  </div>
              </a>
          </div>
      </div>



    <div class="col-lg-3 col-md-6" >
      <div class="panel panel-obj" id="divCompaniesPending">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-3">
                      <i class="fa fa-table fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                      <div class="huge" id="divCompaniesNumber"></div>
                      <div>RESULTADOS</div>
                  </div>
              </div>
          </div>
          <a href="/resultado/create" class="pf">
              <div class="panel-footer">
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
              </div>
          </a>
      </div>
    </div>

    <div class="col-lg-3 col-md-6" >
      <div class="panel panel-obj" id="divCompaniesPending">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-3">
                      <i class="fa fa-pie-chart fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                      <div class="huge" id="divCompaniesNumber"></div>
                      <div>DASHBOARD</div>
                  </div>
              </div>
          </div>
          <a href="/Dashboard" class="pf">
              <div class="panel-footer">
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
              </div>
          </a>
      </div>
    </div>
  </div>
  
<div class="row">
    <div class="col-lg-3 col-md-6" >
        <div class="panel panel-obj" id="divPartnersPending" style="Background-color: #BE5353">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-puzzle-piece fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" id="divPartnersNumber"></div>
                        <div>ESTRATEGIA</div>
                    </div>
                </div>
            </div>
            <a href="/infestrategia" class="pf">
                <div class="panel-footer">
                    <span class="pull-left" id="spPartnersPending">en base</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
  </div>


    </div>
  </div>
</div>
@stop
