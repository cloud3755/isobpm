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
    <link rel="stylesheet" href="/css/Dropdown Office Menu.css">
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
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script type="text/javascript">
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
        $('.Menu').click(
                function () {

                   var sublevelclass =$('#sublevel' + $(this).attr("id")).attr("class").split(' ')[0];

                    var sublevelhide= sublevelclass.substring(8);
                    for(var i = sublevelhide; i<4; i++)
                        $('.sublevel'+i).hide();

                    var childs = $('#sublevel' + $(this).attr("id") + ' ul li').length;
                    var porc = ((100/childs-1));
                    $('#sublevel' + $(this).attr("id") + ' ul li div').css('width', (porc+'%'));
                    $('#sublevel' + $(this).attr("id") + ' ul li div center *').css('font-size', ((porc*.1)+'vw'));
                    $('#sublevel' + $(this).attr("id") + ' ul li div .bigdiv').css('width', ((porc*1.4)+'%'));
                    $('#sublevel' + $(this).attr("id") + ' ul li div center .smallfont').css('font-size', (((porc/1.7)*.1)+'vw'));
                    $('#sublevel' + $(this).attr("id") + ' ul li div center .verysmallfont').css('font-size', (((porc/2)*.1)+'vw'));
                    $('#sublevel' + $(this).attr("id")).show(500);
                },

            );
      });

      // $(function(){
      //     $(document).on('click','#cambio', function (event){
      //       event.preventDefault();
      //       $("#msg").html("se elimino el registro");
      //     });
      // });

    </script>



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

            <!-- <div class="navbar-default sidebar" role="navigation" style='background-color:#0074B9; '>
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="hidden-xs" style="background-color: #FFF">
                        </li>
                    </ul>
                </div>
            </div> -->

        </nav>




<div class="mainMenu officeColorStyle">
    <ul class="mainMenu border">
        <li><a id="Documentada" class="Menu" href="#">Inf. Documentada</a></li>
        <li><a id="ObjetivosIndicadores" class="Menu" href="#">Objetivos & Indicadores</a></li>
        <li><a href="/procesos/visual">Procesos</a></li>
        <li><a id="RiesgosOportunidades" class="Menu" href="#">Riesgos & oportunidades</a></li>
        <li><a id="MejoraPrincipal" class="Menu" href="#">Mejora</a></li>
    </ul>
</div>
<!--Mejora-->
<div class="sublevel1 sublevel officeColorStyle" id="sublevelMejoraPrincipal">
    <ul class="mainMenu">
        <li>
            <div class="bigdiv">
                <center>
                <i class="fa fa-user-times fa-2x imagesOfficeBar"></i>
                <br>
                <a class="officeColorStyleFont"  href="/quejas/create">QUEJAS</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                <i class="fa fa-thumbs-o-down fa-2x imagesOfficeBar"></i>
                <br>
                <a class="officeColorStyleFont smallfont"  href="/noconformidad/create">NO CONFORMIDADES</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                <i class="fa fa-shield fa-2x imagesOfficeBar"></i>
                <br>
                <a class="officeColorStyleFont smallfont"  href="/accioncorrectiva">ACCIONES CORRECTIVAS</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                <i class="fa fa-tasks fa-2x imagesOfficeBar"></i>
                <br>
                <a class="officeColorStyleFont smallfont"  href="/promejoras">PROYECTOS DE MEJORA</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                <i class="fa fa-pie-chart fa-2x imagesOfficeBar"></i>
                <br>
                <a class="officeColorStyleFont smallfont"  href="/DashboardMejora">REPORTES DE MEJORA</a>
                </center>
            </div>
        </li>
        <li></li>
    </ul>
</div>
<!--Mejora-->

