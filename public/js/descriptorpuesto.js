

$(document).ready(function(){

$("#btnAgregaIndicador").attr("disabled", true);
$("#btnAgregaIndicador").hide();

  initControls();

    $("#indicadores").change(function(){

    $("#indicadores option[value='']").remove();
    $("#btnAgregaIndicador").val($("#indicadores").val());
    $("#btnAgregaIndicador").show();
    $("#btnAgregaIndicador").attr("disabled", false);
  });


              });

// termina document ready

  function initControls(){
  window.location.hash="red";
  window.location.hash="Red" //chrome
  window.onhashchange=function(){window.location.hash="red";}

  }


  function pulsar(e) {
    tecla = (document.all) ? e.keyCode :e.which;
    return (tecla!=13);
  }


  function guardadescriptor() {


    var x = confirm("Estas seguro de hacer los cambios?");
    if (x){


  var value = $("#puestoid").val();
  var route = "/personaldescriptoredit/"+value;
  var fd = new FormData(document.getElementById("descripform"));
  var progressBar = 0;
  var token = $('meta[name="_token"]').attr('content');


  $.ajax({
   url: route,
   headers: {'X-CSRF_TOKEN': token},
   type: 'post',
   data: fd,
   processData: false,  // tell jQuery not to process the data
   contentType: false,
   xhr: function() {
     var xhr = $.ajaxSettings.xhr();
     xhr.upload.onprogress = function(e) {
       progressBar.max = e.total;
       progressBar.value = e.loaded;
         console.log(Math.floor(e.loaded / e.total *100) + '%');
     };
     return xhr;
   },
   success: function(){
     setTimeout(function() {
             toastr.options = {
                 closeButton: true,
                 progressBar: true,
                 showMethod: 'slideDown',
                 timeOut: 4000
             };
             toastr.success('Se guardo el cambio', 'Cambio efectuado');

         }, 0);

   }
  });

  }
  else {

    setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.error('No se guardo cambio', 'Cancelacion de actualizacion');

        }, 0);
  }

  }

  function guardaperfil() {

        var x = confirm("Estas seguro de hacer los cambios?");
        if (x){

      var value = $("#puestoid2").val();
      var route = "/personalperfiledit/"+value;
      var fd = new FormData(document.getElementById("perfilform"));
      var progressBar = 0;
      var token = $('meta[name="_token"]').attr('content');

      $.ajax({
       url: route,
       headers: {'X-CSRF_TOKEN': token},
       type: 'post',
       data: fd,
       processData: false,  // tell jQuery not to process the data
       contentType: false,
       xhr: function() {
         var xhr = $.ajaxSettings.xhr();
         xhr.upload.onprogress = function(e) {
           progressBar.max = e.total;
           progressBar.value = e.loaded;
             console.log(Math.floor(e.loaded / e.total *100) + '%');
         };
         return xhr;
       },
       success: function(){
         setTimeout(function() {
                 toastr.options = {
                     closeButton: true,
                     progressBar: true,
                     showMethod: 'slideDown',
                     timeOut: 4000
                 };
                 toastr.success('Se guardó el cambio', 'Cambio efectuado');

             }, 0);

       }
      });

      }
      else {

        setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.error('No se guardó cambio', 'Cancelación de actualización');

            }, 0);
      }
  }

  function abremodalagrega(btn) {



  $("#ponderacion").val("0.00");
  $("#headermodal").empty();
  $("#headermodal").append('Agrega ponderaci&oacute;n para: ' + $("#indicadores option:selected").text());
  $("#labelmod").empty();
  $("#labelmod").append('Agrega ponderaci&oacute;n');
  $("#indicadoridmodal").val($("#indicadores").val());
  $("#btnguardaindicador").show();
  $("#btnactualizaindicador").hide();
  }


  function abremodalactualiza(btn) {


  $("#btnactualizaindicador").val(btn.value);
  $("#ponderacion").val("0.00");
  $("#headermodal").empty();
  $("#headermodal").append('Actualiza la ponderaci&oacute;n');
  $("#labelmod").empty();
  $("#labelmod").append('Actualiza ponderaci&oacute;n');
  $("#indicadoridmodal").val(btn.value);
  $("#btnguardaindicador").hide();
  $("#btnactualizaindicador").show();


  }

 // vuelve a cargar el el tab con los indicadores
