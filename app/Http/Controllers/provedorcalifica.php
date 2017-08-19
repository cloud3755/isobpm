<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\insumos;
use App\Models\proveedores;
use App\Models\provedorinsumo;
use App\Models\User;
use App\Models\Proveedorcalifica;
use App\Models\Areas;
use App\Models\insumoscalificados;


class provedorcalifica extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;

      $proveedores = new proveedores;
      $proveedor = $proveedores->where('id_compania',$compañiaid)->orderBy('id')->get();

      $areas = new Areas;
      $area = $areas->where('id_compania',$compañiaid)->orderBy('id')->get();


      return view('/Secundarias/provedorcalifica',compact('proveedor','area'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexinsumo($id)
    {
      $usuarios = Auth::user();
      $listainsumo = DB::table('provedorinsumos')
                               ->join('insumos','provedorinsumos.idinsumo','=','insumos.id')
                               ->select('provedorinsumos.id as id','insumos.Producto_o_Servicio as Producto_o_Servicio','insumos.id as idinsumo')
                               ->where('provedorinsumos.idproveedor','=',$id)
                               ->get();

      return response()->json($listainsumo);

    }


    public function indexarea()
    {
      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;

      $area = DB::table('areas')
                               ->select('*')
                               ->where('areas.id_compania','=',$compañiaid)
                               ->get();

      return response()->json($area);

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

      $compañiaid = $usuarios->id_compania;
      $iduser = $usuarios->id;



      if (!\Input::file('archivo'))
      {
                 $archivo = 'No se cargo archivo';
                 $nombreunicoarchivo1 = 'No se cargo archivo';
                 $bytes = 0;
      }
      else {
                $file1                            = $request->file('archivo');
                $extension1                       = strtolower($file1->getclientoriginalextension());
                $nombreunicoarchivo1              = uniqid().'.'.$extension1;
                $bytes                            = \File::size($file1);
                $archivo = $file1->getClientOriginalName();
      }


      $fecha = $request->input('fechacalificacion');


      $idd = DB::table('Proveedorcalifica')->insertGetId(
          [
           'idproveedor' => $request->input('proveedorid'),
           'pedido' =>  $request->input('pedido'),
           'tiempo' => $request->input('Tiempo'),
           'calidad' => $request->input('calidad'),
           'servicio' => $request->input('servicio'),
           'costo' => $request->input('costo'),
           'idautor'=> $iduser,
           'idarea' => $request->input('area'),
           'idcompania' => $compañiaid,
           'archivo' => $archivo,
           'nombreunico' => $nombreunicoarchivo1 ,
           'size' => $bytes ,
           'fechacalificacion' => $fecha
           ]);




           $ins=$request->input('elistaSeleccionada');


           for ($i=0;$i<count($ins);$i++)
           {
             $inscal = new insumoscalificados;
             $inscal->idcalificacion = $idd;
             $inscal->idinsumo = $ins[$i];
             $inscal->idcompañia = $compañiaid;
             $inscal->idautor = $iduser;
             $inscal->idarea = $request->input('area');
             $inscal->save();
           }



           if (!\Input::file('archivo'))
           {

           }
               else {
                 \Storage::disk('calificaproveedor')->put($nombreunicoarchivo1,  \File::get($file1));
               }

        return redirect('/proveedores');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function resultadoindex()
     {
       $usuarios = Auth::user();
       $compañiaid = $usuarios->id_compania;

       $proveedores = new proveedores;
       $proveedor = $proveedores->where('id_compania',$compañiaid)->orderBy('id')->get();

       $areas = new Areas;
       $area = $areas->where('id_compania',$compañiaid)->orderBy('id')->get();

       $insumos = new insumos;
       $insumo = $insumos->where('idcompañia',$compañiaid)->orderBy('id')->get();

       $yesterday = Carbon::yesterday();

       $tomorrow = Carbon::tomorrow('Europe/London');

       $totalcalificaciones = DB::table('proveedores')
                                ->join('proveedorcalifica','proveedores.id','=','proveedorcalifica.idproveedor')
                                ->join('insumoscalificados','insumoscalificados.idcalificacion','=','proveedorcalifica.id')
                                ->select('*')
                                ->where('proveedores.id_compania','=',$compañiaid)
                                ->get();
       return(dd($totalcalificaciones));

       return view('\Secundarias\provedorcalificaresultado',compact('proveedor','area','insumo','tomorrow','yesterday'));
     }




    public function showresult($provedorid,$insumoid,Request $request)
    {
        //
        $usuarios = Auth::user();


        $calificacion = DB::table('proveedorcalifica')
                                 ->select(DB::raw('proveedorcalifica.pedido as Pedido'),DB::raw('proveedorcalifica.tiempo as Tiempo'),DB::raw('proveedorcalifica.calidad as Calidad'),DB::raw('proveedorcalifica.servicio as Servicio'),DB::raw('proveedorcalifica.costo as Costo'))
                                 ->where('proveedorcalifica.idproveedor','=',$provedorid)
                                 ->where('proveedorcalifica.idinsumo','=',$insumoid)
                                 ->orderby('proveedorcalifica.id')
                                 ->get();




         $result[] = ['   Pedido','   Tiempo','   Calidad','   Servicio','   Costo'];
         foreach ($calificacion as $key => $value) {
             $result[++$key] = [$value->Pedido, (int)$value->Tiempo, (int)$value->Calidad, (int)$value->Servicio, (int)$value->Costo];
         }
                                 return response()->json($result);


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
