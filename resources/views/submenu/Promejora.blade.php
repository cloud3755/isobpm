@extends('layouts.principal2')

@section('content')

<br><br><br><br><br><br><br><br><br>

      <div class="col-lg-3 col-md-6" id="lean" >
          <div class="panel" id="divPartnersPending" style="Background-color: #FFA500">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-xs-3">
                      </div>
                      <div class="col-xs-9 text-right">
                          <div class="huge" id="divPartnersNumber"></div>
                          <center><div><h3>LEAN</h3></div></center>
                      </div>
                  </div>
              </div>
              <a href="/lean/create" class="pf">
                  <div class="panel-footer">
                      <span class="pull-left" id="spPartnersPending"></span>
                      <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                  </div>
              </a>
          </div>
      </div>



    <div class="col-lg-3 col-md-6" id="sigma" >
      <div class="panel" id="divPartnersPending" style="Background-color: #FFA500">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-3">
                  </div>
                  <div class="col-xs-9 text-right">
                      <div class="huge" id="divCompaniesNumber"></div>
                      <center><div><h3>SIX SIGMA</h3></div></center>
                  </div>
              </div>
          </div>
          <a href="/sigma/create" class="pf">
              <div class="panel-footer">
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
              </div>
          </a>
      </div>
    </div>

    <div class="col-lg-3 col-md-6" id="bpm" >
      <div class="panel" id="divPartnersPending" style="Background-color: #FFA500">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-3">
                  </div>
                  <div class="col-xs-9 text-right">
                      <div class="huge" id="divCompaniesNumber"></div>
                      <center><div><h3>BPM</h3></div></center>
                  </div>
              </div>
          </div>
          <a href="/bpm/create" class="pf">
              <div class="panel-footer">
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
              </div>
          </a>
      </div>
    </div>

    <div class="row">
        <div class="col-lg-10" id="tablaproyecto">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Proyectos
                </div>
                <div class="panel-body">
                  <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="datos">
                    <thead style='background-color: #868889; color:#FFF'>.
                      <tr>
                        <th>
                          <div class="th-inner sortable both">
                              ID Proyecto
                          </div>
                        </th>
                        <th>
                          <div class="th-inner sortable both">
                              Tipo
                          </div>
                        </th>
                        <th>
                          <div class="th-inner sortable both">
                              Proyecto
                          </div>
                        </th>
                        <th>
                          <div class="th-inner sortable both">
                              Responsable
                          </div>
                        </th>
                        <th>
                          <div class="th-inner sortable both">
                              Impacto
                          </div>
                        </th>
                        <th>
                          <div class="th-inner sortable both">
                              Beneficio plan
                          </div>
                        </th>
                        <th>
                          <div class="th-inner sortable both">
                              Beneficio Real
                          </div>
                        </th>
                        <th>
                          <div class="th-inner sortable both">
                              %Plan vs Real
                          </div>
                        </th>
                        <th>
                          <div class="th-inner sortable both">
                              Estatus
                          </div>
                        </th>
                        <th>
                          <div class="th-inner sortable both">
                              Etapas y modificacion
                          </div>
                        </th>
                        <th>
                          <div class="th-inner sortable both">
                              Eliminar
                          </div>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($mejorarelacion as $mejoras): ?>
                      <tr>
                        <td><?=$mejoras->id?></td>
                        <td><?=$mejoras->tipo?></td>
                        <td><?=$mejoras->proyecto?></td>
                        <td><?=$mejoras->usernombre?></td>
                        <td><?=$mejoras->nombreimpacto?></td>
                        <td><?=$mejoras->beneficioplan?></td>
                        <td><?=$mejoras->beneficioreal?></td>
                        <td>
                          @if($mejoras->beneficioplan < 1)
                            0%
                          @else
                            <?=($mejoras->beneficioreal/$mejoras->beneficioplan)*100?>%
                          @endif
                          </td>
                        <td><?=$mejoras->nombreestatus?></td>
                        <td>
                          <form class="" action="/subiretapa/etapa/<?=$mejoras->id?>">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                              <button type="submit" class="btnobjetivo" ><i class="glyphicon glyphicon-pencil">Editar</i></button>
                          </form>
                        </td>
                        <td>
                          <form class="" action="/mejora/delete/<?=$mejoras->id?>" method="post">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}
                            <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" onclick="
return confirm('Estas seguro de eliminar El proyecto: <?=$mejoras->proyecto?>?')">Eliminar</button>
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
@stop
