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

      $Analisisriesgos = new Analisisriesgos;
      $Analisisriesgo = $Analisisriesgos->where('idcompañia',$usuarios->id_compania)->get();

      $areas = new Areas;
      $area = $areas->where('id_compania',$usuarios->id_compania)->get();

      $procesos = new Proceso;
      $proceso = $procesos->where('idcompañia',$usuarios->id_compania)->get();

      $Abcriesgos = new Abcriesgos;
      $Abcriesgo = $Abcriesgos->where('id_compania',$usuarios->id_compania)->get();

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




        return view('/Principales/Dashboard/mapadecalor',compact('Analisisriesgo','area','proceso','Abcriesgo','riskmap_11','riskmap_12','riskmap_13','riskmap_21','riskmap_22','riskmap_23','riskmap_31','riskmap_32','riskmap_33',
        'riskmap2_11','riskmap2_12','riskmap2_13','riskmap2_21','riskmap2_22','riskmap2_23','riskmap2_31','riskmap2_32','riskmap2_33'));
    }

    public function indexfiltros(Request $request)
    {
      $usuarios = Auth::user();
      if ($request->input('areas') == 0 and $request->input('procesos') == 0 and $request->input('tipos') == 0){

        $Analisisriesgos = new Analisisriesgos;
        $Analisisriesgo = $Analisisriesgos->where('idcompañia',$usuarios->id_compania)->get();
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

        $Analisisriesgos = new Analisisriesgos;
        $Analisisriesgo = $Analisisriesgos->where('id_area',$request->input('areas'))->get();
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

        $Analisisriesgos = new Analisisriesgos;
        $Analisisriesgo = $Analisisriesgos->where('procesos_id',$request->input('procesos'))->get();
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

        $Analisisriesgos = new Analisisriesgos;
        $Analisisriesgo = $Analisisriesgos->where('riesgo_id',$request->input('tipos'))->get();
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
        $Analisisriesgos = new Analisisriesgos;
        $Analisisriesgo = $Analisisriesgos->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->get();
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
              //return dd($request);
        $Analisisriesgos = new Analisisriesgos;
        $Analisisriesgo = $Analisisriesgos->where('id_area',$request->input('areas'))->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->get();
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
        $Analisisriesgos = new Analisisriesgos;
        $Analisisriesgo = $Analisisriesgos->where('id_area',$request->input('areas'))->where('riesgo_id',$request->input('tipos'))->get();
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

        //return dd($request);
        $Analisisriesgos = new Analisisriesgos;
        $Analisisriesgo = $Analisisriesgos->where('procesos_id',$request->input('procesos'))->where('riesgo_id',$request->input('tipos'))->get();
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



            $areas = new Areas;
            $area = $areas->where('id_compania',$usuarios->id_compania)->get();

            $procesos = new Proceso;
            $proceso = $procesos->where('idcompañia',$usuarios->id_compania)->get();

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
