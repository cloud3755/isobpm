@extends('layouts.principal2')

@section('content')
<br>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Usuarios</h1>
  </div>
</div>

<br><br><br><br><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Usuarios
                    <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-upload"></i></button>
                </div>
            <div class="panel-body">
              <div class="row">
                <div class="table-responsive">
                    <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblUsers">
                      <thead style='background-color: #868889; color:#FFF'>
                        <tr>
                          <th>  <div class="th-inner sortable both">    Usuario  </div></th>
                          <th>  <div class="th-inner sortable both">    Nombre  </div></th>
                          <th>  <div class="th-inner sortable both">    Perfil  </div></th>
                          <th>  <div class="th-inner sortable both">    Telefono  </div></th>
                          <th>  <div class="th-inner sortable both">    Fecha Alta  </div></th>
                          <th>  <div class="th-inner sortable both">    Area  </div></th>

                          <th>  <div class="th-inner sortable both">    Modificacion  </div></th>
                        </tr>
                      </thead>
                      <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                      <tbody id="myTable">
                        <?php foreach ($usuario as $usuarios): ?>
                        <tr>
                          <td>  <?=$usuarios->usuario?></td>
                          <td>  <?=$usuarios->nombre?></td>
                          <td>
                            @if($usuarios->perfil == 1)
                                Super-Administrador
                              @elseif($usuarios->perfil == 2)
                                Partner
                              @elseif($usuarios->perfil == 3)
                                Administrador
                              @else
                                Usuario
                            @endif
                            </td>
                          <td>  <?=$usuarios->telefono?></td>
                          <td>  <?=$usuarios->created_at?></td>
                          <td>  <?=$usuarios->area?></td>

                          <td>
                            <form class="" action="/usuarios/destroy/{{ $usuarios->id }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                              <button type="submit" class="btnobjetivo" id="btnpro" style="font-family: Arial;" onclick="
                                return confirm('Estas seguro de eliminar el Usuario <?=$usuarios->nombre?>?')">Eliminar</button>
                              <button type="button" class="btnobjetivo" data-toggle="modal" data-target="#modaledit<?=$usuarios->id?>"><i class="glyphicon glyphicon-pencil"></i> Editar  </button>
                            </form>
                          </td>
                        </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center">
                  <ul class="pagination pagination-lg pager" id="myPager"></ul>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>
</div>
</div>


<!-- Modal para agregar Usuarios-->
    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" style="background-color:gray">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">ALTA DE USUARIOS</h2>
                </div>
                <div class="modal-body">
                  <form class="" action="/usuarios/store" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                      @if(Auth::user()->perfil == 1)
                        <div class="col-lg-12">
                            <label style="font-weight: bold">Empresa:</label>
                            <select required="" class="form-control" style="width: 100%" id="id_compania" name="id_compania" required>
                                <option value=""></option>
                                <?php foreach ($empresa as $empresas): ?>
                                  <option value="<?=$empresas['id']?>"><?=$empresas['razonSocial']?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        @endif
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label style="font-weight: bold">(*) Correo:</label>
                            <input type="text" class="form-control" id="email" name="email" required=""/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label style="font-weight: bold">(*) Contraseña: &nbsp;&nbsp;&nbsp;</label><input type="checkbox" tabindex="500" id="chkVerPassword" onclick="mostrarpas()"/><span style="font-size:12px">Ver</span>
                            <input type="password" class="form-control" id="password" name="password" required=""/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label style="font-weight: bold">Perfil:</label>
                            <select class="form-control" id="perfil" name="perfil" required="">
                              <option value=""></option>
                              @if(Auth::user()->perfil == 1)
                                <option value="1">Super-Administrador</option>
                                <option value="2">Partner</option>
                              @endif
                                <option value="3">Administrador</option>
                                <option value="4">Usuario</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label style="font-weight: bold">(*) Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required=""/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label style="font-weight: bold">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"/>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <label style="font-weight: bold">Estatus:</label>
                            <select class="form-control" id="status" name="status" required="">
                                <option value=""></option>
                                <option selected="selected" value="1">Pendiente</option>
                                <option value="2">Suspendido</option>
                                <option value="3">Activo</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <label style="font-weight: bold">Area:</label>
                            <select class="form-control" id="status" name="id_area" required="">
                              <option value=""></option>
                              <?php foreach ($area as $areas): ?>
                                <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                        <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnobjetivo" style="font-family: Arial;">Subir Cliente</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
    </div>
<!-- Fin del modal para agregar Usuarios-->
<!-- Modal para editar Usuarios-->

