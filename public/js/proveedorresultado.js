

  $(document).ready(function() {

    //$('#proveedor').find('option:first').attr('selected', 'selected').parent('select');
   escondetodo();



// obtiene proveedor y muestra insumos
  $("#proveedor").change(function() {
    $("#proveedor option[value='0']").remove();

    enseñatodo();

    var id = $('#proveedor').val();
    var route = "/provedores/califica/insumo/"+ $('#proveedor').val();


    $.get(route, function(res){
      for (var i = 0; i < res.length; i++) {
        $("#elistaSeleccionada").append('<option value="'+res[i].idinsumo+'" selected="selected">'+res[i].Producto_o_Servicio+'</option>');
      }
      });

    var route = "/provedores/califica/areas/"+ $('#proveedor').val();

      $.get(route, function(res){
        for (var i = 0; i < res.length; i++) {
          $("#area").append('<option value="'+res[i].idarea+'">'+res[i].nombre+'</option>');
        }
        });



              });

initControls();


$("#botonfiltro").click(function(){

grafica();
tabla();
  });


            });



   function escondetodo(){
     $('#elistaSeleccionada').empty();
     $('#area').empty();
     $('#areas').hide();
     $('#fech').hide();
     $('#fecha2').hide();
     $('#selectinsumos').hide();
     $('#botonfiltro').hide();
     $('#curve_chart').hide();
     $('#tablediv').hide();
   }

   function enseñatodo(){
     $('#areas').show();
     $('#fech').show();
     $('#fecha2').show();
     $('#selectinsumos').show();
     $('#botonfiltro').show();

   }


    function initControls(){
            window.location.hash="red";
            window.location.hash="Red" //chrome
            window.onhashchange=function(){window.location.hash="red";}
            }

    function grafica(){


              $('#curve_chart').show();



                  var route = "/provedores/resultado/filtro"
                  var proveedor = $('#proveedor').val();
                  var area = $('#area').val();
                  var fech = $('#fech').val();
                  var fecha2 = $('#fecha2').val();
                  var elistaSeleccionada = $('#elistaSeleccionada').val();
                  var token = $("#token").val();
                  var fd = new FormData(document.getElementById("formulariofiltro"));
                  var progressBar = 0;
/*
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
                      alert("Cambios guardados correctamente");
                      location.reload();
                    }
                  });
  */



//               $.get(route, {fd},
//                 function(respuesta){
                //asi se valida lo que recibe haciendo que lo escriba en un div
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
                              google.charts.load('current', {'packages':['corechart']});
                              google.charts.setOnLoadCallback(drawChart);

                              function drawChart() {



                                var data = google.visualization.arrayToDataTable(respuesta);

                                var options = {
                                  title: 'Calificacion de proveedor',
                        //          curveType: 'function',
                                  hAxis: {title: 'Fecha - Identificador de pedido',
                                          titleTextStyle: { bold: 1,color: 'black', fontName: 'global-font-name', fontSize: 'global-font-size'},
                                        },
                                  legend: { position: 'bottom' },
                                  seriesType: 'bars',
                                  series: {4: {type: 'line',pointShape: 'circle',pointsVisible: 'true',curveType: 'function',}},
                            //      pointShape: 'circle',
                            //      pointsVisible: 'true',
                                  vAxis: {title: 'Calificacion',
                                          maxValue: 10},
                                  animation: {duration: 500,
                                              startup: 1,
                                              easing: 'inAndOut'},
                                  aggregationTarget: 'category',
                                  focusTarget: 'category',
                                };

                                var chart = new google.visualization.ComboChart(document.getElementById('curve_chart'));
                                chart.draw(data, options);

                                //google.visualization.events.addListener(chart, 'click', showDetails(getSelection()));

                                         }
                }
              });
              }

//                  $("#pruebasjquery").html(respuesta);});

/*                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                   $("#proveedor").attr('disabled', true);
                   $("#insumo").attr('disabled', true);


                  var data = google.visualization.arrayToDataTable(respuesta);

                  var options = {
                    title: 'Calificacion de proveedor',
          //          curveType: 'function',
                    hAxis: {title: 'Identificador de pedido',
                            titleTextStyle: { bold: 1,color: 'black', fontName: 'global-font-name', fontSize: 'global-font-size'},
                          },
                    legend: { position: 'bottom' },
                    seriesType: 'bars',
                    series: {4: {type: 'line',pointShape: 'circle',pointsVisible: 'true',curveType: 'function',}},
              //      pointShape: 'circle',
              //      pointsVisible: 'true',
                    vAxis: {title: 'Calificacion',
                            maxValue: 10},
                    animation: {duration: 500,
                                startup: 1,
                                easing: 'inAndOut'},
                    aggregationTarget: 'category',
                    focusTarget: 'category',
                  };

                  var chart = new google.visualization.ComboChart(document.getElementById('curve_chart'));
                  chart.draw(data, options);

                  google.visualization.events.addListener(chart, 'click', showDetails(getSelection()));

                  $("#proveedor").attr('disabled', false);
                  $("#insumo").attr('disabled', false);

                }
});
*/



function tabla (){
$('#tablediv').show();
              }


            // para select multiple

      function agregaSeleccion(origen, destino) {
                obj = document.getElementById(origen);
                if (obj.selectedIndex == -1)
                    return;

                for (i = 0; opt = obj.options[i]; i++)
                    if (opt.selected) {
                        valor = opt.value; // almacenar value
                        txt = obj.options[i].text; // almacenar el texto
                        obj.options[i] = null; // borrar el item si está seleccionado
                        obj2 = document.getElementById(destino);

                        opc = new Option(txt, valor,"defaultSelected");
                        eval(obj2.options[obj2.options.length] = opc);
                    }



                    var select = document.getElementById('elistaSeleccionada');

                    for ( var i = 0, l = select.options.length, o; i < l; i++ )
                    {
                      o = select.options[i];
                        o.selected = true;
                    }


                }

      function agregaTodo(origen, destino) {
                    obj = document.getElementById(origen);
                    obj2 = document.getElementById(destino);
                    aux = obj.options.length;
                    for (i = 0; i < aux; i++) {
                        aux2 = 0;
                        opt = obj.options[aux2];
                    valor = opt.value; // almacenar value
                    txt = obj.options[aux2].text; // almacenar el texto
                    obj.options[aux2] = null; // borrar el item si está seleccionado

                    opc = new Option(txt, valor,"defaultSelected");
                    eval(obj2.options[obj2.options.length] = opc);
                }



                var select = document.getElementById('elistaSeleccionada');

                for ( var i = 0, l = select.options.length, o; i < l; i++ )
                {
                  o = select.options[i];
                    o.selected = true;
                }
            }

  function showDetails(e){
  //              switch (e['row']) {
                  //asi se valida lo que recibe haciendo que lo escriba en un div
                  //document.getElementById('pruebasjquery').style.visibility='visible';
                  //  $("#pruebasjquery").html(holamundo);
            alert('Hola mundo' + e['row']);


    //            }
            }
