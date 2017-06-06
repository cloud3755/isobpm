@extends('layouts.principal2')

@section('content')

<br>
<form action="/lean/storelean" method="post">
			{{ csrf_field() }}
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
			    <input class="form-control" name="fechaactual" type="text" readonly value="<?php echo date("m/d/Y"); ?>" size="10"/>
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

			<div class="form-group form-group-lg" id="lista_de_distribucion">
				<h2><label for="Equipo" class="control-label col-md-12">Equipo:</label></h2>
				<div class="col-md-6">

					<select class="form-control multi-select"  multiple="multiple" name="lista_de_distribucion[]" id="lista_de_distribucion" width="100%" multiple data-actions-box="true" >
						 <?php foreach ($User as $Users): ?>
							 <option value="<?=$Users['id']?>"> <?=$Users['usuario']?> </option>
						 <?php endforeach ?>
					 </select>

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
			<center><button type="submit" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Alta de proyecto</button></center>
	</form>
	<br>
	<center><button type="submit" onclick=location="/Promejoras" class="btnobjetivo" id="btnaltaindicador" style="font-family: Arial;">Regresar</button></center>
@stop
