<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Abcriesgos;
use App\Models\Tiporiesgos;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AbcriesgosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          return view('Abcriesgos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $usuarios = Auth::user();
      $Abcriesgo = new Abcriesgos;
      $Abcriesgos = $Abcriesgo->where('id_compania',$usuarios->id_compania)->get();

      $Tiporiesgo = new Tiporiesgos;
      $Tiporiesgos = $Tiporiesgo->all();

      $riesgorelacion = \DB::table('abcriesgos')
                               ->leftjoin('tiporiesgos','abcriesgos.tipo_riesgo_id','=','tiporiesgos.id')
                               ->select('abcriesgos.*','tiporiesgos.id as tipo_id','tiporiesgos.nombre as tipo_nombre')
                               ->where('abcriesgos.id_compania',$usuarios->id_compania)
                               ->get();

      //return(dd($riesgorelacion));
      return View('/Principales/abcriesgoVisual', compact('Abcriesgos', 'Tiporiesgos','riesgorelacion'));
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
        $Abcriesgo = new Abcriesgos;
        $Abcriesgo->tipo_riesgo_id = $request->input('tipo_id_riesgo');
        $Abcriesgo->nombre = $request->input('riesgo');
        $Abcriesgo->descripcion = $request->input('descripcion');
        $Abcriesgo->id_compania = $usuarios->id_compania;
        $Abcriesgo->save();

      return redirect('abcriesgos/create');
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
    public function edit($id,Request $request)
    {

    $Abcriesgo = Abcriesgos::findOrFail($id);
    $Abcriesgo->tipo_riesgo_id = $request->input('tipo_id_riesgo');
    $Abcriesgo->nombre = $request->input('riesgo');
    $Abcriesgo->descripcion = $request->input('descripcion');
    $Abcriesgo->save();

  return redirect('abcriesgos/create');

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
      $abcriesgo = Abcriesgos::find($id);
      if (is_null ($abcriesgo))
      {
          App::abort(404);
      }

      $abcriesgo->delete();

      return redirect('abcriesgos/create');
    }
}
