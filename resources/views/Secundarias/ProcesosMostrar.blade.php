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

<br><br><br><br>
<?php foreach ($proceso as $procesos): ?>
<?php endforeach ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel blank-panel">
            <div class="panel-heading">
                <div class="panel-options">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a data-toggle="tab" href="#tab-1">General</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2">An&aacute;lisis</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-3">Informaci&oacute;n</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-4">Mapa de Proceso</a></li>
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
                             <input type="hidden" id="id" value="<?=$procesos['id']?>">
                              <div class="container">
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                  <h3><label for="Usuario" class="control-label" >Tipo de Proceso:</label></h3>
                                  <select class="form-control" name="tipo" id="protipoproc">
                                    <?php foreach ($tipoproceso as $tipoproc): ?>
                                      @if($procesos['tipo'] == $tipoproc['nombreproceso'] )
                                        <option value="<?=$tipoproc['nombreproceso']?>" selected="true"> <?=$tipoproc['nombreproceso']?> </option>
                                      @else
                                        <option value="<?=$tipoproc['nombreproceso']?>"> <?=$tipoproc['nombreproceso']?> </option>
                                      @endif
                                    <?php endforeach ?>
                                  </select>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6">
                                  <h3><label for="Usuario" class="control-label">Nombre Proceso:</label></h3>
                                  <input class="form-control" value="<?=$procesos['proceso']?>" id="probproces" type="Text" placeholder="Nombre del proceso" name="proceso" maxlength="50">
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6">
                                  <h3><label for="tipo" class="control-label" >Responsable:</label></h3>
                                   <select class="form-control" name="usuario_responsable_id" id="proresponsableob">
                                     <?php foreach ($User as $Users1): ?>
                                       @if($procesosrelacion->usuario_responsable_id == $Users1['id'] )
                                        <option value="<?=$Users1['id']?>" selected="true"> <?=$Users1['nombre']?> </option>
                                       @else
                                        <option value="<?=$Users1['id']?>"> <?=$Users1['nombre']?> </option>
                                       @endif
                                    <?php endforeach ?>
                                  </select>
                                </div>

                                <div class="col-lg-8 col-md-8 col-sm-6">
                                  <h3><label for="Usuario" class="control-label">Decripcion:</label></h3>
                                  <textarea class="form-control" id = "prodescripcionproces" rows="3" placeholder="Descripcion del proceso" name="descripcion" maxlength="255"><?=$procesos['descripcion']?></textarea>
                                </div>

                                  <div class="col-lg-4 col-md-4 col-sm-4">
                                      <h3><label for="Usuario" class="control-label" >Numero de revision:</label></h3>
                                      <input class="form-control" value="<?=$procesos['rev']?>" id="protipoOb" type="Text" placeholder="Numero Revision" name="rev" maxlength="50">
                                  </div>

                                  <div class="col-lg-12 col-md-12 col-sm-8">
                                      <h3><label for="Usuario" class="control-label">Detalle de Revision:</label></h3>
                                      <textarea class="form-control" id = "prodescripcionproce" rows="3" placeholder="Detalle de rev" name="detalle_de_rev" maxlength="255"><?=$procesos['detalle_de_rev']?></textarea>
                                  </div>

                                  <div class="col-lg-3 col-md-3 col-sm-4">
                                      <h3><label for="Usuario" class="control-label">Tipo de archivo:</label></h3>
                                      <form>
                                        @if($procesos['tipoarchivo'] == '1')
                                          <input type="radio" name="tipoarchivo" value="1" checked> HTML<br>
                                          <input type="radio" name="tipoarchivo" value="2"> Otro<br>
                                        @else
                                          <input type="radio" name="tipoarchivo" value="1"> HTML<br>
                                          <input type="radio" name="tipoarchivo" value="2" checked> Otro<br>
                                        @endif
                                      </form>
                                  </div>

                                  <div class="col-lg-8 col-md-8 col-sm-8">
                                      <h3><label for="Usuario" class="control-label">Archivo HTML:</label></h3>
                                        <input class="form-control input-lg" id="probproces" type="Text" placeholder="Sin archivo adjunto" name="filetext" disabled="disabled" value ="<?=$procesos['archivo_html']?>">
                                        <input class="form-control input-lg" id="probproces" type="file" accept=".zip" placeholder="<?=$procesos['archivo_html']?>" name="file" >
                                        <progress id="progress" value="0"></progress>
                                  </div>

                                  <div class="col-lg-11 col-md-11 col-sm-11">

                                                <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
                                                    <thead style='background-color: #868889; color:#FFF'>
                                                        <tr>
                                                            <th><div class="th-inner sortable both">S</div></th>
                                                            <th><div class="th-inner sortable both">I</div></th>
                                                            <th><div class="th-inner sortable both">P</div></th>
                                                            <th><div class="th-inner sortable both">O</div></th>
                                                            <th><div class="th-inner sortable both">C</div></th>
                                                        </tr>
                                                    </thead>
                                                    <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                                                    <tbody id = "myTable">
                                                      <?php foreach ($sipoc as $sipocs): ?>
                                                          <tr onclick="Editar(<?=$sipocs->id?>);" >
                                                              <td><?=$sipocs->S?></td>
                                                              <td><?=$sipocs->I?></td>
                                                              <td><?=$sipocs->P?></td>
                                                              <td><?=$sipocs->O?></td>
                                                              <td><?=$sipocs->C?></td>

                                                          </tr>
                                                      <?php endforeach ?>
                                                    </tbody>
                                                </table>

                                  </div>

                                  <div class="col-lg-1 col-md-1 col-sm-1">
                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-floppy-save"></i></button>
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
                              <div class="col-md-6 col-sm-6 col-lg-4">
                                <h2><label for="Usuario" >Lista de distribucion:</label></h2>
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
                                                       <?php foreach ($Activosrelacion as $Activosrelaciones): ?>
                                                         <option value="<?=$Activosrelaciones->id?>" selected="true"> <?=$Activosrelaciones->nombre ?> </option>
                                                       <?php endforeach ?>
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
                                                         <?php foreach ($Documentosrelacion as $Documentosrelaciones): ?>
                                                           <option value="<?=$Documentosrelaciones->id?>" selected="true"> <?=$Documentosrelaciones->nombre ?> </option>
                                                         <?php endforeach ?>
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
                                                           <?php foreach ($Insumosrelacion as $Insumosrelaciones): ?>
                                                             <option value="<?=$Insumosrelaciones->id?>" selected="true"> <?=$Insumosrelaciones->Producto_o_Servicio ?> </option>
                                                           <?php endforeach ?>
                                                         </select>
                                                     </td>
                                                 </tr>
                                             </tbody></table>
                                         <p></p>
                                       </div>
                                   </div>

                                   <div class="col-md-6 col-sm-6 col-lg-4">
                                     <h2><label for="Puestos" >Puestos:</label></h2>
                                         <div>
                                               <p>
                                                   </p><table>
                                                       <tbody><tr>
                                                           <td>Puestos no elegidos</td>
                                                           <td></td>
                                                           <td>Puestos elegidos</td>
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
                                                             <?php foreach ($Puestorelacion as $Puestorelaciones): ?>
                                                               <option value="<?=$Puestorelaciones->id?>" selected="true"> <?=$Puestorelaciones->nombrepuesto ?> </option>
                                                             <?php endforeach ?>
                                                           </select>
                                                       </td>
                                                   </tr>
                                               </tbody></table>
                                           <p></p>
                                         </div>
                                     </div>

                                 <div class="col-md-6 col-sm-6 col-lg-4">
                                   <a  href="/abcriesgos/create">
                                     <img class="imagesOfficeBar" src="/img/navBar office style images/Riesgos.jpg"/>
                                     <br>
                                     Riesgos</a>
                                </div>
                                 <div class="col-md-6 col-sm-6 col-lg-4">
                                   <a  href="/abcoportunidades/create">
                                     <img class="imagesOfficeBar" src="/img/navBar office style images/oportunidades.png"/>
                                     <br>
                                     Oportunidades</a>
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
                              <input type="number" name="demandamen" id="demandamen" value="<?=$procesos['demandamen']?>">
                            </div>
                            <div class="col-md-12">
                              <label for="" class="labeltask">Días lab al mes:</label>
                              <input type="number" name="diasmes" id="diasmes" value="<?=$procesos['diasmes']?>">
                            </div>
                            <div class="col-md-12">
                              <label for="" class="labeltask">Turnos al día:</label>
                              <input type="number" name="turnosdia" id="turnosdia" value="<?=$procesos['turnosdia']?>">
                            </div>
                            <div class="col-md-12">
                              <label for="" class="labeltask">Horas por turno:</label>
                              <input type="number" name="turnoshora" id="turnoshora" value="<?=$procesos['turnoshora']?>">
                            </div>
                            <div class="col-md-12">
                              <label for="" class="labeltask">Horas descanso:</label>
                              <input type="number" name="horades" id="horades" value="<?=$procesos['horades']?>">
                            </div>
                            <div class="col-md-12">
                              <br>
                              <br>
                            </div>
                              <div class="col-md-12">
                                <label for="" class="labeltask">Tiempo Disp seg:</label>
                                <input readonly style="background: #58ACFA; color: white;" type="text" name="Tiemposeg" id="Tiemposeg" value="<?=$procesos['Tiemposeg']?>">
                              </div>
                              <div class="col-md-12">
                                <label for="" class="labeltask">Tiempo Disp min:</label>
                                <input style="background: #58ACFA; color: white;" type="text" name="Tiempomin" id="Tiempomin" value="<?=$procesos['Tiempomin']?>">
                              </div>
                              <div class="col-md-12">
                                <label for="" class="labeltask">Takt Time min:</label>
                                <input style="background: #58ACFA; color: white;" type="text" name="Takt" id="Takt" value="<?=$procesos['Takt']?>">
                              </div>
                              <div class="col-md-12">
                                <label for="" class="labeltask">Takt Time seg:</label>
                                <input style="background: #58ACFA; color: white;" type="text" name="taktseg" id="taktseg" value="<?=$procesos['taktseg']?>">
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
                                    <input type="text" name="Yield" id="Yield" value="<?=$procesos['Yield']?>">
                                  </div>
                                  <div class="col-md-12">
                                    <label for="" class="labeltask">RTY:</label>
                                    <input type="text" name="RTY" id="RTY" value="<?=$procesos['RTY']?>">
                                  </div>
                                  <div class="col-md-12">
                                    <label for="" class="labeltask">DPMO's:</label>
                                    <input type="text" name="DPMO" id="DPMO" value="<?=$procesos['DPMO']?>">
                                  </div>
                                  <div class="col-md-12">
                                    <label for="" class="labeltask">Nivel Sigma:</label>
                                    <input type="text" name="Sigma" id="Sigma" value="<?=$procesos['Sigma']?>">
                                  </div>
                                </div>

                                <div class="col-md-4 col-sm-4">
                                  <h3>Productividad</h3>
                                  <div class="col-md-12">
                                    <label for="" class="labeltask">#/Persona:</label>
                                    <input type="text" name="Persona" id="Persona" value="<?=$procesos['Persona']?>">
                                  </div>
                                  <div class="col-md-12">
                                    <label for="" class="labeltask">#/Maquina:</label>
                                    <input type="text" name="Maquina" id="Maquina" value="<?=$procesos['Maquina']?>">
                                  </div>
                                  <div class="col-md-12">
                                    <label for="" class="labeltask">$/#:</label>
                                    <input type="text" name="dinero" id="dinero" value="<?=$procesos['dinero']?>">
                                  </div>
                                </div>


                            </div>
                            <div class="container" style="margin-top:40px;">
                              <div class="col-md-4 col-sm-4">
                                <h3>Niveles de Servicio:</h3>
                                <div class="col-md-12">
                                  <label for="" class="labeltask">SLA1:</label>
                                  <input type="text" name="SLA1" id="SLA1" value="<?=$procesos['SLA1']?>">
                                </div>
                                <div class="col-md-12">
                                  <label for="" class="labeltask">SLA2:</label>
                                  <input type="text" name="SLA2" id="SLA2" value="<?=$procesos['SLA2']?>">
                                </div>
                                <div class="col-md-12">
                                  <label for="" class="labeltask">SLA3:</label>
                                  <input type="text" name="SLA3" id="SLA3" value="<?=$procesos['SLA3']?>">
                                </div>
                              </div>

                              <div class="col-md-4 col-sm-4">
                                <h3>Capacidad del proceso</h3>
                                <div class="col-md-12">
                                  <label for="" class="labeltask">#/Mes:</label>
                                  <input type="text" name="Mes" id="Mes" value="<?=$procesos['Mes']?>">
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                   </div>

                    <div id="tab-4" class="tab-pane">
                      <div class="row">
                        @if(!empty($rutacompleta))
                          @if(!empty($rutaalindex2))
                            <div class="embed-container" style="maegin: 0 auto;">
                              <iframe  id="iframeinterno" width="100%" height="100%" src="{{$rutaalindex}}" frameborder="0" allowfullscreen></iframe>
                            </div>
                          @else
                          <center>
                          <a href="/storage/<?=$archivoabrir?>" downloadFile="<?=$archivoabrir?>" target="_blank" style='color:#FFF'>
                            <button type="button" class="btn btn-lg btn-warning">
                                 <i class="glyphicon glyphicon-cloud-download"></i>
                            </button>
                          </a>
                          </center>
                          @endif
                        @else

                          <div>
                            <center>
                              <label for="">Sin archivo</label>
                            </center>
                          </div>
                        @endif
                      </div>
                   </div>

                </div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-sm-4 col-md-4 col-lg-4">
      <center><button type="button" class="btn btn-lg btn-default" onclick=location="/procesos/visual" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-arrow-left"></i></button></center>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
      <center><a class="btn btn-lg btn-primary" role="button" id="actualizar" style="font-family: Arial;"><i class="glyphicon glyphicon-edit"></i></a></center>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
      <form class="" action="/procesos/delete/<?=$procesos['id']?>" method="post">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
        <center><button type="submit" class="btn btn-lg btn-danger" id="btndelete_<?=$procesos['id']?>" style="font-family: Arial;" dataid="<?=$procesos['id']?>" onclick="
          return confirm('Estas seguro de eliminar el proceso <?=$procesos['proceso']?>?')"><i class="fa fa-trash"></i></button></center>
      </form>
    </div>
  </div>

  <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                  <h3 class="modal-title">ALTA DE ACTIVO</h3>
              </div>
              <div class="modal-body">
                <form class="" action="/sipoc/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" id="porceso_id" name="porceso_id" value="<?=$procesos['id']?>">
                  <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h2><label for="Usuario" class="control-label">S:</label></h2>
                        <input class="form-control input-lg" id="S" type="Text" placeholder="S" name="S" required>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <h2><label for="Usuario" class="control-label">I:</label></h2>
                        <input class="form-control input-lg" id="I" type="Text" placeholder="I" name="I" required>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <h2><label for="Usuario" class="control-label">P:</label></h2>
                        <input class="form-control input-lg" id="P" type="Text" placeholder="P" name="P" required>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <h2><label for="Usuario" class="control-label">O:</label></h2>
                        <input class="form-control input-lg" id="O" type="Text" placeholder="O" name="O" required>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <h2><label for="Usuario" class="control-label">C:</label></h2>
                        <input class="form-control input-lg" id="C" type="Text" placeholder="C" name="C" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnobjetivo"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                  </div>
                </form>
              </div>
          </div>
      </div>
    </div>


  <div class="modal inmodal" id="modaledit" name="modaledit" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                  <h3 class="modal-title">ACTUALIZAR SIPOC</h3>
              </div>
              <div class="modal-body">
                <form id="fileinfosipoc" method="post">

                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                <input type="hidden" id="eid">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                      <h2><label for="Usuario" class="control-label">S:</label></h2>
                      <input class="form-control input-lg" id="eS" type="Text" placeholder="S" name="eS" required>
                  </div>
                  <div class="col-md-12 col-sm-12">
                      <h2><label for="Usuario" class="control-label">I:</label></h2>
                      <input class="form-control input-lg" id="eI" type="Text" placeholder="I" name="eI" required>
                  </div>
                  <div class="col-md-12 col-sm-12">
                      <h2><label for="Usuario" class="control-label">P:</label></h2>
                      <input class="form-control input-lg" id="eP" type="Text" placeholder="P" name="eP" required>
                  </div>
                  <div class="col-md-12 col-sm-12">
                      <h2><label for="Usuario" class="control-label">O:</label></h2>
                      <input class="form-control input-lg" id="eO" type="Text" placeholder="O" name="eO" required>
                  </div>
                  <div class="col-md-12 col-sm-12">
                      <h2><label for="Usuario" class="control-label">C:</label></h2>
                      <input class="form-control input-lg" id="eC" type="Text" placeholder="C" name="eC" required>
                  </div>
                </div>
              </form>
                <div class="modal-footer">
                  <a class="btn btn-primary" id="actualizarsipoc" style="font-family: Arial;"><i class="glyphicon glyphicon-edit"></i><br>Editar</a>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                  <a class="btn btn-danger" id="btndeletesipoc" style="font-family: Arial;" onclick="destroysipoc()"><i class="fa fa-trash"></i><br>Eliminar</a>
                </div>
            </div>
        </div>
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
    var value = $("#id").val();
    var route = "/procesos/edit/"+value+"";
    var fd = new FormData(document.getElementById("fileinfo"));
    var progressBar = document.getElementById("progress");

    $.ajax({
      url: route,
      headers: {'X-CSRF-Token': $('meta[name="_token"]').attr('content')},
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

      }
    });

    var route = "/procesos/edit2/"+value+"";
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

    var route = "/procesos/edit3/"+value+"";
    var fd = new FormData(document.getElementById("fileinfo3"));

    $.ajax({
      url: route,
      headers: {'X-CSRF-Token': $('meta[name="_token"]').attr('content')},
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
