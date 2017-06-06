<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Proceso;
use App\Models\User;
use App\Models\tipoproceso;
use App\Models\Analisisriesgos;
use App\Models\Abcriesgos;
use App\Models\Areas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnalisisriesgosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $Users = Auth::user();
      $procesos = new Proceso;
      $proceso = $procesos->where('idcompañia',$Users->id_compania)->get();

      $Users = new User;
      $User = $Users->all();

      $tipoprocesos = new tipoproceso;
      $tipoproceso = $tipoprocesos->orderBy('id')->get();

      $areas = new Areas;
      $area = $areas->all();


      //dd($objetivos->all());
      //return view('CreateProceso',compact('proceso','user')); //=> $proceso->toArray()], User);
      return View('/Principales/ProcesosDeRiesgos', compact('proceso','User','tipoproceso','area'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $Users = Auth::user();

     //return(dd($request));
      $Analisisriesgo = new Analisisriesgos;
      $Analisisriesgo->procesos_id = $request->input('procesos_id');
      $Analisisriesgo->actividad = $request->input('actividad');
      $Analisisriesgo->riesgo_id = $request->input('riesgo_id');

      $Analisisriesgo->descripcion_modo_falla = $request->input('descripcion_modo_falla');
      $Analisisriesgo->Severidad = $request->input('Severidad');
      $Analisisriesgo->probabilidad = $request->input('probabilidad');

      $Analisisriesgo->riesgo_inherente = $request->input('Severidad') * $request->input('probabilidad');

      $Analisisriesgo->controles = $request->input('controles');
      $Analisisriesgo->Severidad2 = $request->input('Severidad2');
      $Analisisriesgo->probabilidad2 = $request->input('probabilidad2');

      $Analisisriesgo->riesgo_residual = $request->input('Severidad2') * $request->input('probabilidad2');

      $Analisisriesgo->idcompañia = $Users->id_compania;
      $Analisisriesgo->id_area = $request->input('id_area');

      $Analisisriesgo->save();

      return redirect('/riesgos/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $Users = Auth::user();
      $procesos = new Proceso;
      $proceso = $procesos->where('ID',$id)->first();

      $Analisisriesgos = new Analisisriesgos;
      $Analisisriesgo = $Analisisriesgos->where('procesos_id',$id)->get();

      $analisisriesgo2 = \DB::table('analisisriesgos')
                               ->join('abcriesgos','analisisriesgos.riesgo_id','=','abcriesgos.id')
                               ->select('analisisriesgos.*','abcriesgos.nombre as riesgo_nombre')
                               ->where('analisisriesgos.procesos_id',$id)
                               ->get();

     //return(dd($analisisriesgo2));

      $Abcriesgos = new Abcriesgos;
      $Abcriesgo = $Abcriesgos->where('id_compania',$Users->id_compania)->get();

      $procesosrelacion = \DB::table('procesos')
                               ->select('procesos.*','users.nombre')
                               ->join('users','procesos.usuario_responsable_id','=','users.id')
                               ->where('procesos.id',$id)->first();

      //return(dd($procesosrelacion));
      $listaenvio = \DB::table('users')
                        ->leftjoin('lista_envios','users.id', '=', 'lista_envios.id_usuario')
                        ->select('lista_envios.id_proceso','users.id','users.usuario')
                  //      ->leftjoin('procesos','lista_envios.id_proceso','=','procesos.lista_de_distribucion')
                  //      ->where('lista_envios.id_proceso',$lista)
                        ->get();

      //return(dd($listaenvios));

      $indicadoresrelacion = \DB::table('indicadores')
                               ->select('lista_indicadores_procesos.id_proceso','indicadores.id','indicadores.nombre')
                               ->leftjoin('lista_indicadores_procesos','indicadores.id','=','lista_indicadores_procesos.id_indicador')
                  //             ->leftjoin('procesos','lista_indicadores_procesos.id_proceso','=','procesos.indicadores')
                  //             ->where('lista_indicadores_procesos.id_proceso',$indicator)
                               ->get();

      $areas = new Areas;
      $area = $areas->where('id_compania',$Users->id_compania)->get();


      //para validar si trae los campos correctos
      //dd($resultado->all());
      return View('/Secundarias/RiesgosMostrar', compact('proceso', 'Analisisriesgo','analisisriesgo2','Abcriesgo','procesosrelacion','listaenvio','indicadoresrelacion','area'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {

      //return(dd($request));
       $Analisisriesgo = Analisisriesgos::findorfail($id);
       $Analisisriesgo->procesos_id = $request->input('procesos_id');
       $Analisisriesgo->actividad = $request->input('actividad');
       $Analisisriesgo->riesgo_id = $request->input('riesgo_id');

       $Analisisriesgo->descripcion_modo_falla = $request->input('descripcion_modo_falla');
       $Analisisriesgo->Severidad = $request->input('Severidad');
       $Analisisriesgo->probabilidad = $request->input('probabilidad');

       $Analisisriesgo->riesgo_inherente = $request->input('Severidad') * $request->input('probabilidad');

       $Analisisriesgo->controles = $request->input('controles');
       $Analisisriesgo->Severidad2 = $request->input('Severidad2');
       $Analisisriesgo->probabilidad2 = $request->input('probabilidad2');

       $Analisisriesgo->riesgo_residual = $request->input('Severidad2') * $request->input('probabilidad2');

       $Analisisriesgo->idcompañia = $Users->id_compania;
       $Analisisriesgo->id_area = $request->input('id_area');

       $Analisisriesgo->save();

       return redirect('/riesgos/create');
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
      $Analisisriesgos = Analisisriesgos::findorfail($id);
      $Analisisriesgos-> delete();
      return Redirect('/riesgos/create');
    }
}
