@extends('layouts.principal2')

@section('content')
@if (session()->has('flash_msg'))
    <div class="alert alert-{{session()->get('flash_type')}}">
        {{session()->get('flash_msg')}}.
    </div>
@endif





<br><br><br><br><br>

<!-- Formulario del indicador-->

<div class="container">
  <form method="POST" action="" accept-charset="UTF-8" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group form-group-lg">
                <h2><label for="tipo" class="control-label col-md-12" >    Objetivo:</label></h2>
                <div class="col-md-6">
                  <input class="form-control input-lg" disabled = "true" id="nombre" value="<?=$indicadorrelacion->indicadoresobjetivo?>" type="Text" placeholder="A que se quiere llegar" name="nombre">
                </div>
            </div>
            <div class="form-group form-group-lg">
                <h2><label for="Usuario" class="control-label col-md-12">Indicador:</label></h2>
                <div class="col-md-6">
                    <input class="form-control input-lg" disabled = "true" id="nombre" value="<?=$indicadorrelacion->nombreindicador?>" type="Text" placeholder="A que se quiere llegar" name="nombre">
                </div>
            </div>
            <div class="form-group form-group-lg">
                <h2>
                <label for="Usuario" class="control-label col-md-12">
                Decripcion:
                </label>
                </h2>
                <div class="col-md-6">
                    <textarea class="form-control" disabled = "true" id = "prodescripcionind" rows="3" placeholder="" name="descripcion" id="descripcion"><?=$indicadorrelacion->descripcionindicador?></textarea>
                </div>
            </div>
            <div class="form-group form-group-lg">
                <h2>
                <label for="tipo" class="control-label col-md-12" >
                    Frecuencia:
                </label>
                </h2>
                <div class="col-md-6">
                  <input class="form-control input-lg" disabled = "true" id="nombre" value="<?=$indicadorrelacion->frecuenciaindicador?>" type="Text" placeholder="A que se quiere llegar" name="nombre">
                </div>
            </div>

            <div class="form-group form-group-lg">
                <h2><label for="tipo" class="control-label col-md-12" >Unidad:</label></h2>
                <div class="col-md-6">
                  <input class="form-control input-lg" disabled = "true" id="nombre" value="<?=$indicadorrelacion->simboloindicador?>" type="Text" placeholder="A que se quiere llegar" name="nombre">
                </div>
            </div>
            <div class="form-group form-group-lg">
                <h2><label for="tipo" class="control-label col-md-12" >Valor de indicador:</label></h2>
                <div class="col-md-6">
                  <input class="form-control input-lg" disabled = "true" id="nombre" value="<?=$indicadorrelacion->logicaindicador?>" type="Text" placeholder="A que se quiere llegar" name="nombre">
                </div>
            </div>
            <div class="form-group form-group-lg">
                <h2><label for="Usuario" class="control-label col-md-12">Meta:</label></h2>
                <div class="col-md-6">
                  <input class="form-control input-lg" disabled = "true" id="nombre" value="<?=$indicadorrelacion->indicadormeta?>" type="Text" placeholder="A que se quiere llegar" name="nombre">
                </div>
            </div>
        </form>
        <button type="button" class="btnobjetivo" onclick=location="/resultado/create" data-dismiss="modal" id="btnCloseUpload">Regresar</button>
</div>
<br><br>

