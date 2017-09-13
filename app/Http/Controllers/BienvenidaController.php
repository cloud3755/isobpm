<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Objetivo;
use App\Models\Indicadores;
use App\Models\Quejas;
use App\Models\Proceso;
use App\Models\Empresas;
use App\Models\Noticias;
use App\Models\User;
use App\Models\Documentos;
use App\Models\Pendientes;
use App\Models\Accioncorrectiva1;
use App\Models\Noconformidades;
use App\Models\LinksInteres;
use App\Models\Areas;
use App\Models\Clientes;
use App\Models\Productos;
use App\Models\Estatus;
use Carbon\Carbon;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mail;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Models\EventModel;
use App\Models\proveedores;
use Chumper\Zipper\Zipper;

class BienvenidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contacto()
    {
        return view('contacto');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mail(Request $request)
    {
      Mail::send('emails.contact',$request->all(), function($msj){
        $msj->subject('Correo de contacto');
        $msj->to('password.recovery@isolutionbusiness.com');
      });
      Session::flash('message','Eviado correctamente');
      return Redirect::to('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function cambioempresa(Request $request){

      $usuarios = Auth::user();
      $empresa = new Empresas;


      if($usuarios->perfil <= 2){

        $user = User::findorfail($usuarios->id);
        $empresas = $empresa->where('id',$request->input('empresa'))->first();
        $user->id_compania = $request->input('empresa');
        if($request->input('empresa') == 0){
          $user->empresa = 'Sin empresa';
        }else {
          $user->empresa = $empresas->razonSocial;
        }

        $user->save();

      }

      return redirect('/bienvenida');

    }


    public function show()
    {
      $usuarios = Auth::user();

		  if($usuarios->perfil == 4)
		  {

        $iduser = $usuarios->id;
        //Proyectos de mejora
                    $mejorasid = \DB::table('mejoras')
                   ->join('users','mejoras.responsable_id','=','users.id')
                   ->leftjoin('lista_accesos','mejoras.listaequipo','=','lista_accesos.id_indicador')
                   ->select('mejoras.id', 'mejoras.proyecto')
                   ->where('lista_accesos.id_usuario','=',$usuarios->id)
                   ->where('mejoras.estatus_id','!=',3)
                   ->orwhere(function ($querys) use ($iduser) {
                     $querys->where('mejoras.estatus_id','!=',3)
                     ->where('mejoras.creador_id', '=', DB::raw("'".$iduser."'"));
                   })
                   ->groupby('mejoras.id')
                   ->get();
                   //Fin de proyectos de mejora

                   //Noticias
                   $noticiasw = \DB::table('noticias')
                   ->join('lista_noticias', 'noticias.id', '=', 'lista_noticias.id_noticia')
                   ->select('noticias.*')
                   ->where('noticias.id_empresa',$usuarios->id_compania)
                   ->where('lista_noticias.id_area',$usuarios->id_area)
                   ->where('fecha_hasta', '>=', date("Y-m-d"))
                   ->get();
                   //fin de noticias

                   // Procesos

                   $collection_one = \Illuminate\Support\Collection::make(DB::table('procesos')
                   ->select('procesos.*')
                   ->join('lista_envios', function($join) use ($iduser)
                     {
                         $join->on('procesos.lista_de_distribucion', '=', 'lista_envios.id_proceso');
                         $join->on(function($query) use ($iduser)
                         {
                           $query->on('lista_envios.id_usuario', '=', DB::raw("'".$iduser."'"));
                         });
                     })
                   ->select('procesos.*')
                   ->get());

                   $collection_two = \Illuminate\Support\Collection::make(DB::table('procesos')
                   ->select('procesos.*')
                   ->leftjoin('lista_envios', function($join) use ($iduser)
                     {
                         $join->on('procesos.lista_de_distribucion', '=', 'lista_envios.id_proceso');
                         $join->on(function($query) use ($iduser)
                         {
                           $query->on('lista_envios.id_usuario', '=', DB::raw("'".$iduser."'"));
                         });
                     })
                   ->whereNull('id_proceso')
                   ->where('usuario_responsable_id',$usuarios->id)
                   ->orwhere(function ($querys) use ($iduser) {
                     $querys->whereNull('id_proceso')
                     ->Where('Creador_id', '=', DB::raw("'".$iduser."'"));
                   })
                   ->get());

                   $procesoa = new \Illuminate\Database\Eloquent\Collection;
                   $procesoa = $collection_one->merge($collection_two);
                   // Final de Procesos

                   //Quejas

                   $quejas = \Illuminate\Support\Collection::make(\DB::table('quejas')
                   ->join('clientes','quejas.cliente_id','=','clientes.id')
                   ->join('users','quejas.usuario_responsable_id','=','users.id')
                   ->join('estatuses','quejas.estatus_id','=','estatuses.id')
                   ->select('quejas.*','users.nombre as usernombre','clientes.nombre as clientenombre','estatuses.nombre as statusnombre')
                   ->where('quejas.idcompañia','=',$usuarios->id_compania)
                   ->where('quejas.usuario_responsable_id','=',$usuarios->id)
                   ->where('quejas.estatus_id','!=',3)
                   ->get());
                   //Final de quejas

                   //Acciones correctivas
                   $accionesCorrectivas = \Illuminate\Support\Collection::make(\DB::table('accioncorrectiva1s')
                   ->select('accioncorrectiva1s.*')
                   ->where('accioncorrectiva1s.idcompañia','=',$usuarios->id_compania)
                   ->where('accioncorrectiva1s.responsable_id','=',$usuarios->id)
                   ->where('accioncorrectiva1s.estatus_id','!=',3)
                   ->orwhere(function ($querys) use ($iduser) {
                     $querys->where('accioncorrectiva1s.estatus_id','!=',3)
                     ->where('accioncorrectiva1s.creador_id', '=', DB::raw("'".$iduser."'"));
                   })
                   ->get());
                   //Final Acciones correctivas

                   $Noconformidades = \Illuminate\Support\Collection::make(\DB::table('noconformidades')
                   ->select('noconformidades.*')
                   ->where('noconformidades.idcompañia','=',$usuarios->id_compania)
                   ->where('noconformidades.usuario_responsable_id','=',$usuarios->id)
                   ->where('noconformidades.estatus_id','!=',3)
                   ->orwhere(function ($querys) use ($iduser) {
                     $querys->where('noconformidades.estatus_id','!=',3)
                     ->where('noconformidades.creador_id', '=', DB::raw("'".$iduser."'"));
                   })
                   ->get());


		  }else{
			     $mejorasid = \DB::table('mejoras')
                   ->join('users','mejoras.responsable_id','=','users.id')
                   ->leftjoin('lista_accesos','mejoras.listaequipo','=','lista_accesos.id_indicador')
                   ->select('mejoras.id', 'mejoras.proyecto')
                   ->where('mejoras.id_compania',$usuarios->id_compania)
                   ->where('mejoras.estatus_id','!=',3)
                   ->groupby('mejoras.id')
                   ->get();

                   $noticiasw = \DB::table('noticias')
                   ->select('noticias.*')
                   ->where('noticias.id_empresa',$usuarios->id_compania)
                   ->where('fecha_hasta', '>=', date("Y-m-d"))
                   ->get();

                   $procesosa = new Proceso;
                   $procesoa = $procesosa
                   ->where('idcompañia',$usuarios->id_compania)
                   ->get();

                   $quejas = \Illuminate\Support\Collection::make(\DB::table('quejas')
                   ->join('clientes','quejas.cliente_id','=','clientes.id')
                   ->join('users','quejas.usuario_responsable_id','=','users.id')
                   ->join('estatuses','quejas.estatus_id','=','estatuses.id')
                   ->select('quejas.*','users.nombre as usernombre','clientes.nombre as clientenombre','estatuses.nombre as statusnombre')
                   ->where('quejas.idcompañia','=',$usuarios->id_compania)
                   ->where('quejas.estatus_id','!=',3)
                   ->get());

                   $accionesCorrectivas = \Illuminate\Support\Collection::make(\DB::table('accioncorrectiva1s')
                   ->select('accioncorrectiva1s.*')
                   ->where('accioncorrectiva1s.idcompañia','=',$usuarios->id_compania)
                   ->where('accioncorrectiva1s.estatus_id','!=',3)
                   ->get());

                   $Noconformidades = \Illuminate\Support\Collection::make(\DB::table('noconformidades')
                   ->select('noconformidades.*')
                   ->where('noconformidades.idcompañia','=',$usuarios->id_compania)
                   ->get());
		  }

      //Para los modales
      $Users = new User;
      $User = $Users->where('id_compania',$usuarios->id_compania)->get();

      $Area = new Areas;
      $Areas = $Area->where('id_compania',$usuarios->id_compania)->get();

      $clientes = new Clientes;
      $cliente = $clientes->where('id_compania',$usuarios->id_compania)->get();

      $procesos = new Proceso;
      $proceso = $procesos->where('idcompañia',$usuarios->id_compania)->get();

      $indicador = \Illuminate\Support\Collection::make(\DB::table('indicadores')
                               ->leftjoin('objetivos','indicadores.objetivo_id','=','objetivos.id')
                               ->select('indicadores.*','objetivos.id_compania')
                               ->where('objetivos.id_compania','=',$usuarios->id_compania)
                               ->get());

      //Sin necesidad de separar
      $Links = new LinksInteres;
      $Link = $Links->where('id_empresa',$usuarios->id_compania)->get();

      $estatuses = new Estatus;
      $estatus = $estatuses->all();

      $producto = new Productos;
      $productos = $producto->where('idcompañia',$usuarios->id_compania)->get();

      $documentos = new Documentos;
      $documento = $documentos ->where('id_user',$usuarios->id)->get();

      $indicadores=new Indicadores;
      $indicadora = $indicadores->where('usuario_responsable_id',$usuarios->id)->get();

      $pendientes = new Pendientes;
      $pendiente = $pendientes->where('id_UsuarioAsignado',$usuarios->id)->get();

      $proveedores = new proveedores;
      $proveedor = $proveedores->where('id_compania',$usuarios->id_compania)->orderBy('id')->get();
      $cuentaproveedor = $proveedor->count();

      //Para super admin o partners
      if($usuarios->perfil == 1){
        $empresas = new Empresas;
        $empresa = $empresas->get();
      }else{
        $empresas = new Empresas;
        $empresa = $empresas->where('id_creador',$usuarios->id)->get();
      }

      $events = [];
      $options = [];

      if($usuarios->perfil == 4)
      {
        $allevents = \DB::table('event_models')
              ->join('lista_eventos', 'event_models.id', '=', 'lista_eventos.id_evento')
              ->select('event_models.*')
              ->where('lista_eventos.id_area',$usuarios->id_area)
              //->whereMonth('fecha_creacion', '=', date('m'))
              //dd( $noticiasw);
              ->get();

      }else{
        $allevents = \DB::table('event_models')
              ->join('lista_eventos', 'event_models.id', '=', 'lista_eventos.id_evento')
              ->select('event_models.*')
              ->where('lista_eventos.id_area',$usuarios->id_area)
              //->whereMonth('fecha_creacion', '=', date('m'))
              //dd( $noticiasw);
              ->get();

      }

//return(dd($allevents));

    foreach ($allevents as $event) {
        $events[] = \Calendar::event(
            $event->title,
            $event->Descripcion,
            $event->all_day,
            new \DateTime($event->start),
            new \DateTime($event->end),
            $event->id,
            $options= [//'url'=>$event->url,
                       'editable'=>$event->editable,
                       'color'=>$event->color]
         );

         }

// Para el calendario
  $calendar = \Calendar::addEvents($events) //add an array with addEvents
   ->setOptions(
     [//set fullcalendar options
     'firstDay' => 1,
     'locale' => 'mx']);


$calendar = \Calendar::setCallbacks([
    'eventClick' => 'function(calEvent, jsEvent, view) {
     $("#TituloEvento").text(calEvent.title);
     $("#id_eve").text(calEvent.id);
     $("#MensajeEvento").text(calEvent.descripcion);
     $("#mostrarevento").click();
 }',
 /*
 'dayClick' => 'function(date, jsEvent, view) {
    alert("Hello world");
 }',*/

 'eventMouseover' => 'function(calevent, jsEvent, view) {
  $(this).css("color", "black");
  $(this).css("font-weight", "bolder");
}',

'eventMouseout' => 'function(calevent, jsEvent, view) {
 $(this).css("color", "white");
 $(this).css("font-weight", "normal");
}',

     ]);
