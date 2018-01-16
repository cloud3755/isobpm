<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Quejas;
use App\Models\Estatus;
use App\Models\User;
use App\Models\Clientes;
use App\Models\Areas;
use App\Models\Productos;
use App\Models\Proceso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuejasController extends Controller
{
    /**
     * Display a listing of the resource.a
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Quejas');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $usuarios = Auth::user();

      $procesos          = new Proceso;
      $proceso           = $procesos->where('idcompañia',$usuarios->id_compania)->get();

      $producto         = new Productos;
      $productos        = $producto->where('idcompañia',$usuarios->id_compania)->get();

      $areas = new Areas;
      $area  = $areas->where('id_compania',$usuarios->id_compania)->get();

      $clientes = new Clientes;
      $cliente  = $clientes->where('id_compania',$usuarios->id_compania)->get();

      $queja = new Quejas;
      $quejas = $queja->where('idcompañia',$usuarios->id_compania)->get();

      $estatuses = new Estatus;
      $estatus = $estatuses->all();

      $Users = new User;
      $User = $Users->where('id_compania',$usuarios->id_compania)->where('perfil','>=','3')->get();

      if($usuarios->perfil == 4)
      {
          $relaciontabla = \DB::table('quejas')
          ->join('clientes','quejas.cliente_id','=','clientes.id')
          ->join('users','quejas.usuario_responsable_id','=','users.id')
          ->join('estatuses','quejas.estatus_id','=','estatuses.id')
          ->select('quejas.*','users.nombre as usernombre','clientes.nombre as clientenombre','estatuses.nombre as statusnombre')
          ->where('quejas.idcompañia','=',$usuarios->id_compania)
          ->where('quejas.usuario_responsable_id','=',$usuarios->id)
          ->get();
       }
       else {
         $relaciontabla = \DB::table('quejas')
         ->join('clientes','quejas.cliente_id','=','clientes.id')
         ->join('users','quejas.usuario_responsable_id','=','users.id')
         ->join('estatuses','quejas.estatus_id','=','estatuses.id')
         ->select('quejas.*','users.nombre as usernombre','clientes.nombre as clientenombre','estatuses.nombre as statusnombre')
         ->where('quejas.idcompañia','=',$usuarios->id_compania)
         ->get();
       }

        //dd($relaciontabla);
      return View('/Principales/quejaVisual', compact('quejas', 'estatus','User','cliente','relaciontabla','area','proceso','productos'));
    }

    /**
     * Store a newly created resource in storage.
     *asas
     *asdasdas
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $queja = new Quejas;

        $queja->fecha                  = $request->input('fecha');
        $queja->cliente_id             = $request->input('cliente_id');
        $queja->descripcion            = $request->input('descripcion');
        $queja->usuario_responsable_id = $request->input('responsable');
        $queja->acciones               = $request->input('acciones');
        $queja->fecha_plan             = $request->input('fecha_plan');
        $queja->evidencia              = $request->input('evidencia');
        $queja->fecha_cierre           = $request->input('fecha_cierre');
        $queja->estatus_id             = $request->input('status_id');
        $queja->idcompañia             = $request->input('id_compania');
        $queja->area                   = $request->input('area');
        $queja->proceso                = $request->input('proceso_id');
        $queja->producto               = $request->input('producto_id');
        $queja->monto                  = $request->input('monto');
        $queja->producto            = $request->input('producto_id');
        $queja->monto                 = $request->input('monto');



        $file1                            = $request->file('archivo1');
        if($file1 != null)
        {
            $extension1                       = strtolower($file1->getclientoriginalextension());
            $nombreunicoarchivo1              = uniqid().'.'.$extension1;
            $queja->archivoqueja              = $file1->getClientOriginalName();
            $queja->uniquearchivoqueja        = $nombreunicoarchivo1;
            \Storage::disk('quejas')->put($nombreunicoarchivo1,  \File::get($file1));
        }

        $file2                            = $request->file('archivo2');
        if($file2 != null)
        {
            $extension2                       = strtolower($file2->getclientoriginalextension());
            $nombreunicoarchivo2              = uniqid().'.'.$extension2;
            $queja->archivoevidencia          = $file2->getClientOriginalName();
            $queja->uniquearchivoevidencia    = $nombreunicoarchivo2;
            \Storage::disk('quejas')->put($nombreunicoarchivo2,  \File::get($file2));
        }

        $queja->save();

        return redirect('quejas/create');
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

    public function editM($id){
      $queja = Quejas::find($id);
        return response()->json(
          $queja->toArray()
        );
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
      $queja = Quejas::findorfail($id);

      //nombre del archivo
      $file2                            = $request->file('earchivo1_q');
      $file1                            = $request->file('earchivo2_q');
      //se valida que no este vacio el archivo 2
      if($file1!= null )
      {
          $extension1                       = strtolower($file1->getclientoriginalextension());
          $nombreunicoarchivo1              = uniqid().'.'.$extension1;
          if($queja->uniquearchivoqueja != null)

          if (\Storage::disk('quejas')->exists($queja->uniquearchivoqueja)) {
          \Storage::disk('quejas')->delete($queja->uniquearchivoqueja);
          }
          \Storage::disk('quejas')->put($nombreunicoarchivo1,  \File::get($file1));
          $queja->archivoqueja              = $file1->getClientOriginalName();
          $queja->uniquearchivoqueja        = $nombreunicoarchivo1;
      }
      //se valida que no este vacio el archivo
      if($file2 != null)
      {
        $extension2                       = strtolower($file2->getclientoriginalextension());
        $nombreunicoarchivo2              = uniqid().'.'.$extension2;

        if($queja->uniquearchivoevidencia != null)

        if (\Storage::disk('quejas')->exists($queja->uniquearchivoevidencia)) {
        \Storage::disk('quejas')->delete($queja->uniquearchivoevidencia);
      }
        \Storage::disk('quejas')->put($nombreunicoarchivo2,  \File::get($file2));
        $queja->archivoqueja              = $file2->getClientOriginalName();
        $queja->uniquearchivoqueja        = $nombreunicoarchivo2;
      }

      $queja->fecha = $request->input('efecha_q');
      $queja->cliente_id = $request->input('ecliente_id_q');
      $queja->descripcion = $request->input('edescripcion_q');
      $queja->usuario_responsable_id = $request->input('eresponsable_q');
      $queja->acciones = $request->input('eacciones_q');
      $queja->fecha_plan = $request->input('efecha_plan_q');
      $queja->evidencia = $request->input('eevidencia_q');
      $queja->fecha_cierre = $request->input('efecha_cierre_q');
      $queja->estatus_id = $request->input('estatus_id_q');
      $queja->producto   = $request->input('eproducto_id_q');
      $queja->monto     = $request->input('emonto_q');
      $queja->area      = $request->input('earea_q');
      $queja->proceso    = $request->input('eproceso_id_q');

      $queja->save();

      return Redirect('/quejas/create');


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


      $usuario = Auth::user();
      //
      $iduser = $usuario->id;
      $compañiaid = $usuario->id_compania;

            $queja = Quejas::findorfail($id);

      if($queja->idcompañia == $compañiaid){

            if($queja->uniquearchivoqueja != null)
              \Storage::disk('quejas')->delete($queja->uniquearchivoqueja);
            if($queja->uniquearchivoevidencia != null)
              \Storage::disk('quejas')->delete($queja->uniquearchivoevidencia);

            $queja-> delete();
            //return Redirect('/quejas/create');
            $msg = "se elimino correctmente";

            //return Response::json($msg);
       }
       return Redirect('/quejas/create');
    }
}