<!-- Tabla de los resultados -->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                Resultados
            </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                  <form>
                      Buscar <input id="searchTerm" type="text" onkeyup="doSearch()" />
                  </form>
                  <br>
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
                        <thead style='background-color: #868889; color:#FFF'>
                            <tr>
                                <th><div class="th-inner sortable both">Año-Mes</div></th>
                                <th>  <div class="th-inner sortable both">Valor</div></th>
                                <th>
                                  <div class="th-inner sortable both">
                                      Modificar
                                  </div>
                                </th>
                            </tr>
                        </thead>
                        <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                        <tbody>
                            <?php foreach ($resultado as $resultados): ?>
                                <tr>
                                    <td><?=$resultados['mes']?></td>
                                    <td><?=$resultados['valor']?></td>
                                    <td>
                                    <form class="" action="/resultado/destroy/{{ $resultados->id }}" method="post">
                                                  {{ csrf_field() }}
                                    <button type="button" class="btnobjetivo" id="edit<?=$resultados['id']?>" data-toggle="modal" data-target="#modaledit<?=$resultados['id']?>">Editar</i></button>
                                    </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                          </tbody>
                       </table>
                <!-- aqui se agrega un row para insertar nuevo indicador -->
                <h2><label for="Usuario" class="control-label col-md-12">Agrega el siguiente resultado:</label></h2>
                      <tbody>
                        <table>
                          <form action="/resultado/store" method="post">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="indicador_id" id="indicador_id" value = "<?=$indicador['id']?>" >
                              <input class="form-control input-lg" id="periodo" type="hidden" placeholder="# del periodo" name="periodo" value="<?=$siguienteperiodo?>">
                            <tr>
                                <td><input class="form-control input-lg" id="mes" type="<?=$formato?>"  name="mes" value="<?= $siguientefecha?>"></td>
                                <td><input class="form-control input-lg" id="valor" type="Text" placeholder="# del valor de tu periodo" name="valor" required></td>
                                <td><button type="submit" class="btnobjetivo" id="btnresultado" style="font-family: Arial;" >Alta de Resultado</button></td>
                            </tr>
                          </form>
                        </table>
                      </tbody>
                <!-- aqui se agrega un row para insertar nuevo indicador -->
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal para editar -->
<?php foreach ($resultado as $resultados): ?>
<?php if ($formato == 'month') {
  $fecha = substr($resultados['mes'],0,7);
}
else {
  $fecha = $resultados['mes'];
}
  ?>
<div class="modal fade" id="modaledit<?=$resultados['id']?>" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">EDITAR RESULTADO</h2>
            </div>
            <form  action="/resultado/edit/<?=$resultados['id']?>" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token()}}">
              <input type="hidden" name="procesos_id" value="<?=$resultados['id']?>">
              <input type="hidden" name="indicador_id" id="indicador_id" value = "<?=$resultados['indicador_id']?>" >
              <div class="modal-body">
                <div class="container">
                  <div class="form-group form-group-lg">
                      <table>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="resultado_id" id="resultado_id" value = "<?=$resultados['id']?>" >
                            <input class="form-control input-lg" id="periodo" type="hidden" placeholder="# del periodo" name="periodo" value="<?=$resultados['periodo']?>">
                          <tr>
                              <td><input class="form-control input-lg" id="mes" type="<?=$formato?>"  name="mes" value="<?=$fecha?>"></td>
                              <td><input class="form-control input-lg" id="valor" type="Text" placeholder="# del valor de tu periodo" name="valor" value="<?=$resultados['valor']?>"></td>
                          </tr>
                     </table>
                   </div>
                   </div>
                    <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnEditCli" style="font-family: Arial;">Editar Registro</button>
                        <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>

                 </div>
                 </div>
              </form>
            </div>
  </div>
</div>

<?php endforeach?>
<!-- terminaa Modal para editar -->




<?php
  $dato = json_encode($resultado);
 ?>
<!--<button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload" onclick="prueba()">Cerrar</button>-->
<!--se pasa el dato a javascript en formato json para pasar el dato-->
<!--Funcion para buscar en la tabla -->
<script language="javascript">
function prueba()
{
  var variable = eval(<?php echo $dato ?>);

  for(i=0; i<variable.length; i++)
    document.write(variable[i].nombre+variable[i].id);
}

function doSearch()
{
  var tableReg = document.getElementById('datos');
  var searchText = document.getElementById('searchTerm').value.toLowerCase();
  var cellsOfRow="";
  var found=false;
  var compareWith="";

  // Recorremos todas las filas con contenido de la tabla
  for (var i = 1; i < tableReg.rows.length; i++)
  {
    cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
    found = false;
    // Recorremos todas las celdas
    for (var j = 0; j < cellsOfRow.length-1 && !found; j++)
    {
      compareWith = cellsOfRow[j].innerHTML.toLowerCase();
      // Buscamos el texto en el contenido de la celda
      if (searchText.length == 0 || (compareWith.indexOf(searchText) > -1))
      {
        found = true;
      }
    }
    if(found)
    {
      tableReg.rows[i].style.display = '';
    } else {
      // si no ha encontrado ninguna coincidencia, esconde la
      // fila de la tabla
      tableReg.rows[i].style.display = 'none';
    }
  }
}

</script>
@stop
