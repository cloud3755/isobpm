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
use Carbon\Carbon;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mail;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Models\EventModel;
use App\Models\proveedores;

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
      $noticias = new Noticias;
      $noticiasw = $noticias->where('id_empresa',$usuarios->id_compania)
      ->where('fecha_creacion',date("Y-m-d"))->get();

      $objetivos = new Objetivo;
      $objetivo = $objetivos->where('id_compania',$usuarios->id_compania)->get();

      $queja = new Quejas;
      $quejas = $queja->where('idcompañia',$usuarios->id_compania)->get();

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

$allevents = EventModel::all();
//return(dd($allevents));

    foreach ($allevents as $event) {
        $events[] = \Calendar::event(
            $event->title,
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
     'firstDay' => 1]
     );

$calendar = \Calendar::setCallbacks([
    'eventClick' => 'function(calEvent, jsEvent, view) {
     alert("Click en evento: "+ calEvent.id );
 }',

 'dayClick' => 'function(date, jsEvent, view) {
    alert("Hello world");
 }',

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

      return View('bienvenida', compact('objetivo', 'quejas','proceso','cuentaproveedor','empresa', 'noticiasw','calendar'));
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
}
