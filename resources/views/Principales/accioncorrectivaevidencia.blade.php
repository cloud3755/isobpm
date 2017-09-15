@extends('layouts.principal2')

@section('content')

<div id="contenedor">
	<div id="cajon1"><img src="/img/perfil.png"/></div>
	<div id="cajontitulo"><h2>Reporte de Accion Correctiva
	</h2></div>
	<div id="cajon3"><img src="/img/perfil.png"/></div>
</div>

<div class="titulo">
	<div id="cajon2">Esta seccion debe ser completada por la persona que detecto el producto </div>
</div>

<div class="row" id="primero">
	<div class="col-md-3" id="fecha">Fecha</div>
	<div class="col-md-3" id="datofecha">
		<?php foreach ($accion as $acciones): ?>
			<?=$acciones['fechaalta']?>
		<?php endforeach ?></div>
	<div class="col-md-3" id="creador">Creado por</div>
	<div class="col-md-3">
			<?=$accionrelacion->creador?>
	</div>
	</div>
</div>

<div class="row" id="segundo">
		<div class="col-md-3" id="creador">producto/servicio afectado</div>
		<div class="col-md-3" id="datoproducto">
			<?=$accionrelacion->nombreproducto?>
		</div>
		<div class="col-md-3" id="creador">Proceso</div>
		<div class="col-md-3">
			<?=$accionrelacion->nombrep?>
		</div>
</div>

<div class="titulo" id="titulosegundo">
	<div id="cajon2">Esta seccion debe ser completada por la persona que detecto el producto</div>
</div>

<div class="row">
		<div class="col-md-12">
				<textarea class="form-control" id = "area1" rows="9" placeholder="" name="descripcion" readonly="true" style="background-color: #87CEEB;">
					<?php foreach ($accion as $acciones): ?>
						<?=$acciones['descripcion']?>
					<?php endforeach ?>
				</textarea>
		</div>
	</div>

	<div class="titulo" id="titulosegundo">
	<div id="cajon2">Esta seccion debe ser completada por la persona que detecto el producto</div>
</div>

<div class="row" id="cuarta">
		<div class="col-md-3" id="creador">Nombre del responsable</div>
		<div class="col-md-3" id="datoresponsable"><?=$accionrelacion->nombreresponsable?><br>
		</div>
</div>

<div class="titulo" id="titulotercero">
	<div id="cajontercero">Analisis de causa raiz</div>
</div>

<div class="row">
		<div class="col-md-12">
			<?php
				//$var="\n";
			?>
				<textarea class="form-control" rows="9" name="descripcion" id="textareaanalisis" placeholder="prueb" readonly="true" style="background-color: #87CEEB;">
					<?php foreach ($accion as $acciones): ?>

						<?php echo "*" ?><?=$acciones['porque1']?>
					<?php endforeach ?>
				</textarea>
		</div>
	</div>
	<br>
	<div class="row">
      <div class="col-lg-12">
          <div class="panel panel-red">
              <div class="panel-heading">
                  Subir Evidencia
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-floppy-save"></i></button>
              </div>
							<table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
								<thead style='background-color: #868889; color:#FFF'>
									<tr>
										<th><div class="th-inner sortable both">Accion correctiva</div></th>
										<th><div class="th-inner sortable both">Responsable</div></th>
										<th><div class="th-inner sortable both">Accion</div></th>
										<th><div class="th-inner sortable both">descripcion</div></th>
										<th><div class="th-inner sortable both">Archivo 1</div></th>
										<th><div class="th-inner sortable both">Archivo 2</div></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($evidencia as $evidencias): ?>
									<tr>
										<td><?=$evidencias['id_accioncorrectiva']?></td>
										<td><?=$evidencias['id_responsable']?></td>
										<td><?=$evidencias['accionarealizar']?></td>
										<td><?=$evidencias['descripcion']?></td>
										<td><?=$evidencias['archivo_html1']?>
											<a href="/storage/<?=$evidencias['nombreunicoarchivo1']?>" downloadFile="<?=$evidencias['nombreunicoarchivo1']?>" style='color:#FFF'>
											 	<button type="button" class="btn btn-warning">
														 <span class="glyphicon glyphicon-cloud-download"></span>
    										</button>
											</a>
										</td>
									<td><?=$evidencias['archivo_html2']?>
										<a href="/storage/<?=$evidencias['nombreunicoarchivo2']?>" downloadFile="<?=$evidencias['nombreunicoarchivo2']?>" style='color:#FFF'>
											<button type="button" class="btn btn-warning">
													 <span class="glyphicon glyphicon-cloud-download"></span>
											</button>
										</a>
									</td>
								</tr>
									<?php endforeach ?>
								</tbody>
							</table>
  					</br>
           </br>
         </div>
      </div>
    </div>

		<form method="POST" action="/guardar/evidencia" accept-charset="UTF-8" enctype="multipart/form-data">
	    <input type="hidden" name="_token" value="{{ csrf_token() }}">
			<?php foreach ($accion as $acciones): ?>
			<input type="hidden" name="id_accioncorrectiva" value="<?=$acciones['id']?>">
			<?php endforeach ?>
			<input type="hidden" name="creador_id" value="{{Auth::user()->id}}">
	         <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog">
	             <div class="modal-dialog" role="form">
	                 <div class="modal-content">
	                     <div class="modal-header">

	                         <h2 class="modal-title">Alta de evidencia</h2>
	                     </div>
	                     <div class="modal-body">
	             <div class="container">

								 <div class="form-group form-group-lg">
										 <h2>
										 <label for="Usuario" class="control-label col-md-12">Accion a realizar</label>
										 </h2>
										 <div class="col-md-6">
												 <input class="form-control input-lg" id="accionarealizar" type="Text" placeholder="accion a realizar" name="accionarealizar" maxlength="50">
										 </div>
								 </div>

								 <div class="form-group form-group-lg">
                     <h2><label for="Usuario" class="control-label col-md-12">Decripcion:</label></h2>
                     <div class="col-md-6">
                         <textarea class="form-control input-lg" id = "descripcion" rows="3" placeholder="Descripcion de la accion" name="descripcion" maxlength="255"></textarea>
                     </div>
                 </div>

								 <div class="form-group form-group-lg">
										 <h2><label for="Usuario" class="control-label col-md-12">Archivo de evidencia:</label></h2>
										 <div class="col-md-6">
												 <input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo1" required="">
										 </div>
								 </div>

								 <div class="form-group form-group-lg">
 										<h2><label for="Usuario" class="control-label col-md-12">Archivo de evidencia 2:</label></h2>
 										<div class="col-md-6">
 												<input class="file" id="file-1" type="file" placeholder="Archivo" name="archivo2">
 										</div>
 								</div>

					 		 </div>
					 			            <div class="modal-footer">
															<button type="submit" value="file" class="btn btn-success" id="btnaltaproceso" style="font-family: Arial;"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</button>
					 			              <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
					 			            </div>
					 			         </div>
					 			      </div>
					 			  </div>
				     </div>
				</form>

@stop
