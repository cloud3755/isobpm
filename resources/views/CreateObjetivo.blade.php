@extends('layouts.principal')

@section('content')
    @if (session()->has('flash_msg'))
        <div class="alert alert-{{session()->get('flash_type')}}">
            {{session()->get('flash_msg')}}.
        </div>
    @endif
    <div class="row" style="padding: 5px">
        <div class="col-lg-12 text-right">
            <button type="button" class="btnobjetivo" id="btnHelp">?</button>
        </div>
        <div class="col-lg-12" id="divHelp" style="display:none">
            <div class="col-lg-3 col-md-4 col-sm-4 hidden-xs text-center">
                <img src="/img/help/doc_ext.jpg" class="img-responsive img-thumbnail" />
            </div>
            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                <p>
                    En este apartado se publican los Documentos Externos de la organización, tales como Normas, Contratos,
                    Acuerdos de Servicio y todo aquella documentación requerida y utilizada por la organización para su
                    sistema de Gestión.
                </p>
            </div>
        </div>
    </div><br><br><br><br><br>
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header" style="margin-bottom: 0px; margin: 0px; border-bottom: none">
                <ol class="breadcrumb iso-breadcumb">
                    <li><a href="../" style='color:#FFF'>Objetivos Pro</a></li>
                    <li class="active">Objetivos e indicadores</li>
                </ol>
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-right">
            <center>
                <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i> Subir objetivo</button>
            </center>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Objetivos
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
                                    <th>
                                        <div class="th-inner sortable both">
                                            ID
                                        </div>
                                    </th>
                                    <th>
                                        <div class="th-inner sortable both">
                                            Objetivo ID
                                        </div>
                                    </th>
                                    <th>
                                        <div class="th-inner sortable both">
                                            Nombre
                                        </div>
                                    </th>
                                    <th>
                                        <div class="th-inner sortable both">
                                            Descripcion
                                        </div>
                                    </th>
                                    <th>
                                        <div class="th-inner sortable both">
                                            Fecha
                                        </div>
                                    </th>
                                    <th>
                                        <div class="th-inner sortable both">
                                            Responsable id
                                        </div>
                                    </th>
                                    <th>
                                        <div class="th-inner sortable both">
                                            Creador id
                                        </div>
                                    </th>
                                    <th>
                                      <div class="th-inner sortable both">
                                          Modificar
                                      </div>
                                    </th>
                                </tr>
                            </thead>
                            <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                            <tbody>
                                <?php foreach ($objetivo as $objetiv): ?>
                                    <tr>
                                          <td>
                                              <?=$objetiv['id']?>
                                          </td>
                                          <td>
                                              <?=$objetiv['tipo_objetivo_id']?>
                                          </td>
                                          <td>
                                              <?=$objetiv['nombre']?>
                                          </td>
                                          <td>
                                              <?=$objetiv['descripcion']?>
                                          </td>
                                          <td>
                                              <?=$objetiv['fecha']?>
                                          </td>
                                          <td>

                                              <?=$objetiv['usuario_responsable_id']?>
                                          </td>
                                          <td>
                                              <?=$objetiv['usuario_creador_id']?>
                                          </td>
                                        <td>
                                        <form class="" action="/objetivos/destroy/{{ $objetiv->id }}" method="post">
                                                      {{ csrf_field() }}
                                                      {{ method_field('DELETE') }}
                                          <button type="button" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;" >Editar</button>
                                          <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;" onclick="
return confirm('seguro de eliminar el indicador {{$objetiv->nombre}}?')">Eliminar</button>
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
    <div class="modal fade in" id="modalUpload" tabindex="-1" role="dialog" style="">
        <div class="modal-dialog" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Alta de objetivo</h2>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="/objetivos/store" method="post" role="form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="creador_id" value="{{Auth::user()->id}}">
                          <div class="form-group form-group-lg">
                            <div class="form-group form-group-lg">
                                <h2>
                                  <label for="tipo" class="control-label col-md-12" >
                                    Tipo de Objetivo:
                                  </label>
                                </h2>
                                <div class="col-md-6">
                                    <select class="form-control input-lg" name="tipo_objetivo_id" id="tipo_objetivo_id">
                                        <?php foreach ($Tipo_objetivo as $Tipo): ?>
                                            <option value="<?=$Tipo['id']?>"><?=$Tipo['nombre']?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                              </div>
                                <div class="form-group form-group-lg">
                                    <h2><label for="Usuario" class="control-label col-md-12">Objetivo:</label></h2>
                                    <div class="col-md-6">
                                        <input class="form-control input-lg" id="nombre" type="Text" placeholder="A que se quiere llegar" name="nombre">
                                    </div>
                                </div>

                                <div class="form-group form-group-lg">
                                    <h2>
                                        <label for="Usuario" class="control-label col-md-12">
                                            Decripcion:
                                        </label>
                                    </h2>
                                    <div class="col-md-6">
                                        <textarea class="form-control" id = "descripcion" rows="3" name="descripcion">
                                        </textarea>
                                    </div>
                                </div>

                                <div class="form-group form-group-lg">
                                    <h2><label for="fecha requerimiento" class="control-label col-md-12">Fecha:</label></h2>
                                    <div class="col-md-6">
                                        <input class="form-control input-lg" id="fecha" type="date" placeholder="Fecha" name="fecha">
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
                                                <option value="<?=$Users['id']?>"><?=$Users['usuario']?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;" >Alta de Objetivo</button>
                        </form>
                        <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
      $dato = json_encode($objetivo);
     ?>
<button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload" onclick="prueba()">Cerrar</button>
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
