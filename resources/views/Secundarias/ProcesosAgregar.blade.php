@extends('layouts.principal2')

@section('content')
<style media="screen">
.embed-container {
  position: relative;
  padding-bottom: 56.25%;
  height: 0;
  overflow: hidden;
}
.embed-container iframe {
  position: absolute;
  top:0;
  left: 0;
  width: 100%;
  height: 100%;
}
.glyphicon {
    font-size: 150%;
}
.labeltask {
  display: inline-block;
  width: 140px;
  text-align: right;
}​
.fa {
    font-size: 160%;
}
.boxsizingBorder {
    -webkit-box-sizing: border-box;
       -moz-box-sizing: border-box;
            box-sizing: border-box;
}
</style>

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

            var select = document.getElementById(origen);

            for ( var i = 0, l = select.options.length, o; i < l; i++ )
            {
              o = select.options[i];
                o.selected = true;
            }

            var select = document.getElementById(destino);

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

        var select = document.getElementById(destino);

        for ( var i = 0, l = select.options.length, o; i < l; i++ )
        {
          o = select.options[i];
            o.selected = true;
        }

    }

</script>
<br><br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel blank-panel">
            <div class="panel-heading">
                <div class="panel-options">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a data-toggle="tab" href="#tab-1">General</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2">An&aacute;lisis</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-3">Informaci&oacute;n</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">

                    <div id="tab-1" class="tab-pane active">
                      <div id="datos">
                        <div class="row">
                          <form id="fileinfo" method="post">
                             <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <div class="container">
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                  <h3><label for="Usuario" class="control-label" >Tipo de Proceso:</label></h3>
                                  <input class="form-control" readonly id="tipo" value="<?=$tipoproceso?>" type="Text" placeholder="Tipo de proceso" name="tipo" maxlength="50">
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6">
                                  <h3><label for="Usuario" class="control-label">Nombre Proceso:</label></h3>
                                  <input class="form-control"  id="probproces" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6">
                                  <h3><label for="tipo" class="control-label" >Responsable:</label></h3>
                                   <select class="form-control" name="usuario_responsable_id" id="proresponsableob">
                                     <?php foreach ($User as $Users1): ?>
                                        <option value="<?=$Users1['id']?>"> <?=$Users1['nombre']?> </option>
                                    <?php endforeach ?>
                                  </select>
                                </div>

                                <div class="col-lg-8 col-md-8 col-sm-6">
                                  <h3><label for="Usuario" class="control-label">Decripcion:</label></h3>
                                  <textarea class="form-control" id = "prodescripcionproces" rows="3" placeholder="Descripcion del proceso" name="descripcion" maxlength="255"></textarea>
                                </div>

                                  <div class="col-lg-4 col-md-4 col-sm-4">
                                      <h3><label for="Usuario" class="control-label" >Numero de revision:</label></h3>
                                      <input class="form-control" value="" id="protipoOb" type="Text" placeholder="Numero Revision" name="rev" maxlength="50">
                                  </div>

                                  <div class="col-lg-12 col-md-12 col-sm-8">
                                      <h3><label for="Usuario" class="control-label">Detalle de Revision:</label></h3>
                                      <textarea class="form-control" id = "prodescripcionproce" rows="3" placeholder="Detalle de rev" name="detalle_de_rev" maxlength="255"></textarea>
                                  </div>

                                  <div class="col-lg-3 col-md-3 col-sm-4">
                                      <h3><label for="Usuario" class="control-label">Tipo de archivo:</label></h3>
                                      <form>
                                          <input type="radio" name="tipoarchivo" value="1" checked> HTML<br>
                                          <input type="radio" name="tipoarchivo" value="2"> Otro<br>
                                      </form>
                                  </div>

                                  <div class="col-lg-8 col-md-8 col-sm-8">
                                      <h3><label for="Usuario" class="control-label">Archivo HTML:</label></h3>
                                        <input class="form-control input-lg" id="probproces" type="file" accept=".zip" name="file" >
                                        <progress id="progress" value="0"></progress>
                                  </div>
                            </div>
                            <!-- se creara un bucle para generar los n modales necesarios para la edicion de datos -->
                          </form>
                        </div>
                      </div>
                    </div>


                    <div id="tab-2" class="tab-pane">
                      <div id="bitacora">
                        <div class="row">
                          <form id="fileinfo2" method="post">
                            <font size=2em>
                          <div class="container">
                            <div class="col-md-6 col-sm-6 col-lg-4">
                              <h2><label for="Usuario" >Indicadores:</label></h2>
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
                             <div class="col-md-6 col-sm-6 col-lg-4">
                               <h2><label for="Usuario" >Activos de informacion:</label></h2>
                                   <div>
                                         <p>
                                             </p><table>
                                                 <tbody><tr>
                                                     <td>Activos no elegidos</td>
                                                     <td></td>
                                                     <td>Activos elegidos</td>
                                                 </tr>
                                                 <tr>
                                                     <td>
                                                         <select multiple name="listaActivosDisponibles[]"  id="listaActivosDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('listaActivosDisponibles', 'Activos');">
                                                           <?php foreach ($Activos as $Activo): ?>
                                                             <option value="<?=$Activo->id?>"> <?=$Activo->nombre ?> </option>
                                                           <?php endforeach ?>
                                                         </select>

                                                 </td>
                                                 <td>
                                                     <table>
                                                         <tbody><tr>
                                                             <td>
                                                                 <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('listaActivosDisponibles', 'Activos');">
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
                                                                 <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('Activos', 'listaActivosDisponibles');">
                                                             </td>
                                                         </tr>
                                                     </tbody></table>

                                                 </td>
                                                 <td>
                                                     <select multiple="multiple" name="Activos[]"  id="Activos" size="7" style="width: 100%;" onclick="agregaSeleccion('Activos','listaActivosDisponibles');">

                                                     </select>
                                                 </td>
                                             </tr>
                                         </tbody></table>
                                     <p></p>
                                   </div>
                               </div>


                               <div class="col-md-6 col-sm-6 col-lg-4">
                                 <h2><label for="Usuario" >Documentos:</label></h2>
                                     <div>
                                           <p>
                                               </p><table>
                                                   <tbody><tr>
                                                       <td>Documentos no elegidos</td>
                                                       <td></td>
                                                       <td>Documentos elegidos</td>
                                                   </tr>
                                                   <tr>
                                                       <td>
                                                           <select multiple name="listaDocumentosDisponibles[]"  id="listaDocumentosDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('listaDocumentosDisponibles', 'Doculist');">
                                                             <?php foreach ($Documentos as $Documento): ?>
                                                               <option value="<?=$Documento->id?>"> <?=$Documento->nombre ?> </option>
                                                             <?php endforeach ?>
                                                           </select>

                                                   </td>
                                                   <td>
                                                       <table>
                                                           <tbody><tr>
                                                               <td>
                                                                   <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('listaDocumentosDisponibles', 'Doculist');">
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
                                                                   <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('Doculist', 'listaDocumentosDisponibles');">
                                                               </td>
                                                           </tr>
                                                       </tbody></table>

                                                   </td>
                                                   <td>
                                                       <select multiple="multiple" name="Doculist[]"  id="Doculist" size="7" style="width: 100%;" onclick="agregaSeleccion('Doculist','listaDocumentosDisponibles');">

                                                       </select>
                                                   </td>
                                               </tr>
                                           </tbody></table>
                                       <p></p>
                                     </div>
                                 </div>

                                 <div class="col-md-6 col-sm-6 col-lg-4">
                                   <h2><label for="Insumos" >Insumos:</label></h2>
                                       <div>
                                             <p>
                                                 </p><table>
                                                     <tbody><tr>
                                                         <td>Insumos no elegidos</td>
                                                         <td></td>
                                                         <td>Insumos elegidos</td>
                                                     </tr>
                                                     <tr>
                                                         <td>
                                                             <select multiple name="listaInsumosDisponibles[]"  id="listaInsumosDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('listaInsumosDisponibles', 'Insumos');">
                                                               <?php foreach ($Insumos as $Insumo): ?>
                                                                 <option value="<?=$Insumo->id?>"> <?=$Insumo->Producto_o_Servicio ?> </option>
                                                               <?php endforeach ?>
                                                             </select>

                                                     </td>
                                                     <td>
                                                         <table>
                                                             <tbody><tr>
                                                                 <td>
                                                                     <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('listaInsumosDisponibles', 'Insumos');">
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
                                                                     <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('Insumos', 'listaInsumosDisponibles');">
                                                                 </td>
                                                             </tr>
                                                         </tbody></table>

                                                     </td>
                                                     <td>
                                                         <select multiple="multiple" name="Insumos[]"  id="Insumos" size="7" style="width: 100%;" onclick="agregaSeleccion('Insumos','listaInsumosDisponibles');">

                                                         </select>
                                                     </td>
                                                 </tr>
                                             </tbody></table>
                                         <p></p>
                                       </div>
                                   </div>

                                   <div class="col-md-6 col-sm-6 col-lg-4">
                                     <h2><label for="Puestos" >Accesos:</label></h2>
                                         <div>
                                               <p>
                                                   </p><table>
                                                       <tbody><tr>
                                                           <td>Accesos no elegidos</td>
                                                           <td></td>
                                                           <td>Accesos elegidos</td>
                                                       </tr>
                                                       <tr>
                                                           <td>
                                                               <select multiple name="listaPuestosDisponibles[]"  id="listaPuestosDisponibles" size="7" style="width: 100%;" onclick="agregaSeleccion('listaPuestosDisponibles', 'Puestos');">
                                                                 <?php foreach ($Puesto as $Puestos): ?>
                                                                   <option value="<?=$Puestos->id?>"> <?=$Puestos->nombrepuesto ?> </option>
                                                                 <?php endforeach ?>
                                                               </select>

                                                       </td>
                                                       <td>
                                                           <table>
                                                               <tbody><tr>
                                                                   <td>
                                                                       <input type="button" name="agregar todo" value=">>>" title="agregar todo" onclick="agregaTodo('listaPuestosDisponibles', 'Puestos');">
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
                                                                       <input type="button" name="quitar todas" value="<<<" title="Quitar todo" onclick="agregaTodo('Puestos', 'listaPuestosDisponibles');">
                                                                   </td>
                                                               </tr>
                                                           </tbody></table>

                                                       </td>
                                                       <td>
                                                           <select multiple="multiple" name="Puestos[]"  id="Puestos" size="7" style="width: 100%;" onclick="agregaSeleccion('Puestos','listaPuestosDisponibles');">

                                                           </select>
                                                       </td>
                                                   </tr>
                                               </tbody></table>
                                           <p></p>
                                         </div>
                                     </div>
                                   </div>
                                 </font>
                               </form>
                        </div>
                      </div>
                    </div>


                    <div id="tab-3" class="tab-pane">
                      <div class="container">
                        <form id="fileinfo3" method="post">
                        <div class="row">
                          <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="container" style="margin-top:40px;">
                            <h3>Takt Time</h3>
                            <div class="col-md-12">
                              <label for="" class="labeltask">Demanda mensual:</label>
                              <input type="number" name="demandamen" id="demandamen" >
                            </div>
                            <div class="col-md-12">
                              <label for="" class="labeltask">Días lab al mes:</label>
                              <input type="number" name="diasmes" id="diasmes" >
                            </div>
                            <div class="col-md-12">
                              <label for="" class="labeltask">Turnos al día:</label>
                              <input type="number" name="turnosdia" id="turnosdia" >
                            </div>
                            <div class="col-md-12">
                              <label for="" class="labeltask">Horas por turno:</label>
                              <input type="number" name="turnoshora" id="turnoshora" >
                            </div>
                            <div class="col-md-12">
                              <label for="" class="labeltask">Horas descanso:</label>
                              <input type="number" name="horades" id="horades" >
                            </div>
                            <div class="col-md-12">
                              <br>
                              <br>
                            </div>
                              <div class="col-md-12">
                                <label for="" class="labeltask">Tiempo Disp seg:</label>
                                <input readonly style="background: #58ACFA; color: white;" type="text" name="Tiemposeg" id="Tiemposeg" >
                              </div>
                              <div class="col-md-12">
                                <label for="" class="labeltask">Tiempo Disp min:</label>
                                <input readonly style="background: #58ACFA; color: white;" type="text" name="Tiempomin" id="Tiempomin" >
                              </div>
                              <div class="col-md-12">
                                <label for="" class="labeltask">Takt Time min:</label>
                                <input readonly style="background: #58ACFA; color: white;" type="text" name="Takt" id="Takt" >
                              </div>
                              <div class="col-md-12">
                                <label for="" class="labeltask">Takt Time seg:</label>
                                <input readonly style="background: #58ACFA; color: white;" type="text" name="taktseg" id="taktseg" >
                              </div>
                              <div class="col-md-12" style="float: right;">
                                <button onclick="calcular2()" type="button" name="calcular" style="background: #FF9966; border-radius: 5px;">Calcular</button>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-8 col-md-8 col-sm-8">
                            <div class="container" style="margin-top:40px;">
                                <div class="col-md-4 col-sm-4">
                                  <h3>Nivel de calidad</h3>

                                  <div class="col-md-12">
                                    <label for="" class="labeltask">Yield:</label>
                                    <input type="text" name="Yield" id="Yield" >
                                  </div>
                                  <div class="col-md-12">
                                    <label for="" class="labeltask">RTY:</label>
                                    <input type="text" name="RTY" id="RTY" >
                                  </div>
                                  <div class="col-md-12">
                                    <label for="" class="labeltask">DPMO's:</label>
                                    <input type="text" name="DPMO" id="DPMO" >
                                  </div>
                                  <div class="col-md-12">
                                    <label for="" class="labeltask">Nivel Sigma:</label>
                                    <input type="text" name="Sigma" id="Sigma" >
                                  </div>
                                </div>

                                <div class="col-md-4 col-sm-4">
                                  <h3>Productividad</h3>
                                  <div class="col-md-12">
                                    <label for="" class="labeltask">#/Persona:</label>
                                    <input type="text" name="Persona" id="Persona" >
                                  </div>
                                  <div class="col-md-12">
                                    <label for="" class="labeltask">#/Maquina:</label>
                                    <input type="text" name="Maquina" id="Maquina" >
                                  </div>
                                  <div class="col-md-12">
                                    <label for="" class="labeltask">$/#:</label>
                                    <input type="text" name="dinero" id="dinero" >
                                  </div>
                                </div>


                            </div>
                            <div class="container" style="margin-top:40px;">
                              <div class="col-md-4 col-sm-4">
                                <h3>Niveles de Servicio:</h3>
                                <div class="col-md-12">
                                  <label for="" class="labeltask">SLA1:</label>
                                  <input type="text" name="SLA1" id="SLA1" >
                                </div>
                                <div class="col-md-12">
                                  <label for="" class="labeltask">SLA2:</label>
                                  <input type="text" name="SLA2" id="SLA2" >
                                </div>
                                <div class="col-md-12">
                                  <label for="" class="labeltask">SLA3:</label>
                                  <input type="text" name="SLA3" id="SLA3" >
                                </div>
                              </div>

                              <div class="col-md-4 col-sm-4">
                                <h3>Capacidad del proceso</h3>
                                <div class="col-md-12">
                                  <label for="" class="labeltask">#/Mes:</label>
                                  <input type="text" name="Mes" id="Mes" >
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6">
      <center><button type="button" class="btn btn-lg btn-default" onclick=location="/procesos/visual" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-arrow-left"></i></button></center>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6">
      <center>
        <a class="btn btn-lg btn-success" role="button" id="actualizar" style="font-family: Arial;"><i class="glyphicon glyphicon-floppy-save"></i></a>
      </center>
    </div>
  </div>
