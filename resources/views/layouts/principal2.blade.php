<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>Isobpm</title>

    {{-- neón theme --}}

    <link rel="stylesheet" href="/css/skins/black.css">
    <link rel="stylesheet" href="/css/styleizr.css">
    <link rel="stylesheet" href="/css/jquery-ui/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="/css/font-icons/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="/css/daterangepicker/daterangepicker-bs2.css">
    <link rel="stylesheet" href="/css/icheck/flat/blue.css">
    <link rel="stylesheet" href="/css/bootstrap-select.css">
    <link rel="stylesheet" href="/js/select2/select2.css">


    <script src="/js/jquery.js" charset="utf-8"></script>
    <script src="/js/jquery.mvclite.js" charset="utf-8"></script>
    <script src="/js/jquery.multi-select.js" charset="utf-8"></script>
    <script src="/js/gsap/main-gsap.js" charset="utf-8"></script>
    <script src="/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" charset="utf-8"></script>
    <script src="/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" charset="utf-8"></script>
    <script src="/js/joinable.js" charset="utf-8"></script>
    <script src="/js/resizeable.js" charset="utf-8"></script>
    <script src="/js/neon-api.js" charset="utf-8"></script>
    <script src="/js/toastr.js" charset="utf-8"></script>
    <script src="/js/neon-chat.js" charset="utf-8"></script>
    <script src="/js/neon-custom.js" charset="utf-8"></script>
    <script src="/js/jquery.validate.min.js" charset="utf-8"></script>
    <script src="/js/jquery.dataTables.min.js" charset="utf-8"></script>
    <script src="/js/datatables/TableTools.min.js" charset="utf-8"></script>
    <script src="/js/dataTables.bootstrap.js" charset="utf-8"></script>
    <script src="/js/datatables/jquery.dataTables.columnFilter.js" charset="utf-8"></script>
    <script src="/js/datatables/lodash.min.js" charset="utf-8"></script>
    <script src="/js/datatables/responsive/js/datatables.responsive.js" charset="utf-8"></script>
    <script src="/js/select2/select2.min.js" charset="utf-8"></script>
    <script src="/js/select2/select2.js" charset="utf-8"></script>
    <script src="/js/daterangepicker/moment.min.js" charset="utf-8"></script>
    <script src="/js/icheck/icheck.min.js" charset="utf-8"></script>
    <script src="/js/bootstrap-select.min.js" charset="utf-8"></script>

    {{-- neón theme --}}

    <link rel="stylesheet" href="/sweet/sweetalert.css" type="text/css">
    <!-- Bootstrap Core CSS -->
    <!--<link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="/componentes/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="/css/timeline.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/css/sb-admin-2.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="/componentes/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="/componentes/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/componentes/bootstrap-table/bootstrap-table.css" rel="stylesheet" type="text/css" />

    {{-- Estilos personalizados --}}
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/custom.css">

    <!-- Border titulos -->
    <link rel="stylesheet" href="/css/accioncorrectiva.css">

    <!--Office style bar-->
    <!--<link rel="stylesheet" href="/css/Dropdown Office Menu.css">-->
    <link rel="stylesheet" href="/css/Office2.css">
    <link rel="stylesheet" href="/css/colors.css">
    <style>
    /*@font-face{font-family: 'noto_sansbold'; src:url('/css/fonts/notosans-bold-webfont.eot') format("opentype")}
    body{font-family: 'noto_sansregular' !important;}*/
    </style>



    <script src="/sweet/sweetalert.min.js"></script>
    <script src="/componentes/jquery/dist/jquery.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="/componentes/metisMenu/dist/metisMenu.min.js"></script>
    <!-- Morris Charts JavaScript -->
    <script src="/componentes/raphael/raphael-min.js"></script>

    <script src="/componentes/bootstrap-table/bootstrap-table.js" ></script>
    <script src="/componentes/bootstrap-table/locale/bootstrap-table-es-MX.js"></script>
    <script src="/js/index.js" ></script>


    <!-- jQuery -->
    <script src="/componentes/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="/componentes/metisMenu/dist/metisMenu.min.js"></script>
    <!-- Morris Charts JavaScript -->
    <script src="/componentes/raphael/raphael-min.js"></script>

    <script src="/componentes/bootstrap-table/bootstrap-table.js" ></script>
    <script src="/componentes/bootstrap-table/locale/bootstrap-table-es-MX.js"></script>

    <script src="/js/index.js" ></script>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-inverse " role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/bienvenida">
                  <font color="white">Inicio</font>
                    <img src=" /img/marca-blanca.png" style="width: 35px; height: 35px; float: left; margin-right:5px" />
                </a>
            </div>

                    <ul class="nav navbar-top-links navbar-right">
                      <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" style="color: #A0C0D3" href="#">
                          <i class="fa fa-gear fa-2x"></i>  {{Auth::user()->nombre}} <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user"  style="background-color: #F8BB49">
                          <li><a href="/perfil"><i class="fa fa-user fa-fw"></i> Mi Perfil</a></li>
                          @if(Auth::user()->perfil != 4)
                            <li><a href="/admin"><i class="fa fa-wrench fa-fw"></i> Administración</a></li>
                            @endif
                            <li><a href="{{ Route('admin.auth.logout') }}"><i class="fa fa-sign-out fa-fw"></i> Salir</a></li>
                        </ul>
                      </li>
                    </ul>
                    <center><label for="" class="opcion_iluminada"><h5>{{Auth::user()->empresa}}</h5 ></label></center>
                    <!--
                    <div class="social">
                    		<ul>
                          <li><a href="/infdocumentada" class="icon-bar-graph">Inf.Docu</a></li>
                          <li><a href="/objetivosindicadores"  class="icon-bar-graph">Objetivos</a></li>
                          <li><a href="/procesos/visual" class="icon-bar-graph">Procesos</a></li>
                          <li><a href="/riesgos"  class="icon-bar-graph">Riesgos</a></li>
                          <li><a href="/mejoras" class="icon-bar-graph">Mejoras</a></li>
                          @if(Auth::user()->perfil != 4)
                          <li><a href="#" id="presionarBotonModalNoticia" class="icon-bar-graph">Noticia</a></li>
                          <button hidden id="mostrarModalNoticia" type="hidden" data-toggle="modal" data-target="#modalAgregarNoticia"></button>
                          @endif
                    		</ul>
                    	</div>
                    -->
            <!-- <div class="navbar-default sidebar" role="navigation" style='background-color:#0074B9; '>
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="hidden-xs" style="background-color: #FFF">
                        </li>
                    </ul>
                </div>
            </div> -->

        </nav>




