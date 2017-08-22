@extends('layouts.principal2')

@section('content')

<br><br><br><br><br><br><br><br><br>

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
@stop
