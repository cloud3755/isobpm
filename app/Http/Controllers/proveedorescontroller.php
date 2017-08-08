<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\insumos;
use App\Models\proveedores;
use App\Models\insumpoproveedor;

class proveedorescontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        $usuario = Auth::user();
        //
        $compañiaid = $usuario->id_compania;


        $insumos = new insumos;
        $insumo = $insumos->where('idcompañia',$compañiaid)->orderBy('id')->get();
        $cuentainsumo = $insumo->count();

        $proveedores = new proveedores;
        $proveedor = $proveedores->where('id_compania',$compañiaid)->orderBy('id')->get();
        $cuentaproveedor = $proveedor->count();


      return view('Principales\proveedores',compact('cuentainsumo','cuentaproveedor'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrar()
    {
      $usuario = Auth::user();
      //
      $compañiaid = $usuario->id_compania;

      $insumos = new insumos;
      $insumo = $insumos->where('idcompañia',$compañiaid)->orderBy('id')->get();

      $proveedores = new proveedores;
      $provedor = $proveedores->where('id_compania',$compañiaid)->orderBy('id')->get();
      $cuentaproveedor = $provedor->count();
      
    return view('\Principales\proveedoreslist',compact('insumo','provedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $usuario = Auth::user();
      $compañiaid = $usuario->id_compania;

      $provedor = new proveedores;
      $provedor->id_compania = $compañiaid;
      $provedor->proveedor = $request->input('proveedor');
      $provedor->email = $request->input('email');
      $provedor->telefono = $request->input('telefono');
      $provedor->activo = $request->input('activo');
      $provedor->direccion = $request->input('direccion');
      $provedor->observaciones = $request->input('observaciones');
      $provedor->save();

      return redirect('/proveedores/mostrar');


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
      $provedor = proveedores::findorfail($id);
      $provedor-> delete();
      return redirect('/proveedores/mostrar');
    }
}