<?php foreach ($usuario as $usuarios): ?>
<div class="modal fade" id="modaledit<?=$usuarios->id?>" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">EDITAR USUARIO</h2>
            </div>
            <div class="modal-body">
              <form  action="/usuarios/edit/<?=$usuarios->id?>" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <div class="row">
                  @if(Auth::user()->perfil == 1)
                    <div class="col-lg-12">
                        <label style="font-weight: bold">Empresa:</label>
                        <select class="form-control" style="width: 100%" id="id_compania" name="id_compania" required>
                            <option id="optionPartner" style="display: none" selected="selected"></option>
                            <?php foreach ($empresa as $empresas): ?>
                              @if($usuarios->id_compania == $empresas['id'])
                                <option value="<?=$empresas['id']?>" selected><?=$empresas['razonSocial']?></option>
                              @else
                                <option value="<?=$empresas['id']?>"><?=$empresas['razonSocial']?></option>
                              @endif
                            <?php endforeach ?>
                        </select>
                    </div>
                    @endif
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label style="font-weight: bold">Correo:</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?=$usuarios->email?>" />
                    </div>
                      <div class="col-lg-6 col-md-6 col-sm-6">
                          <label style="font-weight: bold">Si queda vacio permanece la misma contraseña</label>
                          <input type="password" class="form-control" id="password" name="password"/>
                      </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label style="font-weight: bold">Perfil:</label>
                        <select class="form-control" id="perfil" name="perfil">
                          @if($usuarios->perfil == 2)
                            @if(Auth::user()->perfil == 1)
                              <option value="1">Super-Administrador</option>
                              <option value="2" selected>Partner</option>
                            @endif
                            <option value="3">Administrador</option>
                            <option value="4">Usuario</option>
                          @endif
                          @if($usuarios->perfil == 3)
                            @if(Auth::user()->perfil == 1)
                              <option value="1">Super-Administrador</option>
                              <option value="2">Partner</option>
                            @endif
                            <option value="3" selected>Administrador</option>
                            <option value="4">Usuario</option>
                          @endif
                          @if($usuarios->perfil == 4)
                            @if(Auth::user()->perfil == 1)
                              <option value="1">Super-Administrador</option>
                              <option value="2">Partner</option>
                            @endif
                            <option value="3">Administrador</option>
                            <option value="4" selected>Usuario</option>
                          @endif
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label style="font-weight: bold">(*) Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?=$usuarios->nombre?>"/>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label style="font-weight: bold">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?=$usuarios->telefono?>"/>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label style="font-weight: bold">Estatus:</label>
                        <select class="form-control" id="status" name="status">
                          <?php foreach ($statuses as $status): ?>
                            @if($usuarios->status == $status['id'])
                              <option  selected="selected" value="<?=$status['id']?>"><?=$status['nombre']?></option>
                            @else
                              <option value="<?=$status['id']?>"><?=$status['nombre']?></option>
                            @endif
                          <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label style="font-weight: bold">Area:</label>
                        <select class="form-control" id="id_area" name="id_area">
                          <?php foreach ($area as $areas): ?>
                            @if($usuarios->id_area == $areas['id'])
                              <option  selected="selected" value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                            @else
                              <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                            @endif
                          <?php endforeach ?>
                        </select>
                    </div>
                </div>


                    <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnEditCli" style="font-family: Arial;">Editar Registro</button>
                        <button type="button" class="btnobjetivo" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
</div>

<?php endforeach?>

<!-- Fin del modal para editar Usuarios-->

<script type="text/javascript">

$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 7,
            showPrevNext: false,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);

    var listElement = $this;
    var perPage = settings.perPage;
    var children = listElement.children();
    var pager = $('.pager');

    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }

    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }

    var numItems = children.size();
    var numPages = Math.ceil(numItems/perPage);

    pager.data("curr",0);

    if (settings.showPrevNext){
        $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
    }

    var curr = 0;
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }

    if (settings.showPrevNext){
        $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
    }

    pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
      pager.children().eq(1).addClass("active");

    children.hide();
    children.slice(0, perPage).show();

    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });

    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }

    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }

    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;

        children.css('display','none').slice(startAt, endOn).show();

        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }

        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }

        pager.data("curr",page);
      	pager.children().removeClass("active");
        pager.children().eq(page+1).addClass("active");

    }
};

$(document).ready(function(){

  $('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:10});

});

function mostrarpas(){
  if(document.getElementById("chkVerPassword").checked)
  {
      $("#password").prop("type", "text");
  }
  else {
    $("#password").prop("type", "password");

  }
};
</script>

@stop