<!--Riesgos & oportunidades-->
<div class="sublevel1 sublevel officeColorStyle" id="sublevelRiesgosOportunidades">
    <ul class="mainMenu">
        <li>
            <div class="bigdiv">
                <center>
                <i class="fa fa-th-list fa-2x imagesOfficeBar"></i>
                <br>
                <a class="officeColorStyleFont smallfont"  href="/abcriesgos/create">ABC RIESGOS</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                <i class="fa fa-cogs fa-2x imagesOfficeBar"></i>
                <br>
                <a class="officeColorStyleFont smallfont"  href="/riesgos/create">ANÁLISIS DE RIESGO</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                <i class="fa fa-thermometer-three-quarters fa-2x imagesOfficeBar"></i>
                <br>
                <a class="officeColorStyleFont smallfont"  href="/mapadecalor">MAPA DE CALOR</a>
                </center>
            </div>
        </li>
        <li></li>
        <li></li>
    </ul>
</div>
<!--Riesgos & oportunidades-->
<!--Objetivos & Indicadores-->
<div class="sublevel1 sublevel officeColorStyle" id="sublevelObjetivosIndicadores">
    <ul class="mainMenu">
        <li>
            <div class="bigdiv">
                <center>
                <i class="fa fa-crosshairs fa-2x imagesOfficeBar"></i>
                <br>
                <a class="officeColorStyleFont smallfont"  href="/objetivos/visual">OBJETIVOS</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                <i class="fa fa-table fa-2x imagesOfficeBar"></i>
                <br>
                <a class="officeColorStyleFont smallfont"  href="/resultado/create">RESULTADOS</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                <i class="fa fa-pie-chart fa-2x imagesOfficeBar"></i>
                <br>
                <a class="officeColorStyleFont smallfont"  href="/Dashboard">DASHBOARD</a>
                </center>
            </div>
        </li>
        <li></li>
        <li></li>
    </ul>
</div>
<!--Objetivos & Indicadores-->
<!--Info Documentada-->
<div class="sublevel1 sublevel officeColorStyle" id="sublevelDocumentada">
    <ul class="mainMenu">
        <li>
            <div>
                <center>
                    <a id="Documentos" class="Menu" href="#">Documentos</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <a id="Estrategia" class="Menu" href="#">Estrategia</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <a id="Procesos" class="Menu" href="#">Procesos</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <a id="Riesgos" class="Menu" href="#">Riesgos</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <a id="Recursos" class="Menu" href="#">Recursos</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <a id="Operacion" class="Menu" href="#">Operación</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <a id="Evaluacion" class="Menu" href="#">Evaluación</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <a id="Mejora" class="Menu" href="#">Mejora</a>
                </center>
            </div>
        </li>
    </ul>
</div>
<div class="sublevel2 sublevel officeColorStyle" id="sublevelMejora">
    <ul class="mainMenu">
        <li >
            <div class="bigdiv">
                <center>
                    <i class="fa fa-eraser fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont verysmallfont" href="/documentada/81">ACCIONES CORRECTIVAS</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-check-square-o fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/82">PROYECTOS DE MEJORA</a>
                </center>
            </div>
        </li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<div class="sublevel2 sublevel officeColorStyle" id="sublevelEvaluacion">
    <ul class="mainMenu">
        <li >
            <div class="bigdiv">
                <center>
                    <br>
                    <a id="PlanesControl" class="Menu officeColorStyleFont smallfont" href="#">PLANES DE CONTROL</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>

                    <br>
                    <a id="PNC" class="Menu officeColorStyleFont smallfont" href="#">INCIDENTES O PNC</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <br>
                    <a id="AuditoriasInternas" class="Menu officeColorStyleFont smallfont" href="#">AUDITORIAS INTERNAS</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-user-times fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/71">QUEJAS</a>
                </center>
            </div>
        </li>

        <li></li>
    </ul>
</div>
<div class="sublevel2 sublevel officeColorStyle" id="sublevelOperacion">
    <ul class="mainMenu">
        <li >
            <div class="bigdiv">
                <center>
                    <i class="fa fa-pencil-square-o  fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont verysmallfont" href="/documentada/56">DISEÑO Y DESARROLLO</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-usd fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/57">COMPRAS</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <br>
                    <a id="Operacion2" class="Menu officeColorStyleFont smallfont" href="#">OPERACIÓN</a>
                </center>
            </div>
        </li>
        <li></li>
    </ul>
