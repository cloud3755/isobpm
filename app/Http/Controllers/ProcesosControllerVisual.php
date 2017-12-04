<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Indicadores;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Proceso;
use App\Models\puestos;
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
      if ($usuario->perfil == 4) {
        $iduser = $usuario->id;
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
        ->where('usuario_responsable_id',$usuario->id)
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
        ->where('idcompañia',$usuario->id_compania)
        ->get();
      }

      $Users = new User;
      $User = $Users->where('id_compania',$usuario->id_compania)
      ->where('perfil',4)
      ->get();

      $tipoprocesos = new tipoproceso;
      $tipoproceso = $tipoprocesos->orderBy('id')->get();

      $indicador = \DB::table('indicadores')
                               ->join('objetivos','indicadores.objetivo_id','=','objetivos.id')
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
        $rutaalindex = "";
        foreach ($zipper->listFiles() as $lista):
          if ((stripos($lista,"index.html") !== false))
          {
            $rutaalindex = $lista;
             $rutaalindex2 = 'si es';
          }
        endforeach;

        $rutaalindex = str_replace("/","\\",$rutaalindex);

        $rutaalindex = "\storage\bizagi\\$rutaalindex";
      }

      $indicator = $proceso['indicadores'];
      $lista = $proceso['lista_de_distribucion'];
      $puestolist = $proceso['puestos'];
      $Insumoslist = $proceso['insumos'];
      $Documentoslist = $proceso['documento'];
      $Activoslist = $proceso['activo'];

      $procesos = new Proceso;
      $proceso = $procesos->where('id',$id)->get();

      $Users = new User;
      $User = $Users->where('id_compania',$usuario->id_compania)
      ->where('perfil',4)
      ->get();

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

      //return(dd($listaenvio));

      $Users = \DB::table('users')
                      ->select('lista_envios.id_proceso','users.id','users.nombre')
                      ->leftJoin('lista_envios', function($join) use ($lista)
                        {
                            $join->on('users.id', '=', 'lista_envios.id_usuario');
                            $join->on(function($query) use ($lista)
                            {
                              $query->on('lista_envios.id_proceso', '=', DB::raw("'".$lista."'"));
                            });
                        })
                      ->where('id_compania',$usuario->id_compania)
                      ->where('perfil',4)
                      ->whereNull('id_proceso')
                      //->where('lista_envios.id_proceso',$lista)
                      ->get();
      //return(dd($User));

      $indicadoresrelacion = \DB::table('indicadores')
                               ->select('lista_indicadores_procesos.id_proceso','indicadores.id','indicadores.nombre')
                               ->leftjoin('lista_indicadores_procesos','indicadores.id','=','lista_indicadores_procesos.id_indicador')
                               ->leftjoin('procesos','lista_indicadores_procesos.id_proceso','=','procesos.indicadores')
                               ->where('lista_indicadores_procesos.id_proceso',$indicator)
                               ->get();

    //  $indicador = \DB::table('indicadores')
    //                ->select('indicadores.id','indicadores.nombre')
    //                ->join('objetivos','indicadores.objetivo_id','=','objetivos.id')
    //                ->where('objetivos.id_compania',$usuario->id_compania)
    //                ->get();

      $indicador = \DB::table('indicadores')
                       ->select('procesos.proceso','indicadores.id','indicadores.nombre')
                       ->leftJoin('lista_indicadores_procesos', function($join) use ($indicator)
                         {
                             $join->on('indicadores.id', '=', 'lista_indicadores_procesos.id_indicador');
                             $join->on(function($query) use ($indicator)
                             {
                               $query->on('lista_indicadores_procesos.id_proceso', '=', DB::raw("'".$indicator."'"));
                             });
                         })
                         ->leftjoin('procesos','lista_indicadores_procesos.id_proceso', '=', 'procesos.indicadores')
                         ->join('objetivos','indicadores.objetivo_id','=','objetivos.id')
                         ->where('objetivos.id_compania',$usuario->id_compania)
                         ->whereNull('procesos.proceso')
                       //->where('lista_indicadores_procesos.id_proceso',$indicator)
                       ->get();


    $Puestorelacion = \DB::table('lista_puestos_procesos')
                     ->select('lista_puestos_procesos.id_proceso','puestos.*')
                     ->join('puestos','puestos.id', '=', 'lista_puestos_procesos.id_puesto')
                     ->where('lista_puestos_procesos.id_proceso',$puestolist)
                     ->get();

     //return(dd($listaenvio));

     $Puesto = \DB::table('puestos')
                     ->select('lista_puestos_procesos.id_proceso','puestos.*')
                     ->leftJoin('lista_puestos_procesos', function($join) use ($puestolist)
                       {
                           $join->on('puestos.id', '=', 'lista_puestos_procesos.id_puesto');
                           $join->on(function($query) use ($puestolist)
                           {
                             $query->on('lista_puestos_procesos.id_proceso', '=', DB::raw("'".$puestolist."'"));
                           });
                       })
                     ->where('id_compania',$usuario->id_compania)
                     ->whereNull('id_proceso')
                     //->where('lista_envios.id_proceso',$lista)
                     ->get();


    $Insumosrelacion = \DB::table('lista_insumos_procesos')
                     ->select('lista_insumos_procesos.id_proceso','insumos.*')
                     ->join('insumos','insumos.id', '=', 'lista_insumos_procesos.id_insumo')
                     ->where('lista_insumos_procesos.id_proceso',$Insumoslist)
                     ->get();

     //return(dd($listaenvio));


     $Insumos = \DB::table('insumos')
                     ->select('lista_insumos_procesos.id_proceso','insumos.*')
                     ->leftJoin('lista_insumos_procesos', function($join) use ($Insumoslist)
                       {
                           $join->on('insumos.id', '=', 'lista_insumos_procesos.id_insumo');
                           $join->on(function($query) use ($Insumoslist)
                           {
                             $query->on('lista_insumos_procesos.id_proceso', '=', DB::raw("'".$Insumoslist."'"));
                           });
                       })
                     ->where('idcompañia',$usuario->id_compania)
                     ->whereNull('id_proceso')
                     //->where('lista_envios.id_proceso',$lista)
                     ->get();
