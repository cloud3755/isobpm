@extends('layouts.principal2')

@section('content')

<div id="contenedor">
	<div id="cajon1"><img src="/img/perfil.png"/></div>
	<div id="cajontitulo"><h2>Reporte de Accion Correctiva</h2></div>
	<div id="cajon3"><img src="/img/perfil.png"/></div>
</div>

<div class="titulo">
	<div id="cajon2">Esta seccion debe ser completada por la persona que detecto el producto</div>
</div>

<div class="row" id="primero">
	<div class="col-md-3" id="fecha"><br>Fecha</div>
	<div class="col-md-3" id="datofecha">valor</div>
	<div class="col-md-3" id="creador"><br>Creado por</div>
	<div class="col-md-3">valor</div>
</div>

<div class="row" id="segundo">
		<div class="col-md-3" id="producto"><br>producto/servicio afectado</div>
		<div class="col-md-3" id="datoproducto">valor</div>
		<div class="col-md-3" id="proceso"><br>Proceso</div>
		<div class="col-md-3">valor</div>
</div>

<div class="titulo" id="titulosegundo">
	<div id="cajon2">Esta seccion debe ser completada por la persona que detecto el producto</div>
</div>

<div class="row">
		<div class="col-md-12">
				<textarea class="form-control" id = "area1" rows="9" placeholder="" name="descripcion" id="descripcion">
				</textarea>
		</div>
	</div>

	<div class="titulo" id="titulosegundo">
	<div id="cajon2">Esta seccion debe ser completada por la persona que detecto el producto</div>
</div>

<div class="row" id="cuarta">
		<div class="col-md-3" id="responsable"><br>Nombre del responsable</div>
		<div class="col-md-3" id="datoresponsable"><br>valor</div>
</div>

<div class="titulo" id="titulotercero">
	<div id="cajontercero">Analisis de causa raiz</div>
</div>


@stop
