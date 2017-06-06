@extends('layouts.principal')

@section('content')

    <div id="action" class="">

        <div class="row">
            <div class="col-sm-12 end">
                <div class="row dashboard">
                    <div class="col-sm-6 end--left">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-sm-7 end--left">
                                        <div class="panel-title" id="destino2" data-src="/mentorlab/admin/dashboard/dashboard">
                                            <h4><strong>Resultados.</strong></h4>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 end--right">
                                        <div id="grupo_select" data-src="/mentorlab/admin/catalogos/getvalues">
                                            <div class="btn-group bootstrap-select">
                                                <button type="button" class="btn dropdown-toggle bs-placeholder btn-default" data-toggle="dropdown" role="button" data-id="select_grupo" title="Selecciona un grupo">
                                                    <span class="filter-option pull-left">Selecciona un indicador</span>&nbsp;
                                                    <span class="bs-caret">
                                                        <span class="caret"></span>
                                                    </span>
                                                </button>

                                        </div>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div>
                            <div class="panel-body" id="graficaAnimos"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="chart-estado" width="756" height="378" style="display: block; width: 756px; height: 378px;"></canvas>
                                <!--<div id="container" style="min-width: 310px; height: 200px; max-width: 350px; margin: 0 auto"></div>-->
                            </div>
                            <div class="panel-heading text-right">
                                <a type="button" style="margin-top: 3px" class="btn btn-primary btn-sm" href="//adrian.internetizante.com/mentorlab/admin/dashboard/reporteemociones">
                                    Reporte
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 end--right">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-12 end">
                                        <div class="panel-title">
                                            <h4><strong>Porcentajes.</strong></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="chart-asistencia" width="756" height="378" style="display: block; width: 756px; height: 378px;"></canvas>
                                <!--<center><span class="chart"><div id="container2" style="min-width: 310px; max-width: 350px; height: 400px; margin: 0 auto"></div></span></center>-->
                            </div>
                            <div class="panel-heading text-right">
                                    Reporte
                            </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div>
                <div class="col-sm-12 end">
                    <div class="row">
                        <div class="col-sm-6 end--left">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h4><strong>Quejas.<br><small></small></strong></h4>
                                    </div>
                                </div>
                                <div class="panel-body no-padding"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                    <canvas id="chart-app" width="756" height="378" style="display: block; width: 756px; height: 378px;"></canvas>
                                    <!--<div id="container3" style="min-width: 300px; max-width: 600px; height: 200px; margin: 0 auto"></div>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 end--right">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h4><strong>Históricos<br><small></small></strong></h4>
                                    </div>
                                </div>
                                <div class="panel-body  mCustomScrollbar scroll__div _mCS_1" style="position: relative; overflow: hidden; data-mcs-theme=" id="home-notifications"><div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: none;" tabindex="0"><div id="mCSB_1_container" class="mCSB_container" style="position: relative; top: -87px; left: 0px;" dir="ltr">
                                    <div class="tile-stats tile-white-brown">
                                        <div class="row">
                                            <div class="col-md-2 end">
                                                <div class="img-user">
                                                    <img src="/mentorlab/admin/img/render/386/256/256?v=58c4a26a91e58" class="img-circle mCS_img_loaded" width="44px">									</div>
                                                </div>
                                                <div class="col-md-8">
                                                    <p><strong>Martin Mcfly</strong></p>
                                                    <p>Fecha: 2016-12-07 16:00:00</p>
                                                    <p>Hijos: Zahara Lupe Macfly, Rubyi Macfly</p>
                                                    <p>Estatus: atendido</p>
                                                </div>
                                                <div class="col-md-2 end">
                                                    <div class="btn-group btn--full" data-toggle="buttons">
                                                        <label class="btn btn-checkbox">
                                                            <input type="checkbox" autocomplete="off" checked="">
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tile-stats tile-white-brown">
                                            <div class="row">
                                                <div class="col-md-2 end">
                                                    <div class="img-user">
                                                        <img src="/mentorlab/admin/img/render/386/256/256?v=58c4a26a91f79" class="img-circle mCS_img_loaded" width="44px">									</div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p><strong>Martin Mcfly</strong></p>
                                                        <p>Fecha: 2016-12-20 12:11:00</p>
                                                        <p>Hijos: Maxi Ades, Zahara Lupe Macfly</p>
                                                        <p>Estatus: atendido</p>
                                                    </div>
                                                    <div class="col-md-2 end">
                                                        <div class="btn-group btn--full" data-toggle="buttons">
                                                            <label class="btn btn-checkbox">
                                                                <input type="checkbox" autocomplete="off" checked="">
                                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tile-stats tile-white-brown">
                                                <div class="row">
                                                    <div class="col-md-2 end">
                                                        <div class="img-user">
                                                            <img src="/mentorlab/admin/img/render/386/256/256?v=58c4a26a92021" class="img-circle mCS_img_loaded" width="44px">									</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <p><strong>Martin Mcfly</strong></p>
                                                            <p>Fecha: 2017-01-17 00:43:00</p>
                                                            <p>Hijos: </p>
                                                            <p>Estatus: atendido</p>
                                                        </div>
                                                        <div class="col-md-2 end">
                                                            <div class="btn-group btn--full" data-toggle="buttons">
                                                                <label class="btn btn-checkbox">
                                                                    <input type="checkbox" autocomplete="off" checked="">
                                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tile-stats tile-white-brown">
                                                    <div class="row">
                                                        <div class="col-md-2 end">
                                                            <div class="img-user">
                                                                <img src="/mentorlab/admin/img/render/386/256/256?v=58c4a26a920c5" class="img-circle mCS_img_loaded" width="44px">									</div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p><strong>Martin Mcfly</strong></p>
                                                                <p>Fecha: 2017-01-17 23:57:00</p>
                                                                <p>Hijos: </p>
                                                                <p>Estatus: atendido</p>
                                                            </div>
                                                            <div class="col-md-2 end">
                                                                <div class="btn-group btn--full" data-toggle="buttons">
                                                                    <label class="btn btn-checkbox">
                                                                        <input type="checkbox" autocomplete="off" checked="">
                                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tile-stats tile-white-brown">
                                                        <div class="row">
                                                            <div class="col-md-2 end">
                                                                <div class="img-user">
                                                                    <img src="/mentorlab/admin/img/render/386/256/256?v=58c4a26a9216c" class="img-circle mCS_img_loaded" width="44px">									</div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <p><strong>Martin Mcfly</strong></p>
                                                                    <p>Fecha: 2017-01-20 01:00:00</p>
                                                                    <p>Hijos: </p>
                                                                    <p>Estatus: atendido</p>
                                                                </div>
                                                                <div class="col-md-2 end">
                                                                    <div class="btn-group btn--full" data-toggle="buttons">
                                                                        <label class="btn btn-checkbox">
                                                                            <input type="checkbox" autocomplete="off" checked="">
                                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tile-stats tile-white-brown">
                                                            <div class="row">
                                                                <div class="col-md-2 end">
                                                                    <div class="img-user">
                                                                        <img src="/mentorlab/admin/img/render/386/256/256?v=58c4a26a9220f" class="img-circle mCS_img_loaded" width="44px">									</div>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <p><strong>Martin Mcfly</strong></p>
                                                                        <p>Fecha: 2017-02-07 14:30:00</p>
                                                                        <p>Hijos: Zahara Lupe Macfly, Rubyi Macfly</p>
                                                                        <p>Estatus: atendido</p>
                                                                    </div>
                                                                    <div class="col-md-2 end">
                                                                        <div class="btn-group btn--full" data-toggle="buttons">
                                                                            <label class="btn btn-checkbox">
                                                                                <input type="checkbox" autocomplete="off" checked="">
                                                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: block;"><div class="mCSB_draggerContainer"><div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; top: 54px; display: block; height: 236px; max-height: 370px;"><div class="mCSB_dragger_bar" style="line-height: 30px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--EVENTOS-->
                                        <div class="col-md-12 end">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <h4><strong>Eventos del dia<br><small></small></strong></h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body ">
                                                    <div class="tile-stats events-list">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <strong><h3>Version pro</h3></strong>
                                                                <p>Informacion</p>
                                                                <p></p>
                                                                <p> </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--EVENTOS-->

                                        <div id="modalSerio" class="modal fade bs-modal-lg" tabindex="-10" role="dialog" data-keyboard="true" data-backdrop="false">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        <h4 class="modal-title">Lista de alumnos</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col-md-12">
                                                            <table class="table table-condensed table-striped table-responsive"><thead><tr></tr></thead><tbody></tbody></table>           </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js" type="text/javascript"></script>
    <script>
    jQuery(document).ready(function($) {
        //Graficas
        var estado = document.getElementById("chart-estado");
        var asistencia = document.getElementById("chart-asistencia");
        var app = document.getElementById("chart-app");
        var utilizacion = [{"data":[0,11]},{"data":[0,0]}];
        var grupos = ["1\u00b0 A","1\u00b0 C","2\u00b0 B","2\u00b0 D","3\u00b0 B"];
        var porcentaje = [0,0,0,0,0];
        var reportes = {"mes":["Enero","Febrero","Marzo"],"emociones":[["7","7",0],["5",0,"1"],["6",0,"1"],["2",0,0]]};
        var emociones = reportes.emociones;
        var meses = reportes.mes;
        console.log(meses);
        console.log(emociones);
        //Función estado de animo
        var myChart = new Chart(estado, {
            type: 'line',
            data: {
                labels: meses,
                datasets: [
                    {
                        label: "Indicador 1",
                        backgroundColor: "rgba(255,99,132,0.2)",
                        borderColor: "#ff6384",
                        pointBackgroundColor: "#ff6384",
                        pointBorderColor: "#ff6384",
                        pointHoverBackgroundColor: "#ff6384",
                        pointHoverBorderColor: "#ff6384",
                        borderWidth: 2,
                        data: emociones[0],
                        //Border
                        lineTension: 0.1,
                    },
                    {
                        label: "Indicador 2",
                        backgroundColor: "rgba(54,162,235,0.2)",
                        borderColor: "#36a2eb",
                        pointBackgroundColor: "#36a2eb",
                        pointBorderColor: "#36a2eb",
                        pointHoverBackgroundColor: "#36a2eb",
                        pointHoverBorderColor: "rgba(179,181,198,1)",
                        borderWidth: 2,
                        data: emociones[1],
                        //Border
                        lineTension: 0.1,
                    },
                    {
                        label: "Indicador 2",
                        backgroundColor: "rgba(255,197,51,0.2)",
                        borderColor: "#FFC533",
                        pointBackgroundColor: "#FFC533",
                        pointBorderColor: "#FFC533",
                        pointHoverBackgroundColor: "#FFC533",
                        pointHoverBorderColor: "rgba(255,197,51,0.2)",
                        borderWidth: 2,
                        data: emociones[2],
                        //Border
                        lineTension: 0.1,
                    },
                    {
                        label: "Indicador 3",
                        backgroundColor: "rgba(153,76,0,0.2)",
                        borderColor: "#CC6600",
                        pointBackgroundColor: "#CC6600",
                        pointBorderColor: "#CC6600",
                        pointHoverBackgroundColor: "#663300",
                        pointHoverBorderColor: "rgba(255,197,51,0.2)",
                        borderWidth: 2,
                        data: emociones[3],
                        //Border
                        lineTension: 0.1,
                    }
                ],
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });

        //Función asistencias
        var myChart = new Chart(asistencia, {
            type: 'line',
            data: {
                //labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio"],
                labels: grupos,
                datasets: [
                    {
                        label: "",
                        backgroundColor: "rgba(49,152,99,0.5)",
                        borderColor: "#319863",
                        pointBackroundColor: "rgba(49,152,99,0.5)",
                        pointBorderColor: "#319863",
                        pointHoverBackgroundColor: "#319863",
                        pointHoverBorderColor: "rgba(49,152,99,0.5)",
                        data : porcentaje,
                        //data: [10, 50, 30, 60, 40, 20, 70],
                        lineTension: 0.1,
                    }
                ],
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        })

        var myCharto = new Chart(app, {
            type: 'bar',
            data: {
                labels: ["Quejas resueltas", "Quejas en proceso"],
                datasets: [
                    {
                        label: "",
                        backgroundColor: "#705fd9",
                        borderColor: "#705fd9",
                        pointBackgroundColor: "#705fd9",
                        pointBorderColor: "#705fd9",
                        pointHoverBackgroundColor: "#705fd9",
                        pointHoverBorderColor: "#705fd9",
                        data: utilizacion[1].data,
                        lineTension: 0.1,
                    },
                    {
                        label: "",
                        backgroundColor: "#f29705",
                        borderColor: "#f29705",
                        pointBackgroundColor: "#f29705",
                        pointBorderColor: "#f29705",
                        pointHoverBackgroundColor: "#f29705",
                        pointHoverBorderColor: "#f29705",
                        data: utilizacion[0].data,
                        lineTension: 0.1,
                    }
                ],
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
        // document.getElementById("chart-app").onclick = function(evt){
        //     var activePoints = myCharto.getElementsAtEvent(evt);
        //     var firstPoint = activePoints[0];
        //     var label = myCharto.data.labels[firstPoint._index];
        //     if (label == "App utilizada"){
        //         $('#modal_used').modal('show');
        //     }else{
        //         $('#modal_noused').modal('show');
        //     }
        // };
    });

    </script>

    <script>
    $(document).ready(function(){
        // $("#grupo_select").change(function(){
        //     var option = $('#grupo_select option:selected').val()
        //     /*var url_filtro = document.getElementById('grpo_select');
        //     var url = $(url_filtro).data('src');*/
        //     var url_temporal = document.getElementById('destino2');
        //     var  destino2= $(url_temporal).data('src');
        //     window.location.replace( destino2 + "/" + option);
        //
        // });
    });
    </script>
</div>
</div>

@stop