</div>
<div class="sublevel2 sublevel officeColorStyle" id="sublevelRecursos">
    <ul class="mainMenu">
        <li >
            <div>
                <center>
                    <a id="Personal" class="Menu officeColorStyleFont smallfont" href="#">PERSONAL</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <a id="Infraestructura" class="Menu officeColorStyleFont smallfont" href="#">INFRAESTRUCTURA</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <a id="EquipoMedicion" class="Menu officeColorStyleFont smallfont" href="#">EQUIPO DE MEDICIÓN</a>
                </center>
            </div>
        </li>
        <li></li>
        <li></li>
        <li></li>

    </ul>
</div>
<div class="sublevel2 sublevel officeColorStyle" id="sublevelRiesgos">
    <ul class="mainMenu">
        <li >
            <div class="bigdiv">
                <center>
                    <i class="fa fa-exclamation-circle fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/31">CALIDAD</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-tree fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/32">AMBIENTALES</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-plus-square fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/33">SEGURIDAD LABORAL</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-battery-quarter fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/34">SUMINISTROS</a>
                </center>
            </div>
        </li>
        <li></li>

    </ul>
</div>
<div class="sublevel2 sublevel officeColorStyle" id="sublevelProcesos">
    <ul class="mainMenu">
        <li >
            <div class="bigdiv">
                <center>
                    <i class="fa fa-pencil fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/21">ARQUITECTURA DE PROCESOS</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-cubes fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/22">PROCESOS DE GESTION</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-circle-o-notch fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/23">PROCESOS CORE</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-desktop fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/24">PROCESOS DE SOPORTE</a>
                </center>
            </div>
        </li>
        <li></li>
    </ul>
</div>
<div class="sublevel2 sublevel officeColorStyle" id="sublevelEstrategia">
    <ul class="mainMenu">
        <li >
            <div class="bigdiv">
                <center>
                    <i class="fa fa-arrows-alt fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont verysmallfont" href="/documentada/11">PLANIFICACION ESTRATEGICA (FODA)</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-comments fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/12">PARTES INTERESADAS</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-line-chart fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/13">OBJETIVOS E INDICADORES</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-user-o fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/14">REVISIONES DIRECTIVAS</a>
                </center>
            </div>
        </li>
        <li></li>
    </ul>
</div>
<div class="sublevel2 sublevel officeColorStyle" id="sublevelDocumentos">
    <ul class="mainMenu">
        <li >
            <div>
                <center>
                    <i class="fa fa-copyright fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont" href="/documentada/1">Politicas</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-book fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont" href="/documentada/1">Manuales</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-cogs fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont" href="/documentada/3">Procedimientos</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-level-up fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/4">Instrucciones de trabajo</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-sticky-note-o fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont" href="/documentada/5">Formatos</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-mail-forward fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/6">Documentos externos</a>
                </center>
            </div>
        </li>
    </ul>
</div>
<div class="sublevel3 sublevel officeColorStyle" id="sublevelAuditoriasInternas">
    <ul class="mainMenu">
        <li>
            <div>
                <center>
                    <i class="fa fa-list-ol fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/68">PROGRAMAS DE AUDITORIAS</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-binoculars fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/69">AUDITORES INTERNOS</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-gavel fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/70">DICTAMENES DE AUDITORIA</a>
                </center>
            </div>
        </li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<div class="sublevel3 sublevel officeColorStyle" id="sublevelPNC">
    <ul class="mainMenu">
        <li>
            <div>
                <center>
                    <i class="fa fa-thumbs-o-up fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/64">PNC'S DE CALIDAD</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-tree fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/65">PNC'S AMBIENTALES</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-lock fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/66">PNC'S DE SEGURIDAD</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-battery-three-quarters fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/67">PNC'S DE SUMINISTROS</a>
                </center>
            </div>
        </li>
        <li></li>
        <li></li>
    </ul>
