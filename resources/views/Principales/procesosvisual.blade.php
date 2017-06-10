@extends('layouts.principal2')

@section('content')
<br><br><br><br><br><br><br><br>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
            <ol class="breadcrumb iso-breadcumb">
                <li><a href="/bienvenida/" style='color:#FFF'>Procesos</a></li>
                <li class="active">Visualizacion de Procesos</li>
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
                <button type="button" class="btn btn-green btn-xs" id="<?=$tipoproc['nombreproceso'] ?>" data-toggle="modal" data-target="#modalUpload<?=$tipoproc['id'] ?>"><i class="glyphicon glyphicon-upload"></i></button>
            </div>
</br>

      <?php foreach ($proceso->where('tipo',$tipoproc['nombreproceso']) as $process): ?>

      <button type="button" class="btnproceso" onclick=location="/procesos/registro/<?=$process->id ?>" id="<?=$process->proceso ?>"><?=$process->proceso ?></button>

      <?php endforeach ?>

         </br>
       </div>
    </div>
  </div>
<?php endforeach ?>




</br>




<?php foreach ($tipoproceso as $tipoproc): ?>

 <form method="POST" action="/procesos/store" accept-charset="UTF-8" enctype="multipart/form-data">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <input type="hidden" name="tipo" id="protipoproc" value = "<?=$tipoproc['nombreproceso'] ?>">
        <div class="modal fade" id="modalUpload<?=$tipoproc['id'] ?>" tabindex="-1" role="dialog" style="background-color:gray">
            <div class="modal-dialog" role="form">
                <div class="modal-content">
                    <div class="modal-header">

                        <h2 class="modal-title">Alta de proceso</h2>
                    </div>
                    <div class="modal-body">
            <div class="container">
                <div class="form-group form-group-lg">
                  <h2><label for="Usuario" class="control-label col-md-12" >Tipo de proceso:  <?=$tipoproc['nombreproceso'] ?></label></h2>
                    <div class="col-md-6">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Nombre Proceso:</label></h2>
                    <div class="col-md-6">
                        <input class="form-control input-lg" id="probproces" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12">
                    Decripcion:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <textarea class="form-control input-lg" id = "prodescripcionproces" rows="3" placeholder="Descripcion del proceso" name="descripcion" maxlength="255"></textarea>
                    </div>
                </div>


                <div class="form-group form-group-lg">
                    <h2>
                    <label for="tipo" class="control-label col-md-12" >
                        Responsable:
                    </label>
                    </h2>
                    <div class="col-md-6">
                         <select class="form-control input-lg" name="usuario_responsable_id" id="proresponsableob">
                          <?php foreach ($User as $Users): ?>
                            <option value="<?=$Users['id']?>"> <?=$Users['nombre']?> </option>
                          <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>    <label for="Tipo" class="control-label col-md-12" >
                        Revision:
                    </label>    </h2>
                    <div class="col-md-6">
                      <input class="form-control input-lg" id="protipoOb" type="Text" placeholder="Numero de revision" name="rev" maxlength="50">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12">
                    Detalle de Revision:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <textarea class="form-control" id = "prodescripcionproce" rows="3" placeholder="Detalle de rev" name="detalle_de_rev" maxlength="255"></textarea>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Archivo HTML:</label></h2>
                    <div class="col-md-6">
                        <input class="form-control input-lg" id="probproces" type="file" accept=".zip" placeholder="file" name="file">
                    </div>
                </div>



                <div class="form-group form-group-lg">
                    <h2>
                    <label for="tipo" class="control-label col-md-12" >
                        Indicadores:
                    </label>
                    </h2>
                    <div class="col-md-6">
                      <select multiple class="form-control multi-select" name="indicadores[]" id="proresponsableob" width="100%">
                       <?php foreach ($indicador as $indicadores): ?>
                         <option value="<?=$indicadores->id?>"> <?=$indicadores->nombre?> </option>
                       <?php endforeach ?>
                     </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2><label for="Usuario" class="control-label col-md-12">Lista de distribucion:</label></h2>
                  <div class="col-md-12">

                        <select class="form-control multi-select"  multiple="multiple" name="lista_de_distribucion[]" id="lista_de_distribucion" width="100%" multiple data-actions-box="true" >
                           <?php foreach ($User as $Users): ?>
                             <option value="<?=$Users['id']?>"> <?=$Users['nombre']?> </option>
                           <?php endforeach ?>
                         </select>

                  </div>
                </div>


          </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        <button type="submit" value="file" class="btnobjetivo" id="btnaltaproceso" style="font-family: Arial;">Alta de Proceso</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
</form>

<?php endforeach ?>

@stop
