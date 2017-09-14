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
                <button type="button" class="btn btn-success btn-xs" id="<?=$tipoproc['nombreproceso'] ?>" data-toggle="modal" data-target="#modalUpload"  onclick="tipoproceso(this);"><i class="glyphicon glyphicon-floppy-save"></i></button>
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




<form id="fileinfo" method="post">
  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
   <input type="hidden" name="tipo" id="tipo">
        <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" style="background-color:gray">
            <div class="modal-dialog modal-lg" role="form">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                        <h3 class="modal-title">Alta de proceso</h3>
                    </div>
                    <div class="modal-body">
            <div class="container">
                <div class="form-group form-group-lg">
                  <h2><label for="Usuario" class="control-label col-md-12" >Tipo de proceso:</label></h2>
                    <div class="col-sm-9">
                      <input readonly class="form-control input-lg" id="tipoprocess" type="Text" name="tipoprocess" maxlength="50">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Nombre Proceso:</label></h2>
                    <div class="col-sm-9">
                        <input class="form-control input-lg" id="probproces" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12">
                    Decripcion:
                    </label>
                    </h2>
                    <div class="col-sm-9">
                        <textarea class="form-control input-lg" id = "prodescripcionproces" rows="3" placeholder="Descripcion del proceso" name="descripcion" maxlength="255"></textarea>
                    </div>
                </div>


                <div class="form-group form-group-lg">
                    <h2>
                    <label for="tipo" class="control-label col-md-12" >
                        Responsable:
                    </label>
                    </h2>
                    <div class="col-sm-9">
                         <select class="form-control input-lg" name="usuario_responsable_id" id="proresponsableob">
                          <?php foreach ($User as $Users): ?>
                            <option value="<?=$Users['id']?>"> <?=$Users['nombre']?> </option>
                          <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                  <h2><label for="Usuario" class="control-label col-md-12">Numero de Revision:</label></h2>
                    <div class="col-sm-9">
                      <input class="form-control input-lg" id="protipoOb" type="Text" placeholder="Numero de revision" name="rev" maxlength="50">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2>
                    <label for="Usuario" class="control-label col-md-12">
                    Detalle de Revision:
                    </label>
                    </h2>
                    <div class="col-sm-9">
                        <textarea class="form-control" id = "prodescripcionproce" rows="3" placeholder="Detalle de rev" name="detalle_de_rev" maxlength="255"></textarea>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <h2><label for="Usuario" class="control-label col-md-12">Archivo HTML:</label></h2>
                    <div class="col-sm-9">
                        <input class="form-control input-lg" id="probproces" type="file" accept=".zip" placeholder="file" name="file">
                        <progress id="progress" value="0"></progress>
                    </div>
                </div>



                <div class="form-group form-group-lg">
                    <h2>
                    <label for="tipo" class="control-label col-md-12" >
                        Indicadores:
                    </label>
                    </h2>
                    <div class="col-sm-9">
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
                  <div class="col-md-12">

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
                                                        <?php foreach ($User as $user1): ?>
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

                                                  </select>
                                              </td>
                                          </tr>
                                      </tbody></table>
                                  <p></p>
                              </div>

                  </div>
                </div>


          </div>
                    <div class="modal-footer">
                        <a class="btn btn-success" role="button" id="actualizar" style="font-family: Arial;"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
</form>


<script type="text/javascript">

function Abrir(btn){
  location.href = "/procesos/registro/"+btn.value;
}

function tipoproceso(btn){
  $("#tipoprocess").val(btn.id);
  $("#tipo").val(btn.id);
}

$(document).ready(function(){

  $("#actualizar").click(function(){
    var route = "/procesos/store";
    var token = $("#token").val();
    var fd = new FormData(document.getElementById("fileinfo"));
    var progressBar = document.getElementById("progress");

    $.ajax({
      url: route,
      headers: {'X-CSRF_TOKEN': $('input[name="_token"]').val()},
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


@stop
