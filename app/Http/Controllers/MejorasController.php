<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Estatus;
use App\Http\Requests;
use App\Models\User;
use App\Models\Impactos;
use App\Http\Controllers\Controller;
use App\Models\lista_envio;
use App\Models\lista_acceso;
use App\Models\Mejoras;
use App\Models\Mejoraetapas;
use Illuminate\Support\Facades\Auth;

class MejorasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function modificarlean($id, Request $request)
    {
      $mejoraedit   =  Mejoras::findorfail($id);

      $mejoraedit->proyecto          =  $request->input('proyecto');
      $mejoraedit->impacto           =  $request->input('impacto');
      $mejoraedit->responsable_id    =  $request->input('responsable_id');
      $mejoraedit->descripcion       =  $request->input('descripcion');
      $mejoraedit->beneficioplan       =  $request->input('beneficioplan');
      $mejoraedit->beneficioreal       =  $request->input('beneficioreal');
      $mejoraedit->fechaactual       =  $request->input('fechaactual');
      $mejoraedit->estatus_id       =  $request->input('estatus_id');

      $mejoraedit->save();

      $listadeequipo = $request->input('lista_de_accesos');
      $listadeequipo2 = $request->input('lista_de_accesos2');

      $equipo = $mejoraedit->listaequipo;

      $deletedRows = new lista_acceso;
      $deletedRows ->where('id_indicador', $equipo)->delete();

      if(count($listadeequipo)>0)
      for ($i=0;$i<count($listadeequipo);$i++)
      {

              $lista = new lista_acceso;
              $lista->id_usuario = $listadeequipo[$i];
              $lista->id_indicador = $equipo;
              $lista->save();
      }

      return redirect('/Promejoras');

    }

    public function subiretapas($id)
    {
      $usuarios = Auth::user();

      $impactos = new Impactos;
      $impacto = $impactos->all();

      $Users = new User;
      $User = $Users->where('id_compania',$usuarios->id_compania)->get();

      $estatus  = new Estatus;
      $estatu   = $estatus->all();


      $mejorarelacion = \DB::table('mejoras')
             ->select('mejoras.*','users.nombre as usernombre','impactos.nombre as nombreimpacto','estatuses.nombre as nombreestatus')
             ->join('users','mejoras.responsable_id','=','users.id')
             ->join('impactos','mejoras.impacto','=','impactos.id')
             ->join('estatuses','mejoras.estatus_id','=','estatuses.id')
             ->where('mejoras.id',$id)
             ->first();

               $relaciontabla = \DB::table('mejoraetapas')
                       ->join('mejoras','mejoraetapas.id_mejoras','=','mejoras.id')
                       ->select('mejoraetapas.*')
                       ->where('mejoraetapas.id_mejoras','=',$id)
                       ->get();

                       $listadeequipo = \DB:: table('lista_accesos')
                       ->select('users.*')
                       ->join('mejoras','lista_accesos.id_indicador','=','mejoras.listaequipo')
                       ->join('users','users.id','=','lista_accesos.id_usuario')
                       ->where('mejoras.id','=',$id)
                       ->groupby('users.id')
                       ->get();


                       $listadeequipono = \DB:: table('lista_accesos')
                       ->select('users.*')
                       ->leftjoin('mejoras','lista_accesos.id_indicador','=','mejoras.listaequipo')
                       ->rightjoin('users','users.id','=','lista_accesos.id_usuario')
                       ->where('mejoras.id','=',$id)
                       ->where('users.id','!=','lista_accesos.id_usuario')
                       ->where('users.id_compania',$usuarios->id_compania)
                       ->groupby('users.id')
                       ->get();


              if($mejorarelacion->tipo == 'lean')
                return view('subiretapa',compact('mejorarelacion','impacto','User','estatu','relaciontabla','listadeequipo','listadeequipono'));

              if($mejorarelacion->tipo == 'six sigma')
                return view('sigmacreate',compact('mejorarelacion','impacto','User','estatu','relaciontabla','listadeequipo','listadeequipono'));

              if($mejorarelacion->tipo == 'Bpm')
                return view('bpmetapa',compact('mejorarelacion','impacto','User','estatu','relaciontabla','listadeequipo','listadeequipono'));
    }


    public function eliminaretapa($id)
    {
      $mejoraetapas = Mejoraetapas::findorfail($id);

      if($mejoraetapas->uniquearchivo != null)
        \Storage::disk('mejoras')->delete($mejoraetapas->uniquearchivo);

        $mejoraetapas->delete();

        return redirect('/Promejoras');
    }

    public function guardaretapa(Request $request)
    {
        $mejoraetapas = new Mejoraetapas;

          $mejoraetapas->id_mejoras = $request->input('idmejora');
          $mejoraetapas->idetapa    = $request->input('etapa');
          $mejoraetapas->fecha      = $request->input('fecha');
        $mejoraetapas->descripcion  = $request->input('descripcion');

        $file1                            = $request->file('archivo');
        if($file1 != null)
        {
            $extension1                       = strtolower($file1->getclientoriginalextension());
            $nombreunicoarchivo1              = uniqid().'.'.$extension1;
            $mejoraetapas->archivo              = $file1->getClientOriginalName();
            $mejoraetapas->uniquearchivo        = $nombreunicoarchivo1;
            \Storage::disk('mejoras')->put($nombreunicoarchivo1,  \File::get($file1));
        }
        $mejoraetapas->save();
        return redirect('/Promejoras');
    }

    public function index()
    {

        $usuarios = Auth::user();

        $mejoras = new Mejoras;
        $mejora  = $mejoras->all();


            $mejorarelacion = \DB::table('mejoras')
                   ->join('users','mejoras.responsable_id','=','users.id')
                   ->join('impactos','mejoras.impacto','=','impactos.id')
                   ->join('lista_accesos','mejoras.listaequipo','=','lista_accesos.id_indicador')
                   ->join('estatuses','mejoras.estatus_id','=','estatuses.id')
                   ->select('mejoras.*','users.nombre as usernombre','impactos.nombre as nombreimpacto','estatuses.nombre as nombreestatus')
                   ->where('lista_accesos.id_usuario','=',$usuarios->id)
                   ->orwhere('mejoras.creador_id',$usuarios->id)
                   ->groupby('mejoras.id')
                   ->get();
      //dd($mejorarelacion);


        return view('submenu/Promejora',compact('mejora','mejorarelacion'));
    }

    public function leancreate()
    {

      $usuarios = Auth::user();

      $estatus  = new Estatus;
      $estatu   = $estatus->all();

      $impactos = new Impactos;
      $impacto = $impactos->all();

      $Users = new User;
      $User = $Users->where('id_compania',$usuarios->id_compania)->where('perfil','>=','3')->get();

      return view('leancreate',compact('User','impacto','estatu'));
    }

    public function bpmcreate()
    {

      $usuarios = Auth::user();

            $estatus  = new Estatus;
            $estatu   = $estatus->all();

            $impactos = new Impactos;
            $impacto = $impactos->all();

            $Users = new User;
            $User = $Users->where('id_compania',$usuarios->id_compania)->where('perfil','>=','3')->get();

            return view('altabpm',compact('User','impacto','estatu'));
    }

    public function sigmacreate()
    {

      $usuarios = Auth::user();

      $estatus  = new Estatus;
      $estatu   = $estatus->all();

      $impactos = new Impactos;
      $impacto = $impactos->all();

      $Users = new User;
      $User = $Users->where('id_compania',$usuarios->id_compania)->where('perfil','>=','3')->get();

      return view('altasigma',compact('User','impacto','estatu'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function storelean(Request $request)
    {

      $usuarios = Auth::user();

      $mejoras = new Mejoras;
      $mejoras->tipo     = $request->input('tipo');
      $mejoras->proyecto = $request->input('proyecto');
      $mejoras->responsable_id = $request->input('responsable_id');
      $mejoras->impacto  =  $request->input('impacto');
      $mejoras->descripcion = $request->input('descripcion');
      $mejoras->beneficioplan  =  $request->input('beneficioplan');
      $mejoras->beneficioreal  =  $request->input('beneficioreal');
      $mejoras->fechaactual    =  $request->input('fechaactual');
      $mejoras->estatus_id     =  $request->input('estatus_id');
      $mejoras->id_compania    =  $usuarios->id_compania;
      $mejoras->creador_id     =  $usuarios->id;
      $equipo = uniqid('eqp_');
      $mejoras->listaequipo    =  $equipo;
      $mejoras->save();

      $listadeequipo = $request->input('lista_de_distribucion');

      for ($i=0;$i<count($listadeequipo);$i++)
      {
        $lista = new lista_acceso;
        $lista->id_usuario = $listadeequipo[$i];
        $lista->id_indicador = $equipo;
        $lista->save();
      }

      // $lista2 = new lista_acceso;
      // $lista2->id_usuario = $usuarios->id;
      // $lista2->id_indicador = $equipo;
      // $lista2->save();

      return redirect('/Promejoras');
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
