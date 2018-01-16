@extends('layouts.principal2')

@section('content')
<br>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Mapa de Arquitectura de Procesos</h1>
    </div>
</div>

<br><br><br><br>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
            <ol class="breadcrumb iso-breadcumb">
                <li><a href="/bienvenida/" style='color:#FFF'>Procesos</a></li>
                <li class="active" style='color:#FFF'>Procesos por aprobar</li>
            </ol>
        </h2>
    </div>
</div>
</br>

@if ($errors->any())
<div class="alert alert-danger" role="alert">
<p> Se deben llenar todos los datos del formulario<p>
</div>
@endif


<?php foreach ($tipoproceso as $tipoproc): ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
              <!--<center>             </center>-->
                <?=$tipoproc['nombreproceso'] ?>
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


<script type="text/javascript">

function Abrir(btn){
  location.href = "/procesos/aprobar/2/"+btn.value;
}

$(document).ready(function(){


});
</script>


@stop
