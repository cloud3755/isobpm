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

        
        <div class="officeColorStyle">
            <ul>

                <li class="dropdown items" style="display: block">
                    <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Inf. Documentada
                    </a>
                    <ul class="dropdown-menu mega-menu officeColorStyle">

                        <li class="mega-menu-column dropdown items">
                            <i class="fa fa-file-text fa-5x imagesOfficeBar" src=" /img/navBar office style images/Politicas.jpg" ></i>
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                DOCUMENTOS
                            </a>
                            <ul class="dropdown-menu mega-menu officeColorStyle">

                                <li class="mega-menu-column">
                                <center>
                                    <ul>
                                        <li class="nav-header"></li>
                                        <i class="fa fa-copyright fa-5x imagesOfficeBar" src=" /img/navBar office style images/Politicas.jpg" ></i>
                                        <br><a class="officeColorStyleFont" href="/documentada/1">Politicas</a>
                                    </ul>
                                </center>
                        </li>
                        <li class="mega-menu-column">
                        <center>
                            <ul>
                                <li class="nav-header"></li>
                                <i class="fa fa-book fa-5x imagesOfficeBar"></i><br>
                                <a class="officeColorStyleFont" href="/documentada/1">Manuales</a>
                            </ul>
                        </center>
                </li>   
                <li class="mega-menu-column">
                <center>
                    <ul>
                        <li class="nav-header"></li>
                        <i class="fa fa-cogs fa-5x imagesOfficeBar"></i><br>
                        <a class="officeColorStyleFont" href="/documentada/3">Procedimientos</a>
                    </ul>
                </center>
                </li>
                <li class="mega-menu-column">
                <center>
                    <ul>
                        <li class="nav-header"></li>
                        <i class="fa fa-level-up fa-5x imagesOfficeBar"></i><br>
                        <a class="officeColorStyleFont" href="/documentada/4">Instrucciones de trabajo</a>
                    </ul>
                </center>
                </li>      
                <li class="mega-menu-column">
                <center>
                    <ul>
                        <li class="nav-header"></li>
                        <i class="fa fa-sticky-note-o fa-5x imagesOfficeBar"></i><br>
                        <a class="officeColorStyleFont" href="/documentada/5">Formatos</a>
                    </ul>
                </center>
                </li> 
                <li class="mega-menu-column">
                <center>
                    <ul>
                        <li class="nav-header"></li>
                        <i class="fa fa-mail-forward fa-5x imagesOfficeBar"></i><br>
                        <a class="officeColorStyleFont" href="/documentada/6">Documentos externos</a>
                    </ul>
                </center>
                </li> 
            </ul>
            </li>
            <li class="mega-menu-column dropdown items">
                <i class="fa fa-file-text fa-5x imagesOfficeBar" src=" /img/navBar office style images/Politicas.jpg" ></i>
                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    DOCUMENTOS
                </a>
                <ul class="dropdown-menu mega-menu officeColorStyle">

                    <li class="mega-menu-column">
                    <center>
                        <ul>
                            <li class="nav-header"></li>
                            <i class="fa fa-copyright fa-5x imagesOfficeBar" src=" /img/navBar office style images/Politicas.jpg" ></i>
                            <br><a class="officeColorStyleFont" href="/documentada/1">Politicas</a>
                        </ul>
                    </center>
            </li>
            <li class="mega-menu-column">
            <center>
                <ul>
                    <li class="nav-header"></li>
                    <i class="fa fa-book fa-5x imagesOfficeBar"></i><br>
                    <a class="officeColorStyleFont" href="/documentada/1">Manuales</a>
                </ul>
            </center>
            </li>   
            <li class="mega-menu-column">
            <center>
                <ul>
                    <li class="nav-header"></li>
                    <i class="fa fa-cogs fa-5x imagesOfficeBar"></i><br>
                    <a class="officeColorStyleFont" href="/documentada/3">Procedimientos</a>
                </ul>
            </center>
            </li>
            <li class="mega-menu-column">
            <center>
                <ul>
                    <li class="nav-header"></li>
                    <i class="fa fa-level-up fa-5x imagesOfficeBar"></i><br>
                    <a class="officeColorStyleFont" href="/documentada/4">Instrucciones de trabajo</a>
                </ul>
            </center>
            </li>      
            <li class="mega-menu-column">
            <center>
                <ul>
                    <li class="nav-header"></li>
                    <i class="fa fa-sticky-note-o fa-5x imagesOfficeBar"></i><br>
                    <a class="officeColorStyleFont" href="/documentada/5">Formatos</a>
                </ul>
            </center>
            </li> 
            <li class="mega-menu-column">
            <center>
                <ul>
                    <li class="nav-header"></li>
                    <i class="fa fa-mail-forward fa-5x imagesOfficeBar"></i><br>
                    <a class="officeColorStyleFont" href="/documentada/6">Documentos externos</a>
                </ul>
            </center>
            </li> 
            </ul>
            </li>


            </ul>

            </li>
                <li class="dropdown items" style="display: block">
                    <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Inf. Documentada
                    </a>
                    <ul class="dropdown-menu mega-menu officeColorStyle">

                        <li class="mega-menu-column dropdown items">
                            <i class="fa fa-file-text fa-5x imagesOfficeBar" src=" /img/navBar office style images/Politicas.jpg" ></i>
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                DOCUMENTOS
                            </a>
                            <ul class="dropdown-menu mega-menu officeColorStyle">

                                <li class="mega-menu-column">
                                <center>
                                    <ul>
                                        <li class="nav-header"></li>
                                        <i class="fa fa-copyright fa-5x imagesOfficeBar" src=" /img/navBar office style images/Politicas.jpg" ></i>
                                        <br><a class="officeColorStyleFont" href="/documentada/1">Politicas</a>
                                    </ul>
                                </center>
                        </li>
                        <li class="mega-menu-column">
                        <center>
                            <ul>
                                <li class="nav-header"></li>
                                <i class="fa fa-book fa-5x imagesOfficeBar"></i><br>
                                <a class="officeColorStyleFont" href="/documentada/1">Manuales</a>
                            </ul>
                        </center>
                </li>   
                <li class="mega-menu-column">
                <center>
                    <ul>
                        <li class="nav-header"></li>
                        <i class="fa fa-cogs fa-5x imagesOfficeBar"></i><br>
                        <a class="officeColorStyleFont" href="/documentada/3">Procedimientos</a>
                    </ul>
                </center>
                </li>
                <li class="mega-menu-column">
                <center>
                    <ul>
                        <li class="nav-header"></li>
                        <i class="fa fa-level-up fa-5x imagesOfficeBar"></i><br>
                        <a class="officeColorStyleFont" href="/documentada/4">Instrucciones de trabajo</a>
                    </ul>
                </center>
                </li>      
                <li class="mega-menu-column">
                <center>
                    <ul>
                        <li class="nav-header"></li>
                        <i class="fa fa-sticky-note-o fa-5x imagesOfficeBar"></i><br>
                        <a class="officeColorStyleFont" href="/documentada/5">Formatos</a>
                    </ul>
                </center>
                </li> 
                <li class="mega-menu-column">
                <center>
                    <ul>
                        <li class="nav-header"></li>
                        <i class="fa fa-mail-forward fa-5x imagesOfficeBar"></i><br>
                        <a class="officeColorStyleFont" href="/documentada/6">Documentos externos</a>
                    </ul>
                </center>
                </li> 
            </ul>
            </li>
            <li class="mega-menu-column dropdown items">
                <i class="fa fa-file-text fa-5x imagesOfficeBar" src=" /img/navBar office style images/Politicas.jpg" ></i>
                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    DOCUMENTOS
                </a>
                <ul class="dropdown-menu mega-menu officeColorStyle">

                    <li class="mega-menu-column">
                    <center>
                        <ul>
                            <li class="nav-header"></li>
                            <i class="fa fa-copyright fa-5x imagesOfficeBar" src=" /img/navBar office style images/Politicas.jpg" ></i>
                            <br><a class="officeColorStyleFont" href="/documentada/1">Politicas</a>
                        </ul>
                    </center>
            </li>
            <li class="mega-menu-column">
            <center>
                <ul>
                    <li class="nav-header"></li>
                    <i class="fa fa-book fa-5x imagesOfficeBar"></i><br>
                    <a class="officeColorStyleFont" href="/documentada/1">Manuales</a>
                </ul>
            </center>
            </li>   
            <li class="mega-menu-column">
            <center>
                <ul>
                    <li class="nav-header"></li>
                    <i class="fa fa-cogs fa-5x imagesOfficeBar"></i><br>
                    <a class="officeColorStyleFont" href="/documentada/3">Procedimientos</a>
                </ul>
            </center>
            </li>
            <li class="mega-menu-column">
            <center>
                <ul>
                    <li class="nav-header"></li>
                    <i class="fa fa-level-up fa-5x imagesOfficeBar"></i><br>
                    <a class="officeColorStyleFont" href="/documentada/4">Instrucciones de trabajo</a>
                </ul>
            </center>
            </li>      
            <li class="mega-menu-column">
            <center>
                <ul>
                    <li class="nav-header"></li>
                    <i class="fa fa-sticky-note-o fa-5x imagesOfficeBar"></i><br>
                    <a class="officeColorStyleFont" href="/documentada/5">Formatos</a>
                </ul>
            </center>
            </li> 
            <li class="mega-menu-column">
            <center>
                <ul>
                    <li class="nav-header"></li>
                    <i class="fa fa-mail-forward fa-5x imagesOfficeBar"></i><br>
                    <a class="officeColorStyleFont" href="/documentada/6">Documentos externos</a>
                </ul>
            </center>
            </li> 
            </ul>
            </li>


            </ul>

            </li>
            </ul>

        </div>

