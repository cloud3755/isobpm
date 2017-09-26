@extends('layouts.principal2')

@section('content')

<!-- Toastr -->
<script src="/js/toastr.min.js"></script>
<link href="/css/toastr.min.css" rel="stylesheet">
<script src="/js/descriptorpuesto.js"></script>

</br>

@if(Session::has('flash_message'))
<script>
alert ('{{Session::get('flash_message')}}')
</script>
@endif



  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#descriptorDePuesto"><strong>Descriptor de puesto</strong></a></li>
    <li><a data-toggle="tab" href="#perfilDePuesto"><strong>Perfil de puesto</strong></a></li>
    <li><a data-toggle="tab" href="#indicadoresDeDesempeño"><strong>Indicadores de desempeño</strong></a></li></strong>
  </ul>

  <div class="tab-content">
    <div id="descriptorDePuesto" class="tab-pane fade in active">
      <form id="descripform" class="" action="" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="puestoid" id="puestoid" value="<?= $descriptorpuesto->id_puesto ?>">
        <div class="row">
          <div class="col-lg-12">
           <h3>Descriptor de puesto</h3>
         </div>
        </div>
          <br>
        <div class="row">
          <div class="form-group">
            <label class="control-label col-sm-2" for="puestomostrar1">Puesto:</label>
            <div class="col-sm-6">
             <input type="puestomostrar" class="form-control" id="puestomostrar1" name="puestomostrar1" placeholder="puestomostrar" value="<?=  $descriptorpuesto->nombrepuesto ?>" disabled="disabled" >
            </div>
              <input id="btnDescriptor" type="button" class="btnobjetivo" value="Guardar cambios en descriptor" onclick="guardadescriptor()"/>
              <button type="button" class="btnobjetivo" onclick=location="/personal" data-dismiss="modal" id="btnCloseUpload">Regresar</button>
          </div>
        </div>
          <br>
      <div class="row">
          <div class="col-sm-3">
            <label class="control-label" for="area">Area:</label>
            <select class="form-control" name="area" id="area">
                <option value="<?= $descriptorpuesto->id_area ?>" selected="selected" ><?= $descriptorpuesto->areanombre ?></option>
                <?php foreach ($areas as $area): ?>
                <option value="<?=$area->id?>"><?=$area->nombre?></option>
              <?php endforeach ?>

          </select>
        </div>
        <div class="col-sm-3">
             <label class="control-label" for="personalACargo">Personal a cargo:</label>
             <input type="puestomostrar" class="form-control" id="personalACargo" name="personalACargo" placeholder="Personal a cargo" value="<?=  $descriptorpuesto->personalacargo ?>">
        </div>
        <div class="col-sm-3">
            <label class="control-label" for="reportaA">Reporta a:</label>
            <input type="puestomostrar" class="form-control" id="reportaA" name="reportaA" placeholder="Reporta a" value="<?=  $descriptorpuesto->reportaa ?>" disabled="disabled">
        </div>
        <div class="col-sm-3">
           <label class="control-label" for="monto">Monto de valores asignados:</label>
           <input type="puestomostrar" class="form-control" id="monto" name="monto" placeholder="Monto asignado" value="<?=  $descriptorpuesto->montovalores ?>">
        </div>
      </div>
       <br>
      <div class="row">
        <div class="form-group col-sm-12">
          <label class="control-label col-sm-12" for="misionPuesto">Mision del puesto:</label>
            <textarea class="form-control input-lg" id = "misionPuesto" rows="3" placeholder="Mision del puesto" name="misionPuesto" maxlength="255"><?=  $descriptorpuesto->mision ?></textarea>
        </div>
      </div>
      <br>
        <div class="row">
            <div class="col-sm-4">
            <label class="control-label col-sm-12" for="funcionPuesto">Funciones del puesto:</label>
            <textarea class="form-control input-lg" id = "funcionPuesto" rows="3" placeholder="Funciones del puesto" name="funcionPuesto" maxlength="255"><?=  $descriptorpuesto->funciones ?></textarea>
            </div>
            <div class="col-sm-4">
            <label class="control-label col-sm-12" for="responsabilidadPuesto">Responsabilidades del puesto:</label>
            <textarea class="form-control input-lg" id = "responsabilidadPuesto" rows="3" placeholder="Responsabilidades del puesto" name="responsabilidadPuesto" maxlength="255"><?=  $descriptorpuesto->responsabilidades ?></textarea>
            </div>
            <div class="col-sm-4">
            <label class="control-label col-sm-12" for="autoridadesPuesto">Autoridades del puesto:</label>
            <textarea class="form-control input-lg" id = "autoridadesPuesto" rows="3" placeholder="Autoridades del puesto" name="autoridadesPuesto" maxlength="255"><?=  $descriptorpuesto->autoridades ?></textarea>
            </div>
        </div>