//return(dd($Insumos));

$Documentosrelacion = \DB::table('lista_documentos_procesos')
                 ->select('lista_documentos_procesos.id_proceso','documentos.*')
                 ->join('documentos','documentos.id', '=', 'lista_documentos_procesos.id_documento')
                 ->where('lista_documentos_procesos.id_proceso',$Documentoslist)
                 ->get();

 //return(dd($listaenvio));

 $Documentos = \DB::table('documentos')
                 ->select('lista_documentos_procesos.id_proceso','documentos.*')
                 ->leftJoin('lista_documentos_procesos', function($join) use ($Documentoslist)
                   {
                       $join->on('documentos.id', '=', 'lista_documentos_procesos.id_documento');
                       $join->on(function($query) use ($Documentoslist)
                       {
                         $query->on('lista_documentos_procesos.id_proceso', '=', DB::raw("'".$Documentoslist."'"));
                       });
                   })
                 ->where('id_compania',$usuario->id_compania)
                 ->whereNull('id_proceso')
                 //->where('lista_envios.id_proceso',$lista)
                 ->get();

$Activosrelacion = \DB::table('lista_activos_procesos')
                 ->select('lista_activos_procesos.id_proceso','activosdeinfs.*')
                 ->join('activosdeinfs','activosdeinfs.id', '=', 'lista_activos_procesos.id_activo')
                 ->where('lista_activos_procesos.id_proceso',$Activoslist)
                 ->get();



 $Activos = \DB::table('activosdeinfs')
                 ->select('lista_activos_procesos.id_proceso','activosdeinfs.*')
                 ->leftJoin('lista_activos_procesos', function($join) use ($Activoslist)
                   {
                       $join->on('activosdeinfs.id', '=', 'lista_activos_procesos.id_activo');
                       $join->on(function($query) use ($Activoslist)
                       {
                         $query->on('lista_activos_procesos.id_proceso', '=', DB::raw("'".$Activoslist."'"));
                       });
                   })
                 ->where('id_compania',$usuario->id_compania)
                 ->whereNull('id_proceso')
                 //->where('lista_envios.id_proceso',$lista)
                 ->get();

       $sipoc = \DB::table('sipocs')
                      ->where('id_proceso','=',$id)
                      ->get();



       return View('/Secundarias/ProcesosMostrar', compact('proceso','User','Users','tipoproceso','procesosrelacion','listaenvio','indicadoresrelacion','indicador','rutaalindex','archivoabrir','rutacompleta','rutaalindex2','Puesto','Puestorelacion','Insumos','Documentos','Activos','Insumosrelacion','Documentosrelacion','Activosrelacion','sipoc'));
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
