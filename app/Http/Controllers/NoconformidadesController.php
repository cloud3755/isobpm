<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Illuminate\Mail\Message;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Noconformidades;
use App\Models\Proceso;
use App\Models\Estatus;
use App\Models\User;
use App\Models\Productos;
use App\Models\Areas;
use Illuminate\Support\Facades\Auth;


class NoconformidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $usuarios = Auth::user();

      $Noconformidad = new Noconformidades;
      $Noconformidades = $Noconformidad->where('idcompañia',$usuarios->id_compania)->get();

      $Procesos = new Proceso;
      $Proceso = $Procesos->where('idcompañia',$usuarios->id_compania)->get();

      $estatuses = new Estatus;
      $estatus = $estatuses->all();

      $Users = new User;
      $User = $Users->where('id_compania',$usuarios->id_compania)->where('perfil','>=','3')->get();

      $Productos = new Productos;
      $Producto = $Productos->where('idcompañia',$usuarios->id_compania)->get();

      $areas = new Areas;
      $area = $areas->where('id_compania',$usuarios->id_compania)->get();

      if($usuarios->perfil == 4)
      {
        $relaciontabla = \DB::table('noconformidades')
        ->leftjoin('procesos','noconformidades.proceso_id','=','procesos.id')
        ->leftjoin('estatuses','noconformidades.estatus_id','=','estatuses.id')
        ->join('users as u1','noconformidades.usuario_responsable_id','=','u1.id')
        ->join('users as u2','noconformidades.creador_id','=','u2.id')
        ->leftjoin('productos','noconformidades.producto_id','=','productos.id')
        ->select('noconformidades.*','procesos.proceso as procesonombre','estatuses.nombre as estatusnombre','u1.nombre as usuarionombre','productos.nombre as productonombre','u2.nombre as creador')
        ->where('noconformidades.idcompañia','=',$usuarios->id_compania)
        ->where('noconformidades.usuario_responsable_id','=',$usuarios->id)
        ->orwhere('noconformidades.creador_id','=',$usuarios->id)
        ->get();
      }else {
        $relaciontabla = \DB::table('noconformidades')
        ->leftjoin('procesos','noconformidades.proceso_id','=','procesos.id')
        ->leftjoin('estatuses','noconformidades.estatus_id','=','estatuses.id')
        ->leftjoin('users as u1','noconformidades.usuario_responsable_id','=','u1.id')
        ->leftjoin('users as u2','noconformidades.creador_id','=','u2.id')
        ->leftjoin('productos','noconformidades.producto_id','=','productos.id')
        ->select('noconformidades.*','procesos.proceso as procesonombre','estatuses.nombre as estatusnombre','u1.nombre as usuarionombre','productos.nombre as productonombre','u2.nombre as creador')
        ->where('noconformidades.idcompañia','=',$usuarios->id_compania)
        ->get();
      }
      return View('/Principales/noconformidadVisual', compact('Noconformidades', 'Proceso', 'estatus','User','Producto','area','relaciontabla'));
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
      $Noconformidad = new Noconformidades;

      $Noconformidad->fecha                 = $request->input('fecha');
      $Noconformidad->proceso_id            = $request->input('proceso_id');
      //$Noconformidad->proceso_id = 1;
      $Noconformidad->producto_id           = $request->input('producto_id');
      $Noconformidad->documento             = $request->input('documento');

      $Noconformidad->evidenciapertura      = $request->input('evidenciapertura');
      //$Noconformidad->apertura_unic = '1';

      $Noconformidad->descripcion           = $request->input('descripcion');
      $Noconformidad->usuario_responsable_id = $request->input('usuario_responsable_id');

      $Noconformidad->acciones              = $request->input('acciones');
      $Noconformidad->fecha_plan            = $request->input('fecha_plan');
      $Noconformidad->evidencia             = $request->input('evidencia');

      //$Noconformidad->evidencia_unic = '1';

      $Noconformidad->fecha_cierre          = $request->input('fecha_cierre');
      $Noconformidad->estatus_id            = $request->input('estatus_id');
      $Noconformidad->monto                 = $request->input('monto');
      $Noconformidad->idcompañia            = $request->input('id_compania');
      $Noconformidad->id_area               = $request->input('id_area');
      $Noconformidad->creador_id            = $usuarios->id;

      $file1                                = $request->file('archivo1');

      if($file1 !=null)
      {
          $extension1                       = strtolower($file1->getclientoriginalextension());
          $nombreunicoarchivo1              = uniqid().'.'.$extension1;
          $Noconformidad->evidenciapertura  = $file1->getClientOriginalName();
          $Noconformidad->apertura_unic     = $nombreunicoarchivo1;
          \Storage::disk('noconformidad')->put($nombreunicoarchivo1,  \File::get($file1));
      }
      $file2                                = $request->file('archivo2');
      if($file2 != null)
      {
          $extension2                       = strtolower($file2->getclientoriginalextension());
          $nombreunicoarchivo2              = uniqid().'.'.$extension2;
          $Noconformidad->evidencia         = $file2->getClientOriginalName();
          $Noconformidad->evidencia_unic    = $nombreunicoarchivo2;
          \Storage::disk('noconformidad')->put($nombreunicoarchivo2,  \File::get($file2));
      }
      $Noconformidad->save();

    if( $usuarios->empresas->mensajesNC == 1)
    {
      Mail::queue('emails.noconformidades.noconformidadabierta', ['NC' => $Noconformidad], function ($m) use ($Noconformidad){
        $m->to($Noconformidad->responsable->email,$Noconformidad->responsable->nombre)->subject('Tienes una no conformidad asignada');
      });
     }

      return redirect('noconformidad/create');
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
      $usuarios = Auth::user();

      $Noconformidad = Noconformidades::findorfail($id);
        $file2                            = $request->file('archivo1_nc');
        $file1                            = $request->file('archivo2_nc');

      if($file1!= null )
      {
          $extension1                       = strtolower($file1->getclientoriginalextension());
          $nombreunicoarchivo1              = uniqid().'.'.$extension1;

          if($Noconformidad->evidencia_unic != null)
          \Storage::disk('noconformidad')->delete($Noconformidad->evidencia_unic);

          \Storage::disk('noconformidad')->put($nombreunicoarchivo1,  \File::get($file1));
          $Noconformidad->evidencia              = $file1->getClientOriginalName();
          $Noconformidad->evidencia_unic        = $nombreunicoarchivo1;
      }

      if($file2 !=null)
      {
        $extension2                       = strtolower($file2->getclientoriginalextension());
        $nombreunicoarchivo2              = uniqid().'.'.$extension2;

        if($Noconformidad->apertura_unic != null)
        \Storage::disk('noconformidad')->delete($Noconformidad->apertura_unic);

        \Storage::disk('noconformidad')->put($nombreunicoarchivo2,  \File::get($file2));
        $Noconformidad->evidenciapertura  = $file2->getClientOriginalName();
        $Noconformidad->apertura_unic        = $nombreunicoarchivo2;
      }

      $Noconformidad->fecha                  = $request->input('fecha_nc');
      $Noconformidad->proceso_id             = $request->input('proceso_id_nc');
      $Noconformidad->documento              = $request->input('documento_nc');
      $Noconformidad->producto_id            = $request->input('producto_id_nc');
      $Noconformidad->descripcion            = $request->input('descripcion_nc');
      $Noconformidad->usuario_responsable_id = $request->input('usuario_responsable_id_nc');
      $Noconformidad->acciones               = $request->input('acciones_nc');
      $Noconformidad->fecha_plan             = $request->input('fecha_plan_nc');
      $Noconformidad->fecha_cierre           = $request->input('fecha_cierre_nc');
      $Noconformidad->estatus_id             = $request->input('estatus_id_nc');
      $Noconformidad->monto                  = $request->input('monto_nc');
      $Noconformidad->id_area                = $request->input('id_area_nc');

      $Noconformidad->save();


      if( $usuarios->empresas->mensajesNC == 1)
      {

         if($Noconformidad->estatus_id == 2)
          {
          Mail::queue('emails.noconformidades.noconformidadenvioaprobacion', ['NC' => $Noconformidad], function ($m) use ($Noconformidad){
            $m->to($Noconformidad->creador->email,$Noconformidad->creador->nombre)->subject('Tienes una no conformidad pendiente de aprobar');
          });
          }

          if($Noconformidad->estatus_id == 4)
           {
           Mail::queue('emails.noconformidades.noconformidadrechazoresponsable', ['NC' => $Noconformidad], function ($m) use ($Noconformidad){
             $m->to($Noconformidad->creador->email,$Noconformidad->creador->nombre)->subject('Tienes una no conformidad rechazada por el responsable');
           });
           }

           if($Noconformidad->estatus_id == 5)
            {
            Mail::queue('emails.noconformidades.noconformidadrechazosolucion', ['NC' => $Noconformidad], function ($m) use ($Noconformidad){
              $m->to($Noconformidad->responsable->email,$Noconformidad->responsable->nombre)->subject('La solucion a la no conformidad ha sido rechazada');
            });
            }

            

           if($Noconformidad->estatus_id == 3)
            {
              $emails = [$Noconformidad->creador->email => $Noconformidad->creador->nombre, $Noconformidad->responsable->email => $Noconformidad->responsable->nombre];
            Mail::queue('emails.noconformidades.noconformidadcerrada', ['NC' => $Noconformidad], function ($m) use ($Noconformidad,$emails){
              $m->to($emails)->subject('No conformidad cerrada');
            });
            }

      }

      return Redirect('/noconformidad/create');
    }

    public function editM($id){
      $nc = Noconformidades::find($id);
        return response()->json(
          $nc->toArray()
        );
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

      $Noconformidad = Noconformidades::findorfail($id);

      if ($Noconformidad->idcompañia == $compañiaid)
      {
      if($Noconformidad->evidencia_unic != null)
        \Storage::disk('noconformidad')->delete($Noconformidad->evidencia_unic);
      if($Noconformidad->apertura_unic != null)
      \Storage::disk('noconformidad')->delete($Noconformidad->apertura_unic);

      $Noconformidad-> delete();
      }
      return Redirect('/noconformidad/create');

    }
}
