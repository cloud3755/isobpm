@extends('layouts.principal2')

@section('content')
<div class="row" style="padding: 5px">
    <div class="col-lg-12 text-right">
        <button type="button" class="btn btn-primary" id="btnHelp">?</button>
    </div>
    <div class="col-lg-12" id="divHelp" style="display:none">
        <div class="col-lg-3 col-md-4 col-sm-4 hidden-xs text-center">
            <img src="/img/help/doc_ext.jpg" class="img-responsive img-thumbnail" />
        </div>
        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
            <p>
                En este apartado se depositan y visualizan los distintos riesgos.
            </p>
        </div>
    </div>
</div><br><br><br><br><br>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
            <ol class="breadcrumb iso-breadcumb">
                <li><a href="/riesgos" style='color:#FFF'>Analisis de riesgo</a></li>
                <li class="active">Visualizacion de Procesos</li>
            </ol>
        </h2>
    </div>
</div>

</br>

<?php foreach ($tipoproceso as $tipoproc): ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
              <center>
                <?=$tipoproc['nombreproceso'] ?>
              </center>
            </div>
</br>

      <?php foreach ($proceso->where('tipo',$tipoproc['nombreproceso']) as $process): ?>

      <button type="button" class="btnproceso" onclick=location="/analisisrisk/registro/<?=$process['id'] ?>" id="<?=$process['proceso'] ?>"><?=$process['proceso'] ?></button>

      <?php endforeach ?>

         </br>
       </div>
    </div>
  </div>
<?php endforeach ?>
</br>

@stop
