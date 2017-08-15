

  $(document).ready(function() {

    //$('#proveedor').find('option:first').attr('selected', 'selected').parent('select');

    $('#selectinsumos').hide();
    $('#checkinputs').hide();
    $('#curve_chart').hide();
    $("#ctiempo").val(1);
    $("#ccalidad").val(1);
    $("#cservicio").val(1);
    $("#ccosto").val(1);


// obtiene proveedor y muestra insumos
  $("#proveedor").change(function() {
    //$('#proveedor').val('0').find('option[value="0"]‌​').remove();
    $("#proveedor option[value='0']").remove();
    $("#ctiempo").val(1);
    $("#ccalidad").val(1);
    $("#cservicio").val(1);
    $("#ccosto").val(1);
    $('#curve_chart').hide();
    $('#checkinputs').hide();
    $('#selectinsumos').show();
    $("#insumo").empty();
    var id = $('#proveedor').val();
    var route = "/provedores/califica/insumo/"+ $('#proveedor').val();


    $.get(route, function(res){
      $("#insumo").append('<option value="0">Selecciona un insumo</option>');
      for (var i = 0; i < res.length; i++) {
        $("#insumo").append('<option value="'+res[i].idinsumo+'">'+res[i].Producto_o_Servicio+'</option>');
      }
      });
      var test = $("input[name=proveedorid]:hidden").val(id);
              });

// obtiene proveedor y muestra insumos
    $("#insumo").change(function() {
      $("#insumo option[value='0']").remove();
      $("#ctiempo").val(1);
      $("#ccalidad").val(1);
      $("#cservicio").val(1);
      $("#ccosto").val(1);

      var id2 = $('#insumo').val();
      var test2 = $("input[name=insumoid]:hidden").val(id2);
      //$('#checkinputs').show();
      $('#curve_chart').show();

        var proveedorid = $("#proveedorid").val();
        var insumoid = $("#insumoid").val();
        var route = "/provedores/resultado/"+proveedorid+"/"+insumoid;
        var token = $("#token").val();


       $.get(route,// {token,proveedorid,insumoid},
         function(respuesta){
        //asi se valida lo que recibe haciendo que lo escriba en un div
        //  $("#pruebasjquery").html(respuesta);

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
           $("#proveedor").attr('disabled', true);
           $("#insumo").attr('disabled', true);
           $("#ctiempo").attr('disabled', true);
           $("#ccalidad").attr('disabled', true);
           $("#cservicio").attr('disabled', true);
           $("#ccosto").attr('disabled', true);



          var data = google.visualization.arrayToDataTable(respuesta);

          var options = {
            title: 'Calificacion de proveedor',
            curveType: 'function',
            hAxis: {title: 'Identificador de pedido',
                    titleTextStyle: { bold: 1,color: 'black', fontName: 'global-font-name', fontSize: 'global-font-size'},
                  },
            legend: { position: 'bottom' },
            pointShape: 'circle',
            pointsVisible: 'true',
            vAxis: {maxValue: 11},
            animation: {duration: 500,
                        startup: 1,
                        easing: 'inAndOut'},
          };

          var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

          chart.draw(data, options);
          $("#proveedor").attr('disabled', false);
          $("#insumo").attr('disabled', false);
          $("#ctiempo").attr('disabled', false);
          $("#ccalidad").attr('disabled', false);
          $("#cservicio").attr('disabled', false);
          $("#ccosto").attr('disabled', false);
        }


       });



                });

  $("#ctiempo").click(function(){


    var proveedorid = $("#proveedorid").val();
    var insumoid = $("#insumoid").val();
    var route = "/provedores/resultado/"+proveedorid+"/"+insumoid;
    var token = $("#token").val();


   $.get(route, //{token,proveedorid,insumoid},
     function(respuesta){

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
         $("#proveedor").attr('disabled', true);
         $("#insumo").attr('disabled', true);
         $("#ctiempo").attr('disabled', true);
         $("#ccalidad").attr('disabled', true);
         $("#cservicio").attr('disabled', true);
         $("#ccosto").attr('disabled', true);





        var data = google.visualization.arrayToDataTable(respuesta);

        var options = {
          title: 'Calificacion de proveedor',
          curveType: 'function',
          hAxis: {title: 'Identificador de pedido',
                  titleTextStyle: { bold: 1,color: 'black', fontName: 'global-font-name', fontSize: 'global-font-size'},
                },
          legend: { position: 'bottom' },
          pointShape: 'circle',
          pointsVisible: 'true',
          vAxis: {maxValue: 11},
          animation: {duration: 500,
                      startup: 1,
                      easing: 'inAndOut'},
        };



        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        var ctiempo = $("#ctiempo").val();
        if (ctiempo == 1) {
        chart.hideColumns([1]);
         }
        chart.draw(chart, options);
        $("#proveedor").attr('disabled', false);
        $("#insumo").attr('disabled', false);
        $("#ctiempo").attr('disabled', false);
        $("#ccalidad").attr('disabled', false);
        $("#cservicio").attr('disabled', false);
        $("#ccosto").attr('disabled', false);


    }


          });

});
});