<div class="sublevel0 mainMenu officeColorStyle">
    <ul class="mainMenu noBorder">
        <li>
            <div id="Inicio" class="officeColorStyleFont Menu" onclick="window.location='/bienvenida';">
                <center >
                    <span>Inicio</span>
                </center>
            </div>
        </li>
        <li>
            <div id="Documentos" class="officeColorStyleFont Menu">
                <center >
                    <span>Documentos</span>
                </center>
            </div>
        </li>
        <li>
            <div id="Recursos" class="officeColorStyleFont Menu">
                <center >
                    <span>Recursos</span>
                </center>
            </div>
        </li>
        <li>
            <div id="Estrategia" class="officeColorStyleFont Menu">
                <center >
                    <span>Estrategia</span>
                </center>
            </div>
        </li>
        <li>
            <div id="Procesos" class="officeColorStyleFont Menu">
                <center >
                    <span>Procesos</span>
                </center>
            </div>
        </li>
        <li>
            <div id="Proveedores" class="officeColorStyleFont Menu">
                <center >
                    <span>Proveedores</span>
                </center>
            </div>
        </li>
        <li>
            <div id="Riesgos" class="officeColorStyleFont Menu">
                <center >
                    <span>Riesgos</span>
                </center>
            </div>
        </li>
        <li>
            <div id="Oportunidades" class="officeColorStyleFont Menu">
                <center >
                    <span>Oportunidades</span>
                </center>
            </div>
        </li><li>
            <div id="Mejora" class="officeColorStyleFont Menu">
                <center >
                    <span>Mejora</span>
                </center>
            </div>
        </li>
    </ul>
</div>

<div class="sublevel1 sublevel officeColorStyle2" id="sublevelDocumentos">
        <ul class="mainMenu left">
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/Documento.jpg"/>
                    <br>
                    <a  href="/infdocumentos">Documentos</a> 
                </center> 
          
            </div>

        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/Carpeta.png"/>
                    <br> 
                    <a class="" href="/documentada/56">Registros</a> 
                </center> 
          
            </div>

        </li>
    </ul>
