@extends('layouts.principal2')

@section('content')

<br>
<form id="fileinfo" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
			<input type="hidden" name="tipo" value="lean">
			<div class="row" id="descripcion">
				<div class="col-md-12" id="titulo"><center>PROYECTO LEAN</center></div>
			</div>

			<div class="row" id="primero">
				<div class="col-md-3" id="fecha">Proyecto</div>
				<div class="col-md-9" id="datofecha">
			    <input class="form-control" type="text" name="proyecto" placeholder="Nombre de proyecto">
			  </div>
			</div>

			<div class="row" id="primero">
				<div class="col-md-3" id="creador">Impacto</div>
				<div class="col-md-3">

					<select class="form-control input-lg" name="impacto" id="proresponsableob">
					 <?php foreach ($impacto as $impactos): ?>
						 <option value="<?=$impactos['id']?>"> <?=$impactos['nombre']?> </option>
					 <?php endforeach ?>
				 </select>

			  </div>
			  <div class="col-md-3" id="fecha">Responsable</div>
				<div class="col-md-3" id="datofecha">

					<select class="form-control input-lg" name="responsable_id" id="proresponsableob">
					 <?php foreach ($User as $Users): ?>
						 <option value="<?=$Users['id']?>"> <?=$Users['nombre']?> </option>
					 <?php endforeach ?>
				 </select>

			  </div>
			</div>

			<div class="row" id="segundo">
				<div class="col-md-2" id="creador">Beneficio real</div>
				<div class="col-md-3">
			    <textarea class="form-control" name="beneficioreal" rows="1" cols="40" placeholder="Beneficio real"></textarea>
			  </div>
			  <div class="col-md-3" id="creador">Beneficio plan</div>
			  	<div class="col-md-3">
			      <textarea class="form-control" name="beneficioplan" rows="1" cols="40" placeholder="Beneficio plan"></textarea>
			    </div>
			</div>

			<div class="row" id="segundo">
				<div class="col-md-3" id="fecha">Fecha</div>
				<div class="col-md-3">
			    <input class="form-control" name="fechaactual" type="date" readonly value="<?php echo date("Y-m-d");?>" size="10"/>
			  </div>
			  <div class="col-md-3" id="fecha">Estatus</div>
				<div class="col-md-3" id="datofecha">

					<select class="form-control input-lg" name="estatus_id">
						<?php foreach ($estatu as $estatus): ?>
							<option value="<?=$estatus['id']?>"> <?=$estatus['nombre']?> </option>
						<?php endforeach ?>
					</select>

			  </div>
			</div>

			<div class="form-group form-group-lg">
				<h2><label for="Equipo" class="control-label col-md-12">Equipo:</label></h2>
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
																	<?php foreach ($User as $Users): ?>
										 							 <option value="<?=$Users['id']?>"> <?=$Users['nombre']?> </option>
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

			<div class="row"  id="descripcion">

				<div class="col-md-12" id="creador"><center>Descripcion</center></div>
			</div>
			<br>
			<div class="row">
					<div class="col-sm-3 col-md-11 ">
							<textarea class="form-control" rows="9" name="descripcion"></textarea>
					</div>
			</div>
			<br>
			<center><a class="btn btnprocesoform btn-md active" role="button" id="actualizar" style="font-family: Arial;">Alta de proyecto</a></center>
	</form>
	<br>
	<center><button type="submit" onclick=location="/Promejoras" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Regresar</button></center>

<script type="text/javascript">

$(document).ready(function(){

  $("#actualizar").click(function(){
    var route = "https://www.isobpm.com/lean/storelean";
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
        window.location.href = "/Promejoras";
      }
    });
  });

});

</script>
@stop
