@extends('layouts.principal2')

@section('content')

<br>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">RIESGOS</h1>
    </div>
</div>

<br><br>
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

      <button type="button" class="btnproceso" onclick=location="/analisisrisk/registro/<?=$process->id ?>" id="<?=$process->proceso ?>"><?=$process->proceso ?></button>

      <?php endforeach ?>

         </br>
       </div>
    </div>
  </div>
<?php endforeach ?>
</br>

@stop
