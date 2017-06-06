<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Proceso;
use App\Models\User;
use App\Models\Tipo_objetivo;
use App\Models\Objetivo;
use App\Models\Indicadores;
use App\Models\Logica;
use App\Models\Frecuencias;
use App\Models\Unidades;
use Illuminate\Support\Facades\Auth;

class ObjetivosControllerVisual extends Controller
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

      $objetivos = new Objetivo;
      if($usuarios->perfil == 4)
      {
          $objetivo = $objetivos
          ->where('id_compania',$usuarios->id_compania)
          ->where('usuario_responsable_id',$usuarios->id)
          ->orwhere('Creador_id',$usuarios->id)
          ->get();
      }

      else {
        $objetivo = $objetivos
        ->where('id_compania',$usuarios->id_compania)
        ->get();
      }
      $procesos = new Proceso;
      $proceso = $procesos->where('idcompañia',$usuarios->id_compania)->get();

      $Users = new User;
      $User = $Users->where('id_compania',$usuarios->id_compania)->get();

      $tipoobjetivos = new tipo_objetivo;
      $tipoobjetivo = $tipoobjetivos->all();

      return View('/Principales/Objetivosvisual', compact('objetivo','proceso','User','tipoobjetivo'));        //
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
      $usuarios = Auth::user();
      $objetivos = new Objetivo;
      $objetivo = $objetivos->all();

      $indicadores = new Indicadores;
      $indicador = $indicadores->where('objetivo_id',$id)->get();

      $frecuencia = new frecuencias;
      $frecuencias = $frecuencia->all();

      $unidad = new unidades;
      $unidades = $unidad->all();

      $Users = new User;
      $User = $Users->where('id_compania',$usuarios->id_compania)->where('perfil','!=',1)->get();

      $logicas = new logica;
      $logica = $logicas->all();

      $tipoobjetivos = new tipo_objetivo;
      $tipoobjetivo = $tipoobjetivos->all();


       $indicadorrelacion = \DB::table('indicadores')
                                ->leftjoin('objetivos','indicadores.objetivo_id','=','objetivos.id')
                                ->leftjoin('users','indicadores.usuario_responsable_id','=','users.id')
                                ->leftjoin('frecuencias','indicadores.frecuencia_id','=','frecuencias.id')
                                ->leftjoin('unidades','indicadores.unidad','=','unidades.id')
                                ->leftjoin('logicas','indicadores.logica','=','logicas.id')
                                ->select('indicadores.id as id','indicadores.objetivo_id as objetivo_id','objetivos.nombre as indicadoresobjetivo','indicadores.nombre as nombreindicador','indicadores.descripcion as descripcionindicador','users.usuario as userindicador','frecuencias.nombre as frecuenciaindicador','unidades.simbolo as simboloindicador','logicas.simbolo as logicaindicador','indicadores.meta as indicadormeta','frecuencias.id as frecuencia_id','unidades.id as unidad_id','logicas.id as logicas_id','users.id as user_id','indicadores.acceso as acceso')
                                ->where('indicadores.objetivo_id','=',$id)
                                ->get();


      $registro = objetivo::where('id', $id)->first();

      $tipoactual = tipo_objetivo::where('id',$registro['tipo_objetivo_id'])->first();

      $responsableactual = User::where('id',$registro['usuario_responsable_id'])->first();

      return view('/Secundarias/ObjetivoMostrar',compact('objetivo','indicador','id','frecuencias','unidades','User','logica','tipoobjetivo','indicadorrelacion','registro','tipoactual','responsableactual'));
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
