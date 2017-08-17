<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\tipoproceso;
use App\Models\Analisisriesgos;
use App\Models\Abcriesgos;
use App\Models\Areas;
use App\Models\Proceso;
use Illuminate\Support\Facades\Auth;



class mapadecalorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

      $Abcriesgos = new Abcriesgos;
      $Abcriesgo = $Abcriesgos->where('id_compania',$usuarios->id_compania)->get();

      if ($usuarios->perfil == 4) {
        $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
        ->select('analisisriesgos.*','procesos.lista_de_distribucion','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
        ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
        ->join('areas','areas.id','=','analisisriesgos.id_area')
        ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
        ->leftjoin('lista_envios', function($join) use ($user)
          {
              $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
              $join->on(function($query) use ($user)
              {
                $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
              });
          })
        ->where('analisisriesgos.idcompañia',$usuarios->id_compania)
        ->WhereNotNull('lista_envios.id_usuario')
        ->orwhere('procesos.Creador_id' ,$usuarios->id)
        ->orwhere('procesos.usuario_responsable_id' ,$usuarios->id)
        ->get());


        $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','1')->count();
        $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','2')->count();
        $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','3')->count();
        $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','1')->count();
        $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','2')->count();
        $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','3')->count();
        $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','1')->count();
        $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','2')->count();
        $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','3')->count();

        $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','1')->count();
        $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','2')->count();
        $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','3')->count();
        $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','1')->count();
        $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','2')->count();
        $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','3')->count();
        $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','1')->count();
        $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','2')->count();
        $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','3')->count();
      }else {
        $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
        ->select('analisisriesgos.*','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
        ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
        ->join('areas','areas.id','=','analisisriesgos.id_area')
        ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
        ->where('analisisriesgos.idcompañia',$usuarios->id_compania)->get());

        $riskmap_11 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 1)->where('probabilidad',1)->count();
        $riskmap_12 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 1)->where('probabilidad',2)->count();
        $riskmap_13 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 1)->where('probabilidad',3)->count();
        $riskmap_21 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 2)->where('probabilidad',1)->count();
        $riskmap_22 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 2)->where('probabilidad',2)->count();
        $riskmap_23 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 2)->where('probabilidad',3)->count();
        $riskmap_31 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 3)->where('probabilidad',1)->count();
        $riskmap_32 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 3)->where('probabilidad',2)->count();
        $riskmap_33 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 3)->where('probabilidad',3)->count();

        $riskmap2_11 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 1)->where('probabilidad2',1)->count();
        $riskmap2_12 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 1)->where('probabilidad2',2)->count();
        $riskmap2_13 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 1)->where('probabilidad2',3)->count();
        $riskmap2_21 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 2)->where('probabilidad2',1)->count();
        $riskmap2_22 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 2)->where('probabilidad2',2)->count();
        $riskmap2_23 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 2)->where('probabilidad2',3)->count();
        $riskmap2_31 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 3)->where('probabilidad2',1)->count();
        $riskmap2_32 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 3)->where('probabilidad2',2)->count();
        $riskmap2_33 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 3)->where('probabilidad2',3)->count();
      }




        return view('/Principales/Dashboard/mapadecalor',compact('Analisisriesgo','area','proceso','Abcriesgo','riskmap_11','riskmap_12','riskmap_13','riskmap_21','riskmap_22','riskmap_23','riskmap_31','riskmap_32','riskmap_33',
        'riskmap2_11','riskmap2_12','riskmap2_13','riskmap2_21','riskmap2_22','riskmap2_23','riskmap2_31','riskmap2_32','riskmap2_33'));
    }

    public function indexfiltros(Request $request)
    {
      $usuarios = Auth::user();
      if ($usuarios->perfil == 4) {
        if ($request->input('areas') == 0 and $request->input('procesos') == 0 and $request->input('tipos') == 0){

          $user = $usuarios->id;
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.lista_de_distribucion','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('analisisriesgos.idcompañia',$usuarios->id_compania)
          ->WhereNotNull('lista_envios.id_usuario')
          ->orwhere('procesos.Creador_id' ,$usuarios->id)
          ->orwhere('procesos.usuario_responsable_id' ,$usuarios->id)
          ->get());

          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','3')->count();

        }
        elseif($request->input('areas') != 0 and $request->input('procesos') == 0 and $request->input('tipos') == 0){

          $user = $usuarios->id;
          $area1 = $request->input('areas');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.lista_de_distribucion','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('analisisriesgos.idcompañia',$usuarios->id_compania)
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

          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','3')->count();
        }
        elseif($request->input('areas') == 0 and $request->input('procesos') != 0 and $request->input('tipos') == 0){

          $user = $usuarios->id;
          $procesos1 = $request->input('procesos');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.lista_de_distribucion','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('analisisriesgos.idcompañia',$usuarios->id_compania)
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


          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','3')->count();

        }
        elseif($request->input('areas') == 0 and $request->input('procesos') == 0 and $request->input('tipos') != 0){

          $user = $usuarios->id;
          $tipo1 = $request->input('tipos');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.lista_de_distribucion','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('analisisriesgos.idcompañia',$usuarios->id_compania)
          ->where('riesgo_id',$tipo1)
          ->WhereNotNull('lista_envios.id_usuario')
          ->orWhere(function ($query2) use ($user,$tipo1){
            $query2->where('procesos.Creador_id' ,$user)
            ->where('riesgo_id',$tipo1);
          })
          ->orWhere(function ($query2) use ($user,$tipo1){
            $query2->where('procesos.usuario_responsable_id' ,$user)
            ->where('riesgo_id',$tipo1);
          })
          ->get());


          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','3')->count();

        }
        elseif($request->input('areas') != 0 and $request->input('procesos') != 0 and $request->input('tipos') == 0){

          $user = $usuarios->id;
          $area1 = $request->input('areas');
          $proceso1 = $request->input('procesos');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.lista_de_distribucion','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('analisisriesgos.idcompañia',$usuarios->id_compania)
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

          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','3')->count();
        }
        elseif($request->input('areas') != 0 and $request->input('procesos') != 0 and $request->input('tipos') != 0){
                //return dd($request);
          $user = $usuarios->id;
          $area1 = $request->input('areas');
          $tipo1 = $request->input('tipos');
          $proceso1 = $request->input('procesos');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.lista_de_distribucion','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('analisisriesgos.idcompañia',$usuarios->id_compania)
          ->where('id_area',$area1)
          ->where('riesgo_id',$tipo1)
          ->where('procesos_id',$proceso1)
          ->WhereNotNull('lista_envios.id_usuario')
          ->orWhere(function ($query2) use ($user,$area1,$proceso1,$tipo1){
            $query2->where('procesos.Creador_id' ,$user)
            ->where('id_area',$area1)
            ->where('procesos_id',$proceso1)
            ->where('riesgo_id',$tipo1);
          })
          ->orWhere(function ($query2) use ($user,$area1,$proceso1,$tipo1){
            $query2->where('procesos.usuario_responsable_id' ,$user)
            ->where('id_area',$area1)
            ->where('procesos_id',$proceso1)
            ->where('riesgo_id',$tipo1);
          })
          ->get());

          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','3')->count();

        }
        elseif($request->input('areas') != 0 and $request->input('procesos') == 0 and $request->input('tipos') != 0){
          //return dd($request);
          $user = $usuarios->id;
          $area1 = $request->input('areas');
          $tipo1 = $request->input('tipos');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.lista_de_distribucion','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('analisisriesgos.idcompañia',$usuarios->id_compania)
          ->where('id_area',$area1)
          ->where('riesgo_id',$tipo1)
          ->WhereNotNull('lista_envios.id_usuario')
          ->orWhere(function ($query2) use ($user,$area1,$tipo1){
            $query2->where('procesos.Creador_id' ,$user)
            ->where('id_area',$area1)
            ->where('riesgo_id',$tipo1);
          })
          ->orWhere(function ($query2) use ($user,$area1,$tipo1){
            $query2->where('procesos.usuario_responsable_id' ,$user)
            ->where('id_area',$area1)
            ->where('riesgo_id',$tipo1);
          })
          ->get());

          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','3')->count();

        }
        elseif($request->input('areas') == 0 and $request->input('procesos') != 0 and $request->input('tipos') != 0){

          $user = $usuarios->id;
          $tipo1 = $request->input('tipos');
          $proceso1 = $request->input('procesos');
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.lista_de_distribucion','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->leftjoin('lista_envios', function($join) use ($user)
            {
                $join->on('lista_envios.id_proceso','=','procesos.lista_de_distribucion');
                $join->on(function($query) use ($user)
                {
                  $query->on('lista_envios.id_usuario', '=', DB::raw("'".$user."'"));
                });
            })
          ->where('analisisriesgos.idcompañia',$usuarios->id_compania)
          ->where('riesgo_id',$tipo1)
          ->where('procesos_id',$proceso1)
          ->WhereNotNull('lista_envios.id_usuario')
          ->orWhere(function ($query2) use ($user,$tipo1,$proceso1){
            $query2->where('procesos.Creador_id' ,$user)
            ->where('procesos_id',$proceso1)
            ->where('riesgo_id',$tipo1);
          })
          ->orWhere(function ($query2) use ($user,$tipo1,$proceso1){
            $query2->where('procesos.usuario_responsable_id' ,$user)
            ->where('procesos_id',$proceso1)
            ->where('riesgo_id',$tipo1);
          })
          ->get());

          $riskmap_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','1')->count();
          $riskmap_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','2')->count();
          $riskmap_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '1')->where('probabilidad','3')->count();
          $riskmap_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','1')->count();
          $riskmap_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','2')->count();
          $riskmap_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '2')->where('probabilidad','3')->count();
          $riskmap_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','1')->count();
          $riskmap_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','2')->count();
          $riskmap_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad', '3')->where('probabilidad','3')->count();

          $riskmap2_11 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','1')->count();
          $riskmap2_12 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','2')->count();
          $riskmap2_13 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '1')->where('probabilidad2','3')->count();
          $riskmap2_21 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','1')->count();
          $riskmap2_22 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','2')->count();
          $riskmap2_23 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '2')->where('probabilidad2','3')->count();
          $riskmap2_31 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','1')->count();
          $riskmap2_32 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','2')->count();
          $riskmap2_33 = $Analisisriesgo->where('idcompañia',$usuarios->id_compania)->where('Severidad2', '3')->where('probabilidad2','3')->count();

        }

      }else {
        if ($request->input('areas') == 0 and $request->input('procesos') == 0 and $request->input('tipos') == 0){

          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->where('analisisriesgos.idcompañia',$usuarios->id_compania)->get());

          $riskmap_11 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 1)->where('probabilidad',1)->count();
          $riskmap_12 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 1)->where('probabilidad',2)->count();
          $riskmap_13 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 1)->where('probabilidad',3)->count();
          $riskmap_21 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 2)->where('probabilidad',1)->count();
          $riskmap_22 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 2)->where('probabilidad',2)->count();
          $riskmap_23 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 2)->where('probabilidad',3)->count();
          $riskmap_31 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 3)->where('probabilidad',1)->count();
          $riskmap_32 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 3)->where('probabilidad',2)->count();
          $riskmap_33 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad', 3)->where('probabilidad',3)->count();

          $riskmap2_11 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 1)->where('probabilidad2',1)->count();
          $riskmap2_12 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 1)->where('probabilidad2',2)->count();
          $riskmap2_13 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 1)->where('probabilidad2',3)->count();
          $riskmap2_21 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 2)->where('probabilidad2',1)->count();
          $riskmap2_22 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 2)->where('probabilidad2',2)->count();
          $riskmap2_23 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 2)->where('probabilidad2',3)->count();
          $riskmap2_31 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 3)->where('probabilidad2',1)->count();
          $riskmap2_32 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 3)->where('probabilidad2',2)->count();
          $riskmap2_33 = DB::table('analisisriesgos')->where('idcompañia',$usuarios->id_compania)->where('severidad2', 3)->where('probabilidad2',3)->count();


        }
        elseif($request->input('areas') != 0 and $request->input('procesos') == 0 and $request->input('tipos') == 0){

          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->where('id_area',$request->input('areas'))->get());

          $riskmap_11 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',1)->where('id_area',$request->input('areas'))->count();
          $riskmap_12 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',2)->where('id_area',$request->input('areas'))->count();
          $riskmap_13 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',3)->where('id_area',$request->input('areas'))->count();
          $riskmap_21 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',1)->where('id_area',$request->input('areas'))->count();
          $riskmap_22 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',2)->where('id_area',$request->input('areas'))->count();
          $riskmap_23 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',3)->where('id_area',$request->input('areas'))->count();
          $riskmap_31 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',1)->where('id_area',$request->input('areas'))->count();
          $riskmap_32 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',2)->where('id_area',$request->input('areas'))->count();
          $riskmap_33 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',3)->where('id_area',$request->input('areas'))->count();

          $riskmap2_11 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',1)->where('id_area',$request->input('areas'))->count();
          $riskmap2_12 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',2)->where('id_area',$request->input('areas'))->count();
          $riskmap2_13 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',3)->where('id_area',$request->input('areas'))->count();
          $riskmap2_21 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',1)->where('id_area',$request->input('areas'))->count();
          $riskmap2_22 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',2)->where('id_area',$request->input('areas'))->count();
          $riskmap2_23 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',3)->where('id_area',$request->input('areas'))->count();
          $riskmap2_31 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',1)->where('id_area',$request->input('areas'))->count();
          $riskmap2_32 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',2)->where('id_area',$request->input('areas'))->count();
          $riskmap2_33 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',3)->where('id_area',$request->input('areas'))->count();

        }
        elseif($request->input('areas') == 0 and $request->input('procesos') != 0 and $request->input('tipos') == 0){

          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->where('procesos_id',$request->input('procesos'))->get());

          $riskmap_11 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',1)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_12 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',2)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_13 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',3)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_21 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',1)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_22 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',2)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_23 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',3)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_31 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',1)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_32 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',2)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_33 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',3)->where('procesos_id',$request->input('procesos'))->count();

          $riskmap2_11 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',1)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_12 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',2)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_13 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',3)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_21 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',1)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_22 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',2)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_23 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',3)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_31 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',1)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_32 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',2)->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_33 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',3)->where('procesos_id',$request->input('procesos'))->count();

        }
        elseif($request->input('areas') == 0 and $request->input('procesos') == 0 and $request->input('tipos') != 0){

          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->where('riesgo_id',$request->input('tipos'))->get());

          $riskmap_11 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',1)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_12 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',2)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_13 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',3)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_21 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',1)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_22 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',2)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_23 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',3)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_31 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',1)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_32 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',2)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_33 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',3)->where('riesgo_id',$request->input('tipos'))->count();

          $riskmap2_11 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',1)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_12 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',2)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_13 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',3)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_21 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',1)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_22 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',2)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_23 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',3)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_31 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',1)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_32 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',2)->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_33 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',3)->where('riesgo_id',$request->input('tipos'))->count();

        }
        elseif($request->input('areas') != 0 and $request->input('procesos') != 0 and $request->input('tipos') == 0){

          //return dd($request);
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->get());

          $riskmap_11 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_12 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_13 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_21 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_22 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_23 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_31 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_32 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap_33 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();

          $riskmap2_11 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_12 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_13 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_21 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_22 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_23 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_31 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_32 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
          $riskmap2_33 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->count();
        }
        elseif($request->input('areas') != 0 and $request->input('procesos') != 0 and $request->input('tipos') != 0){

          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->get());

          $riskmap_11 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_12 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_13 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_21 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_22 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_23 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_31 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_32 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_33 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();

          $riskmap2_11 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_12 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_13 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_21 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_22 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_23 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_31 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',1)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_32 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',2)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_33 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',3)->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();


        }
        elseif($request->input('areas') != 0 and $request->input('procesos') == 0 and $request->input('tipos') != 0){
          //return dd($request);
          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->get());

          $riskmap_11 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',1)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_12 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',2)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_13 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',3)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_21 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',1)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_22 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',2)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_23 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',3)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_31 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',1)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_32 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',2)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_33 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',3)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();

          $riskmap2_11 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',1)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_12 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',2)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_13 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',3)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_21 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',1)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_22 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',2)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_23 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',3)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_31 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',1)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_32 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',2)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_33 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',3)->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->count();

        }
        elseif($request->input('areas') == 0 and $request->input('procesos') != 0 and $request->input('tipos') != 0){

          $Analisisriesgo = \Illuminate\Support\Collection::make(DB::table('analisisriesgos')
          ->select('analisisriesgos.*','procesos.proceso as nombreproceso','abcriesgos.nombre as abcriesgo','areas.nombre as nomarea')
          ->join('abcriesgos','abcriesgos.id','=','analisisriesgos.riesgo_id')
          ->join('areas','areas.id','=','analisisriesgos.id_area')
          ->join('procesos','procesos.id','=','analisisriesgos.procesos_id')
          ->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->get());

          $riskmap_11 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',1)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_12 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',2)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_13 = DB::table('analisisriesgos')->where('severidad', 1)->where('probabilidad',3)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_21 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',1)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_22 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',2)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_23 = DB::table('analisisriesgos')->where('severidad', 2)->where('probabilidad',3)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_31 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',1)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_32 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',2)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap_33 = DB::table('analisisriesgos')->where('severidad', 3)->where('probabilidad',3)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();

          $riskmap2_11 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',1)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_12 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',2)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_13 = DB::table('analisisriesgos')->where('severidad2', 1)->where('probabilidad2',3)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_21 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',1)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_22 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',2)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_23 = DB::table('analisisriesgos')->where('severidad2', 2)->where('probabilidad2',3)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_31 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',1)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_32 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',2)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();
          $riskmap2_33 = DB::table('analisisriesgos')->where('severidad2', 3)->where('probabilidad2',3)->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->count();


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
            $Abcriesgos = new Abcriesgos;
            $Abcriesgo = $Abcriesgos->where('id_compania',$usuarios->id_compania)->get();


            return view('/Principales/Dashboard/mapadecalor',compact('Analisisriesgo','riskmap_11','riskmap_12','riskmap_13','riskmap_21','riskmap_22','riskmap_23','riskmap_31','riskmap_32','riskmap_33',
            'riskmap2_11','riskmap2_12','riskmap2_13','riskmap2_21','riskmap2_22','riskmap2_23','riskmap2_31','riskmap2_32','riskmap2_33','area','proceso','Abcriesgo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