</div>

<script type="text/javascript">


function calcular2(){
  var demandamen = document.getElementById("demandamen").value;
  var diasmes = document.getElementById("diasmes").value;
  var turnosdia = document.getElementById("turnosdia").value;
  var turnoshora = document.getElementById("turnoshora").value;
  var horades = document.getElementById("horades").value;

  var dispmin = (((turnoshora - horades)*turnosdia)*diasmes)*60;
  var dispseg = (((turnoshora - horades)*turnosdia)*diasmes)*3600;
  var taktseg = dispseg/demandamen;
  var taktmin = taktseg/diasmes;

  $("#Tiemposeg").val(dispmin);
  $("#Tiempomin").val(dispseg);
  $("#Takt").val(taktmin);
  $("#taktseg").val(taktseg);

}

//Funcion para el edit

function Editar(btn){
  var route = "/sipoc/"+btn+"/edit";

  $.get(route, function(res){
    $('#modaledit').modal('show');
    $("#eid").val(res.id);
    $("#eS").val(res.S);
    $("#eI").val(res.I);
    $("#eP").val(res.P);
    $("#eO").val(res.O);
    $("#eC").val(res.C);
  });
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
        success: function(data){
          var route = "/procesos/store2/"+data;
          var fd = new FormData(document.getElementById("fileinfo2"));

          $.ajax({
            url: route,
            headers: {'X-CSRF-Token': $('meta[name="_token"]').attr('content')},
            type: 'post',
            data: fd,
            processData: false,  // tell jQuery not to process the data
            contentType: false,
            success: function(){

            }
          });

          var route = "/procesos/store3/"+data;
          var fd = new FormData(document.getElementById("fileinfo3"));

          $.ajax({
            url: route,
            headers: {'X-CSRF-Token': $('meta[name="_token"]').attr('content')},
            type: 'post',
            data: fd,
            processData: false,  // tell jQuery not to process the data
            contentType: false,
            success: function(){
              location.href = "/procesos/visual";
            }
          });

        }
      });

    });


  $("#actualizarsipoc").click(function(){
    var value = $("#eid").val();
    var route = "/sipoc/edit/"+value+"";
    var token = $("#token").val();
    var fd = new FormData(document.getElementById("fileinfosipoc"));

    $.ajax({
      url: route,
      headers: {'X-CSRF_TOKEN': token},
      type: 'post',
      data: fd,
      processData: false,  // tell jQuery not to process the data
      contentType: false,
      success: function(){
        alert("Cambios guardados correctamente");
        location.reload();
      }
    });
  });

});

function destroysipoc(){
  var value = $("#eid").val();
  if(confirm('Estas seguro de querer borrar el registro '+value+'?')){
    var route = "/sipoc/destroy/"+value+"";


    $.ajax({
        url: route,
        headers: {'X-CSRF-Token': $('meta[name="_token"]').attr('content')},
        type: 'delete',
        success: function(result) {
          alert("Cambios guardados correctamente");
          location.reload();
        }
    });

  }else {
    console.log('no');
  }
}
</script>

@Stop
