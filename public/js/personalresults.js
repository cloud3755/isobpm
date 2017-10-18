

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
          $('#curve_chart').hide();
          $('#tablediv').hide();
          return
        }

        grafica();
        //tabla();
          });


              });

// termina document ready









   function escondetodo(){


     $('#curve_chart').hide();
     $('#tablediv').hide();
     $('#pruebasjquery').hide();
   }



    function initControls(){
            window.location.hash="red";
            window.location.hash="Red" //chrome
            window.onhashchange=function(){window.location.hash="red";}
            }

    function grafica(){



              $('#curve_chart').show();

                  var route = "/personal/resultado/filtro"
                  var user = $('#usuario').val();
                  var fech = $('#fech').val();
                  var fecha2 = $('#fecha2').val();
                  var token = $("#token").val();
                  var fd = new FormData(document.getElementById("formulariofiltro"));
                  var progressBar = 0;



                  if (fecha2 < fech) {
                   alert('La fecha final no puede ser menor que la de inicio')
                   return false;
                  }


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
                  error: function(){alert("no se encontraron resultados");
                                    $('#curve_chart').hide();},
                  success: function(respuesta){

                              google.charts.load('current', {'packages':['corechart']});
                              google.charts.setOnLoadCallback(drawChart);

                              function drawChart() {



                                var data = google.visualization.arrayToDataTable(respuesta);

                                var options = {
                                  title: 'Resultado total del mes',
                        //          curveType: 'function',
                                  hAxis: {title: 'Año - Mes',
                                          titleTextStyle: { bold: 1,color: 'black', fontName: 'global-font-name', fontSize: 'global-font-size'},
                                        },
                                  legend: { position: 'bottom' },
                                  seriesType: 'bars',
                                  series: {4: {type: 'line',pointShape: 'circle',pointsVisible: 'true',curveType: 'function',}},
                            //      pointShape: 'circle',
                            //      pointsVisible: 'true',
                                  vAxis: {title: 'Resultado',
                                          maxValue: 10},
                                  animation: {duration: 500,
                                              startup: 1,
                                              easing: 'inAndOut'},
                                  aggregationTarget: 'category',
                                  focusTarget: 'category',
                                  height: 600,

                                };

                                var chart = new google.visualization.ComboChart(document.getElementById('curve_chart'));

                                google.visualization.events.addListener(chart, 'error', function (googleError) {
                                google.visualization.errors.removeError(googleError.id);
                                document.getElementById("error_msg").innerHTML = "Message removed = '" + googleError.message + "'";

});

                                chart.draw(data, options);



                                         }
            //    alert($('#area').val());
              //  tabla(respuesta);
                }
              });

              }

//                  $("#pruebasjquery").html(respuesta);});




function tabla (){
$('#FmyTable').empty();
$('#tablediv').show();


                  var route = "/provedores/resultado/filtro/tabla"
                  var proveedor = $('#proveedor').val();
                  var area = $('#area').val();
                  var fech = $('#fech').val();
                  var fecha2 = $('#fecha2').val();
                  var elistaSeleccionada = $('#elistaSeleccionada').val();
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
  $('#FmyTable').empty();
  $('#tablediv').hide();
  $('#curve_chart').hide();
  $('#pruebasjquery').show();
  $("#pruebasjquery").html('<h4>No se encontraron resultados con los valores asignados a los campos</h4>');
  }
else {
            for (var i = 0; i < respuesta.length; i++) {
//              $("#FmyTable").append('<tr><td>'+respuesta[i].pedido+'</td><td>'+respuesta[i].fechacalificacion+'</td><td>'+respuesta[i].tiempo+'</td><td>'+respuesta[i].calidad+'</td><td>'+respuesta[i].servicio+'</td><td>'+respuesta[i].costo+'</td><td>'+respuesta[i].comentarioevaluacion+'</td><td>'+respuesta[i].archivo+
//              '</td><td><form class="form-inline" action="/proveedor/resultado/delete/'+respuesta[i].id+'" method="post"> <a href="/proveedor/file/califica/ver/'+respuesta[i].id+'" target="_blank" style=\'color:#FFF\'><button type="button" class="btnobjetivo"><i class="glyphicon glyphicon-download-alt"></i> Ver archivo </button> </a>  <input type="hidden" name="_token" value="{{{ csrf_token() }}}"> <button hidden="hidden" type="submit" class="btnobjetivo" id="btndelete_'+respuesta[i].id+'" //style="font-family: Arial;" dataid="'+respuesta[i].id+'" onclick="return confirm(\'Estas seguro de eliminar el archivo: ' +
//               respuesta[i].nombre +'?\')"><i class="glyphicon glyphicon-remove"></i> Eliminar</button></form></td></tr>');
 if(respuesta[i].archivo=='No se cargo archivo'){var txt = '';}else{var txt = '<a href="/proveedor/file/califica/ver/'+respuesta[i].id+'" target="_blank" class="btn btn-warning" style=\'color:#FFF\'><i class="glyphicon glyphicon-cloud-download"></i></a>';}
               $("#prov").empty();
               $("#prov").html(respuesta[i].proveedor);
               var profile = $("#uprofile").val();
               console.log(profile);
               if (profile !=4) {
                 $("#FmyTable").append('<tr><td>'+respuesta[i].pedido+'</td><td>'+respuesta[i].fechacalificacion+'</td><td>'+respuesta[i].tiempo+'</td><td>'+respuesta[i].calidad+'</td><td>'+respuesta[i].servicio+'</td><td>'+respuesta[i].costo+'</td><td>'+respuesta[i].comentarioevaluacion+'</td><td>'+respuesta[i].archivo+
                 txt +'</td><td><form class="" action="/provedores/califica/delete/'+respuesta[i].id+'" method="delete">  <input type="hidden" name="_token" value="{{{ csrf_token() }}}"> <button type="submit" class="btn btn-danger" id="btndelete_'+respuesta[i].id+'" style="font-family: Arial;" dataid="'+respuesta[i].id+'" onclick="return confirm(\'Estas seguro de eliminar la calificacion:?\')"><i class="fa fa-trash"></i></button></form></td></tr>');
               }else {
                 $("#FmyTable").append('<tr><td>'+respuesta[i].pedido+'</td><td>'+respuesta[i].fechacalificacion+'</td><td>'+respuesta[i].tiempo+'</td><td>'+respuesta[i].calidad+'</td><td>'+respuesta[i].servicio+'</td><td>'+respuesta[i].costo+'</td><td>'+respuesta[i].comentarioevaluacion+'</td><td>'+respuesta[i].archivo+
                 txt +'</td></tr>');
               }

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
