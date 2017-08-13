<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\insumos;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class insumoscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuario = Auth::user();
        //
        $compañiaid = $usuario->id_compania;



        $insumos = new insumos;
        $insumo = $insumos->where('idcompañia',$compañiaid)->orderBy('id')->get();

        return view('Secundarias\insumos',compact('usuario','insumo'));
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

        $Users = Auth::user();
        $compañiaid = $Users->id_compania;

        $insumos= new insumos;
        $insumos->producto_o_servicio = $request->input('producto');
        $insumos->descripcion = $request->input('descripcion');
        $insumos->tipo = $request->input('tipo');
        $insumos->idcompañia = $compañiaid;
        $insumos->save();

        return Redirect('/insumos');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

      public function show($id){
        $Users = Auth::user();
        $insumo = insumos::findorfail($id);
          return response()->json($insumo->toArray());
        }



    public function edit($id,Request $request)
    {
      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;
      $insumo = insumos::findorfail($id);
      $insumo->producto_o_servicio = $request->input('eproducto');
      $insumo->descripcion = $request->input('edescripcion');
      $insumo->tipo = $request->input('etipo');
      $insumo->idcompañia = $compañiaid;
      $insumo->save();
      return response()->json([
        'mensaje' => "listo"
      ]);

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
      $insumo = insumos::findorfail($id);
      $insumo-> delete();
      return Redirect('/insumos');
    }
}
