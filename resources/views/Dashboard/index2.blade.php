@extends('layouts.principal')

@section('content')

<!--GOOGLE HARTS-->
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<!--
        <div id="grafica"></div>
        <div id="grafica1"></div>
        <div id="grafica2"></div>
-->
        <div id="capaGrafico"></div>
    <script>
    // Carga el API de Visualizacion y el paquete del gráfico de quesitos
     google.load('visualization', '1.0', {'packages':['corechart']});

     // Cuando la API de Visualización de Google está cargada llama a la función dibujaGrafico.
     google.setOnLoadCallback(dibujaGrafico);

     // Llama a la función que crea y rellena la tabla,
     // crea el gráfico de quesitos, la pasa los datos y
     // lo dibuja.
     function dibujaGrafico() {

       // Crea la tabla de datos.
       var datos = new google.visualization.DataTable();
       datos.addColumn('string', 'Ingredientes');
       datos.addColumn('number', 'Trozos');
       datos.addRows([
         ['Setas', 3],
         ['Champiñones', 8],
         ['Aceitunas', 1],
         ['Zucchini', 1],
         ['Pepperoni', 2]
       ]);

       // Opciones del gráfico
       var opciones = {'title':'Pizza que me comí anoche',
                      'width':400,
                      'height':300};

       // Crea y dibuja el gráfico, pasando algunas opciones.
       var grafico =
        new google.visualization.PieChart(
        document.getElementById('capaGrafico'));
       grafico.draw(datos, opciones);
     }

     $(function($){
         $('#grafica').highcharts({
             title:{text:'ABANDONO'},
             xAxis:{categories:['Periodo 1 (mes 1)','periodo 2 (mes 2)','periodo 3 (mes 3)','periodo 4 (mes 4)']},
             yAxis:{title:'Porcentaje %',plotLines:[{value:0,width:1,color:'#808080'}]},
             tooltip:{valueSuffix:'%'},
             legend:{layout:'vertical',align:'right',verticalAlign:'middle',borderWidth:0},
             series:[{type: 'pie',name: 'abandono',data: [25,23, 21,22]},
             {name: 'PERIODO 1',data: [25,23, 21,22]},
             {type: 'column',name: 'PERIODO 2',data: [25,23, 21,22,23]},
             {type: 'spline',name: 'PERIODO 3',data: [25,23, 21,22]},
             {name: 'PERIODO 4',data: [25,23, 21,22]},
             {name: 'PERIODO 1',data: [25,23, 21,22]},
           ],
             plotOptions:{line:{dataLabels:{enabled:true}}}
         });
     });

     $(function($){
         $('#grafica1').highcharts({
             title:{text:'Indicador'},
             xAxis:{categories:['2002','2004','2015']},
             yAxis:{title:'Porcentaje %',plotLines:[{value:0,width:1,color:'#808080'}]},
             tooltip:{valueSuffix:'%'},
             legend:{layout:'vertical',align:'right',verticalAlign:'middle',borderWidth:0},
             series:[{type: 'column',name: 'Java',data: [25,23, 21]},
             {name: 'C',data: [20,18, 19]},
             {type: 'column',name: 'C++',data: [15, 17,11]},
             {type: 'spline',name: 'C#',data: [0, 4, 4]},
             {name: 'Objective-C',data: [0,1, 1.5]}
           ],
             plotOptions:{line:{dataLabels:{enabled:true}}}
         });
     });

     Highcharts.chart('grafica2', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'Indicador'
    },
    subtitle: {
        text: 'INDICADORES'
    },
    xAxis: {
        allowDecimals: false,
        labels: {
            formatter: function () {
                return this.value; // clean, unformatted number for year
            }
        }
    },
    yAxis: {
        title: {
            text: 'Valores'
        },
        labels: {
            formatter: function () {
                return this.value / 1000 + 'k';
            }
        }
    },
    tooltip: {
        pointFormat: '{series.name} produced <b>{point.y:,.0f}</b><br/>warheads in {point.x}'
    },
    plotOptions: {
        area: {
            pointStart: 1940,
            marker: {
                enabled: false,
                symbol: 'circle',
                radius: 2,
                states: {
                    hover: {
                        enabled: true
                    }
                }
            }
        }
    },
    series: [{
        name: 'peridod 1',
        data: [null, null, null, null, null, 6, 11, 32, 110, 235, 369, 640,
            1005, 1436, 2063, 3057, 4618, 6444, 9822, 15468, 20434, 24126,
            27387, 29459, 31056, 31982, 32040, 31233, 29224, 27342, 26662,
            26956, 27912, 28999, 28965, 27826, 25579, 25722, 24826, 24605,
            24304, 23464, 23708, 24099, 24357, 24237, 24401, 24344, 23586,
            22380, 21004, 17287, 14747, 13076, 12555, 12144, 11009, 10950,
            10871, 10824, 10577, 10527, 10475, 10421, 10358, 10295, 10104]
    }, {
        name: 'periodo 2',
        data: [null, null, null, null, null, null, null, null, null, null,
            5, 25, 50, 120, 150, 200, 426, 660, 869, 1060, 1605, 2471, 3322,
            4238, 5221, 6129, 7089, 8339, 9399, 10538, 11643, 13092, 14478,
            15915, 17385, 19055, 21205, 23044, 25393, 27935, 30062, 32049,
            33952, 35804, 37431, 39197, 45000, 43000, 41000, 39000, 37000,
            35000, 33000, 31000, 29000, 27000, 25000, 24000, 23000, 22000,
            21000, 20000, 19000, 18000, 18000, 17000, 16000]
    }]
});

    </script>
@stop
