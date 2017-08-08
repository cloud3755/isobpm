@extends('layouts.principal2')

@section('content')

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
            <div class="panel-footer">
      </a>
  </div>
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
            <div class="panel-footer">
      </a>
  </div>
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
      <a href="/proveedores" class="pf">
        <!--  <div class="panel-footer">
              <span class="pull-left" id="spCompaniesPending">Quejas: </span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
          </div> -->
          <div class="panel-footer">
            <span class="pull-left" id="spCompaniesPending">Proveedores: 0</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
        </div>
            <div class="panel-footer">
      </a>
  </div>
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
      <a href="/proveedores" class="pf">
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
            <div class="panel-footer">
      </a>
  </div>
</div>
</div>



</div>

@stop
