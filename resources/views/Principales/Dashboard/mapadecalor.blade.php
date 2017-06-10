@extends('layouts.principal2')

@section('content')
<form action="/mapadecalor" method="post" role="form">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="col-lg-12">
    <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Mapa de calor</h1>
  </div>
  <div class="row">
    <div class="col-md-4">
      <h2><label for="">Area:</label></h2>
      <select class="form-control input-lg" class="form-control" name="areas" id="areas">
        <option selected value="0">Sin filtro</option>
        <?php foreach ($area as $areas): ?>
          <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
        <?php endforeach ?>
      </select>
    </div>
        <div class="col-md-4">
          <h2><label for="">Procesos:</label></h2>
          <select class="form-control input-lg" name="procesos" id="procesos">
            <option selected value="0">Sin filtro</option>
            <?php foreach ($proceso as $procesos): ?>
              <option value="<?=$procesos->id?>"><?=$procesos->proceso?></option>
            <?php endforeach ?>
          </select>
        </div>
    <div class="col-md-4">
      <h2><label for="">Tipo de riesgos:</label></h2>
      <select class="form-control input-lg" class="form-control" name="tipos" id="tipos">
        <option selected value="0">Sin filtro</option>
        <?php foreach ($Abcriesgo as $Abcriesgos): ?>
          <option value="<?=$Abcriesgos['id']?>"><?=$Abcriesgos['nombre']?></option>
        <?php endforeach ?>
      </select>
    </div>
  </div>
<br>
  <div class="col-md-4">
    <button type="submit" class="btnobjetivo" id="" style="font-family: Arial;" >Filtrar</button>
  </div>

</form>

<div class="panel-body">
    <div class="dataTable_wrapper">
          <table align="center" style="overflow-x:auto;" class="table table-striped table-hover" id="tablacalor">
            <thead style='color:#FFF'>
              <tr>
                <th>  <div class="th-inner sortable both"><font size=6 color="#000"> </font></div></th>
                <th>  <div class="th-inner sortable both"><font size=6 color="#000">  Inherente  </font></div></th>
                <th>  <div class="th-inner sortable both"><font size=6 color="#000"> </font></div></th>
                <th>  <div class="th-inner sortable both"><font size=6 color="#000">  Residual  </font></div></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                  <td align="right" WIDTH="10" HEIGHT="10">
                    <label style=" transform:translate(25px, 150px) rotate(270deg);"for="">severidad</label>
                  </td>
                  <td><table  align="center" border=1 id="tabladecalor">
                  <tr>
                    <td id="amarillo"><center><?=$riskmap_31?></center></td>
                    <td id="rojoclaro"><center><?=$riskmap_32?></center></td>
                    <td id="rojo"><center><?=$riskmap_33?></center></td>
                  </tr>
                  <tr>
                    <td id="verdeclaro"><center><?=$riskmap_21?></center></td>
                    <td id="amarillo"><center><?=$riskmap_22?></center></td>
                    <td id="rojoclaro"><center><?=$riskmap_23?></center></td>
                  </tr>
                  <tr>
                    <td id="verde"><center><?=$riskmap_11?></center></td>
                    <td id="verdeclaro"><center><?=$riskmap_12?></center></td>
                    <td id="amarillo"><center><?=$riskmap_13?></center></td>
                  </tr>

                </table><label for="">Probabilidad</label></td>
                <td align="right" WIDTH="10" HEIGHT="10" >
                  <label style=" transform:translate(25px, 150px) rotate(270deg);"for="">severidad</label>
                </td>
              <td>
                <table  align="center" border=1 id="tabladecalor2">
                  <tr>
                    <td id="amarillo"><center><?=$riskmap2_31?></center></td>
                    <td id="rojoclaro"><center><?=$riskmap2_32?></center></td>
                    <td id="rojo"><center><?=$riskmap2_33?></center></td>
                  </tr>
                  <tr>
                    <td id="verdeclaro"><center><?=$riskmap2_21?></center></td>
                    <td id="amarillo"><center><?=$riskmap2_22?></center></td>
                    <td id="rojoclaro"><center><?=$riskmap2_23?></center></td>
                  </tr>
                  <tr>
                    <td id="verde"><center><?=$riskmap2_11?></center></td>
                    <td id="verdeclaro"><center><?=$riskmap2_12?></center></td>
                    <td id="amarillo"><center><?=$riskmap2_13?></center></td>
                  </tr>
                </table>
                <label for="">Probabilidad</label>
              </td>
              </tr>
            </tbody>
          </table>
  </div>
</div>







<!-- Tabla -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                Riesgos
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <div class="dataTable_wrapper">
                  <br>
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
                        <thead style='background-color: #868889; color:#FFF'>
                            <tr>
                                <th><div class="th-inner sortable both">actividad</div></th>
                                <th><div class="th-inner sortable both">riesgo_id</div></th>
                                <th><div class="th-inner sortable both">descripcion_modo_falla</div></th>
                                <th><div class="th-inner sortable both">Severidad</div></th>
                                <th><div class="th-inner sortable both">probabilidad</div></th>
                                <th><div class="th-inner sortable both">controles</div></th>
                                <th><div class="th-inner sortable both">Severidad2</div></th>
                                <th><div class="th-inner sortable both">probabilidad2</div></th>
                                <th><div class="th-inner sortable both">riesgo inherente</div></th>
                                <th><div class="th-inner sortable both">riesgo residual</div></th>
                            </tr>
                        </thead>
                        <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                        <tbody>
                            <?php foreach ($Analisisriesgo as $Analisisriesgos): ?>
                                <tr>
                                    <td><?=$Analisisriesgos->actividad?></td>
                                    <td><?=$Analisisriesgos->riesgo_id?></td>
                                    <td><?=$Analisisriesgos->descripcion_modo_falla?></td>
                                    <td><?=$Analisisriesgos->Severidad?></td>
                                    <td><?=$Analisisriesgos->probabilidad?></td>
                                    <td><?=$Analisisriesgos->controles?></td>
                                    <td><?=$Analisisriesgos->Severidad2?></td>
                                    <td><?=$Analisisriesgos->probabilidad?></td>
                                    <td><?=$Analisisriesgos->riesgo_inherente?></td>
                                    <td><?=$Analisisriesgos->riesgo_residual?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

@stop
