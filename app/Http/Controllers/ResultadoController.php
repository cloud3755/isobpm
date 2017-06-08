<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Resultados;
use App\Models\Indicadores;
use App\Models\Frecuencias;
use App\Models\Unidades;
use App\Models\Logica;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ResultadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //estos datos se van a pasar a la vista de dash para poderlos graficar
        $resultados = new Resultados;
        $resultado = $resultados->select('periodo','valor')->get();
        //para validar si trae los campos correctos
        //dd($resultado->all());
        return view('createresultado', compact('resultado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $usuarios = Auth::user();

      if($usuarios->perfil ==4)
      {
        $indicadorrelacion = \DB::table('indicadores')
                                 ->leftjoin('objetivos','indicadores.objetivo_id','=','objetivos.id')
                                 ->leftjoin('users','indicadores.usuario_responsable_id','=','users.id')
                                 ->leftjoin('frecuencias','indicadores.frecuencia_id','=','frecuencias.id')
                                 ->leftjoin('unidades','indicadores.unidad','=','unidades.id')
                                 ->leftjoin('logicas','indicadores.logica','=','logicas.id')
                                 ->leftjoin('lista_accesos','indicadores.acceso','=','lista_accesos.id_indicador')
                                 ->select('indicadores.id as id','indicadores.objetivo_id as objetivo_id','objetivos.nombre as indicadoresobjetivo','indicadores.nombre as nombreindicador','indicadores.descripcion as descripcionindicador','users.usuario as userindicador','frecuencias.nombre as frecuenciaindicador','unidades.simbolo as simboloindicador','logicas.simbolo as logicaindicador','indicadores.meta as indicadormeta')
                                 ->where('lista_accesos.id_usuario',$usuarios->id)
                                 ->orwhere('indicadores.creador_id',$usuarios->id)
                                 ->get();
      }

      else
      {
        $indicadorrelacion = \DB::table('indicadores')
                                 ->leftjoin('objetivos','indicadores.objetivo_id','=','objetivos.id')
                                 ->leftjoin('users','indicadores.usuario_responsable_id','=','users.id')
                                 ->leftjoin('frecuencias','indicadores.frecuencia_id','=','frecuencias.id')
                                 ->leftjoin('unidades','indicadores.unidad','=','unidades.id')
                                 ->leftjoin('logicas','indicadores.logica','=','logicas.id')
                                 ->select('indicadores.id as id','indicadores.objetivo_id as objetivo_id','objetivos.nombre as indicadoresobjetivo','indicadores.nombre as nombreindicador','indicadores.descripcion as descripcionindicador','users.usuario as userindicador','frecuencias.nombre as frecuenciaindicador','unidades.simbolo as simboloindicador','logicas.simbolo as logicaindicador','indicadores.meta as indicadormeta')
                                 ->where('objetivos.id_compania',$usuarios->id_compania)
                                 ->get();
      }
       //return(dd($indicadorrelacion));
      //para validar si trae los campos correctos
      //dd($resultado->all());
      return View('/Principales/ResultadosMostrar', compact('indicador', 'resultado','indicadorrelacion'));
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

        if (strlen($request->input('mes')) == 7)
        {
          $fechainput =  $request->input('mes').'-01';
        }
        else {
          $fechainput = $request->input('mes');
        }

        $resultado = new Resultados;
        $resultado->periodo = $request->input('periodo');
        $resultado->indicador_id = $request->input('indicador_id');
        $resultado->valor = $request->input('valor');
        $resultado->mes = $fechainput;
        $resultado->numero = 1;//$request->input('numero'); no se a donde se vincula esta
        $resultado->creador_id =  $usuarios->id;

        $resultado->save();

        session()->flash('flash_msg',"Se guardo correctamene el periodo");
        session()->flash('flash_type','warning');
        return redirect('resultado/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $indicadorrelacion = \DB::table('indicadores')
                               ->where('indicadores.id','=',$id)
                               ->leftjoin('objetivos','indicadores.objetivo_id','=','objetivos.id')
                               ->leftjoin('users','indicadores.usuario_responsable_id','=','users.id')
                               ->leftjoin('frecuencias','indicadores.frecuencia_id','=','frecuencias.id')
                               ->leftjoin('unidades','indicadores.unidad','=','unidades.id')
                               ->leftjoin('logicas','indicadores.logica','=','logicas.id')
                               ->select('indicadores.id as id','indicadores.objetivo_id as objetivo_id','objetivos.nombre as indicadoresobjetivo','indicadores.nombre as nombreindicador','indicadores.descripcion as descripcionindicador','users.usuario as userindicador','frecuencias.nombre as frecuenciaindicador','unidades.simbolo as simboloindicador','logicas.simbolo as logicaindicador','indicadores.meta as indicadormeta')
                               ->first();


      $indicadores = new Indicadores;
      $indicador = $indicadores->where('ID',$id)->first();

      $resultados = new Resultados;
      $resultado = $resultados->where('indicador_id',$id)->orderBy('mes','Asc')->get();

      // Para obligar al cliente a meter el siguiente periodo
      $siguienteperiodo = $resultado->max('periodo');

      if($siguienteperiodo == NULL){
        $siguienteperiodo = 1;
      }
      else {
        $siguienteperiodo = ($siguienteperiodo + 1);
      }


      // para obligar al cliente con la siguiente fecha segun la frecuencia elegida
      $siguientefecha = $resultado->max('mes');
      $periodicidad = $indicador->frecuencia_id;

      if($siguientefecha == NULL){
        //$fecha =   new \DateTime()
        $carbon =  new \Carbon\Carbon();
        $siguientefecha = $carbon->now();
        if($periodicidad <> 2)
        {
          $siguientefecha = $siguientefecha->todatestring('Y-m-d');
          $formato = 'date';
        }
        else {
          $formato = 'month';
          $siguientefecha = substr($siguientefecha->todatestring('Y-m-d'),0,7);
        }

        //return(dd($siguientefecha));
      }
      elseif ($periodicidad == 1)
        {

          $siguientefecha = Carbon::parse($siguientefecha)->addday(1);
          $formato = 'date';
          $siguientefecha = $siguientefecha->todatestring('Y-m-d');

        }
        elseif ($periodicidad == 2)
          {
            $siguientefecha = Carbon::parse($siguientefecha)->addmonth(1);
            $formato = 'month';
            $siguientefecha = substr($siguientefecha->todatestring('Y-m-d'),0,7);
          }
          elseif ($periodicidad == 3)
            {

              $siguientefecha = Carbon::parse($siguientefecha)->addmonth(6);
              $formato = 'date';
              $siguientefecha = $siguientefecha->todatestring('Y-m-d');
            }
            elseif ($periodicidad == 4)
              {

              $siguientefecha = Carbon::parse($siguientefecha)->addyear(1);
              $formato = 'date';
              $siguientefecha = $siguientefecha->todatestring('Y-m-d');
              }

      $frecuencia = Frecuencias::where('id',$indicador['frecuencia_id'])->first();
      $unidad = Unidades::where('id',$indicador['unidad'])->first();
      $logica = Logica::where('id',$indicador['logica'])->first();



       //para validar si trae los campos correctos
      //dd($resultado->all());
      return View('/Secundarias/vistaresultado', compact('indicador', 'resultado','frecuencia','unidad','logica','siguienteperiodo','siguientefecha','indicadorrelacion','formato'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {

        $resultado = Resultados::findOrFail($id);

            if (strlen($request->input('mes')) == 7)
            {
              $fechainput =  $request->input('mes').'-01';
            }
            else {
              $fechainput = $request->input('mes');
            }

            $resultado->periodo = $request->input('periodo');
            $resultado->indicador_id = $request->input('indicador_id');
            $resultado->valor = $request->input('valor');
            $resultado->mes = $fechainput;
            $resultado->numero = 1;//$request->input('numero'); no se a donde se vincula esta
            $resultado->save();

            session()->flash('flash_msg',"Se guardo correctamene el periodo");
            session()->flash('flash_type','warning');
            return redirect('resultado/create');


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
      $resultado = Resultados::find($id);
      if (is_null ($resultado))
      {
          App::abort(404);
      }

      $resultado->delete();

      return redirect('resultado/create');
    }
}
