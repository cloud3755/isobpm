@extends('layouts.principal2')

@section('content')
<br><br><br><br><br><br><br>
        <div class="container">
            <form action="/objetivos/edit/<?=$id?>" method="post" role="form" id="formularioobjetivo">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="creador_id" value="{{Auth::user()->id}}">
              <div class="form-group form-group-lg">
                <div class="form-group form-group-lg">
                    <h2>
                      <label for="User" class="control-label col-md-12" >
                        Tipo de Objetivo actual: <?=$tipoactual['nombre'] ?>
                      </label>
                    </h2>
                  </br>
                  <h2>
                    <label for="User" class="control-label col-md-12" >
                      Nuevo tipo objetivo:
                    </label>
                  </h2>
                    <div class="col-md-6">
                        <select class="form-control input-lg" name="tipo_objetivo_id" id="tipo_objetivo_id">
                          <option value="<?=$tipoactual['id']?>" selected="true"><?=$tipoactual['nombre']?></option>
                            <?php foreach ($tipoobjetivo as $tipoobjetiv): ?>
                                <option value="<?=$tipoobjetiv['id'] ?>"><?=$tipoobjetiv['nombre']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                  </div>
                    <div class="form-group form-group-lg">
                        <h2><label for="Usuario" class="control-label col-md-12">Objetivo:</label></h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" id="nombre" value="<?=$registro['nombre']?>" type="Text" placeholder="A que se quiere llegar" name="nombre">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <h2>
                            <label for="Usuario" class="control-label col-md-12">
                                Decripcion:
                            </label>
                        </h2>
                        <div class="col-md-6">
                            <textarea class="form-control" id = "descripcion" rows="3" name="descripcion"><?=$registro['descripcion']?></textarea>
                        </div>
                    </div>



                    <div class="form-group form-group-lg">
                        <h2>
                          <label for="tipo" class="control-label col-md-12" >
                            Responsable actual:
                          </label>
                        </h2>
                        <div class="col-md-6">
                            <input class="form-control input-lg" disabled="true" id="aux" value="<?=$responsableactual['nombre'] ?>" type="text" placeholder="fecha" name="aux">
                        </div>
                      </br>
                      <h2>
                        <label for="tipo" class="control-label col-md-12" >
                          Nuevo responsable:
                        </label>
                      </h2>
                        <div class="col-md-6">
                            <select class="form-control input-lg" name="usuario_responsable_id" id="usuario_responsable_id">
                                <?php foreach ($User as $us): ?>
                                  @IF($responsableactual['id'] == $us['id'])
                                    <option value="<?=$us['id'] ?>" selected="true"><?=$us['nombre']?></option>
                                  @else
                                    <option value="<?=$us['id'] ?>"><?=$us['nombre']?></option>
                                  @endif
                                <?php endforeach ?>
                            </select>
                        </div>
                      </div>
                      <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;" >Guardar cambios</button>
                      <button type="button" class="btnobjetivo" onclick=location="/objetivos/visual" data-dismiss="modal" id="btnCloseUpload">Regresar</button>
                </div>
              </form>
              @if(Auth::user()->perfil <= 3)
              <form class="" action="/objetivos/destroy/<?=$registro['id']?>" method="post">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                <button type="submit" class="btnprocesoform" id="btndelete_<?=$registro['id']?>" style="font-family: Arial;" dataid="<?=$registro['id']?>" onclick="