</div>

<div class="sublevel1 sublevel officeColorStyle2" id="sublevelRecursos">
        <ul class="mainMenu left">
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/personal.png"/>
                    <br>
                    <a  href="/recpersonal">Personal</a> 
                </center> 
          
            </div>
        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/infraestructura.jpg"/>
                    <br> 
                    <a class="" href="/recinfraestructura">Infraestructura</a> 
                </center> 
          
            </div>

        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img style="width:120px;" class="imagesOfficeBar" src="/img/navBar office style images/EquipoMedicion.png"/>
                    <br> 
                    <a class="" href="/recmedicion">Equipo de medición</a> 
                </center> 
          
            </div>

        </li>
    </ul>
</div>

<div class="sublevel1 sublevel officeColorStyle2" id="sublevelEstrategia">
        <ul class="mainMenu left">
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/Estrategia.jpg"/>
                    <br>
                    <a  href="/infestrategia">Estrategia</a> 
                </center> 
          
            </div>
        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img style="width:120px;" class="imagesOfficeBar" src="/img/navBar office style images/objetivos.jpg"/>
                    <br> 
                    <a class="" href="/objetivos/visual">Objetivos</a> 
                </center> 
          
            </div>

        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img style="width:120px;" class="imagesOfficeBar" src="/img/navBar office style images/indicadores.png"/>
                    <br> 
                    <a class="" href="/indicadores/create">Indicadores</a> 
                </center> 
          
            </div>

        </li>
         <li>
            <div class="bigdiv">
            
                <center> 
                    <img style="width:120px;" class="imagesOfficeBar" src="/img/navBar office style images/dashboard.png"/>
                    <br> 
                    <a class="" href="/Dashboard">Dashboard</a> 
                </center> 
          
            </div>

        </li>
    </ul>
</div>

<div class="sublevel1 sublevel officeColorStyle2" id="sublevelProcesos">
        <ul class="mainMenu left">
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/procesos.jpg"/>
                    <br>
                    <a  href="/procesos/visual">Procesos</a> 
                </center> 
          
            </div>

        </li>
    </ul>
</div>

<div class="sublevel1 sublevel officeColorStyle2" id="sublevelProveedores">
        <ul class="mainMenu left">
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/materiales.png"/>
                    <br>
                    <a  href="/insumos">Materiales</a> 
                </center> 
          
            </div>

        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/proveedores.png"/>
                    <br>
                    <a  href="/proveedores">Proveedores</a> 
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/EvaluacionProveedores.png"/>
                    <br>
                    <a  href="/provedores/califica">Evaluación a Proveedores</a> 
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/dashboard.png"/>
                    <br>
                    <a  href="/proveedoradmin">Dashboard</a> 
                </center>
            </div>
        </li>
    </ul>
</div>

<div class="sublevel1 sublevel officeColorStyle2" id="sublevelRiesgos">
        <ul class="mainMenu left">
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/Riesgos.jpg"/>
                    <br>
                    <a  href="/abcriesgos/create">Riesgos</a> 
                </center> 
          
            </div>

        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/analisisRiesgo.png"/>
                    <br>
                    <a  href="/riesgos/create">Análisis de Riesgos</a> 
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/mapacalor.jpg"/>
                    <br>
                    <a  href="/mapadecalor">Mapa de Calor</a> 
                </center>
            </div>
        </li>
    </ul>
</div>

<div class="sublevel1 sublevel officeColorStyle2" id="sublevelOportunidades">
        <ul class="mainMenu left">
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/oportunidades.png"/>
                    <br>
                    <a  href="/abcoportunidades/create">Oportunidades</a> 
                </center> 
            </div>

        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/analisisoportunidades.jpg"/>
                    <br>
                    <a  href="/oportunidades/create">Análisis de Oportunidades</a> 
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/mapacalor.jpg"/>
                    <br>
                    <a  href="/mapadecaloropor">Mapa de Calor</a> 
                </center>
            </div>
        </li>
    </ul>
</div>