</div>
<div class="sublevel3 sublevel officeColorStyle" id="sublevelPlanesControl">
    <ul class="mainMenu">
        <li>
            <div>
                <center>
                    <i class="fa fa-thumbs-o-up fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/60">PLANES DE CALIDAD</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-tree fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/61">PLANES AMBIENTALES</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-lock fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/62">PLANES DE SEGURIDAD</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-battery-three-quarters fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/63">PLANES DE SUMINISTROS</a>
                </center>
            </div>
        </li>
        <li></li>
        <li></li>
    </ul>
</div>
<div class="sublevel3 sublevel officeColorStyle" id="sublevelEquipoMedicion">
    <ul class="mainMenu">
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-tachometer fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/47">EQUIPO DE MED Y PBA</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-balance-scale fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/46">PROGRAMA DE CALIBRACIÓN</a>
                </center>
            </div>
        </li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<div class="sublevel3 sublevel officeColorStyle" id="sublevelInfraestructura">
    <ul class="mainMenu">
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-wrench fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/45">EQUIPO O MAQUINARIA</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-paint-brush fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/44">PROGRAMA DE MANTENIMIENTO</a>
                </center>
            </div>
        </li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<div class="sublevel3 sublevel officeColorStyle" id="sublevelPersonal">
    <ul class="mainMenu">
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-sitemap fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/40">ORGANIGRAMA</a>
                </center>
            </div>
        </li>
        <li>
             <div class="bigdiv">
                <center>
                    <i class="fa fa-address-card-o fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/41">PERFIL DE PUESTO</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-folder-open-o fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/42">EXPEDIENTES</a>
                </center>
            </div>
        </li>
        <li>
            <div class="bigdiv">
                <center>
                    <i class="fa fa-arrow-right fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont smallfont" href="/documentada/43">CAPACITACIÓN</a>
                </center>
            </div>
        </li>
        <li></li>
    </ul>
</div>
<div class="sublevel3 sublevel officeColorStyle" id="sublevelOperacion2">
    <ul class="mainMenu">
        <li>
            <div>
                <center>
                    <i class="fa fa-thumbs-o-up fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont" href="/documentada/51">CALIDAD</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-tree fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont" href="/documentada/52">AMBIENTAL</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-lock fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont" href="/documentada/53">SEGURIDAD</a>
                </center>
            </div>
        </li>
        <li>
            <div>
                <center>
                    <i class="fa fa-battery-three-quarters fa-2x imagesOfficeBar"></i>
                    <br>
                    <a class="officeColorStyleFont" href="/documentada/55">SUMINISTROS</a>
                </center>
            </div>
        </li>
        <li></li>
        <li></li>
    </ul>
</div>
<!--Info Documentada-->
        <!--<div id="page-wrapper" style="background-image: url('/img/fondo-inicio.jpg'); background-repeat: no-repeat;">-->
            <div class="main-content">
            <div>
<div class="modal fade" id="modalAgregarNoticia" tabindex="-1" role="dialog" style="background-color:gray">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Agregar Noticia</h2>
            </div>
                <div class="modal-body">
                    <div class="container">
                        <form class="" action="/administrados/noticiastore" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group form-group-lg">
                            <h2>
                                <label for="Noticia" class="control-label col-md-12" >
                                Noticia
                                </label>
                            </h2>
                            <div class="col-md-6">
                                <textarea class="form-control" id = "descripcionNoticia" rows="3" placeholder="Noticia" name="descripcionNoticia"></textarea>
                            </div>
                        </div>
                </div>
                        <div class="modal-footer">
                        <button type="submit" class="btnobjetivo" id="btnNoticia" style="font-family: Arial;">Agregar Noticia</button>
            </form>
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseUpload">Cerrar</button>
                        </div>
                    </div>
                </div>
    </div>
</div>

        </div>
                @yield('content')
            </div>
        </div>

    </body>
    </html>
