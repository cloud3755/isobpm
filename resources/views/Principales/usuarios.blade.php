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
                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalUpload"><i class="glyphicon glyphicon-floppy-save"></i></button>
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

                          <th>  <div class="th-inner sortable both">    Modificar  </div></th>
                          <th>  <div class="th-inner sortable both">    Eliminar  </div></th>
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
                            <button type="button" onclick="Editar(this);" class="btn btn-primary" data-toggle="modal" data-target="#modaledit" value="{{ $usuarios->id }}"><i class="glyphicon glyphicon-edit"></i>  </button>
                          </td>
                          <td>
                            <form class="" action="/usuarios/destroy/{{ $usuarios->id }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                              <button type="submit" class="btn btn-danger" id="btnpro" style="font-family: Arial;" onclick="
                                return confirm('Estas seguro de eliminar el Usuario <?=$usuarios->nombre?>?')"><i class="fa fa-trash"></i></button>
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
        <div class="modal-dialog-lg" role="document">
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
                            <select class="form-control" id="id_area" name="id_area" required="">
                              <option value=""></option>
                              <?php foreach ($area as $areas): ?>
                                <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <label style="font-weight: bold">Puesto:</label>
                            <select class="form-control" id="puestoalta" name="puestoalta" required>
                              <option value="">Elige un puesto</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <label style="font-weight: bold">Jefe inmediato:</label>
                            <select class="form-control" id="id_jefe" name="id_jefe">
                              <option value="">Elige un jefe</option>
                            </select>
                        </div>
                    </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success" id="btnobjetivo"><i class="glyphicon glyphicon-floppy-save"></i><br>Agregar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
    </div>
<!-- Fin del modal para agregar Usuarios-->

<!-- Modal para editar Usuarios-->

<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">EDITAR USUARIO</h2>
            </div>
            <div class="modal-body">
              <form id="fileinfo" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <input type="hidden" id="eid">
                <input type="hidden" id="puestoedit2">
                <div class="row">
                  @if(Auth::user()->perfil == 1)
                    <div class="col-lg-12">
                        <label style="font-weight: bold">Empresa:</label>
                        <select class="form-control" style="width: 100%" id="eid_compania" name="eid_compania" required>
                              <option value="" selected></option>
                            <?php foreach ($empresa as $empresas): ?>
                              <option value="<?=$empresas['id']?>"><?=$empresas['razonSocial']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    @endif
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label style="font-weight: bold">Correo:</label>
                        <input type="text" class="form-control" id="eemail" name="eemail"/>
                    </div>
                      <div class="col-lg-6 col-md-6 col-sm-6">
                          <label style="font-weight: bold">Si queda vacio permanece la misma contraseña</label>
                          <input type="password" class="form-control" id="epassword" name="epassword"/>
                      </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label style="font-weight: bold">Perfil:</label>
                        <select class="form-control" id="eperfil" name="eperfil">
                            <option value="" selected></option>
                            <option value="1">Super-Administrador</option>
                            <option value="2">Partner</option>
                            <option value="3">Administrador</option>
                            <option value="4">Usuario</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label style="font-weight: bold">(*) Nombre:</label>
                        <input type="text" class="form-control" id="enombre" name="enombre" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label style="font-weight: bold">Teléfono:</label>
                        <input type="text" class="form-control" id="etelefono" name="etelefono"/>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label style="font-weight: bold">Estatus:</label>
                        <select class="form-control" id="estatus" name="estatus">
                          <option value="0" selected></option>
                          <?php foreach ($statuses as $status): ?>
                            <option value="<?=$status['id']?>"><?=$status['nombre']?></option>
                          <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label style="font-weight: bold">Area:</label>
                        <select class="form-control" id="id_area2" name="id_area2">
                          <option value="" selected></option>
                          <?php foreach ($area as $areas): ?>
                            <option value="<?=$areas['id']?>"><?=$areas['nombre']?></option>
                          <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label style="font-weight: bold">Puesto:</label>
                        <select class="form-control" id="puestoedit" name="puestoedit" required>
                          <option value="" selected></option>

                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label style="font-weight: bold">Jefe inmediato:</label>
                        <select class="form-control" id="id_jefeedit" name="id_jefeedit" >

                        </select>
                    </div>
                </div>


                    <div class="modal-footer">
                      <a class="btn btn-primary" id="actualizar" style="font-family: Arial;"><i class="glyphicon glyphicon-edit"></i><br>Editar</a>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseUpload"><i class="glyphicon glyphicon-remove"></i><br>Cerrar</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