<!--
       <div class="officeColorStyle">
            <ul>
                
                <li class="dropdown items">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            DOCUMENTOS
                        </a>
                    <ul class="dropdown-menu mega-menu officeColorStyle">
    
                        <li class="mega-menu-column">
                            <center>
                                <ul>
                                    <li class="nav-header"></li>
                                    <i class="fa fa-copyright fa-5x imagesOfficeBar" src=" /img/navBar office style images/Politicas.jpg" ></i>
                                    <br><a class="officeColorStyleFont" href="/documentada/1">Politicas</a>
                                </ul>
                            </center>
                        </li>
                        <li class="mega-menu-column">
                            <center>
                            <ul>
                                 <li class="nav-header"></li>
                                <i class="fa fa-book fa-5x imagesOfficeBar"></i><br>
                                <a class="officeColorStyleFont" href="/documentada/1">Manuales</a>
                            </ul>
                            </center>
                        </li>   
			<li class="mega-menu-column">
                            <center>
                            <ul>
                                 <li class="nav-header"></li>
                                <i class="fa fa-cogs fa-5x imagesOfficeBar"></i><br>
                                <a class="officeColorStyleFont" href="/documentada/3">Procedimientos</a>
                            </ul>
                            </center>
                        </li>
			<li class="mega-menu-column">
                            <center>
                            <ul>
                                 <li class="nav-header"></li>
                                <i class="fa fa-level-up fa-5x imagesOfficeBar"></i><br>
                                <a class="officeColorStyleFont" href="/documentada/4">Instrucciones de trabajo</a>
                            </ul>
                            </center>
                        </li>      
                        <li class="mega-menu-column">
                            <center>
                            <ul>
                                 <li class="nav-header"></li>
                                <i class="fa fa-sticky-note-o fa-5x imagesOfficeBar"></i><br>
                                <a class="officeColorStyleFont" href="/documentada/5">Formatos</a>
                            </ul>
                            </center>
                        </li> 
                        <li class="mega-menu-column">
                            <center>
                            <ul>
                                 <li class="nav-header"></li>
                                <i class="fa fa-mail-forward fa-5x imagesOfficeBar"></i><br>
                                <a class="officeColorStyleFont" href="/documentada/6">Documentos externos</a>
                            </ul>
                            </center>
                        </li> 
                    </ul>
                </li>
               
            </ul>
           
        </div>