<div class="sublevel1 sublevel officeColorStyle2" id="sublevelMejora">
        <ul class="mainMenu left">
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/quejas.png"/>
                    <br>
                    <a  href="/quejas/create">Quejas</a> 
                </center> 
            </div>

        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/noconformidades.jpg"/>
                    <br>
                    <a  href="/noconformidad/create">No Conformidades</a> 
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/accionescorrectivas.jpg"/>
                    <br>
                    <a  href="/accioncorrectiva">Acciones Correctivas</a> 
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/Lean-Six-Sigma.jpg"/>
                    <br>
                    <a  href="/Promejoras">Proyectos de Mejora</a> 
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/auditorias.png"/>
                    <br>
                    <a  href="/evainternas">Auditorias</a> 
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
            
                <center> 
                    <img class="imagesOfficeBar" src="/img/navBar office style images/dashboard.png"/>
                    <br>
                    <a  href="/DashboardMejora/">Dashboard</a> 
                </center>
            </div>
        </li>
    </ul>
</div>
        <!--<div id="page-wrapper" style="background-image: url('/img/fondo-inicio.jpg'); background-repeat: no-repeat;">-->
            <div class="main-content">
            <div>
            </div>
                @yield('content')
            </div>
        </div>
<!--scripts para las paginas -->
    <script type="text/javascript">
    var DELAY = 200, clicks = 0, timer = null, element;
      $(function () {
        $("#formeliminar").submit(function(event){
            event.preventDefault();
            $(this).closest('tr').remove();

              $.ajax({
                    type:'POST',
                    url: $(this).attr("action"),
                    data: $(this).serialize(),
                    dataType: "json",

                    success : function(data){
                      $("#msg").html(data.msg);
                    }

              });

        });

        function hideSubMenus(){}
        $("#presionarBotonModalNoticia").click(
            function()
            {
                $("#mostrarModalNoticia").click();
            }
        );
        function discolorSubMenus(sublevelClass)
        {
            $('.Menu').each(
                    function()
                    {
                            $('this').removeClass('clicked');
                    }

            );
        }
        $('.Menu').on( 'click',
                function () {
                    clicks++;
                    element = $(this);
                    if(clicks === 1)
                    {
                        timer = setTimeout(function() {

                            var sublevelclass =$('#sublevel' + element.attr("id")).attr("class").split(' ')[0];
                            var Menu =  element.closest('ul');
                            Menu.find('div').each(function(){
                                $(this).removeClass('clicked');
                            });
                            Menu.find('a').each(function(){
                                $(this).removeClass('clicked');
                            });
                            element.addClass('clicked');
                            var sublevelhide= sublevelclass.substring(8);
                            for(var i = sublevelhide; i<4; i++)
                                $('.sublevel'+i).slideUp(150);

                            var childs = $('#sublevel' + element.attr("id") + ' ul li').length;
                            var porc = ((100/childs-1));
                            //$('#sublevel' + element.attr("id") + ' ul li div').css('width', (porc+'%'));
                            //$('#sublevel' + element.attr("id") + ' ul li').css('width', (porc+'%')-2);
                            //$('#sublevel' + element.attr("id") + ' ul li div center *').css('font-size', ((porc*.1)+'vw'));
                           // $('#sublevel' + element.attr("id") + ' ul li div .bigdiv').css('width', ((porc*1.4)+'%'));
                            $('.smallfont').css('font-size', (((porc/1.3)*.1)+'vw'));
                            $('.verysmallfont').css('font-size', (((porc/2)*.1)+'vw'));
                            $('#sublevel' + element.attr("id")).slideDown(300);  
                        clicks = 0;             //after action performed, reset counter
                        }, DELAY);
                    }
                    else
                    {
                        clearTimeout(timer);    //prevent single-click action
                        clicks = 0;             //after action performed, reset counter
                    }

                    })
                    .on("dblclick", function(e){
                        element = $(this);
                        var sublevelclass =$('#sublevel' + element.attr("id")).attr("class").split(' ')[0];
                        var sublevelhide= sublevelclass.substring(8);
                            for(var i = sublevelhide; i<4; i++)
                                $('.sublevel'+i).slideUp(150);
                    });
                });
      // $(function(){
      //     $(document).on('click','#cambio', function (event){
      //       event.preventDefault();
      //       $("#msg").html("se elimino el registro");
      //     });
      // });

    </script>

    </body>
    </html>