return confirm('Estas seguro de eliminar el proceso <?=$registro['nombre']?>?')"><i class="glyphicon glyphicon-remove"></i> Eliminar</button>
              </form>
              @endif
              <div class="row">
                  <div class="col-lg-12">
                      <div class="panel panel-red" id="tablaobjetivo">
                          <div class="panel-heading">
                              Indicadores

                              <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i> </button>

                          </div>
                      <div class="panel-body">
                          <div class="dataTable_wrapper">
                              <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                                <thead style='background-color: #868889; color:#FFF'>
                                  <tr>
                                    <th><div class="th-inner sortable both">Objetivo ID</div></th>
                                    <th><div class="th-inner sortable both">Nombre</div></th>
                                    <th><div class="th-inner sortable both">Descripcion</div></th>
                                    <th><div class="th-inner sortable both">Responsable id</div></th>
                                    <th><div class="th-inner sortable both">frecuencia_id</div></th>
                                    <th><div class="th-inner sortable both">unidad</div></th>
                                    <th><div class="th-inner sortable both">logica</div></th>
                                    <th><div class="th-inner sortable both">meta</div></th>
                                    <th><div class="th-inner sortable both">Modificacion</div></th>
                                  </tr>
                                </thead>
                                <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                                <tbody>
                                  <?php foreach ($indicadorrelacion as $indicadorrel): ?>
                                  <td><?=$indicadorrel->indicadoresobjetivo?></td>
                                  <td><?=$indicadorrel->nombreindicador?></td>
                                  <td><?=$indicadorrel->descripcionindicador?></td>
                                  <td><?=$indicadorrel->userindicador?></td>
                                  <td><?=$indicadorrel->frecuenciaindicador?></td>
                                  <td><?=$indicadorrel->simboloindicador?></td>
                                  <td><?=$indicadorrel->logicaindicador?></td>
                                  <td><?=$indicadorrel->indicadormeta?></td>
                                  <td><form class="" action="/indicadores/destroy/{{ $indicadorrel->id }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}

                                      <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" onclick="
        return confirm('Estas seguro de eliminar el indicador <?=$indicadorrel->nombreindicador?>?')">Eliminar</button>
        <button type="button" class="btnobjetivo" value = "<?=$indicadorrel->id?>" data-toggle="modal" data-target="#modaledit" onclick="Editar(this);"><i class="glyphicon glyphicon-pencil"></i> Editar  </button>

                                    </form>
                                    </td>
                                  </tr>
                                  <?php endforeach ?>
                                </tbody>
                              </table>
                          </div>
                      </div>
                    </div>
                  </div>
          </div>
        </div>
        <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">ALTA DE INDICADOR</h2>
                    </div>
            <div class="modal-body">
            <div class="container">
              <form class="" action="/indicadores/store" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group form-group-lg">
                            <h2>
                            <label for="tipo" class="control-label col-md-12" >
                                Objetivo: <?=$registro['nombre']?>
                            </label>
                            </h2>
                            <div class="col-md-6">
                                <input class="form-control input-lg" readonly="readonly" id="objetivo_id" value = "<?=$registro['id']?>" type="Text" placeholder="A que se quiere llegar" name="objetivo_id">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2><label for="Usuario" class="control-label col-md-12">Indicador:</label></h2>
                            <div class="col-md-6">
                                <input class="form-control input-lg" id="nombre" type="Text" placeholder="Nombre indicador" name="nombre">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2>
                            <label for="Usuario" class="control-label col-md-12">
                            Decripcion:
                            </label>
                            </h2>
                            <div class="col-md-6">
                                <textarea class="form-control" id = "prodescripcionind" rows="3" placeholder="" name="descripcion" id="descripcion"></textarea>
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
                        <div class="form-group form-group-lg">
                            <h2>
                            <label for="tipo" class="control-label col-md-12" >
                                Frecuencia:
                            </label>
                            </h2>
                            <div class="col-md-6">
                                <select class="form-control input-lg" name="frecuencia_id" id="frecuencia_id">
                                  <?php foreach ($frecuencias as $frecuencia): ?>
                                    <option value="<?=$frecuencia['id']?>"><?=$frecuencia['nombre']?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                            <h2>
                            <label for="tipo" class="control-label col-md-12" >
                                Unidad:
                            </label>
                            </h2>
                            <div class="col-md-6">
                                <select class="form-control input-lg" name="unidad" id="unidad">
                                  <?php foreach ($unidades as $unidad): ?>
                                    <option value="<?=$unidad['id']?>"><?=$unidad['simbolo']?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2>
                            <label for="tipo" class="control-label col-md-12" >
                                Valor de indicador:
                            </label>
                            </h2>
                            <div class="col-md-6">
                                <select class="form-control input-lg" name="logica" id="logica">
                                  <?php foreach ($logica as $logicas): ?>
                                    <option value="<?=$logicas['id']?>"><?=$logicas['simbolo']?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <h2><label for="Usuario" class="control-label col-md-12">Meta:</label></h2>
                            <div class="col-md-6">
                                <input class="form-control input-lg" id="meta" type="Text" placeholder="meta" name="meta">
                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                          <h2><label for="Usuario" class="control-label col-md-12">Acceso:</label></h2>
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
                                                         <select multiple name="listaUsuariosDisponibles[]"  id="listaUsuariosDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('listaUsuariosDisponibles', 'lista_de_acceso');">
                                                           <?php foreach ($User as $Users): ?>
                                                             <option value="<?=$Users['id']?>"> <?=$Users['nombre']?> </option>
                                                           <?php endforeach ?>
                                                         </select>

                                                 </td>
                                                 <td>
                                                     <table>
                                                         <tbody><tr>
                                                             <td>
                                                                 <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('listaUsuariosDisponibles', 'lista_de_acceso');">
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
                                                                 <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('lista_de_acceso', 'listaUsuariosDisponibles');">
                                                             </td>
                                                         </tr>
                                                     </tbody></table>

                                                 </td>

                                                 <td>
                                                     <select multiple name="lista_de_acceso[]" id="lista_de_acceso"  size="7" style="width: 100%;" onclick="agregaSeleccion('lista_de_acceso', 'listaUsuariosDisponibles');">

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
                              <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">Alta de indicador</button>
                        </form>
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
                </div>
              </div>
            </div>
        </div>



          <div class="modal fade" id="modaledit" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h2 class="modal-title">Modificar Indicador</h2>
                      </div>
              <div class="modal-body">
              <div class="container">
                <form id="fileinfo" method="post">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" id="id">
                          <div class="form-group form-group-lg">
                              <h2><label for="Usuario" class="control-label col-md-12">Indicador:</label></h2>
                              <div class="col-md-6">
                                  <input class="form-control input-lg" id="enombre" type="Text" placeholder="Nombre indicador" name="enombre">
                              </div>
                          </div>
                          <div class="form-group form-group-lg">
                              <h2>
                              <label for="Usuario" class="control-label col-md-12">
                              Decripcion:
                              </label>
                              </h2>
                              <div class="col-md-6">
                                  <textarea class="form-control" rows="3" placeholder="" name="edescripcion" id="edescripcion"></textarea>
                              </div>
                          </div>
                          <div class="form-group form-group-lg">
                              <h2>
                              <label for="tipo" class="control-label col-md-12" >
                                  Responsable:
                              </label>
                              </h2>
                              <div class="col-md-6">
                                  <select class="form-control input-lg" name="eusuario_responsable_id" id="eusuario_responsable_id">
                                    <?php foreach ($User as $Users): ?>
                                        <option value="<?=$Users['id']?>"><?=$Users['nombre']?></option>
                                    <?php endforeach ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group form-group-lg">
                              <h2>
                              <label for="tipo" class="control-label col-md-12" >
                                  Frecuencia:
                              </label>
                              </h2>
                              <div class="col-md-6">
                                  <select class="form-control input-lg" name="efrecuencia_id" id="efrecuencia_id"º>
                                    <?php foreach ($frecuencias as $frecuencia): ?>
                                      <option value="<?=$frecuencia['id']?>"><?=$frecuencia['nombre']?></option>
                                    <?php endforeach ?>
                                  </select>
                              </div>
                          </div>

                          <div class="form-group form-group-lg">
                              <h2>
                              <label for="tipo" class="control-label col-md-12" >
                                  Unidad:
                              </label>
                              </h2>
                              <div class="col-md-6">
                                  <select class="form-control input-lg" name="eunidad" id="eunidad">
                                    <?php foreach ($unidades as $unidad): ?>
                                      <option value="<?=$unidad['id']?>"><?=$unidad['simbolo']?></option>
                                    <?php endforeach ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group form-group-lg">
                              <h2>
                              <label for="tipo" class="control-label col-md-12" >
                                  Valor de indicador:
                              </label>
                              </h2>
                              <div class="col-md-6">
                                  <select class="form-control input-lg" name="elogica" id="elogica">
                                    <?php foreach ($logica as $logicas): ?>
                                      <option value="<?=$logicas['id']?>"><?=$logicas['simbolo']?></option>
                                    <?php endforeach ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group form-group-lg">
                              <h2><label for="Usuario" class="control-label col-md-12">Meta:</label></h2>
                              <div class="col-md-6">
                                  <input class="form-control input-lg" id="emeta" type="Text" placeholder="meta" name="emeta">
                              </div>
                          </div>

                                          <div class="form-group form-group-lg">
                                            <h2><label for="Usuario" class="control-label col-md-12">Lista de accesos:</label></h2>
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
                                                                                <select multiple name="elistaUsuariosDisponibles[]"  id="elistaUsuariosDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('elistaUsuariosDisponibles', 'elista_de_accesos');">

                                                                                </select>

                                                                        </td>
                                                                        <td>
                                                                            <table>
                                                                                <tbody><tr>
                                                                                    <td>
                                                                                        <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('elistaUsuariosDisponibles', 'elista_de_accesos');">
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

                                                                                                    var select = document.getElementById('lista_de_acceso');

                                                                                                    for ( var i = 0, l = select.options.length, o; i < l; i++ )
                                                                                                    {
                                                                                                      o = select.options[i];
                                                                                                        o.selected = true;
                                                                                                    }
                                                                                                    var select = document.getElementById('elista_de_accesos');

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
                                                                                                var select = document.getElementById('lista_de_acceso');

                                                                                                for ( var i = 0, l = select.options.length, o; i < l; i++ )
                                                                                                {
                                                                                                  o = select.options[i];
                                                                                                    o.selected = true;
                                                                                                }
                                                                                                var select = document.getElementById('elista_de_accesos');

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
                                                                                        <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('elista_de_accesos', 'elistaUsuariosDisponibles');">
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody></table>

                                                                        </td>

                                                                        <td>
                                                                            <select multiple name="elista_de_accesos[]" id="elista_de_accesos"  size="7" style="width: 100%;" onclick="agregaSeleccion('elista_de_accesos', 'elistaUsuariosDisponibles');">

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
                        <a class="btn btn-primary" id="actualizar" style="font-family: Arial;">Guardar Cambios</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        </div>
                  </div>
                </div>
              </div>
          </div>

