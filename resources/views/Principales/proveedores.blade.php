@extends('layouts.principal2')

@section('content')

</br>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">SEP</h1>
    </div>
</div>


<center><button type="button" class="btnobjetivo" onclick=location="/bienvenida" data-dismiss="modal" id="btnCloseUpload">Regresar</button></center>


</br></br></br></br></br>

<div class="row">
<div class="col-lg-3 col-md-6" >
  <div class="panel panel-mej" id="divCompaniesPending">
      <div class="panel-heading">
          <div class="row">
              <div class="col-xs-3">
                  <i class="fa fa-line-chart  fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                  <div class="huge" id="divCompaniesNumber"></div>
                  <div>Insumos</div>
              </div>
          </div>
      </div>
      <a href="/insumos" class="pf">
        <!--  <div class="panel-footer">
              <span class="pull-left" id="spCompaniesPending">Quejas: </span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
          </div> -->
          <div class="panel-footer">
            <span class="pull-left" id="spCompaniesPending">Insumos: <?=$cuentainsumo ?></span>
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
                  <div>Proveedores</div>
              </div>
          </div>
      </div>
      <a href="/proveedores/mostrar" class="pf">
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



<div class="col-lg-3 col-md-6" >
  <div class="panel panel-mej" id="divCompaniesPending">
      <div class="panel-heading">
          <div class="row">
              <div class="col-xs-3">
                  <i class="fa fa-line-chart  fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                  <div class="huge" id="divCompaniesNumber"></div>
                  <div>Calificar proveedores</div>
              </div>
          </div>
      </div>
      <a href="/provedores/califica" class="pf">
        <!--  <div class="panel-footer">
              <span class="pull-left" id="spCompaniesPending">Quejas: </span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
          </div> -->
          <div class="panel-footer">
            <span class="pull-left" id="spCompaniesPending">Calificar proveedores</span>
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
                  <div>Ver calificaciones de proveedor</div>
              </div>
          </div>
      </div>
      <a href="/provedores/calificaresultado/" class="pf">
        <!--  <div class="panel-footer">
              <span class="pull-left" id="spCompaniesPending">Quejas: </span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
          </div> -->
          <div class="panel-footer">
            <span class="pull-left" id="spCompaniesPending">Ver calificaciones de proveedor</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
        </div>
      </a>
  </div>
</div>
</div>




@stop