-->
						
        <!--<div id="page-wrapper" style="background-image: url('/img/fondo-inicio.jpg'); background-repeat: no-repeat;">-->
            <div class="main-content">
            <div>
            <center>
                <div>
                    <table>
                        <tr>
                            <td>
                                <table class="table">
                                    <tr>
                                        <td >
                                            <img style="width: 150px;height: 150px;"  src=" /img/tableCredential images/user.jpg" />
                                        </td>  
                                    </tr>
                                    <tr>
                                        <td>
                                            <div style="border: 1px solid #002858">
                                                <center>
                                                    Noticias
                                                </center>
                                            </div>
                                        </td>  
                                    </tr>
                                    <tr>
                                        <td>
                                            <img style="width: 150px;height: 150px;" src=" /img/tableCredential images/calendar.png" />
                                        </td>  
                                    </tr>
                                </table> 
                            </td>
                            <td>
                            <table class="table">
                                <tr style="border-bottom: 1px solid #002858">
                                    <td>
                                    <i class="fa fa-file-text fa-5x"></i>
                                    <span>Mis Documentos</span>
                                    </td>
                                </tr>
                                
                                <tr style="border-bottom: 1px solid #002858">
                                    <td>
                                        <i class="fa fa fa-bar-chart fa-5x"></i>
                                        <span>Mis Indicadores</span>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #002858">
                                    <td>
                                        <i class="fa fa-code-fork fa-5x"></i>
                                        <span>Mis Procesos</span>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #002858">
                                    <td>
                                        <i class="fa fa fa-edit fa-5x"></i>
                                        <span>Mis Pendientes</span>
                                    </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                    </table>
                    
                    
                </div>
            </center>
        </div>
                @yield('content')
            </div>
        </div>

    </body>
    </html>
