




$(document).ready(function(){


  initControls();



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

  function guardaindicador() {
  alert("indicador");
  }
