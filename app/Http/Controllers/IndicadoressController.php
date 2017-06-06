<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Indicadores;
use App\Models\Frecuencias;
use App\Models\Unidades;
use App\Models\Objetivo;
use App\Models\User;
use App\Models\Logica;
use App\Models\lista_acceso;

class IndicadoressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('indicadores');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $user = Auth::user();
      $indicadores = new Indicadores;
      $indicador = $indicadores->where('id_compania',$Users->id_compania);
      //checar los datos
      //dd($indicador->all());

      $frecuencia = new frecuencias;
      $frecuencias = $frecuencia->all();

      $unidad = new unidades;
      $unidades = $unidad->all();

      $objetivos = new Objetivo;
      $objetivo = $objetivos->all();

      $Users = new User;
      $User = $Users->all();

      $logicas = new logica;
      $logica = $logicas->all();

      $acceso = \DB::table('users')
                        ->select('indicadores_accesos.id_proceso','users.id','users.usuario')
                        ->leftjoin('indicadores_accesos','users.id', '=', 'indicadores_accesos.id_usuario')
                        ->get();

      //dd($objetivos->all());
      return View('crearindicador', compact('indicador', 'frecuencias','unidades','objetivo','User','logica'));
      //return view('crearindicador', ['indicadores' => $indicador->toArray()], ['frecuencias' => $frecuencias->toArray()], ['unidades' => $unidades->toArray()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      /*metodo corto
        $indicador = Indicadores;
        $indicador->create($request->all());
      */
      //por si no jala el siguiente codigo si funciona
      $indicador = new Indicadores;
      $indicador->objetivo_id = $request->input("objetivo_id");
      $indicador->nombre = $request->input("nombre");
      $indicador->descripcion = $request->input("descripcion");
      $indicador->usuario_responsable_id = $request->input("usuario_responsable_id");
      $indicador->frecuencia_id = $request->input("frecuencia_id");
      $indicador->unidad = $request->input("unidad");
      $indicador->logica = $request->input("logica");
      $indicador->meta = $request->input("meta");
      $idacceso = uniqid();
      $indicador->acceso = $idacceso;
      $indicador->save();

      $acceso=$request->input('lista_de_acceso'); //$_POST["lista_de_distribucion"];
      for ($i=0;$i<count($acceso);$i++)
      {
        $lista = new lista_acceso;
        $lista->id_usuario = $acceso[$i];
        $lista->id_indicador = $idacceso;
        $lista->save();
      }
      return redirect('/objetivos/visual');
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
      $indicador = Indicadores::findorfail($id);
      $indicador->objetivo_id = $request->input("objetivo_id");
      $indicador->nombre = $request->input("nombre");
      $indicador->descripcion = $request->input("descripcion");
      $indicador->usuario_responsable_id = $request->input("usuario_responsable_id");
      $indicador->frecuencia_id = $request->input("frecuencia_id");
      $indicador->unidad = $request->input("unidad");
      $indicador->logica = $request->input("logica");
      $indicador->meta = $request->input("meta");
      $indicador->acceso = $request->input("lista_de_acceso");
      $indicador->save();

      return redirect('/objetivos/visual');
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
      $indicadores = Indicadores::find($id);
      if (is_null ($indicadores))
      {
          App::abort(404);
      }

      $paralista = $indicadores->acceso;

      DB::table('lista_accesos')->where('id_indicador',$paralista)->delete();

      $indicadores->delete();



      return redirect('/objetivos/visual');
    }
}
