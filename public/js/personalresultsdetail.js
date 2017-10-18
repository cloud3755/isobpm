

  $(document).ready(function() {



            initControls();






        $("#botonfiltro").click(function(){

        // validamos y cortamos script si hay error

        $('#pruebasjquery').hide();


        if (fecha2 < fech)
        {
          $('#pruebasjquery').show();
          $('#pruebasjquery').html('La fecha fin debe ser mayor o igual que la fecha inicio');
          $('#FmyTable').empty();

          return false;
        }

        tabla();
          });


              });

// termina document ready









    function initControls(){
            window.location.hash="red";
            window.location.hash="Red" //chrome
            window.onhashchange=function(){window.location.hash="red";}
            }





function tabla (){
$('#myTable').empty();



                  var route = "/resultsdetail/filtro"
                  var token = $("#token").val();
                  var fd = new FormData(document.getElementById("formulariofiltro"));
                  var progressBar = 0;



                $.ajax({
                  url: route,
                  headers: {'X-CSRF_TOKEN': token},
                  type: 'post',
                  data: fd,
                  dataType:"json",
                  cache:false,
                  timeout:20000,
                  processData: false,  // tell jQuery not to process the data
                  contentType: false,
                  error: function(){},
                  success: function(respuesta){

if (respuesta.length == 0)
{
  $('#pruebasjquery').show();
  $("#pruebasjquery").html('<h4>No se encontraron resultados con los valores asignados a los campos</h4>');
  }
else {
    $('#pruebasjquery').hide();
            for (var i = 0; i < respuesta.length; i++) {
              $("#myTable").append('<tr><td>'+respuesta[i].area+'</td><td>'+respuesta[i].nombrepuesto+'</td><td>'+respuesta[i].nombre+'</td><td>'+respuesta[i].indicador+'</td><td>'+respuesta[i].periodo+'</td><td>'+respuesta[i].ponderacion+'</td><td>'+respuesta[i].meta+
              '</td><td>'+respuesta[i].logica+'</td><td>'+respuesta[i].resultado+'</td><td>'+respuesta[i].obtenido+'</td></tr>');


                          }

                        }

}
});


}



  function showDetails(e){
  //              switch (e['row']) {
                  //asi se valida lo que recibe haciendo que lo escriba en un div
                  //document.getElementById('pruebasjquery').style.visibility='visible';
                  //  $("#pruebasjquery").html(holamundo);
            alert('Hola mundo' + e['row']);


    //            }
            }
