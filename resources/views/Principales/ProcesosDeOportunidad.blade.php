@extends('layouts.principal2')

@section('content')
<br><br><br><br><br>
<br><br><br><br><br>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
            <ol class="breadcrumb iso-breadcumb">
                <li><a href="/riesgos" style='color:#FFF'>Analisis de oportunidad</a></li>
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
        <button type="button" class="btnproceso" onclick="Abrir(this);" value="<?=$process->id ?>"><?=$process->proceso ?></button>
      <?php endforeach ?>

         </br>
       </div>
    </div>
  </div>
<?php endforeach ?>
</br>

<script type="text/javascript">
  function Abrir(btn){
    location.href = "/analisisopor/registro/"+btn.value;
  }
</script>
@stop