function reload() {

  $("#btnAgregaIndicador").attr("disabled", false);
  $("#btnAgregaIndicador").hide();

  var id = $("#puestoid").val();

  var route = "/indicadorpersonal/table/"+id;

  $.get(route, function(res){
        $("#myTable").empty();
        for (var i = 0; i < res.length; i++) {
          $("#myTable").append('<tr><td><center>'+res[i].nombre+'</center></td><td><center>'+res[i].ponderacion+'</center></td><td><center><button type="button" class="btn btn-primary" value = \"'+res[i].id +'\" data-toggle="modal" data-target="#modalponderacion" onclick="abremodalactualiza(this);"><i class="glyphicon glyphicon-edit"></i></button></center></td><td><form class="" action="" method="post"> <center><button type="button" class="btn btn-danger" value = \"'+res[i].id +'\'" id="btnobjetivo" '+ 'style="font-family: Arial;" onclick="destroy(this);"><i class="fa fa-trash"></i></button></center></form></td><tr>');
    }

    });

  var route = "/indicadorpersonal/ponderacion/"+id;

  $.get(route, function(res){

     if (res == "[object Object]")
     {
       $("#labelponderado").empty();
       $("#labelponderado").append('<font color="red">  % </font>');
     }
     else{

       if (res == "100")
       {
         var color = "green"
       }
       else {
         var color = "red"
       }

       $("#labelponderado").empty();
       $("#labelponderado").append('<font color="'+color+'"> '+res +'% </font>');
     }


    });

  var route = "/indicadorpersonal/indicadores/"+id;

  $.get(route, function(res){
       $("#indicadores").empty();
       $("#indicadores").append('<option value="">Elige indicador a agregar</option>');

    for (var i = 0; i < res.length; i++) {
       $("#indicadores").append('<option value=\"'+res[i].id+'">'+res[i].nombre+'</option>');
     }

     if (res.length == 0)
     {
       $("#btnAgregaIndicador").attr("disabled", true);
        $("#btnAgregaIndicador").hide();
     }

    });

}



function agregaindicador() {

  if ($("#ponderacion").val() == "")
  {
    setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.warning('Debe asignarse un valor al ponderador', 'No se ha guardado');

        }, 0);
    return false
  }

  var idpuesto = $("#puestoid").val();

  var idindicador = $("#indicadoridmodal").val();

  var ponderador = $("#ponderacion").val();

  var route = "/agregaindicadorperfil/"+idpuesto+"/"+idindicador+"/"+ponderador;

  $.get(route, function(res){

    setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.success('Se guardo el indicador', 'Indicador guardado');

        }, 0);


    reload();

    });

  $("#modalponderacion").modal('toggle');

}


function actualizaindicador(btn){

  if (confirm('Estas seguro de cambiar el indicador?') == false )
  {
    setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.warning('No se cambió el indicador', 'Actualizacion cancelada');

        }, 0);
    return false
  }



var ponderador = $("#ponderacion").val();

var route = "/modificaindicadorpuesto/" + btn.value + "/" + ponderador

  $.get(route, function(res){

    setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.success('Se guardo el cambio en indicador', 'Ponderador actualizado');

        }, 0);


    reload();


  });

}


function destroy(btn) {

if (confirm('seguro de eliminar el indicador?') == false )
{
  setTimeout(function() {
          toastr.options = {
              closeButton: true,
              progressBar: true,
              showMethod: 'slideDown',
              timeOut: 4000
          };
          toastr.warning('No se eliminó el indicador', 'Borrar cancelado');

      }, 1000);
  return false
}

var route = "/indicadorpersonal/destroy/"+btn.value;

$.get(route, function(res){
     reload();
  setTimeout(function() {
          toastr.options = {
              closeButton: true,
              progressBar: true,
              showMethod: 'slideDown',
              timeOut: 4000
          };
          toastr.success('Se eliminó el indicador', 'Borrar efectuado');

      }, 1000);
    });

  }
