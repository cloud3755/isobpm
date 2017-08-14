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


      return view('/Secundarias/provedorcalifica',compact('proveedor'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $usuarios = Auth::user();

      $idd = DB::table('Proveedorcalifica')->insertGetId(
          [
           'idproveedor' => $request->input('proveedorid'),
           'idinsumo' => $request->input('insumoid'),
           'pedido' =>  $request->input('pedido'),
           'tiempo' => $request->input('Tiempo'),
           'calidad' => $request->input('calidad'),
           'servicio' => $request->input('servicio'),
           'costo' => $request->input('costo')
           ]);


        return redirect('/proveedores');
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