<br>
        <div class="row">
            <div class="col-sm-4">
            <label class="control-label col-sm-12" for="capacitacionPuesto">Capacitacion del puesto:</label>
            <textarea class="form-control input-lg" id = "capacitacionPuesto" rows="3" placeholder="Capacitacion del puesto" name="capacitacionPuesto" maxlength="255"><?=  $descriptorpuesto->capacitacion ?></textarea>
            </div>
            <div class="col-sm-4">
            <label class="control-label col-sm-12" for="herramientasdetrabajo">Herramientas de trabajo:</label>
            <textarea class="form-control input-lg" id = "herramientasdetrabajo" rows="3" placeholder="Herramientas de trabajo" name="herramientasdetrabajo" maxlength="255"><?=  $descriptorpuesto->herramientas ?></textarea>
            </div>
            <div class="col-sm-4">
            <label class="control-label col-sm-12" for="softwareactivosinformacion">Software y activos de informacion:</label>
            <textarea class="form-control input-lg" id = "softwareactivosinformacion" rows="3" placeholder="Software y activos de informacion" name="softwareactivosinformacion" maxlength="255"><?=  $descriptorpuesto->softwareactivos ?></textarea>
            </div>
        </div>
    </form>

    </div>
    <div id="perfilDePuesto" class="tab-pane fade">
      <form id="perfilform" class="" action="" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="puestoid2" id="puestoid2" value="<?= $descriptorpuesto->id_puesto ?>">
      <div class="row">
        <div class="col-lg-12">
         <h3>Perfil del puesto</h3>
       </div>
      </div>
      <br>
      <div class="row">
        <div class="form-group">
          <label class="control-label col-sm-2" for="puestomostrar2">Puesto:</label>
          <div class="col-sm-6">
           <input type="puestomostrar" class="form-control" id="puestomostrar2" name="puestomostrar2" placeholder="puestomostrar" disabled="disabled" value="<?php $descriptorpuesto->nombrepuesto ?>">
          </div>
            <input id="btnDescriptor" type="button" class="btnobjetivo" value="Guardar cambios en perfil" onclick="guardaperfil()"/>
            <button type="button" class="btnobjetivo" onclick=location="/personal" data-dismiss="modal" id="btnCloseUpload">Regresar</button>
        </div>
      </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
              <label class="control-label" for="rangoedad">Rengo de edad:</label>
              <input type="puestomostrar" class="form-control" id="rangoedad" name="rangoedad" placeholder="Rango de edad" value="<?=  $perfilpuesto->rangoedad ?>">
          </div>
          <div class="col-sm-4">
               <label class="control-label" for="sexo">Sexo:</label>
               <select class="form-control" name="sexo" id="sexo">
                   <option value="<?=  $perfilpuesto->sexo ?>" selected="selected" > <?php switch ($perfilpuesto->sexo) { case 0: echo ("Indistinto"); break; case 1: echo ("Masculino"); break; case 2: echo ("Femenino"); break;}  ?> </option>

                   <option value="0"> Indistinto </option>
                   <option value="1"> Masculino </option>
                   <option value="2"> Femenino </option>
             </select>

          </div>
          <div class="col-sm-4">
              <label class="control-label" for="otrosRequisitos">Otros requisistos:</label>
              <input type="puestomostrar" class="form-control" id="otrosRequisitos" name="otrosRequisitos" placeholder="Otros requisitos" value="<?=  $perfilpuesto->otrosreq ?>">
          </div>

        </div>
         <br>
         <div class="row">
           <div class="form-group col-sm-12">
             <label class="control-label col-sm-12" for="conocimientosgenerales">Conocimientos generales del puesto:</label>
               <textarea class="form-control input-lg" id = "conocimientosgenerales" rows="3" placeholder="Conocimientos generales del puesto" name="conocimientosgenerales" maxlength="255"><?=  $perfilpuesto->conocimientos ?></textarea>
           </div>
         </div>
         <br>
         <div class="row">
             <div class="col-sm-3">
             <label class="control-label col-sm-12" for="educacion">Educacion:</label>
             <textarea class="form-control input-lg" id = "educacion" rows="5" placeholder="Educacion" name="educacion" maxlength="255"><?=  $perfilpuesto->educacion ?></textarea>
             </div>
             <div class="col-sm-3">
             <label class="control-label col-sm-12" for="formacion">Formacion:</label>
             <textarea class="form-control input-lg" id = "formacion" rows="5" placeholder="Formacion" name="formacion" maxlength="255"><?=  $perfilpuesto->formacion ?></textarea>
             </div>
             <div class="col-sm-3">
             <label class="control-label col-sm-12" for="habilidades">Habilidades:</label>
             <textarea class="form-control input-lg" id = "habilidades" rows="5" placeholder="Habilidades" name="habilidades" maxlength="255"><?=  $perfilpuesto->habilidades ?></textarea>
             </div>
             <div class="col-sm-3">
             <label class="control-label col-sm-12" for="experiencias">Experiencias:</label>
             <textarea class="form-control input-lg" id = "experiencias" rows="5" placeholder="Experiencias" name="experiencias" maxlength="255"><?=  $perfilpuesto->experiencias ?></textarea>
             </div>
         </div>

    </form>
    </div>
    <div id="indicadoresDeDesempeño" class="tab-pane fade">
      <form id="indicaform" class="" action="" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="puestoid3" id="puestoid3" value="<?= $descriptorpuesto->id_puesto ?>">
      <div class="row">
        <div class="col-lg-12">
         <h3>Indicadores de desempeño</h3>
       </div>
      </div>
      <br>
      <div class="row">
        <div class="form-group">
          <label class="control-label col-sm-2" for="puestomostrar3">Puesto:</label>
          <div class="col-sm-6">
            <input type="puestomostrar" class="form-control" id="puestomostrar2" name="puestomostrar2" placeholder="puestomostrar" disabled="disabled" value="<?php $descriptorpuesto->nombrepuesto ?>">
          </div>
           <input id="btnDescriptor" type="button" class="btnobjetivo" value="Guardar cambios en indicadores" onclick="guardaindicador()"/>
            <button type="button" class="btnobjetivo" onclick=location="/personal" data-dismiss="modal" id="btnCloseUpload">Regresar</button>
         </div>
      </div>
    </form>
    </div>
  </div>

@stop
