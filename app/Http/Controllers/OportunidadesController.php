<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Abcoportunidades;
use App\Models\Tipooportunidades;
use App\Models\Oportunidades;
use App\Models\User;
use App\Models\Proceso;
use App\Models\tipoproceso;
use App\Models\Areas;
use Illuminate\Support\Facades\Auth;


class OportunidadesController extends Controller
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
      $usuarios = Auth::user();
      $Abcoportunidades = new Abcoportunidades;
      $Abcoportunidad = $Abcoportunidades->where('id_compania',$usuarios->id_compania)->get();

      $Tipooportunidades = new Tipooportunidades;
      $Tipooportunidad = $Tipooportunidades->all();

      $oportunidadrelacion = \DB::table('abcoportunidades')
                               ->leftjoin('tipooportunidades','abcoportunidades.tipo_oportunidad_id','=','tipooportunidades.id')
                               ->select('abcoportunidades.*','tipooportunidades.id as tipo_id','tipooportunidades.nombre as tipo_nombre')
                               ->where('abcoportunidades.id_compania',$usuarios->id_compania)
                               ->get();

      //return(dd($riesgorelacion));
      return View('/Principales/abcoportunidad', compact('Abcoportunidad', 'Tipooportunidad','oportunidadrelacion'));
    }

    public function createproceso()
    {
      $Users = Auth::user();

      if ($Users->perfil == 4) {
        $iduser = $Users->id;
        $collection_one = \Illuminate\Support\Collection::make(DB::table('procesos')
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
        ->leftjoin('lista_envios', function($join) use ($iduser)
          {
              $join->on('procesos.lista_de_distribucion', '=', 'lista_envios.id_proceso');
              $join->on(function($query) use ($iduser)
              {
                $query->on('lista_envios.id_usuario', '=', DB::raw("'".$iduser."'"));
              });
          })
        ->whereNull('id_proceso')
        ->where('usuario_responsable_id',$Users->id)
        ->orwhere(function ($querys) use ($iduser) {
          $querys->whereNull('id_proceso')
          ->Where('Creador_id', '=', DB::raw("'".$iduser."'"));
        })
        ->get());

        $proceso = new \Illuminate\Database\Eloquent\Collection;
        $proceso = $collection_one->merge($collection_two);
      }else {
        $procesos = new Proceso;
        $proceso = $procesos
        ->where('idcompañia',$Users->id_compania)
        ->get();
      }

      $Users = new User;
      $User = $Users->all();

      $tipoprocesos = new tipoproceso;
      $tipoproceso = $tipoprocesos->orderBy('id')->get();

      $areas = new Areas;
      $area = $areas->all();


      //dd($objetivos->all());
      //return view('CreateProceso',compact('proceso','user')); //=> $proceso->toArray()], User);
      return View('/Principales/ProcesosDeOportunidad', compact('proceso','User','tipoproceso','area'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $usuarios = Auth::user();
      $Abcoportunidad = new Abcoportunidades;
      $Abcoportunidad->tipo_oportunidad_id = $request->input('tipo_id_oportunidad');
      $Abcoportunidad->nombre = $request->input('oportunidad');
      $Abcoportunidad->descripcion = $request->input('descripcion');
      $Abcoportunidad->id_compania = $usuarios->id_compania;
      $Abcoportunidad->save();

      return redirect('abcoportunidades/create');
    }

    public function anastore(Request $request)
    {
      $Users = Auth::user();

     //return(dd($request));
      $Oportunidades = new Oportunidades;
      $Oportunidades->procesos_id = $request->input('procesos_id');
      $Oportunidades->actividad = $request->input('actividad');
      $Oportunidades->oportunidad_id = $request->input('oportunidad_id');

      $Oportunidades->descripcion_modo_falla = $request->input('descripcion_modo_falla');
      $Oportunidades->esfuerzo = $request->input('esfuerzo');
      $Oportunidades->impacto = $request->input('impacto');

      $Oportunidades->oportunidad_potencial = $request->input('esfuerzo') * $request->input('impacto');

      $Oportunidades->controles = $request->input('controles');
      $Oportunidades->esfuerzo2 = $request->input('esfuerzo2');
      $Oportunidades->impacto2 = $request->input('impacto2');

      $Oportunidades->oportunidad_real = $request->input('esfuerzo2') * $request->input('impacto2');

      $Oportunidades->idcompañia = $Users->id_compania;
      $Oportunidades->id_area = $request->input('id_area');

      $Oportunidades->save();

      return redirect()->action('OportunidadesController@show', [$Oportunidades->procesos_id]);
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

       $Oportunidad2 = \DB::table('oportunidades')
                                ->join('abcoportunidades','oportunidades.oportunidad_id','=','abcoportunidades.id')
                                ->select('oportunidades.*','abcoportunidades.nombre as oportunidad_nombre')
                                ->where('oportunidades.procesos_id',$id)
                                ->get();

      //return(dd($analisisriesgo2));

       $Abcoportunidades = new Abcoportunidades;
       $Abcoportunidad = $Abcoportunidades->where('id_compania',$Users->id_compania)->get();

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
       return View('/Secundarias/OportunidadesMostrar', compact('proceso','Oportunidad2','Abcoportunidad','procesosrelacion','listaenvio','indicadoresrelacion','area'));
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
      $Abcoportunidad = Abcoportunidades::findorfail($id);
      $Abcoportunidad->tipo_oportunidad_id = $request->input('etipo_id_oportunidad');
      $Abcoportunidad->nombre = $request->input('eoportunidad');
      $Abcoportunidad->descripcion = $request->input('edescripcion');
      $Abcoportunidad->save();

      return redirect('abcoportunidades/create');
    }

    public function anaedit($id,Request $request)
    {
      $Oportunidad = Oportunidades::findorfail($id);

      $Oportunidad->actividad = $request->input('eactividad');
      $Oportunidad->oportunidad_id = $request->input('eoportunidad_id');

      $Oportunidad->descripcion_modo_falla = $request->input('edescripcion_modo_falla');
      $Oportunidad->esfuerzo = $request->input('eesfuerzo');
      $Oportunidad->impacto = $request->input('eimpacto');

      $Oportunidad->oportunidad_potencial = $request->input('eesfuerzo') * $request->input('eimpacto');

      $Oportunidad->controles = $request->input('econtroles');
      $Oportunidad->esfuerzo2 = $request->input('eesfuerzo2');
      $Oportunidad->impacto2 = $request->input('eimpacto2');

      $Oportunidad->oportunidad_real = $request->input('eesfuerzo2') * $request->input('eimpacto2');

      $Oportunidad->id_area = $request->input('eid_area');
      $Oportunidad->save();

      return redirect()->action('OportunidadesController@show', [$Oportunidad->procesos_id]);
    }


    public function editM($id)
    {
      $abcoportunidades = Abcoportunidades::find($id);
        return response()->json(
          $abcoportunidades->toArray()
        );
    }

    public function anaeditM($id)
    {
      $oportunidades = Oportunidades::find($id);
        return response()->json(
          $oportunidades->toArray()
        );
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
      $Abcoportunidad = Abcoportunidades::find($id);
      if (is_null ($Abcoportunidad))
      {
          App::abort(404);
      }

      $Abcoportunidad->delete();

      return redirect('abcoportunidades/create');
    }

    public function anadestroy($id)
    {
      $Oportunidad = Oportunidades::find($id);
      if (is_null ($Oportunidad))
      {
          App::abort(404);
      }
      $proceso = $Oportunidad->procesos_id;
      $Oportunidad->delete();

      return redirect()->action('OportunidadesController@show', [$proceso]);
    }


    //Mapa de calor funciones

    public function mapaindex()
    {
      $usuarios = Auth::user();

      $areas = new Areas;
      $area = $areas->where('id_compania',$usuarios->id_compania)->get();
      $user = $usuarios->id;

      if ($usuarios->perfil == 4) {
        $proceso = \Illuminate\Support\Collection::make(DB::table('procesos')
        ->select('procesos.*')
        ->leftjoin('lista_envios', function($join) use ($user)
          {
              $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
              $join->on(function($query) use ($user)
              {
                $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
              });
          })
        ->where('idcompañia',$usuarios->id_compania)
        ->WhereNotNull('lista_envios.id_usuario')
        ->orwhere('usuario_responsable_id',$usuarios->id)
        ->orwhere('Creador_id',$usuarios->id)
        ->get());

      }else {
        $proceso = \Illuminate\Support\Collection::make(DB::table('procesos')->where('idcompañia',$usuarios->id_compania)->get());
      }

      $Abcriesgos = new Abcoportunidades;
      $Abcriesgo = $Abcriesgos->where('id_compania',$usuarios->id_compania)->get();

      if ($usuarios->perfil == 4) {
        $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('oportunidades')
        ->select('oportunidades.*','procesos.lista_de_distribucion')
        ->join('procesos','procesos.id','=','oportunidades.procesos_id')
        ->leftjoin('lista_envios', function($join) use ($user)
          {
              $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
              $join->on(function($query) use ($user)
              {
                $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
              });
          })
        ->where('oportunidades.idcompañia',$usuarios->id_compania)
        ->WhereNotNull('lista_envios.id_usuario')
        ->orwhere('procesos.Creador_id' ,$usuarios->id)
        ->orwhere('procesos.usuario_responsable_id' ,$usuarios->id)
        ->get());


        $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','1')->count();
        $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','2')->count();
        $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','3')->count();
        $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','1')->count();
        $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','2')->count();
        $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','3')->count();
        $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','1')->count();
        $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','2')->count();
        $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','3')->count();

        $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','1')->count();
        $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','2')->count();
        $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','3')->count();
        $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','1')->count();
        $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','2')->count();
        $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','3')->count();
        $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','1')->count();
        $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','2')->count();
        $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','3')->count();
      }else {
        $Analisisriesgos = new Oportunidades;
        $Analisisriesgo = $Analisisriesgos->where('idcompañia',$usuarios->id_compania)->get();

        $riskmap_11 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 1)->where('impacto',1)->count();
        $riskmap_12 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 1)->where('impacto',2)->count();
        $riskmap_13 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 1)->where('impacto',3)->count();
        $riskmap_21 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 2)->where('impacto',1)->count();
        $riskmap_22 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 2)->where('impacto',2)->count();
        $riskmap_23 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 2)->where('impacto',3)->count();
        $riskmap_31 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 3)->where('impacto',1)->count();
        $riskmap_32 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 3)->where('impacto',2)->count();
        $riskmap_33 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 3)->where('impacto',3)->count();

        $riskmap2_11 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 1)->where('impacto2',1)->count();
        $riskmap2_12 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 1)->where('impacto2',2)->count();
        $riskmap2_13 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 1)->where('impacto2',3)->count();
        $riskmap2_21 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 2)->where('impacto2',1)->count();
        $riskmap2_22 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 2)->where('impacto2',2)->count();
        $riskmap2_23 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 2)->where('impacto2',3)->count();
        $riskmap2_31 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 3)->where('impacto2',1)->count();
        $riskmap2_32 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 3)->where('impacto2',2)->count();
        $riskmap2_33 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 3)->where('impacto2',3)->count();
      }




        return view('/Principales/Dashboard/mapadecaloroportunidad',compact('Analisisriesgo','area','proceso','Abcriesgo','riskmap_11','riskmap_12','riskmap_13','riskmap_21','riskmap_22','riskmap_23','riskmap_31','riskmap_32','riskmap_33',
        'riskmap2_11','riskmap2_12','riskmap2_13','riskmap2_21','riskmap2_22','riskmap2_23','riskmap2_31','riskmap2_32','riskmap2_33'));
    }


    public function mapaindexfiltros(Request $request)
    {
      $usuarios = Auth::user();
      if ($usuarios->perfil == 4) {
        if ($request->input('areas') == 0 and $request->input('procesos') == 0 and $request->input('tipos') == 0){

          $user = $usuarios->id;
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('oportunidades')
          ->select('oportunidades.*','procesos.lista_de_distribucion')
          ->join('procesos','procesos.id','=','oportunidades.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('oportunidades.idcompañia',$usuarios->id_compania)
          ->WhereNotNull('lista_envios.id_usuario')
          ->orwhere('procesos.Creador_id' ,$usuarios->id)
          ->orwhere('procesos.usuario_responsable_id' ,$usuarios->id)
          ->get());

          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','3')->count();

        }
        elseif($request->input('areas') != 0 and $request->input('procesos') == 0 and $request->input('tipos') == 0){

          $user = $usuarios->id;
          $area1 = $request->input('areas');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('oportunidades')
          ->select('oportunidades.*','procesos.lista_de_distribucion')
          ->join('procesos','procesos.id','=','oportunidades.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('oportunidades.idcompañia',$usuarios->id_compania)
          ->where('id_area',$request->input('areas'))
          ->WhereNotNull('lista_envios.id_usuario')
          ->orWhere(function ($query2) use ($user,$area1){
            $query2->where('procesos.Creador_id' ,$user)
            ->where('id_area', $area1);
          })
          ->orWhere(function ($query2) use ($user,$area1){
            $query2->where('procesos.usuario_responsable_id' ,$user)
            ->where('id_area', $area1);
          })
          ->get());

          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','3')->count();
        }
        elseif($request->input('areas') == 0 and $request->input('procesos') != 0 and $request->input('tipos') == 0){

          $user = $usuarios->id;
          $procesos1 = $request->input('procesos');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('oportunidades')
          ->select('oportunidades.*','procesos.lista_de_distribucion')
          ->join('procesos','procesos.id','=','oportunidades.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('oportunidades.idcompañia',$usuarios->id_compania)
          ->where('procesos_id',$request->input('procesos'))
          ->WhereNotNull('lista_envios.id_usuario')
          ->orWhere(function ($query2) use ($user,$procesos1){
            $query2->where('procesos.Creador_id' ,$user)
            ->where('procesos_id',$procesos1);
          })
          ->orWhere(function ($query2) use ($user,$procesos1){
            $query2->where('procesos.usuario_responsable_id' ,$user)
            ->where('procesos_id',$procesos1);
          })
          ->get());


          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','3')->count();

        }
        elseif($request->input('areas') == 0 and $request->input('procesos') == 0 and $request->input('tipos') != 0){

          $user = $usuarios->id;
          $tipo1 = $request->input('tipos');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('oportunidades')
          ->select('oportunidades.*','procesos.lista_de_distribucion')
          ->join('procesos','procesos.id','=','oportunidades.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('oportunidades.idcompañia',$usuarios->id_compania)
          ->where('oportunidad_id',$tipo1)
          ->WhereNotNull('lista_envios.id_usuario')
          ->orWhere(function ($query2) use ($user,$tipo1){
            $query2->where('procesos.Creador_id' ,$user)
            ->where('oportunidad_id',$tipo1);
          })
          ->orWhere(function ($query2) use ($user,$tipo1){
            $query2->where('procesos.usuario_responsable_id' ,$user)
            ->where('oportunidad_id',$tipo1);
          })
          ->get());


          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','3')->count();

        }
        elseif($request->input('areas') != 0 and $request->input('procesos') != 0 and $request->input('tipos') == 0){

          $user = $usuarios->id;
          $area1 = $request->input('areas');
          $proceso1 = $request->input('procesos');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('oportunidades')
          ->select('oportunidades.*','procesos.lista_de_distribucion')
          ->join('procesos','procesos.id','=','oportunidades.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('oportunidades.idcompañia',$usuarios->id_compania)
          ->where('id_area',$area1)
          ->where('procesos_id',$proceso1)
          ->WhereNotNull('lista_envios.id_usuario')
          ->orWhere(function ($query2) use ($user,$area1,$proceso1){
            $query2->where('procesos.Creador_id' ,$user)
            ->where('id_area',$area1)
            ->where('procesos_id',$proceso1);
          })
          ->orWhere(function ($query2) use ($user,$area1,$proceso1){
            $query2->where('procesos.usuario_responsable_id' ,$user)
            ->where('id_area',$area1)
            ->where('procesos_id',$proceso1);
          })
          ->get());

          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','3')->count();
        }
        elseif($request->input('areas') != 0 and $request->input('procesos') != 0 and $request->input('tipos') != 0){
                //return dd($request);
          $user = $usuarios->id;
          $area1 = $request->input('areas');
          $tipo1 = $request->input('tipos');
          $proceso1 = $request->input('procesos');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('oportunidades')
          ->select('oportunidades.*','procesos.lista_de_distribucion')
          ->join('procesos','procesos.id','=','oportunidades.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('oportunidades.idcompañia',$usuarios->id_compania)
          ->where('id_area',$area1)
          ->where('oportunidad_id',$tipo1)
          ->where('procesos_id',$proceso1)
          ->WhereNotNull('lista_envios.id_usuario')
          ->orWhere(function ($query2) use ($user,$area1,$proceso1,$tipo1){
            $query2->where('procesos.Creador_id' ,$user)
            ->where('id_area',$area1)
            ->where('procesos_id',$proceso1)
            ->where('oportunidad_id',$tipo1);
          })
          ->orWhere(function ($query2) use ($user,$area1,$proceso1,$tipo1){
            $query2->where('procesos.usuario_responsable_id' ,$user)
            ->where('id_area',$area1)
            ->where('procesos_id',$proceso1)
            ->where('oportunidad_id',$tipo1);
          })
          ->get());

          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','3')->count();

        }
        elseif($request->input('areas') != 0 and $request->input('procesos') == 0 and $request->input('tipos') != 0){
          //return dd($request);
          $user = $usuarios->id;
          $area1 = $request->input('areas');
          $tipo1 = $request->input('tipos');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('oportunidades')
          ->select('oportunidades.*','procesos.lista_de_distribucion')
          ->join('procesos','procesos.id','=','oportunidades.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('oportunidades.idcompañia',$usuarios->id_compania)
          ->where('id_area',$area1)
          ->where('oportunidad_id',$tipo1)
          ->WhereNotNull('lista_envios.id_usuario')
          ->orWhere(function ($query2) use ($user,$area1,$tipo1){
            $query2->where('procesos.Creador_id' ,$user)
            ->where('id_area',$area1)
            ->where('oportunidad_id',$tipo1);
          })
          ->orWhere(function ($query2) use ($user,$area1,$tipo1){
            $query2->where('procesos.usuario_responsable_id' ,$user)
            ->where('id_area',$area1)
            ->where('oportunidad_id',$tipo1);
          })
          ->get());

          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','3')->count();

        }
        elseif($request->input('areas') == 0 and $request->input('procesos') != 0 and $request->input('tipos') != 0){

          $user = $usuarios->id;
          $tipo1 = $request->input('tipos');
          $proceso1 = $request->input('procesos');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('oportunidades')
          ->select('oportunidades.*','procesos.lista_de_distribucion')
          ->join('procesos','procesos.id','=','oportunidades.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('oportunidades.idcompañia',$usuarios->id_compania)
          ->where('oportunidad_id',$tipo1)
          ->where('procesos_id',$proceso1)
          ->WhereNotNull('lista_envios.id_usuario')
          ->orWhere(function ($query2) use ($user,$tipo1,$proceso1){
            $query2->where('procesos.Creador_id' ,$user)
            ->where('procesos_id',$proceso1)
            ->where('oportunidad_id',$tipo1);
          })
          ->orWhere(function ($query2) use ($user,$tipo1,$proceso1){
            $query2->where('procesos.usuario_responsable_id' ,$user)
            ->where('procesos_id',$proceso1)
            ->where('oportunidad_id',$tipo1);
          })
          ->get());

          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '1')->where('impacto','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '2')->where('impacto','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', '3')->where('impacto','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '1')->where('impacto2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '2')->where('impacto2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', '3')->where('impacto2','3')->count();

        }

      }else {
        if ($request->input('areas') == 0 and $request->input('procesos') == 0 and $request->input('tipos') == 0){

          $Analisisriesgos = new Oportunidades;
          $Analisisriesgo = $Analisisriesgos->where('idcompañia',$usuarios->id_compania)->get();
          $riskmap_11 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 1)->where('impacto',1)->count();
          $riskmap_12 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 1)->where('impacto',2)->count();
          $riskmap_13 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 1)->where('impacto',3)->count();
          $riskmap_21 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 2)->where('impacto',1)->count();
          $riskmap_22 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 2)->where('impacto',2)->count();
          $riskmap_23 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 2)->where('impacto',3)->count();
          $riskmap_31 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 3)->where('impacto',1)->count();
          $riskmap_32 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 3)->where('impacto',2)->count();
          $riskmap_33 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo', 3)->where('impacto',3)->count();

          $riskmap2_11 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 1)->where('impacto2',1)->count();
          $riskmap2_12 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 1)->where('impacto2',2)->count();
          $riskmap2_13 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 1)->where('impacto2',3)->count();
          $riskmap2_21 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 2)->where('impacto2',1)->count();
          $riskmap2_22 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 2)->where('impacto2',2)->count();
          $riskmap2_23 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 2)->where('impacto2',3)->count();
          $riskmap2_31 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 3)->where('impacto2',1)->count();
          $riskmap2_32 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 3)->where('impacto2',2)->count();
          $riskmap2_33 = DB::table('oportunidades')->where('idcompañia',$usuarios->id_compania)->where('esfuerzo2', 3)->where('impacto2',3)->count();


        }
        elseif($request->input('areas') != 0 and $request->input('procesos') == 0 and $request->input('tipos') == 0){

          $Analisisriesgos = new Oportunidades;
          $Analisisriesgo = $Analisisriesgos->where('id_area',$request->input('areas'))->get();
          $riskmap_11 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',1)->where('id_area',$request->input('areas'))->count();
          $riskmap_12 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',2)->where('id_area',$request->input('areas'))->count();
          $riskmap_13 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',3)->where('id_area',$request->input('areas'))->count();
          $riskmap_21 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',1)->where('id_area',$request->input('areas'))->count();
          $riskmap_22 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',2)->where('id_area',$request->input('areas'))->count();
          $riskmap_23 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',3)->where('id_area',$request->input('areas'))->count();
          $riskmap_31 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',1)->where('id_area',$request->input('areas'))->count();
          $riskmap_32 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',2)->where('id_area',$request->input('areas'))->count();
          $riskmap_33 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',3)->where('id_area',$request->input('areas'))->count();

          $riskmap2_11 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',1)->where('id_area',$request->input('areas'))->count();
          $riskmap2_12 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',2)->where('id_area',$request->input('areas'))->count();
          $riskmap2_13 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',3)->where('id_area',$request->input('areas'))->count();
          $riskmap2_21 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',1)->where('id_area',$request->input('areas'))->count();
          $riskmap2_22 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',2)->where('id_area',$request->input('areas'))->count();
          $riskmap2_23 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',3)->where('id_area',$request->input('areas'))->count();
          $riskmap2_31 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',1)->where('id_area',$request->input('areas'))->count();
          $riskmap2_32 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',2)->where('id_area',$request->input('areas'))->count();
          $riskmap2_33 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',3)->where('id_area',$request->input('areas'))->count();

        }
        elseif($request->input('areas') == 0 and $request->input('procesos') != 0 and $request->input('tipos') == 0){

          $Analisisriesgos = new Oportunidades;
          $Analisisriesgo = $Analisisriesgos->where('procesos_id',$request->input('procesos'))->get();
          $riskmap_11 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',1)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_12 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',2)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_13 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',3)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_21 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',1)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_22 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',2)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_23 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',3)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_31 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',1)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_32 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',2)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_33 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',3)->where('procesos_id',$request->input('procesos'))->count();

          $riskmap2_11 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',1)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_12 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',2)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_13 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',3)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_21 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',1)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_22 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',2)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_23 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',3)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_31 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',1)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_32 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',2)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_33 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',3)->where('procesos_id',$request->input('procesos'))->count();

        }
        elseif($request->input('areas') == 0 and $request->input('procesos') == 0 and $request->input('tipos') != 0){

          $Analisisriesgos = new Oportunidades;
          $Analisisriesgo = $Analisisriesgos->where('oportunidad_id',$request->input('tipos'))->get();
          $riskmap_11 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',1)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_12 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',2)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_13 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',3)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_21 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',1)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_22 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',2)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_23 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',3)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_31 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',1)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_32 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',2)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_33 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',3)->where('oportunidad_id',$request->input('tipos'))->count();

          $riskmap2_11 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',1)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_12 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',2)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_13 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',3)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_21 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',1)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_22 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',2)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_23 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',3)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_31 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',1)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_32 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',2)->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_33 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',3)->where('oportunidad_id',$request->input('tipos'))->count();

        }
        elseif($request->input('areas') != 0 and $request->input('procesos') != 0 and $request->input('tipos') == 0){

                  //return dd($request);
          $Analisisriesgos = new Oportunidades;
          $Analisisriesgo = $Analisisriesgos->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->get();
          $riskmap_11 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_12 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_13 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_21 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_22 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_23 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_31 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_32 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_33 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();

          $riskmap2_11 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_12 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_13 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_21 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_22 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_23 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_31 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_32 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_33 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
        }
        elseif($request->input('areas') != 0 and $request->input('procesos') != 0 and $request->input('tipos') != 0){
                //return dd($request);
          $Analisisriesgos = new Oportunidades;
          $Analisisriesgo = $Analisisriesgos->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->get();
          $riskmap_11 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_12 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_13 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_21 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_22 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_23 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_31 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_32 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_33 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();

          $riskmap2_11 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_12 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_13 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_21 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_22 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_23 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_31 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_32 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_33 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();


        }
        elseif($request->input('areas') != 0 and $request->input('procesos') == 0 and $request->input('tipos') != 0){
          //return dd($request);
          $Analisisriesgos = new Oportunidades;
          $Analisisriesgo = $Analisisriesgos->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->get();
          $riskmap_11 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',1)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_12 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',2)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_13 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',3)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_21 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',1)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_22 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',2)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_23 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',3)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_31 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',1)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_32 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',2)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_33 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',3)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();

          $riskmap2_11 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',1)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_12 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',2)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_13 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',3)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_21 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',1)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_22 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',2)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_23 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',3)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_31 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',1)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_32 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',2)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_33 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',3)->where('id_area',$request->input('areas'))->where('oportunidad_id',$request->input('tipos'))->count();

        }
        elseif($request->input('areas') == 0 and $request->input('procesos') != 0 and $request->input('tipos') != 0){

          //return dd($request);
          $Analisisriesgos = new Oportunidades;
          $Analisisriesgo = $Analisisriesgos->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->get();
          $riskmap_11 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',1)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_12 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',2)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_13 = DB::table('oportunidades')->where('esfuerzo', 1)->where('impacto',3)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_21 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',1)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_22 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',2)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_23 = DB::table('oportunidades')->where('esfuerzo', 2)->where('impacto',3)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_31 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',1)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_32 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',2)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap_33 = DB::table('oportunidades')->where('esfuerzo', 3)->where('impacto',3)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();

          $riskmap2_11 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',1)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_12 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',2)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_13 = DB::table('oportunidades')->where('esfuerzo2', 1)->where('impacto2',3)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_21 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',1)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_22 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',2)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_23 = DB::table('oportunidades')->where('esfuerzo2', 2)->where('impacto2',3)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_31 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',1)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_32 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',2)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();
          $riskmap2_33 = DB::table('oportunidades')->where('esfuerzo2', 3)->where('impacto2',3)->where('procesos_id',$request->input('procesos'))->where('oportunidad_id',$request->input('tipos'))->count();


        }

      }


            $areas = new Areas;
            $area = $areas->where('id_compania',$usuarios->id_compania)->get();

            $user = $usuarios->id;

            if ($usuarios->perfil == 4) {
              $proceso = \Illuminate\Support\Collection::make(DB::table('procesos')
              ->select('procesos.*')
              ->leftjoin('lista_envios', function($join) use ($user)
                {
                    $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                    $join->on(function($query) use ($user)
                    {
                      $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                    });
                })
              ->where('idcompañia',$usuarios->id_compania)
              ->WhereNotNull('lista_envios.id_usuario')
              ->orwhere('usuario_responsable_id',$usuarios->id)
              ->orwhere('Creador_id',$usuarios->id)
              ->get());

            }else {
              $proceso = \Illuminate\Support\Collection::make(DB::table('procesos')->where('idcompañia',$usuarios->id_compania)->get());
            }
            $Abcriesgos = new Abcoportunidades;
            $Abcriesgo = $Abcriesgos->where('id_compania',$usuarios->id_compania)->get();


            return view('/Principales/Dashboard/mapadecaloroportunidad',compact('Analisisriesgo','riskmap_11','riskmap_12','riskmap_13','riskmap_21','riskmap_22','riskmap_23','riskmap_31','riskmap_32','riskmap_33',
            'riskmap2_11','riskmap2_12','riskmap2_13','riskmap2_21','riskmap2_22','riskmap2_23','riskmap2_31','riskmap2_32','riskmap2_33','area','proceso','Abcriesgo'));
    }




}
