<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Objetivo;
use App\Models\Indicadores;
use App\Models\Analisisriesgos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.aa
     *
     * @return \Illuminate\Http\Response
     */
    public function objetivos()
    {
      $usuarios = Auth::user();
      $objetivos = new Objetivo;
      $objetivo = $objetivos->where('id_compania',$usuarios->id_compania)->get();

  //    $indicadores = new Indicadores;
    //  $indicador = $indicadores->whereIn('objetivo_id',$objetivo->id)->get();

//      $indicador = DB::table('indicadores')
//                    ->whereIn('id', [$objetivo['id']])
//                    ->get();

      $indicador = DB::table('indicadores')
      ->join('objetivos', 'indicadores.objetivo_id', '=', 'objetivos.id')
      ->select('indicadores.*', 'objetivos.id_compania')
      ->where('objetivos.id_compania',$usuarios->id_compania)
      ->get();

      return View('submenu/objetivosindicadores', compact('objetivo', 'indicador'));
}

    public function riesgos()
    {
      $Analisisriesgos = new Analisisriesgos;
      $Analisisriesgo = $Analisisriesgos->all();

      return View('submenu/riesgos', compact('indicador'));
    }

    public function mejoras()
    {

      return View('submenu/Mejoras');
    }

    public function admin()
    {
      $usuarios = Auth::user();
      if ($usuarios->perfil != 4) {
        return View('submenu/Administracion');
      }else {
        return redirect('/bienvenida');
      }
    }

    public function infdocumentada()
    {

      return View('submenu/infdocumentada');
    }

    public function promejoras()
    {

      //return View('submenu/Promejora');
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