// termina Para el calendario

      return View('bienvenida',
      compact(
        'objetivo',
        'quejas',
        'proceso',
        'procesoa',
        'cuentaproveedor',
        'empresa',
        'noticiasw',
        'calendar',
        'documento',
        'indicador',
        'indicadora',
        'User',
        'pendiente',
        'accionesCorrectivas',
        'Noconformidades',
        'Areas',
        'cliente',
        'Link',
        'productos',
        'estatus',
        'mejorasid')
      );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function retornardocumento(Request $request)
    {
        if ($request->isMethod('post')){

          $documentos = new Documentos;
          $documento =
          $documentos ->where('id',$request->idDoc)
                      ->first();
          return response()->json(
          [
            'link' => $documento->id
          ]);
        }
    }
    public function retornarProceso(Request $request)
    {
      if ($request->isMethod('post')){

      $procesos = new Proceso;
      $proceso = $procesos->where('id',$request->idProceso);
      $archivoabrir = $proceso->nombreunicoarchivo;
      if (!empty($archivoabrir)) {
        $rutacompleta = public_path(). "/storage/$archivoabrir";
        //$rutacompleta = "public/storage/$archivoabrir";
        $zipper = new Zipper();
        $zipper->make($rutacompleta)->folder('')->extractTo('storage/bizagi');

        foreach ($zipper->listFiles() as $lista):
          if ((stripos($lista,"index.html") !== false))
          {
            $rutaalindex = $lista;
            // $rutaalindex2 = $lista;
          }
        endforeach;

        $rutaalindex = str_replace("/","\\",$rutaalindex);

        $rutaalindex = "\storage\bizagi\\$rutaalindex";
          return response()->json(
          [
            'link' => $rutaalindex
          ]);
        }
      }
    }
}
