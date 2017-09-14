<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Objetivo;
use App\Models\Tipo_objetivo;
use App\Models\relobjetivotipo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ObjetivosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('objetivos');
    }
    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {

      $usuarios = Auth::user();

        $objetivos = new Objetivo;
        $objetivo = $objetivos->where('id_compania',$usuarios->id_compania)->get();

        $Tipo_objetivos = new Tipo_objetivo;
        $Tipo_objetivo = $Tipo_objetivos->all();

        $Users = new User;
        $User = $Users->where('id_compania',$usuarios->id_compania)->get();


        //$usuarios = collect($usercompleto);
        //para validar el arreglo
      //  dd($usercompleto);
        return View('CreateObjetivo', compact('objetivo', 'Tipo_objetivo','User','usuarios'));
        //return view('CreateObjetivo',['objetivo' => $objetivo->toArray()], ['Tipo_objetivo' => $Tipo_objetivo->toArray()], ['User' => $User->toArray()]);
    }

    public function store(Request $request)
    {
      $user = Auth::user();
      $objetivo= new Objetivo;
      $objetivo->tipo_objetivo_id = $request->input('tipo_objetivo_id');
      $objetivo->nombre = $request->input('nombre');
      $objetivo->descripcion = $request->input('descripcion');
      $hoy = new \DateTime();
      $objetivo->fecha = $hoy;
      $objetivo->usuario_responsable_id = $request->input('usuario_responsable_id');
      $objetivo->usuario_creador_id     = $request->input('creador_id');
      $objetivo->id_compania            = $user->id_compania;
      $objetivo->Creador_id             = $user->id;

      $objetivo->save();

        session()->flash('flash_msg',"Se creó un objetivo");
        session()->flash('flash_type','warning');

      return redirect('objetivos/visual');
    }

    public function destroy($id)
    {
      $objetivo = Objetivo::find($id);
      if (is_null ($objetivo))
      {
          App::abort(404);
      }

      $objetivo-> delete();

      return redirect('objetivos/visual');
    }

    public function edit($id,Request $request)
    {

      $objetivo = Objetivo::findOrFail($id);
      $objetivo->tipo_objetivo_id = $request->input('tipo_objetivo_id');
      $objetivo->nombre = $request->input('nombre');
      $objetivo->descripcion = $request->input('descripcion');
      $hoy = new \DateTime();
      $objetivo->fecha = $hoy;
      $objetivo->usuario_responsable_id = $request->input('usuario_responsable_id');
      $objetivo->usuario_creador_id = $request->input('creador_id');
      $objetivo->save();

        session()->flash('flash_msg',"Se actualizo el objetivo");
        session()->flash('flash_type','warning');
        return redirect()->action('ObjetivosControllerVisual@show', [$id]);
    }



}
