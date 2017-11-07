<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Resultados;
use App\Models\Indicadores;
use App\Models\Quejas;
use App\Models\Areas;
use App\Models\Estatus;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){

      $usuarios = Auth::user();
      $resultados = new Resultados;
      $resultado = \DB::table('resultados')->select('mes', 'valor')
                ->where('indicador_id',0)
                ->orderBy('mes', 'asc')
                ->get();


      $indicador = \DB::table('indicadores')
                       ->join('objetivos','indicadores.objetivo_id','=','objetivos.id')
                       ->select('indicadores.*','objetivos.id_compania as id_compania')
                       ->where('objetivos.id_compania',$usuarios->id_compania)
                       ->get();

      $ultimo = new Indicadores;
      $ultimo = \DB::table('indicadores')
                ->where('id',0)
                ->first();

      //para validar si trae los campos correctos
      //dd($resultado->all());
      return view('/Principales/Dashboard/DashboardIO', compact('resultado','indicador','ultimo'));
    }

    public function dashdatos(Request $request){
      $usuarios = Auth::user();

      $resultados = new Resultados;
      $resultado = \DB::table('resultados')->select('mes', 'valor')
                ->where('indicador_id',$request->input("selectindicador"))
                ->whereBetween('mes', [$request->input("fechainicio"), $request->input("fechafin")])
                ->orderBy('mes', 'asc')
                ->get();


      $indicador = \DB::table('indicadores')
                       ->join('objetivos','indicadores.objetivo_id','=','objetivos.id')
                       ->select('indicadores.*','objetivos.id_compania as id_compania')
                       ->where('objetivos.id_compania',$usuarios->id_compania)
                       ->get();


      $ultimo = new Indicadores;
      $ultimo = \DB::table('indicadores')
                ->where('id',$request->input("selectindicador"))
                ->first();

      //para validar si trae los campos correctos
      //dd($resultado->all());
      return view('/Principales/Dashboard/DashboardIO', compact('resultado','indicador','ultimo'));
    }

    public function mejora(Request $request){

      $usuarios = Auth::user();

      $Estatus           = new Estatus;
      $estatus           = $Estatus->all();

      $areas = new Areas;
      $area  = $areas->where('id_compania',$usuarios->id_compania)->get();


      $Quejas = new Quejas;
      $Queja = $Quejas->select('fecha','estatus_id')->get();
      //para validar si trae los campos correctos
      //dd($resultado->all());

      //datos que se le van a pasar es id de status area

      //count para enero atrasada
      $quejacountenero = \DB::table('quejas')
      ->select(DB::raw('COUNT(*) as queja'))
      ->whereRaw('MONTH(fecha_plan) = ?', [01])
      //->whereRaw('YEAR(fecha_plan) = ?', [$year])
      ->where('estatus_id',1)
      ->get();

      $noconformidadsumproductos =  \DB::table('noconformidades')
      ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto, MONTH(fecha_plan) as mes'))
      ->join('productos','noconformidades.producto_id','=','productos.id')
      ->where('producto_id',-1)
      ->groupBy('mes','producto_id')
      ->get();

      $quejacount =  \DB::table('quejas')
      ->select(DB::raw('count(*) as queja, MONTH(fecha_plan) as mes'))
      ->whereBetween('fecha_plan', ['2017-01-01','2017-01-01'])
      ->groupBy('mes')
      ->get();


      $noconformidadcountproductos =  \DB::table('quejas')
      ->select(DB::raw('count(*) as queja, MONTH(fecha_plan) as mes'))
      ->whereBetween('fecha_plan', ['2017-01-01','2017-01-01'])
      ->groupBy('mes')
      ->get();

      $noconformidadtendenciaproducto =  \DB::table('noconformidades')
      ->select(DB::raw('count(*) as total, MONTH(fecha_plan) as mes'))
      ->join('productos','noconformidades.producto_id','=','productos.id')
      ->where('producto_id',-1)
      ->groupBy('mes')
      ->get();

      //dd($quejacount);

      /*

      //Tenemos la anterior consulta SQL
	$datos = DB::table("contratos")
			->select('idContrato','desContrato','diaFinContrato')
			->where('MONTH(fecha)', '=', '03')/// esto producira un Error ya que en laravel este where no
			->get();//lee funciones, Utiliza entonces whereRaw() / whereMonth;

	//Entonces tomamos el where y decimos
	->whereRaw('MONTH(fecha) = ?', [03])
	//o esta otra opcion
	->whereMonth('fecha', '=', '06')//funcion interna de laravel.

      */


      // $quejacount = \DB::table('quejas')->count();
      return view('/Principales/Dashboard/DashboardMejora', compact('Queja','quejacountenero','quejacount','area','estatus','noconformidadcountproductos','noconformidadsumproductos','noconformidadtendenciaproducto'));
    }

    public function mejoraPost(Request $request){

          $usuarios = Auth::user();

          $Quejas = new Quejas;
          $Queja = $Quejas->select('fecha','estatus_id')->get();

          $Estatus           = new Estatus;
          $estatus           = $Estatus->all();

          $areas = new Areas;
          $area  = $areas->where('id_compania',$usuarios->id_compania)->get();

          if($request->input('tipo') == 1)
            {

              if($request->input('tipografico') == 1)
              {

              if($request->input('Area') == 0 && $request->input('statusgrafica') == 0)
                {
                    $noconformidadcountproductos =  \DB::table('quejas')
                    ->select(DB::raw('count(producto) as total,productos.nombre as nombreproducto'))
                    ->join('productos','quejas.producto','=','productos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->groupBy('producto')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->join('productos','quejas.producto','=','productos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('quejas')
                    ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto'))
                    ->join('productos','quejas.producto','=','productos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->groupBy('producto')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                }

                if($request->input('Area') != 0)
                {
                  $noconformidadcountproductos =  \DB::table('quejas')
                  ->select(DB::raw('count(producto) as total,productos.nombre as nombreproducto'))
                  ->join('productos','quejas.producto','=','productos.id')
                  ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                  ->where('quejas.idcompañia',$usuarios->id_compania)
                  ->where('quejas.area',$request->input('Area'))
                  ->groupBy('producto')
                  ->get();

                  $noconformidadtendenciaproducto =  \DB::table('quejas')
                  ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                  ->join('productos','quejas.producto','=','productos.id')
                  ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                  ->where('quejas.idcompañia',$usuarios->id_compania)
                  ->where('quejas.area',$request->input('Area'))
                  ->groupBy('mes')
                  ->get();

                  $noconformidadsumproductos =  \DB::table('quejas')
                  ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto'))
                  ->join('productos','quejas.producto','=','productos.id')
                  ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                  ->where('quejas.idcompañia',$usuarios->id_compania)
                  ->where('quejas.area',$request->input('Area'))
                  ->groupBy('producto')
                  ->get();

                  $quejacount =  \DB::table('quejas')
                  ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                  ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                  ->where('quejas.idcompañia',$usuarios->id_compania)
                  ->where('estatus_id',$request->input('status'))
                  ->where('area',-1)
                  ->groupBy('mes')
                  ->get();
                }

                if($request->input('statusgrafica') != 0)
                {
                  $noconformidadcountproductos =  \DB::table('quejas')
                  ->select(DB::raw('count(producto) as total,productos.nombre as nombreproducto'))
                  ->join('productos','quejas.producto','=','productos.id')
                  ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                  ->where('quejas.idcompañia',$usuarios->id_compania)
                  ->where('quejas.estatus_id',$request->input('statusgrafica'))
                  ->groupBy('producto')
                  ->get();

                  $noconformidadtendenciaproducto =  \DB::table('quejas')
                  ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                  ->join('productos','quejas.producto','=','productos.id')
                  ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                  ->where('quejas.idcompañia',$usuarios->id_compania)
                  ->where('quejas.estatus_id',$request->input('statusgrafica'))
                  ->groupBy('mes')
                  ->get();

                  $noconformidadsumproductos =  \DB::table('quejas')
                  ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto'))
                  ->join('productos','quejas.producto','=','productos.id')
                  ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                  ->where('quejas.idcompañia',$usuarios->id_compania)
                  ->where('quejas.estatus_id',$request->input('statusgrafica'))
                  ->groupBy('producto')
                  ->get();

                  $quejacount =  \DB::table('quejas')
                  ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                  ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                  ->where('quejas.idcompañia',$usuarios->id_compania)
                  ->where('estatus_id',$request->input('status'))
                  ->where('area',-1)
                  ->groupBy('mes')
                  ->get();
                }

                if($request->input('statusgrafica') != 0 && $request->input('Area'))
                {
                  $noconformidadcountproductos =  \DB::table('quejas')
                  ->select(DB::raw('count(producto) as total,productos.nombre as nombreproducto'))
                  ->join('productos','quejas.producto','=','productos.id')
                  ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                  ->where('quejas.idcompañia',$usuarios->id_compania)
                  ->where('quejas.estatus_id',$request->input('statusgrafica'))
                  ->where('quejas.area',$request->input('Area'))
                  ->groupBy('producto')
                  ->get();

                  $noconformidadtendenciaproducto =  \DB::table('quejas')
                  ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                  ->join('productos','quejas.producto','=','productos.id')
                  ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                  ->where('quejas.idcompañia',$usuarios->id_compania)
                  ->where('quejas.estatus_id',$request->input('statusgrafica'))
                  ->where('quejas.area',$request->input('Area'))
                  ->groupBy('mes')
                  ->get();

                  $noconformidadsumproductos =  \DB::table('quejas')
                  ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto'))
                  ->join('productos','quejas.producto','=','productos.id')
                  ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                  ->where('quejas.idcompañia',$usuarios->id_compania)
                  ->where('quejas.estatus_id',$request->input('statusgrafica'))
                  ->where('quejas.area',$request->input('Area'))
                  ->groupBy('producto')
                  ->get();

                  $quejacount =  \DB::table('quejas')
                  ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                  ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                  ->where('quejas.idcompañia',$usuarios->id_compania)
                  ->where('estatus_id',$request->input('status'))
                  ->where('area',-1)
                  ->groupBy('mes')
                  ->get();
                }

              }
              if($request->input('tipografico') == 2)
              {
                if($request->input('Area') == 0 && $request->input('statusgrafica') == 0)
                {
                      $noconformidadcountproductos =  \DB::table('quejas')
                      ->select(DB::raw('count(area) as total,areas.nombre as nombreproducto'))
                      ->join('areas','quejas.area','=','areas.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->groupBy('area')
                      ->get();

                      $noconformidadtendenciaproducto =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->join('areas','quejas.area','=','areas.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->groupBy('mes')
                      ->get();

                      $noconformidadsumproductos =  \DB::table('quejas')
                      ->select(DB::raw('sum(monto) as total,areas.nombre as nombreproducto'))
                      ->join('areas','quejas.area','=','areas.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->groupBy('area')
                      ->get();

                      $quejacount =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('estatus_id',$request->input('status'))
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('area',-1)
                      ->groupBy('mes')
                      ->get();
                  }

                  if($request->input('Area') != 0)
                    {
                      $noconformidadcountproductos =  \DB::table('quejas')
                      ->select(DB::raw('count(area) as total,areas.nombre as nombreproducto'))
                      ->join('areas','quejas.area','=','areas.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('quejas.area',$request->input('Area'))
                      ->groupBy('area')
                      ->get();

                      $noconformidadtendenciaproducto =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->join('areas','quejas.area','=','areas.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('quejas.area',$request->input('Area'))
                      ->groupBy('mes')
                      ->get();

                      $noconformidadsumproductos =  \DB::table('quejas')
                      ->select(DB::raw('sum(monto) as total,areas.nombre as nombreproducto'))
                      ->join('areas','quejas.area','=','areas.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('quejas.area',$request->input('Area'))
                      ->groupBy('area')
                      ->get();

                      $quejacount =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('estatus_id',$request->input('status'))
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('area',-1)
                      ->groupBy('mes')
                      ->get();
                    }
                    if($request->input('statusgrafica') != 0)
                    {
                      $noconformidadcountproductos =  \DB::table('quejas')
                      ->select(DB::raw('count(area) as total,areas.nombre as nombreproducto'))
                      ->join('areas','quejas.area','=','areas.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('quejas.estatus_id',$request->input('statusgrafica'))
                      ->groupBy('area')
                      ->get();

                      $noconformidadtendenciaproducto =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->join('areas','quejas.area','=','areas.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('quejas.estatus_id',$request->input('statusgrafica'))
                      ->groupBy('mes')
                      ->get();

                      $noconformidadsumproductos =  \DB::table('quejas')
                      ->select(DB::raw('sum(monto) as total,areas.nombre as nombreproducto'))
                      ->join('areas','quejas.area','=','areas.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('quejas.estatus_id',$request->input('statusgrafica'))
                      ->groupBy('area')
                      ->get();

                      $quejacount =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('estatus_id',$request->input('status'))
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('area',-1)
                      ->groupBy('mes')
                      ->get();
                    }
                    if($request->input('statusgrafica') != 0 && $request->input('Area'))
                    {
                      $noconformidadcountproductos =  \DB::table('quejas')
                      ->select(DB::raw('count(area) as total,areas.nombre as nombreproducto'))
                      ->join('areas','quejas.area','=','areas.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('quejas.estatus_id',$request->input('statusgrafica'))
                      ->where('quejas.area',$request->input('Area'))
                      ->groupBy('area')
                      ->get();

                      $noconformidadtendenciaproducto =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->join('areas','quejas.area','=','areas.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('quejas.estatus_id',$request->input('statusgrafica'))
                      ->where('quejas.area',$request->input('Area'))
                      ->groupBy('mes')
                      ->get();

                      $noconformidadsumproductos =  \DB::table('quejas')
                      ->select(DB::raw('sum(monto) as total,areas.nombre as nombreproducto'))
                      ->join('areas','quejas.area','=','areas.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('quejas.estatus_id',$request->input('statusgrafica'))
                      ->where('quejas.area',$request->input('Area'))
                      ->groupBy('area')
                      ->get();

                      $quejacount =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('estatus_id',$request->input('status'))
                      ->where('quejas.idcompañia',$usuarios->id_compania)
                      ->where('area',-1)
                      ->groupBy('mes')
                      ->get();
                    }

              }

              if($request->input('tipografico') == 3)
              {
                  if($request->input('Area') == 0 && $request->input('statusgrafica') == 0)
                  {
                    $noconformidadcountproductos =  \DB::table('quejas')
                    ->select(DB::raw('count(quejas.proceso) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','quejas.proceso','=','procesos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->groupBy('quejas.proceso')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->join('procesos','quejas.proceso','=','procesos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('quejas')
                    ->select(DB::raw('sum(monto) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','quejas.proceso','=','procesos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->groupBy('quejas.proceso')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }

                  if($request->input('Area') != 0)
                  {
                    $noconformidadcountproductos =  \DB::table('quejas')
                    ->select(DB::raw('count(quejas.proceso) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','quejas.proceso','=','procesos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('quejas.area',$request->input('Area'))
                    ->groupBy('quejas.proceso')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->join('procesos','quejas.proceso','=','procesos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('quejas.area',$request->input('Area'))
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('quejas')
                    ->select(DB::raw('sum(monto) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','quejas.proceso','=','procesos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('quejas.area',$request->input('Area'))
                    ->groupBy('quejas.proceso')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }

                  if($request->input('statusgrafica') != 0)
                  {
                    $noconformidadcountproductos =  \DB::table('quejas')
                    ->select(DB::raw('count(quejas.proceso) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','quejas.proceso','=','procesos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('quejas.estatus_id',$request->input('statusgrafica'))
                    ->groupBy('quejas.proceso')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->join('procesos','quejas.proceso','=','procesos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('quejas.estatus_id',$request->input('statusgrafica'))
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('quejas')
                    ->select(DB::raw('sum(monto) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','quejas.proceso','=','procesos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('quejas.estatus_id',$request->input('statusgrafica'))
                    ->groupBy('quejas.proceso')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }

                  if($request->input('statusgrafica') != 0 && $request->input('Area') != 0)
                  {
                    $noconformidadcountproductos =  \DB::table('quejas')
                    ->select(DB::raw('count(quejas.proceso) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','quejas.proceso','=','procesos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('quejas.estatus_id',$request->input('statusgrafica'))
                    ->where('quejas.area',$request->input('Area'))
                    ->groupBy('quejas.proceso')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->join('procesos','quejas.proceso','=','procesos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('quejas.estatus_id',$request->input('statusgrafica'))
                    ->where('quejas.area',$request->input('Area'))
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('quejas')
                    ->select(DB::raw('sum(monto) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','quejas.proceso','=','procesos.id')
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('quejas.estatus_id',$request->input('statusgrafica'))
                    ->where('quejas.area',$request->input('Area'))
                    ->groupBy('quejas.proceso')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('quejas.idcompañia',$usuarios->id_compania)
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }
              }

            }
          //para la consulta de no conformidades de producto

          if($request->input('tipo') == 2)
            {
              if($request->input('tipografico') == 1)
                {
                  if($request->input('Area') == 0 && $request->input('statusgrafica') == 0)
                    {
                        $noconformidadcountproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('count(producto_id) as total,productos.nombre as nombreproducto, MONTH(fecha) as mes'))
                        ->join('productos','noconformidades.producto_id','=','productos.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->groupBy('mes','producto_id')
                        ->get();

                        $noconformidadtendenciaproducto =  \DB::table('noconformidades')
                        ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                        ->join('productos','noconformidades.producto_id','=','productos.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->groupBy('mes')
                        ->get();

                        $noconformidadsumproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto'))
                        ->join('productos','noconformidades.producto_id','=','productos.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->groupBy('producto_id')
                        ->get();

                        $quejacount =  \DB::table('quejas')
                        ->select(DB::raw('count(*) as total, MONTH(fecha_plan) as mes'))
                        ->whereBetween('fecha_plan', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('estatus_id',$request->input('status'))
                        ->where('area',-1)
                        ->groupBy('mes')
                        ->get();
                      }
                      if($request->input('Area') != 0)
                      {
                        $noconformidadcountproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('count(producto_id) as total,productos.nombre as nombreproducto, MONTH(fecha_plan) as mes'))
                        ->join('productos','noconformidades.producto_id','=','productos.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.id_area',$request->input('Area'))
                        ->groupBy('producto_id')
                        ->get();

                        $noconformidadtendenciaproducto =  \DB::table('noconformidades')
                        ->select(DB::raw('count(*) as total, MONTH(fecha_plan) as mes'))
                        ->join('productos','noconformidades.producto_id','=','productos.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.id_area',$request->input('Area'))
                        ->groupBy('mes')
                        ->get();

                        $noconformidadsumproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto'))
                        ->join('productos','noconformidades.producto_id','=','productos.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.id_area',$request->input('Area'))
                        ->groupBy('producto_id')
                        ->get();

                        $quejacount =  \DB::table('quejas')
                        ->select(DB::raw('count(*) as total, MONTH(fecha_plan) as mes'))
                        ->whereBetween('fecha_plan', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('estatus_id',$request->input('status'))
                        ->where('area',-1)
                        ->groupBy('mes')
                        ->get();
                      }

                      if($request->input('statusgrafica') != 0)
                      {
                        $noconformidadcountproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('count(producto_id) as total,productos.nombre as nombreproducto, MONTH(fecha_plan) as mes'))
                        ->join('productos','noconformidades.producto_id','=','productos.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                        ->groupBy('producto_id')
                        ->get();

                        $noconformidadtendenciaproducto =  \DB::table('noconformidades')
                        ->select(DB::raw('count(*) as total, MONTH(fecha_plan) as mes'))
                        ->join('productos','noconformidades.producto_id','=','productos.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                        ->groupBy('mes')
                        ->get();

                        $noconformidadsumproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto'))
                        ->join('productos','noconformidades.producto_id','=','productos.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                        ->groupBy('producto_id')
                        ->get();

                        $quejacount =  \DB::table('quejas')
                        ->select(DB::raw('count(*) as total, MONTH(fecha_plan) as mes'))
                        ->whereBetween('fecha_plan', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('area',-1)
                        ->groupBy('mes')
                        ->get();
                      }

                      if($request->input('statusgrafica') != 0 && $request->input('Area') != 0)
                      {
                        $noconformidadcountproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('count(producto_id) as total,productos.nombre as nombreproducto, MONTH(fecha_plan) as mes'))
                        ->join('productos','noconformidades.producto_id','=','productos.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                        ->where('noconformidades.id_area',$request->input('Area'))
                        ->groupBy('producto_id')
                        ->get();

                        $noconformidadtendenciaproducto =  \DB::table('noconformidades')
                        ->select(DB::raw('count(*) as total, MONTH(fecha_plan) as mes'))
                        ->join('productos','noconformidades.producto_id','=','productos.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                        ->where('noconformidades.id_area',$request->input('Area'))
                        ->groupBy('mes')
                        ->get();

                        $noconformidadsumproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto'))
                        ->join('productos','noconformidades.producto_id','=','productos.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                        ->where('noconformidades.id_area',$request->input('Area'))
                        ->groupBy('producto_id')
                        ->get();

                        $quejacount =  \DB::table('quejas')
                        ->select(DB::raw('count(*) as total, MONTH(fecha_plan) as mes'))
                        ->whereBetween('fecha_plan', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('area',-1)
                        ->groupBy('mes')
                        ->get();
                      }
                }

                if($request->input('tipografico') == 2)
                {
                    if($request->input('Area') == 0 && $request->input('statusgrafica') == 0 )
                    {
                        $noconformidadcountproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('count(id_area) as total,areas.nombre as nombreproducto'))
                        ->join('areas','noconformidades.id_area','=','areas.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->groupBy('id_area')
                        ->get();

                        $noconformidadtendenciaproducto =  \DB::table('noconformidades')
                        ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                        ->join('areas','noconformidades.id_area','=','areas.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->groupBy('mes')
                        ->get();

                        $noconformidadsumproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('sum(monto) as total,areas.nombre as nombreproducto'))
                        ->join('areas','noconformidades.id_area','=','areas.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->groupBy('id_area')
                        ->get();

                        $quejacount =  \DB::table('quejas')
                        ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('area',-1)
                        ->groupBy('mes')
                        ->get();
                      }

                      if($request->input('Area') != 0)
                      {
                        $noconformidadcountproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('count(id_area) as total,areas.nombre as nombreproducto'))
                        ->join('areas','noconformidades.id_area','=','areas.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.id_area',$request->input('Area'))
                        ->groupBy('id_area')
                        ->get();

                        $noconformidadtendenciaproducto =  \DB::table('noconformidades')
                        ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                        ->join('areas','noconformidades.id_area','=','areas.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.id_area',$request->input('Area'))
                        ->groupBy('mes')
                        ->get();

                        $noconformidadsumproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('sum(monto) as total,areas.nombre as nombreproducto'))
                        ->join('areas','noconformidades.id_area','=','areas.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.id_area',$request->input('Area'))
                        ->groupBy('id_area')
                        ->get();

                        $quejacount =  \DB::table('quejas')
                        ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('area',-1)
                        ->groupBy('mes')
                        ->get();
                      }

                      if($request->input('statusgrafica') != 0)
                      {
                        $noconformidadcountproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('count(id_area) as total,areas.nombre as nombreproducto'))
                        ->join('areas','noconformidades.id_area','=','areas.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                        ->groupBy('id_area')
                        ->get();

                        $noconformidadtendenciaproducto =  \DB::table('noconformidades')
                        ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                        ->join('areas','noconformidades.id_area','=','areas.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                        ->groupBy('mes')
                        ->get();

                        $noconformidadsumproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('sum(monto) as total,areas.nombre as nombreproducto'))
                        ->join('areas','noconformidades.id_area','=','areas.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                        ->groupBy('id_area')
                        ->get();

                        $quejacount =  \DB::table('quejas')
                        ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('area',-1)
                        ->groupBy('mes')
                        ->get();
                      }

                      if($request->input('Area') != 0 && $request->input('statusgrafica') != 0)
                      {
                        $noconformidadcountproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('count(id_area) as total,areas.nombre as nombreproducto'))
                        ->join('areas','noconformidades.id_area','=','areas.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                        ->where('noconformidades.id_area',$request->input('Area'))
                        ->groupBy('id_area')
                        ->get();

                        $noconformidadtendenciaproducto =  \DB::table('noconformidades')
                        ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                        ->join('areas','noconformidades.id_area','=','areas.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                        ->where('noconformidades.id_area',$request->input('Area'))
                        ->groupBy('mes')
                        ->get();

                        $noconformidadsumproductos =  \DB::table('noconformidades')
                        ->select(DB::raw('sum(monto) as total,areas.nombre as nombreproducto'))
                        ->join('areas','noconformidades.id_area','=','areas.id')
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('noconformidades.idcompañia',$usuarios->id_compania)
                        ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                        ->where('noconformidades.id_area',$request->input('Area'))
                        ->groupBy('id_area')
                        ->get();

                        $quejacount =  \DB::table('quejas')
                        ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                        ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                        ->where('area',-1)
                        ->groupBy('mes')
                        ->get();
                      }
                }

                if($request->input('tipografico') == 3)
                {
                    if($request->input('Area') == 0 && $request->input('statusgrafica') == 0)
                    {
                      $noconformidadcountproductos =  \DB::table('noconformidades')
                      ->select(DB::raw('count(proceso_id) as total,procesos.proceso as nombreproducto'))
                      ->join('procesos','noconformidades.proceso_id','=','procesos.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('noconformidades.idcompañia',$usuarios->id_compania)
                      ->groupBy('proceso_id')
                      ->get();

                      $noconformidadtendenciaproducto =  \DB::table('noconformidades')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->join('procesos','noconformidades.proceso_id','=','procesos.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('noconformidades.idcompañia',$usuarios->id_compania)
                      ->groupBy('mes')
                      ->get();

                      $noconformidadsumproductos =  \DB::table('noconformidades')
                      ->select(DB::raw('sum(monto) as total,procesos.proceso as nombreproducto'))
                      ->join('procesos','noconformidades.proceso_id','=','procesos.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('noconformidades.idcompañia',$usuarios->id_compania)
                      ->groupBy('proceso_id')
                      ->get();

                      $quejacount =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('area',-1)
                      ->groupBy('mes')
                      ->get();
                    }

                    if($request->input('Area') != 0)
                    {
                      $noconformidadcountproductos =  \DB::table('noconformidades')
                      ->select(DB::raw('count(proceso_id) as total,procesos.proceso as nombreproducto'))
                      ->join('procesos','noconformidades.proceso_id','=','procesos.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('noconformidades.idcompañia',$usuarios->id_compania)
                      ->where('noconformidades.id_area',$request->input('Area'))
                      ->groupBy('proceso_id')
                      ->get();

                      $noconformidadtendenciaproducto =  \DB::table('noconformidades')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->join('procesos','noconformidades.proceso_id','=','procesos.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('noconformidades.idcompañia',$usuarios->id_compania)
                      ->where('noconformidades.id_area',$request->input('Area'))
                      ->groupBy('mes')
                      ->get();

                      $noconformidadsumproductos =  \DB::table('noconformidades')
                      ->select(DB::raw('sum(monto) as total,procesos.proceso as nombreproducto'))
                      ->join('procesos','noconformidades.proceso_id','=','procesos.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('noconformidades.idcompañia',$usuarios->id_compania)
                      ->where('noconformidades.id_area',$request->input('Area'))
                      ->groupBy('proceso_id')
                      ->get();

                      $quejacount =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('area',-1)
                      ->groupBy('mes')
                      ->get();
                    }

                    if($request->input('statusgrafica') != 0)
                    {
                      $noconformidadcountproductos =  \DB::table('noconformidades')
                      ->select(DB::raw('count(proceso_id) as total,procesos.proceso as nombreproducto'))
                      ->join('procesos','noconformidades.proceso_id','=','procesos.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('noconformidades.idcompañia',$usuarios->id_compania)
                      ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                      ->groupBy('proceso_id')
                      ->get();

                      $noconformidadtendenciaproducto =  \DB::table('noconformidades')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->join('procesos','noconformidades.proceso_id','=','procesos.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('noconformidades.idcompañia',$usuarios->id_compania)
                      ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                      ->groupBy('mes')
                      ->get();

                      $noconformidadsumproductos =  \DB::table('noconformidades')
                      ->select(DB::raw('sum(monto) as total,procesos.proceso as nombreproducto'))
                      ->join('procesos','noconformidades.proceso_id','=','procesos.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('noconformidades.idcompañia',$usuarios->id_compania)
                      ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                      ->groupBy('proceso_id')
                      ->get();

                      $quejacount =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('area',-1)
                      ->groupBy('mes')
                      ->get();
                    }

                    if($request->input('statusgrafica') != 0 && $request->input('Area') != 0 )
                    {
                      $noconformidadcountproductos =  \DB::table('noconformidades')
                      ->select(DB::raw('count(proceso_id) as total,procesos.proceso as nombreproducto'))
                      ->join('procesos','noconformidades.proceso_id','=','procesos.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('noconformidades.idcompañia',$usuarios->id_compania)
                      ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                      ->where('noconformidades.area',$request->input('Area'))
                      ->groupBy('proceso_id')
                      ->get();

                      $noconformidadtendenciaproducto =  \DB::table('noconformidades')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->join('procesos','noconformidades.proceso_id','=','procesos.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('noconformidades.idcompañia',$usuarios->id_compania)
                      ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                      ->where('noconformidades.area',$request->input('Area'))
                      ->groupBy('mes')
                      ->get();

                      $noconformidadsumproductos =  \DB::table('noconformidades')
                      ->select(DB::raw('sum(monto) as total,procesos.proceso as nombreproducto'))
                      ->join('procesos','noconformidades.proceso_id','=','procesos.id')
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('noconformidades.idcompañia',$usuarios->id_compania)
                      ->where('noconformidades.estatus_id',$request->input('statusgrafica'))
                      ->where('noconformidades.area',$request->input('Area'))
                      ->groupBy('proceso_id')
                      ->get();

                      $quejacount =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('area',-1)
                      ->groupBy('mes')
                      ->get();
                    }
                }
              //dd($quejacountproductos);
            }

            if($request->input('tipo') == 3)
            {
              if($request->input('tipografico') == 1)
              {

                if($request->input('Area') == 0 && $request->input('statusgrafica') == 0)
                {
                      $noconformidadcountproductos =  \DB::table('accioncorrectiva1s')
                      ->select(DB::raw('count(producto_id) as total,productos.nombre as nombreproducto'))
                      ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                      ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                      ->groupBy('producto_id')
                      ->get();

                      $noconformidadtendenciaproducto =  \DB::table('accioncorrectiva1s')
                      ->select(DB::raw('count(*) as total, MONTH(fechaalta) as mes'))
                      ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                      ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                      ->groupBy('mes')
                      ->get();

                      $noconformidadsumproductos =  \DB::table('accioncorrectiva1s')
                      ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto'))
                      ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                      ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                      ->groupBy('producto_id')
                      ->get();

                      $quejacount =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('estatus_id',$request->input('status'))
                      ->where('area',-1)
                      ->groupBy('mes')
                      ->get();
                  }

                  if($request->input('Area') != 0)
                  {
                    $noconformidadcountproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(producto_id) as total,productos.nombre as nombreproducto'))
                    ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('producto_id')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(*) as total, MONTH(fechaalta) as mes'))
                    ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto'))
                    ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('producto_id')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }

                  if($request->input('statusgrafica') != 0)
                  {
                    $noconformidadcountproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(producto_id) as total,productos.nombre as nombreproducto'))
                    ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->groupBy('producto_id')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(*) as total, MONTH(fechaalta) as mes'))
                    ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto'))
                    ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->groupBy('producto_id')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }

                  if($request->input('Area') != 0 && $request->input('statusgrafica') != 0)
                  {
                    $noconformidadcountproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(producto_id) as total,productos.nombre as nombreproducto'))
                    ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('producto_id')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(*) as total, MONTH(fechaalta) as mes'))
                    ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('sum(monto) as total,productos.nombre as nombreproducto'))
                    ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('producto_id')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }
              }

              if($request->input('tipografico') == 2)
              {
                if($request->input('Area') == 0 && $request->input('statusgrafica') == 0)
                {
                      $noconformidadcountproductos =  \DB::table('accioncorrectiva1s')
                      ->select(DB::raw('count(area) as total,areas.nombre as nombreproducto'))
                      ->join('areas','accioncorrectiva1s.area','=','areas.id')
                      ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                      ->groupBy('area')
                      ->get();

                      $noconformidadtendenciaproducto =  \DB::table('accioncorrectiva1s')
                      ->select(DB::raw('count(*) as total, MONTH(fechaalta) as mes'))
                      ->join('areas','accioncorrectiva1s.area','=','areas.id')
                      ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                      ->groupBy('mes')
                      ->get();

                      $noconformidadsumproductos =  \DB::table('accioncorrectiva1s')
                      ->select(DB::raw('sum(monto) as total,areas.nombre as nombreproducto'))
                      ->join('areas','accioncorrectiva1s.area','=','areas.id')
                      ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                      ->groupBy('area')
                      ->get();

                      $quejacount =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('estatus_id',$request->input('status'))
                      ->where('area',-1)
                      ->groupBy('mes')
                      ->get();
                  }

                  if($request->input('Area') != 0)
                  {
                    $noconformidadcountproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(area) as total,areas.nombre as nombreproducto'))
                    ->join('areas','accioncorrectiva1s.area','=','areas.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('area')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(*) as total, MONTH(fechaalta) as mes'))
                    ->join('areas','accioncorrectiva1s.area','=','areas.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('sum(monto) as total,areas.nombre as nombreproducto'))
                    ->join('areas','accioncorrectiva1s.area','=','areas.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('area')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }

                  if($request->input('statusgrafica') != 0)
                  {
                    $noconformidadcountproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(area) as total,areas.nombre as nombreproducto'))
                    ->join('areas','accioncorrectiva1s.area','=','areas.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->groupBy('area')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(*) as total, MONTH(fechaalta) as mes'))
                    ->join('areas','accioncorrectiva1s.area','=','areas.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('sum(monto) as total,areas.nombre as nombreproducto'))
                    ->join('areas','accioncorrectiva1s.area','=','areas.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->groupBy('area')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }

                  if($request->input('statusgrafica') != 0 && $request->input('Area'))
                  {
                    $noconformidadcountproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(area) as total,areas.nombre as nombreproducto'))
                    ->join('areas','accioncorrectiva1s.area','=','areas.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('area')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(*) as total, MONTH(fechaalta) as mes'))
                    ->join('areas','accioncorrectiva1s.area','=','areas.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('sum(monto) as total,areas.nombre as nombreproducto'))
                    ->join('areas','accioncorrectiva1s.area','=','areas.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('area')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }
              }

              if($request->input('tipografico') == 3)
              {
                if($request->input('Area') == 0 && $request->input('statusgrafica') == 0)
                {
                      $noconformidadcountproductos =  \DB::table('accioncorrectiva1s')
                      ->select(DB::raw('count(id_proceso) as total,procesos.proceso as nombreproducto'))
                      ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                      ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                      ->groupBy('id_proceso')
                      ->get();

                      $noconformidadtendenciaproducto =  \DB::table('accioncorrectiva1s')
                      ->select(DB::raw('count(*) as total, MONTH(fechaalta) as mes'))
                      ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                      ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                      ->groupBy('mes')
                      ->get();

                      $noconformidadsumproductos =  \DB::table('accioncorrectiva1s')
                      ->select(DB::raw('sum(monto) as total,procesos.proceso as nombreproducto'))
                      ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                      ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                      ->groupBy('id_proceso')
                      ->get();

                      $quejacount =  \DB::table('quejas')
                      ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                      ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                      ->where('estatus_id',$request->input('status'))
                      ->where('area',-1)
                      ->groupBy('mes')
                      ->get();
                  }

                  if($request->input('Area') != 0)
                  {
                    $noconformidadcountproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(id_proceso) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('id_proceso')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(*) as total, MONTH(fechaalta) as mes'))
                    ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('sum(monto) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('id_proceso')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }

                  if($request->input('statusgrafica') != 0)
                  {
                    $noconformidadcountproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(id_proceso) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->groupBy('id_proceso')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(*) as total, MONTH(fechaalta) as mes'))
                    ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('sum(monto) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->groupBy('id_proceso')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }
                  if($request->input('Area') != 0 && $request->input('statusgrafica') != 0)
                  {
                    $noconformidadcountproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(id_proceso) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('id_proceso')
                    ->get();

                    $noconformidadtendenciaproducto =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('count(*) as total, MONTH(fechaalta) as mes'))
                    ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('mes')
                    ->get();

                    $noconformidadsumproductos =  \DB::table('accioncorrectiva1s')
                    ->select(DB::raw('sum(monto) as total,procesos.proceso as nombreproducto'))
                    ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                    ->whereBetween('fechaalta', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('accioncorrectiva1s.idcompañia',$usuarios->id_compania)
                    ->where('accioncorrectiva1s.estatus_id',$request->input('statusgrafica'))
                    ->where('accioncorrectiva1s.area',$request->input('Area'))
                    ->groupBy('id_proceso')
                    ->get();

                    $quejacount =  \DB::table('quejas')
                    ->select(DB::raw('count(*) as total, MONTH(fecha) as mes'))
                    ->whereBetween('fecha', [$request->input('fechainicio'),$request->input('fechafin')])
                    ->where('estatus_id',$request->input('status'))
                    ->where('area',-1)
                    ->groupBy('mes')
                    ->get();
                  }
              }
            }

                          return view('/Principales/Dashboard/DashboardMejora', compact('Queja','area','noconformidadcountproductos','quejacount','noconformidadsumproductos','noconformidadtendenciaproducto','estatus','area'));

          //dd($quejacount);
          // $quejacount = \DB::table('quejas')->count();
          // return view('/Principales/Dashboard/DashboardMejora', compact('Queja','quejacount','area','quejacountproductos'));
  }
}
