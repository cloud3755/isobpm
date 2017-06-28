@extends('layouts.principal2')

@section('content')
<br><br><br><br><br><br>

<?php foreach ($proceso as $procesos): ?>
<?php endforeach ?>
@if(!empty($rutaalindex))
  <center><a href="{{$rutaalindex}}" id="bizagi" target="_blank" class="btn btn-default btn-md active" role="button">Ver proceso</a></center>
@endif

<form id="fileinfo" method="post">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <input type="hidden" id="id" value="<?=$procesos['id']?>">
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
                           <?php foreach ($User as $Users1): ?>
                             @if($procesosrelacion->usuario_responsable_id == $Users1['id'] )
                              <option value="<?=$Users1['id']?>" selected="true"> <?=$Users1['nombre']?> </option>
                             @else
                              <option value="<?=$Users1['id']?>"> <?=$Users1['nombre']?> </option>
                             @endif
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
                      <progress id="progress" value="0"></progress>
                  </div>
                </div>


                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12" >
                        Indicadores:
                    </label>
                    </h2>
                    <div class="col-md-6">
                        <div>
                                          <p>
                                              </p><table>
                                                  <tbody><tr>
                                                      <td>Indicadores no elegidos</td>
                                                      <td></td>
                                                      <td>Indicadores elegidos</td>
                                                  </tr>
                                                  <tr>
                                                      <td>
                                                          <select multiple name="listaUsuariosDisponibles[]"  id="listaUsuariosDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('listaUsuariosDisponibles', 'indicadores');">
                                                            <?php foreach ($indicador as $indicadores): ?>
                                                              <option value="<?=$indicadores->id?>"> <?=$indicadores->nombre ?> </option>
                                                            <?php endforeach ?>
                                                          </select>

                                                  </td>
                                                  <td>
                                                      <table>
                                                          <tbody><tr>
                                                              <td>
                                                                  <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('listaUsuariosDisponibles', 'indicadores');">
                                                              </td>
                                                          </tr>
                                                          <tr>
                                                              <td>

                                                            </td>
                                                          </tr>
                                                          <tr>
                                                              <td>
                                                              </td>
                                                          </tr>
                                                          <tr>
                                                              <td>
                                                                  <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('indicadores', 'listaUsuariosDisponibles');">
                                                              </td>
                                                          </tr>
                                                      </tbody></table>

                                                  </td>

                                                  <td>
                                                      <select multiple="multiple" name="indicadores[]"  id="indicadores" size="7" style="width: 100%;" onclick="agregaSeleccion('indicadores','listaUsuariosDisponibles');">
                                                        <?php foreach ($indicadoresrelacion as $listaindicadores): ?>
                                                          <option value="<?=$listaindicadores->id?>" selected="true"> <?=$listaindicadores->nombre ?> </option>
                                                        <?php endforeach ?>
                                                      </select>
                                                  </td>
                                              </tr>
                                          </tbody></table>
                                      <p></p>
                                  </div>
                    </div>
                </div>

      <div class="form-group form-group-lg">
        <h2><label for="Usuario" class="control-label col-md-12">Lista de distribucion:</label></h2>
        <div class="col-md-6">

               <div>
                                 <p>
                                     </p><table>
                                         <tbody><tr>
                                             <td>Usuarios no elegidos</td>
                                             <td></td>
                                             <td>Usuarios elegidos</td>
                                         </tr>
                                         <tr>
                                             <td>
                                                 <select multiple name="elistaUsuariosDisponibles[]"  id="elistaUsuariosDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('elistaUsuariosDisponibles', 'lista_de_distribucion');">
                                                   <?php foreach ($Users as $user1): ?>
                                                     <option value="<?=$user1->id?>"> <?=$user1->nombre ?> </option>
                                                   <?php endforeach ?>

                                                 </select>

                                         </td>
                                         <td>
                                             <table>
                                                 <tbody><tr>
                                                     <td>
                                                         <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('elistaUsuariosDisponibles', 'lista_de_distribucion');">
                                                     </td>
                                                 </tr>
                                                 <tr>
                                                     <td>
                                                         <script type="text/javascript">
                                                             function agregaSeleccion(origen, destino) {
                                                                 obj = document.getElementById(origen);
                                                                 if (obj.selectedIndex == -1)
                                                                     return;

                                                                 for (i = 0; opt = obj.options[i]; i++)
                                                                     if (opt.selected) {
                                                                         valor = opt.value; // almacenar value
                                                                         txt = obj.options[i].text; // almacenar el texto
                                                                         obj.options[i] = null; // borrar el item si está seleccionado
                                                                         obj2 = document.getElementById(destino);

                                                                         opc = new Option(txt, valor,"defaultSelected");
                                                                         eval(obj2.options[obj2.options.length] = opc);
                                                                     }

                                                                     var select = document.getElementById('indicadores');

                                                                     for ( var i = 0, l = select.options.length, o; i < l; i++ )
                                                                     {
                                                                       o = select.options[i];
                                                                         o.selected = true;
                                                                     }

                                                                     var select = document.getElementById('lista_de_distribucion');

                                                                     for ( var i = 0, l = select.options.length, o; i < l; i++ )
                                                                     {
                                                                       o = select.options[i];
                                                                         o.selected = true;
                                                                     }


                                                                 }

                                                                 function agregaTodo(origen, destino) {
                                                                     obj = document.getElementById(origen);
                                                                     obj2 = document.getElementById(destino);
                                                                     aux = obj.options.length;
                                                                     for (i = 0; i < aux; i++) {
                                                                         aux2 = 0;
                                                                         opt = obj.options[aux2];
                                                                     valor = opt.value; // almacenar value
                                                                     txt = obj.options[aux2].text; // almacenar el texto
                                                                     obj.options[aux2] = null; // borrar el item si está seleccionado

                                                                     opc = new Option(txt, valor,"defaultSelected");
                                                                     eval(obj2.options[obj2.options.length] = opc);
                                                                 }

                                                                 var select = document.getElementById('indicadores');

                                                                 for ( var i = 0, l = select.options.length, o; i < l; i++ )
                                                                 {
                                                                   o = select.options[i];
                                                                     o.selected = true;
                                                                 }

                                                                 var select = document.getElementById('lista_de_distribucion');

                                                                 for ( var i = 0, l = select.options.length, o; i < l; i++ )
                                                                 {
                                                                   o = select.options[i];
                                                                     o.selected = true;
                                                                 }
                                                             }

                                                         </script>
                                                     </td>
                                                 </tr>
                                                 <tr>
                                                     <td>
                                                     </td>
                                                 </tr>
                                                 <tr>
                                                     <td>
                                                         <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('lista_de_distribucion', 'elistaUsuariosDisponibles');">
                                                     </td>
                                                 </tr>
                                             </tbody></table>

                                         </td>

                                         <td>
                                             <select multiple name="lista_de_distribucion[]" id="lista_de_distribucion"  size="7" style="width: 100%;" onclick="agregaSeleccion('lista_de_distribucion', 'elistaUsuariosDisponibles');">
                                               <?php foreach ($listaenvio as $lista): ?>
                                                   <option value="<?=$lista->id?>" selected="true"> <?=$lista->nombre ?> </option>
                                               <?php endforeach ?>
                                             </select>
                                         </td>
                                     </tr>
                                 </tbody></table>
                             <p></p>
                         </div>

             </div>
         </div>



          </div>
          <br>
          <!-- se creara un bucle para generar los n modales necesarios para la edicion de datos -->
          <center><button type="button" class="btnprocesoformclose" onclick=location="/procesos/visual" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-arrow-left"></i> Cerrar</button></center>


                                      <center><a class="btn btnprocesoform btn-md active" role="button" id="actualizar" style="font-family: Arial;"><i class="glyphicon glyphicon-pencil"></i> Guardar Cambios</a></center>
