@extends('layouts.principal2')

@section('content')
<br>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Balanced ScoreCard</h1>
    </div>
</div>

<br><br><br><br>
<center><button type="button" class="btnobjetivo" onclick=location="/objetivosindicadores" data-dismiss="modal" id="btnCloseUpload">Regresar</button></center>
<br>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
            <ol class="breadcrumb iso-breadcumb">
                <li><a href="/objetivosindicadores" style='color:#FFF'>Objetivos Pro</a></li>
                <li >Visualizacion de Objetivos</li>
            </ol>
        </h2>
    </div>
</div>
</br>

<?php foreach ($tipoobjetivo as $tipoobjetiv): ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                <?=$tipoobjetiv['nombre'] ?>
                    <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target="#modalUpload<?=$tipoobjetiv['id'] ?>"><i class="glyphicon glyphicon-upload"></i></button>
            </div>
</br>

      <?php foreach ($objetivo->where('tipo_objetivo_id',$tipoobjetiv['id']) as $objetiv): ?>

      <button type="button" class="btnproceso" onclick=location="/objetivo/registro/<?=$objetiv['id'] ?>" id="<?=$objetiv['ID'] ?>"><?=$objetiv['nombre'] ?></button>

      <?php endforeach ?>

         </br>
       </div>
    </div>
  </div>
</br>
<div class="modal fade in" id="modalUpload<?=$tipoobjetiv['id'] ?>" tabindex="-1" role="dialog" style="">
    <div class="modal-dialog" role="form">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title">Alta de objetivo</h3>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="/objetivos/store" method="post" role="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="creador_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="tipo_objetivo_id" value="<?=$tipoobjetiv['id'] ?>">
                      <div class="form-group form-group-lg">
                        <div class="form-group form-group-lg">
                            <h2>
                              <label for="tipo" class="control-label col-md-12" >
                                Tipo de Objetivo: <?=$tipoobjetiv['nombre'] ?>
                              </label>
                            </h2>
                          </div>
                            <div class="form-group form-group-lg">
                                <h2><label for="Usuario" class="control-label col-md-12">Nombre Objetivo:</label></h2>
                                <div class="col-md-6">
                                    <input class="form-control input-lg" id="nombre" type="Text" placeholder="A que se quiere llegar" name="nombre">
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <h2>
                                    <label for="Usuario" class="control-label col-md-12">
                                        Decripcion:
                                    </label>
                                </h2>
                                <div class="col-md-6">
                                    <textarea class="form-control" id = "descripcion" rows="3" name="descripcion" placeholder="Descripcion del objetivo"></textarea>
                                </div>
                            </div>



                            <div class="form-group form-group-lg">
                                <h2>
                                    <label for="tipo" class="control-label col-md-12" >
                                        Responsable:
                                    </label>
                                </h2>
                                <div class="col-md-6">
                                    <select class="form-control input-lg" name="usuario_responsable_id" id="usuario_responsable_id">
                                        <?php foreach ($User as $Users): ?>
                                            <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;" >Alta de Objetivo</button>
                    </form>
                    <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>
@stop
