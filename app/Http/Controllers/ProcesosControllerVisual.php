<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Indicadores;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Proceso;
use App\Models\User;
use App\Models\tipoproceso;
use App\Models\Analisisriesgos;
use App\Models\Abcriesgos;
use App\Models\lista_envio;
use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\Auth;

class ProcesosControllerVisual extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     return view('procesosvisual');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $usuario = Auth::user();
      //
      $procesos = new Proceso;
      $proceso = $procesos
      ->where('idcompañia',$usuario->id_compania)
      ->where('usuario_responsable_id',$usuario->id)
      ->orwhere('Creador_id',$usuario->id)
      ->get();

      $Users = new User;
      $User = $Users->where('id_compania',$usuario->id_compania)->get();

      $tipoprocesos = new tipoproceso;
      $tipoproceso = $tipoprocesos->orderBy('id')->get();

      $indicador = \DB::table('indicadores')
                               ->leftjoin('objetivos','indicadores.objetivo_id','=','objetivos.id')
                               ->select('indicadores.*','objetivos.id_compania')
                               ->where('objetivos.id_compania','=',$usuario->id_compania)
                               ->get();

      //dd($objetivos->all());
      //return view('CreateProceso',compact('proceso','user')); //=> $proceso->toArray()], User);
      return View('/Principales/procesosvisual', compact('proceso','User','tipoproceso','indicador'));
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
      $usuario = Auth::user();
      $procesos = new Proceso;
      $proceso = $procesos->where('id',$id)->first();
      //
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
      }

      $indicator = $proceso['indicadores'];
      $lista = $proceso['lista_de_distribucion'];

      $procesos = new Proceso;
      $proceso = $procesos->where('id',$id)->get();


      $Users = new User;
      $User = $Users->where('id_compania',$usuario->id_compania)->get();

      $tipoprocesos = new tipoproceso;
      $tipoproceso = $tipoprocesos->orderBy('id')->get();


      $procesosrelacion = \DB::table('procesos')
                               ->select('procesos.*','users.usuario')
                               ->join('users','procesos.usuario_responsable_id','=','users.id')
                               ->where('procesos.id',$id)->first();

      $listaenvio = \DB::table('lista_envios')
                      ->select('lista_envios.id_proceso','users.id','users.nombre')
                      ->join('users','users.id', '=', 'lista_envios.id_usuario')
                      ->where('lista_envios.id_proceso',$lista)
                      ->get();


      //return(dd($User));

      $indicadoresrelacion = \DB::table('indicadores')
                               ->select('lista_indicadores_procesos.id_proceso','indicadores.id','indicadores.nombre')
                               ->leftjoin('lista_indicadores_procesos','indicadores.id','=','lista_indicadores_procesos.id_indicador')
                               ->leftjoin('procesos','lista_indicadores_procesos.id_proceso','=','procesos.indicadores')
                               ->where('lista_indicadores_procesos.id_proceso',$indicator)
                               ->get();

      $indicador = \DB::table('indicadores')
                    ->select('indicadores.id','indicadores.nombre')
                    ->join('objetivos','indicadores.objetivo_id','=','objetivos.id')
                    ->where('objetivos.id_compania',$usuario->id_compania)
                    ->get();


       return View('/Secundarias/ProcesosMostrar', compact('proceso','User','tipoproceso','procesosrelacion','listaenvio','indicadoresrelacion','indicador','rutaalindex'));
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
