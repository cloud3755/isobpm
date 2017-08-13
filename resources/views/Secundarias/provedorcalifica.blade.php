@extends('layouts.principal2')

@section('content')

</br>
<script src="/js/proveedorescalifica.js" charset="utf-8"></script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Califica proveedores</h1>
    </div>
</div>


<center><button type="button" class="btnobjetivo" onclick=location="/proveedores" data-dismiss="modal" id="btnCloseUpload">Regresar</button></center>


</br></br></br></br></br>


            <div class="modal-header">
  <!--            <ul class="nav nav-tabs">
                <li class="active"><a href="#">Calificar</a></li>
                <li><a href="#">Historial</a></li>
              </ul>-->
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="/provedores/califica/store" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="proveedorid" id="proveedorid" value="">
              <input type="hidden" name="insumoid" id="insumoid" value="">
              <div class="container">


              <div class="form-group form-group-lg">
                  <h2><label for="proveedor" class="control-label" >(*) Proveedor:</label></h2>
                  <select class="form-control" id="proveedor">
                    <option value="0"> Selecciona un proveedor </option>
                    <?php foreach ($proveedor as $proveedores): ?>
                      <option value="<?=$proveedores->id?>"> <?=$proveedores->proveedor ?> </option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div id="selectinsumos" class="form-group form-group-lg">
                  <h2><label for="insumos" class="control-label" >(*) Insumo:</label></h2>
                    <select class="form-control" id="insumo">

                    </select>
                  </div>

                <div id="pedidos" class="form-group form-group-lg">
                  <h2><label for="pedidos" class="control-label" >(*) Pedido:</label></h2>
                    <input class="form-control" id="pedido" type="Text" placeholder="Agrega un identificador del pedido" name="pedido" required>
                </div>

            <div  id="radios">
              <div class="">
                  <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Que calificacion le otorgas al proveedor en los siguientes rubros:</h1>
              </div>
  <div class="row">
    <div class="col-lg-6">
    <h2><label for="tiempo" class="control-label" >Tiempo:</label></h2>
    <div class="form-group">
      <h3>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="1"></br></br> 1
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="2"></br></br>2
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="3"></br></br>3
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="4"></br></br>4
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="5"></br></br>5
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="6"></br></br>6
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="7"></br></br>7
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="8"></br></br>8
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="9"></br></br>9
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="Tiempo" id="Tiempo" value="10" checked="checked"></br></br>10
              </label>
            </h3>
    </div>
  </div>
  <div class="col-lg-6">
    <h2><label for="calidad" class="control-label" >Calidad:</label></h2>
    <div class="form-group">
      <h3>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="1"></br></br> 1
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="2"></br></br>2
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="3"></br></br>3
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="4"></br></br>4
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="5"></br></br>5
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="6"></br></br>6
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="7"></br></br>7
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="8"></br></br>8
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="9"></br></br>9
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="calidad" id="calidad" value="10" checked="checked"></br></br>10
              </label>
            </h3>
    </div>
  </div>
</div>
  <div class="row">
  <div class="col-lg-6">
    <h2><label for="servicio" class="control-label" >Servicio:</label></h2>
    <div class="form-group">
      <h3>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="1"></br></br> 1
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="2"></br></br>2
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="3"></br></br>3
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="4"></br></br>4
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="5"></br></br>5
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="6"></br></br>6
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="7"></br></br>7
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="8"></br></br>8
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="9"></br></br>9
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="servicio" id="servicio" value="10" checked="checked"></br></br>10
              </label>
            </h3>
    </div>
    </div>
    <div class="col-lg-6">
    <h2><label for="costo" class="control-label" >Costo:</label></h2>
    <div class="form-group">
      <h3>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="1"></br></br> 1
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="2"></br></br>2
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="3"></br></br>3
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="4"></br></br>4
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="5"></br></br>5
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="6"></br></br>6
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="7"></br></br>7
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="8"></br></br>8
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="9"></br></br>9
              </label>
              <label class="radio-inline">
                <input class="form-control" type="radio" name="costo" id="costo" value="10" checked="checked"></br></br>10
              </label>
            </h3>
    </div>
</div>
            </div>
              </div>
              </div>
                    <div class="modal-footer">
                    <button type="submit" class="btnobjetivo" id="btnsubmit" style="font-family: Arial;">Guardar calificacion</button>
                  </div>
              </form>
              </div>




@stop