</form>

                                      <form class="" action="/procesos/delete/<?=$procesos['id']?>" method="post">
                                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                                        <center><button type="submit" class="btnprocesoform" id="btndelete_<?=$procesos['id']?>" style="font-family: Arial;" dataid="<?=$procesos['id']?>" onclick="
          return confirm('Estas seguro de eliminar el proceso <?=$procesos['proceso']?>?')"><i class="glyphicon glyphicon-remove"></i> Eliminar</button></center>
                                      </form>
</center>
                                      <br>

<script type="text/javascript">


$(document).ready(function(){

  $("#actualizar").click(function(){
    var value = $("#id").val();
    var route = "https://www.isobpm.com/procesos/edit/"+value+"";
    var token = $("#token").val();
    var fd = new FormData(document.getElementById("fileinfo"));
    var progressBar = document.getElementById("progress");

    $.ajax({
      url: route,
      headers: {'X-CSRF_TOKEN': token},
      type: 'post',
      data: fd,
      processData: false,  // tell jQuery not to process the data
      contentType: false,
      xhr: function() {
        var xhr = $.ajaxSettings.xhr();
        xhr.upload.onprogress = function(e) {
          progressBar.max = e.total;
          progressBar.value = e.loaded;
            console.log(Math.floor(e.loaded / e.total *100) + '%');
        };
        return xhr;
      },
      success: function(){
        alert("Cambios guardados correctamente");
        location.reload();
      }
    });
  });

});
</script>

@Stop
