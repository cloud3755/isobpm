<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
            $mejorasid = \DB::table('mejoras')
                   ->join('users','mejoras.responsable_id','=','users.id')
                   ->leftjoin('lista_accesos','mejoras.listaequipo','=','lista_accesos.id_indicador')
                   ->select('mejoras.id', 'mejoras.proyecto')
                   ->where('lista_accesos.id_usuario','=',$usuarios->id)
                   ->orwhere('mejoras.creador_id',$usuarios->id)
                   ->groupby('mejoras.id')
                   ->get();
		  }

		  else{
			     $mejorasid = \DB::table('mejoras')
                   ->join('users','mejoras.responsable_id','=','users.id')
                   
                   ->leftjoin('lista_accesos','mejoras.listaequipo','=','lista_accesos.id_indicador')
                   ->select('mejoras.id', 'mejoras.proyecto')
                   ->where('mejoras.id_compania',$usuarios->id_compania)
                   ->groupby('mejoras.id')
                   ->get();
		  }
      $noticiasw = \DB::table('noticias')
      ->join('lista_noticias', 'noticias.id', '=', 'lista_noticias.id_noticia')
      ->select('noticias.*')
      ->where('noticias.id_empresa',$usuarios->id_compania)
      ->where('lista_noticias.id_area',$usuarios->id_area)
      ->whereMonth('fecha_creacion', '=', date('m'))
      //dd( $noticiasw);
      ->get();

      $Links = new LinksInteres;
      $Link = $Links->where('id_empresa',$usuarios->id_compania)->get();

      $estatuses = new Estatus;
      $estatus = $estatuses->all();

      $producto = new Productos;  
      $productos = $producto->where('idcompañia',$usuarios->id_compania)->get();

      $documentos = new Documentos;
      $documento = $documentos ->where('id_user',$usuarios->id)->get();

      $pendientes = new Pendientes;
      $pendiente = $pendientes->where('id_UsuarioAsignado',$usuarios->id)->get();

      $indicadores=new Indicadores;
      $indicador = $indicadores->where('usuario_responsable_id',$usuarios->id)->get();

      $objetivos = new Objetivo;
      $objetivo = $objetivos->where('id_compania',$usuarios->id_compania)->get();

      $queja = new Quejas;
      $quejas = $queja->where('idcompañia',$usuarios->id_compania)->get();

      $accionCorrectiva = new Accioncorrectiva1;
      $accionesCorrectivas = $accionCorrectiva->where('idcompañia',$usuarios->id_compania)->get();

      $Noconformidad = new Noconformidades;
      $Noconformidades = $Noconformidad->where('idcompañia',$usuarios->id_compania)->get();

      $Area = new Areas;
      $Areas = $Area->where('id_compania',$usuarios->id_compania)->get();

      $Users = new User;
      $User = $Users->where('id_compania',$usuarios->id_compania)->get();

      $procesos = new Proceso;
      $proceso = $procesos->where('idcompañia',$usuarios->id_compania)->get();

      $proveedores = new proveedores;
      $proveedor = $proveedores->where('id_compania',$usuarios->id_compania)->orderBy('id')->get();
      $cuentaproveedor = $proveedor->count();


      if($usuarios->perfil == 1){
        $empresas = new Empresas;
        $empresa = $empresas->get();
      }else{
        $empresas = new Empresas;
        $empresa = $empresas->where('id_creador',$usuarios->id)->get();
      }

      $events = [];
      $options = [];

$allevents = \DB::table('event_models')
      ->join('lista_eventos', 'event_models.id', '=', 'lista_eventos.id_evento')
      ->select('event_models.*')
      ->where('lista_eventos.id_area',$usuarios->id_area)
      //->whereMonth('fecha_creacion', '=', date('m'))
      //dd( $noticiasw);
      ->get();

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
        'cuentaproveedor',
        'empresa', 
        'noticiasw',
        'calendar',
        'documento',
        'indicador',
        'User', 
        'pendiente',
        'accionesCorrectivas',
        'Noconformidades',
        'Areas',
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
