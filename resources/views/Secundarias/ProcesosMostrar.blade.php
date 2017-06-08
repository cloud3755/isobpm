@extends('layouts.principal2')

@section('content')
<br><br><br><br><br><br>

<?php foreach ($proceso as $procesos): ?>
<?php endforeach ?>
@if(!empty($rutaalindex))
  <center><a href="{{$rutaalindex}}" id="bizagi" target="_blank" class="btn btn-default btn-md active" role="button">Ver proceso</a></center>
@endif

 <form method="POST" action="/procesos/edit/<?=$procesos['id']?>" accept-charset="UTF-8" enctype="multipart/form-data">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="container">
                <div class="form-group form-group-lg">
                  <h2>  <label for="Usuario" class="control-label col-md-12" >
                        Tipo de Proceso:
                    </label>
                     </h2>
                    <div class="col-md-6">
                        <select class="form-control input-lg" name="tipo" id="protipoproc">
                          <option value="<?=$procesos['tipo']?>"> <?=$procesos['tipo']?> </option>
                          <?php foreach ($tipoproceso as $tipoproc): ?>
                            <option value="<?=$tipoproc['nombreproceso']?>"> <?=$tipoproc['nombreproceso']?> </option>
                          <?php endforeach ?>

                        </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Proceso:</label></h2>
                    <div class="col-md-6">
                        <input class="form-control input-lg" value="<?=$procesos['proceso']?>" id="probproces" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12">
                    Decripcion:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <textarea class="form-control input-lg" id = "prodescripcionproces" rows="3" placeholder="Descripcion del proceso" name="descripcion" maxlength="255"><?=$procesos['descripcion']?></textarea>
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
                           <option value="<?=$procesosrelacion->usuario_responsable_id?>" selected="true"> <?=$procesosrelacion->usuario?> </option>
                           <?php foreach ($User as $Users1): ?>
                            <option value="<?=$Users1['id']?>"> <?=$Users1['usuario']?> </option>
                          <?php endforeach ?>
                        </select>
                    </div>

                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12" >
                        Revisado:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <input class="form-control input-lg" value="<?=$procesos['rev']?>" id="protipoOb" type="Text" placeholder="Numero Revision" name="rev" maxlength="50">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12">
                    Detalle de Revision:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <textarea class="form-control" id = "prodescripcionproce" rows="3" placeholder="Detalle de rev" name="detalle_de_rev" maxlength="255"><?=$procesos['detalle_de_rev']?></textarea>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Archivo HTML:</label></h2>
                    <div class="col-md-6">
                      <input class="form-control input-lg" id="probproces" type="Text" placeholder="Sin archivo adjunto" name="filetext" disabled="disabled" value ="<?=$procesos['archivo_html']?>">
                      <input class="form-control input-lg" id="probproces" type="file" accept=".zip" placeholder="<?=$procesos['archivo_html']?>" name="file" >
                  </div>
                </div>


                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12" >
                        Indicadores:
                    </label>
                    </h2>
                    <div class="col-md-6">
                         <select multiple name="indicadores[]" class="form-control multi-select"  id="proresponsableob" width="100%">
                           <?php foreach ($indicador as $indicadores): ?>
                             <?php foreach ($indicadoresrelacion as $listaindicadores): ?>
                               <?php if ($indicadores->id == $listaindicadores->id): ?>
                                 <option value="<?=$listaindicadores->id?>" selected="true"> <?=$listaindicadores->nombre ?> </option>
                               <?php else: ?>
                                 <option value="<?=$indicadores->id?>"> <?=$indicadores->nombre ?> </option>
                               <?php endif ?>
                             <?php endforeach ?>
                           <?php endforeach ?>
                        </select>

                    </div>
                </div>

      <div class="form-group form-group-lg">
        <h2><label for="Usuario" class="control-label col-md-12">Lista de distribucion:</label></h2>
        <div class="col-md-6">

                <select multiple name="lista_de_distribucion[]" class="form-control multi-select" id="lista_de_distribucion" width="100%" >
                 <?php foreach ($Users as $user1): ?>
                   <option value="<?=$user1->id?>"> <?=$user1->nombre ?> </option>
                 <?php endforeach ?>

                 <?php foreach ($listaenvio as $lista): ?>
                     <option value="<?=$lista->id?>" selected="true"> <?=$lista->nombre ?> </option>
                 <?php endforeach ?>

               </select>

             </div>
         </div>



          </div>
          <br>
          <!-- se creara un bucle para generar los n modales necesarios para la edicion de datos -->
          <center><button type="button" class="btnprocesoformclose" onclick=location="/procesos/visual" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-arrow-left"></i> Cerrar</button></center>


                                      <center><button type="submit" class="btnprocesoform" ><i class="glyphicon glyphicon-pencil"></i> Guardar Cambios  </button></center>
</form>

                                      <form class="" action="/procesos/delete/<?=$procesos['id']?>" method="post">
                                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                                        <center><button type="submit" class="btnprocesoform" id="btndelete_<?=$procesos['id']?>" style="font-family: Arial;" dataid="<?=$procesos['id']?>" onclick="
          return confirm('Estas seguro de eliminar el proceso <?=$procesos['proceso']?>?')"><i class="glyphicon glyphicon-remove"></i> Eliminar</button></center>
                                      </form>
</center>
                                      <br>

@Stop