</div>

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

  $("#actualizar").click(function(){
    var value = $("#eid").val();
    var route = "/usuarios/edit/"+value+"";
    var token = $("#token").val();
    var fd = new FormData(document.getElementById("fileinfo"));
console.log($("#puestoedit").val());
    $.ajax({
      url: route,
      headers: {'X-CSRF_TOKEN': token},
      type: 'post',
      data: fd,
      processData: false,  // tell jQuery not to process the data
      contentType: false,
      success: function(){
        alert("Cambios guardados correctamente");
        location.reload();
      }
    });
  });
// cambios en formulario 1

  $('#id_area').change(function(){

    $("#id_area option[value='']").remove();

    var route = "/usuarios/puestos/" + $('#id_area').val();

    $.get(route, function(res){

    $("#puestoalta").empty();


    $("#puestoalta").append('<option value="">Elige un puesto</option>');

 for (var i = 0; i < res.length; i++) {
    $("#puestoalta").append('<option value=\"'+res[i].id+'">'+res[i].nombrepuesto+'</option>');
  }

  });
 });




// cambios en formulario 1

$('#id_area2').change(function(){

  $("#id_area2 option[value='']").remove();

  var route = "/usuarios/puestos/" + $('#id_area2').val();

  $.get(route, function(res){

  $("#puestoedit").empty();

  $("#puestoedit").append('<option value="">Elige un puesto</option>');

for (var i = 0; i < res.length; i++) {
  $("#puestoedit").append('<option value=\"'+res[i].id+'">'+res[i].nombrepuesto+'</option>');
}

});
});


$('#puestoalta').change(function(){

 $("#puestoalta option[value='']").remove();


     var route = "/usuarios/jefes/" + $('#puestoalta').val();

     $.get(route, function(res){

       $("#id_jefe option[value='']").remove();
       $("#id_jefe").empty();
       for (var i = 0; i < res.length; i++) {
         $("#id_jefe").append('<option value=\"'+res[i].id+'">'+res[i].nombre+'</option>');
       }


     });

});



$('#puestoedit').change(function(){

 $("#puestoedit option[value='']").remove();

     var route = "/usuarios/jefes/" + $('#puestoedit').val();

     $.get(route, function(res){

       $("#id_jefeedit option[value='']").remove();
       $("#id_jefeedit").empty();
       for (var i = 0; i < res.length; i++) {
         $("#id_jefeedit").append('<option value=\"'+res[i].id+'">'+res[i].nombre+'</option>');
       }


     });

});


// termina document ready
});







function Editar(btn){
    var route = "/usuarios/"+btn.value+"/edit";

    $.get(route, function(res){
      $("#enombre").val(res.nombre);
      $("#eid").val(res.id);
      $("#puestoedit2").val(res.id_puesto);
      $("#eemail").val(res.email);
      $("#etelefono").val(res.telefono);
      $("#epassword").val("");
      $('#eid_compania option[value="' + res.id_compania + '"]').attr("selected", "selected");
      $('#eperfil option[value="' + res.perfil + '"]').attr("selected", "selected");
      $('#estatus option[value="' + res.status + '"]').attr("selected", "selected");
      $('#id_area2 option[value="' + res.id_area + '"]').attr("selected", "selected");


      var route2 = "/usuarios/puestos/" + res.id_area;
      var idpuesto = res.id_puesto
      $.get(route2, function(res2){
        $("#puestoedit").empty();
        $("#puestoedit").append('<option value="">Elige un puesto</option>');
        for (var i = 0; i < res2.length; i++) {
          $("#puestoedit").append('<option value=\"'+res2[i].id+'">'+res2[i].nombrepuesto+'</option>');
        }
        $('#puestoedit option[value="' + document.getElementById("puestoedit2").value + '"]').attr("selected", "selected");


      });

    //  alert( $('#puestoedit').val());
      var route3 = "/usuarios/jefes/" + document.getElementById("puestoedit2").value;
      $.get(route3, function(res3){
        $("#id_jefeedit").empty();
        for (var i = 0; i < res3.length; i++) {
          $("#id_jefeedit").append('<option value=\"'+res3[i].id+'">'+res3[i].nombre+'</option>');
        }
        $('#id_jefeedit option[value="' + document.getElementById("puestoedit2").value + '"]').attr("selected", "selected");
      });

    });

  }



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
