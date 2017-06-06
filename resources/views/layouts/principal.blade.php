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

    <link rel="stylesheet" href="/css/neon-theme.css">
    <link rel="stylesheet" href="/css/neon-core.css">
    <link rel="stylesheet" href="/css/neon-forms.css">
    <link rel="stylesheet" href="/css/skins/black.css">
    <link rel="stylesheet" href="/css/styleizr.css">
    <link rel="stylesheet" href="/css/jquery-ui/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="/css/font-icons/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="/css/daterangepicker/daterangepicker-bs2.css">
    <link rel="stylesheet" href="/css/icheck/flat/blue.css">
    <link rel="stylesheet" href="/css/bootstrap-select.css">

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
    <script src="/js/daterangepicker/moment.min.js" charset="utf-8"></script>
    <script src="/js/icheck/icheck.min.js" charset="utf-8"></script>
    <script src="/js/bootstrap-select.min.js" charset="utf-8"></script>
    {{-- neón theme --}}
    <link rel="stylesheet" href="/sweet/sweetalert.css" type="text/css">
    <link rel="stylesheet" href="/fonts.css" type="text/css">
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

    <style>
    /*@font-face{font-family: 'noto_sansbold'; src:url('/css/fonts/notosans-bold-webfont.eot') format("opentype")}
    body{font-family: 'noto_sansregular' !important;}*/

    </style>


    <script src="/sweet/sweetalert.min.js"></script>
    <script src="/componentes/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="/componentes/metisMenu/dist/metisMenu.min.js"></script>
    <!-- Morris Charts JavaScript -->
    <script src="/componentes/raphael/raphael-min.js"></script>

    <script src="/js/sb-admin-2.js"></script>

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

    <script src="/js/sb-admin-2.js"></script>
    <script src="/componentes/bootstrap-table/bootstrap-table.js" ></script>
    <script src="/componentes/bootstrap-table/locale/bootstrap-table-es-MX.js"></script>

    <script src="/js/index.js" ></script>
    <script src="/js/objetivos.js" charset="utf-8"></script>



</head>

<body>

    <div id="wrapper"  style='background-color: #0074B9'>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color: #F8BB49">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/bienvenida">
                    Inicio
                    <img src=" /img/marca-blanca.png" style="width: 35px; height: 35px; float: left; margin-right:5px" />
                </a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-gear fa-2x"></i>  {{Auth::user()->nombre}}  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user"  style="background-color: #0074B9">
                        <li><a href=" /folders/profile"><i class="fa fa-user fa-fw"></i> Mi Perfil</a>
                        </li>
                        <li><a href=" /folders/admin"><i class="fa fa-wrench fa-fw"></i> Administración</a>
                        </li>
                        <li><a href=" /"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="navbar-default sidebar" role="navigation" style='background-color:#0074B9; '>
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="hidden-xs" style="background-color: #FFF">
                            <!--<img class='img-responsive' src=" /img/logo-isolution.png" />-->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-plus-circle  fa-fw"></i> VERSION PRO OBJETIVOS E INDICADORES<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/objetivos/create">OBJETIVOS</a>
                                </li>
                                <li>
                                    <a href="/objetivos/visual">OBJETIVOS VISUAL</a>
                                </li>

                                <li>
                                    <a href="/indicadores/create">INDICADORES</a>
                                </li>
                                <li>
                                    <a href="/resultado/create">RESULTADOS</a>
                                </li>
                                <li>
                                    <a href="/Dashboard/">DASHBOARD</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-plus-circle fa-fw"></i>PROCESOS<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">

                                <li>
                                    <a href="/procesos/visual">PROCESOS</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-plus-circle fa-fw"></i>RIESGOS Y OPORTUNIDADES<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/abcriesgos/create">ABC DE RIESGOS</a>
                                </li>
                                <li>
                                    <a href="#">ANALISIS DE RIESGOS</a>
                                </li>
                                <li>
                                    <a href="#">MAPA DE CALOR</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-plus-circle fa-fw"></i>MEJORAS<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/quejas/create">QUEJAS</a>
                                </li>
                                <li>
                                    <a href="/noconformidad/create">NO CONFORMIDADES</a>
                                </li>
                                <li>
                                    <a href="#">ACCIONES CORRECTIVAS</a>
                                </li>
                                <li>
                                    <a href="#">PROYECTOS DE MEJORA</a>
                                </li>
                                <li>
                                    <a href="#">REPORTES DE MEJORA</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                             <a href="{{ Route('admin.auth.logout') }}"><i class="fa fa-plus-circle fa-fw"></i>SALIR<span class="fa arrow"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="page-wrapper" style="background-image: url('/img/fondo-inicio.jpg'); background-repeat: no-repeat; background-size: contain">
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </body>
    </html>