<?php
  $dato = json_encode($indicadorrelacion);
 ?>

<script type="text/javascript">

function Editar(btn){
  $("#id").val(btn.value);

  var route = "https://www.isobpm.com/indicadores/"+btn.value+"/edit";

  $.get(route, function(res){
    $("#enombre").val(res.nombre);
    $("#edescripcion").val(res.descripcion);
    $("#eusuario_responsable_id").val(res.usuario_responsable_id);
    $("#efrecuencia_id").val(res.frecuencia_id);
    $("#eunidad").val(res.unidad);
    $("#elogica").val(res.logica);
    $("#emeta").val(res.meta);
  });

  var route = route+"2";
  $("#elista_de_accesos").empty();
  $.get(route, function(res){
    for (var i = 0; i < res.length; i++) {
      $("#elista_de_accesos").append('<option value="'+res[i].id+'">'+res[i].nombre+'</option>');
    }

    var select = document.getElementById('elista_de_accesos');

    for ( var i = 0, l = select.options.length, o; i < l; i++ )
    {
      o = select.options[i];
        o.selected = true;
    }

  });

  var route = route+"3";
  $("#elistaUsuariosDisponibles").empty();

  $.get(route, function(res){
    for (var i = 0; i < res.length; i++) {
      $("#elistaUsuariosDisponibles").append('<option value="'+res[i].id+'">'+res[i].nombre+'</option>');

    }
  });


}

$(document).ready(function(){

  $("#actualizar").click(function(){
    var value = $("#id").val();
    var route = "https://www.isobpm.com/indicadores/edit/"+value+"";
    var token = $("#token").val();
    var fd = new FormData(document.getElementById("fileinfo"));

    $.ajax({
      url: route,
      headers: {'X-CSRF_TOKEN': token},
      type: 'post',
      data: fd,
      processData: false,  // tell jQuery not to process the data
      contentType: false,
      success: function(){
        location.reload();
      }
    });
  });

});
</script>


@Stop
