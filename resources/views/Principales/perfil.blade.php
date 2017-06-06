@extends('layouts.principal2')

@section('content')
<br>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#FFF;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Mi Perfil</h1>
    </div>
</div>

<br><br><br><br><br>
<div class="row">
    <div class="col-lg-12">
        <h3><i class="fa fa-user fa-2x"></i>&nbsp;Información Usuario</h3>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>{{ Auth::user()->usuario }}</div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Usuario</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>{{ Auth::user()->nombre }}</div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Nombre</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>
                          @if(Auth::user()->perfil == 1)
                            Super-Administrador
                          @elseif(Auth::user()->perfil == 2)
                            Partner
                          @elseif(Auth::user()->perfil == 3)
                            Administrador
                          @else
                            Usuario
                          @endif
                        </div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Perfil</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>
                          @if(Auth::user()->telefono)
                            {{Auth::user()->telefono}}
                          @else
                            Sin telefono
                          @endif
                        </div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Teléfono</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>{{ Auth::user()->created_at }}</div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Fecha Creación</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>{{ Auth::user()->updated_at }}</div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Fecha Ultima Actualizacion</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div>
                          @if(Auth::user()->status == 1)
                            Pendiente
                          @elseif(Auth::user()->status == 2)
                            Suspendido
                          @else
                            Activo
                          @endif
                        </div>
                    </div>
                </div>
            </div>
                <div class="panel-footer" style="font-size:12px; font-weight: bold">
                    <span class="pull-left"><i class="fa fa-terminal fa-2x"></i></span>
                    <span class="pull-left" >Estatus</span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
</div>
@stop
