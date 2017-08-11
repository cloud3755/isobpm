<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Accioncorrectiva1;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Proceso;
use App\Models\Estatus;
use App\Models\Indicadores;
use App\Models\Evidencia;
use App\Models\Productos;
use App\Models\Areas;
use Illuminate\Support\Facades\Auth;


class AccionescorrectivasControllerVisual extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $usuarios = Auth::user();

      $areas = new Areas;
      $area = $areas->where('id_compania',$usuarios->id_compania)->get();

      $productos         = new Productos;
      $producto          = $productos->where('idcompañia',$usuarios->id_compania)->get();

      $Estatus           = new Estatus;
      $estatus           = $Estatus->all();

      $procesos          = new Proceso;
      $proceso           = $procesos->where('idcompañia',$usuarios->id_compania)->get();

      $Users             = new User;
      $User              = $Users->where('id_compania',$usuarios->id_compania)->where('perfil','>=','3')->get();

      $accioncorrectivas = new Accioncorrectiva1;
      $accioncorrectiva  = $accioncorrectivas->where('idcompañia',$usuarios->id_compania)->get();

      // $indicadores       = new Indicadores;
      // $indicador         = $indicadores->where('id_compania',$usuarios->id_compania)->get();

      $indicador = \DB::table('indicadores')
                               ->leftjoin('objetivos','indicadores.objetivo_id','=','objetivos.id')
                               ->select('indicadores.*','objetivos.id_compania')
                               ->where('objetivos.id_compania','=',$usuarios->id_compania)
                               ->get();


       if($usuarios->perfil ==4)
       {
            $relaciontabla = \DB::table('accioncorrectiva1s')
            ->join('estatuses','accioncorrectiva1s.estatus_id','=','estatuses.id')
            ->leftjoin('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
            ->join('users','accioncorrectiva1s.responsable_id','=','users.id')
            ->leftjoin('indicadores','accioncorrectiva1s.indicador_id','=','indicadores.id')
            ->leftjoin('productos','accioncorrectiva1s.producto_id','=','productos.id')
            ->select('accioncorrectiva1s.*','productos.nombre as productonombre','procesos.proceso as procesonombre','users.nombre as usernombre','estatuses.nombre as statusnombre','indicadores.nombre as indicadornombre')
            ->where('accioncorrectiva1s.idcompañia','=',$usuarios->id_compania)
            ->where('accioncorrectiva1s.responsable_id','=',$usuarios->id)
            ->get();
        }

        else
        {
             $relaciontabla = \DB::table('accioncorrectiva1s')
             ->join('estatuses','accioncorrectiva1s.estatus_id','=','estatuses.id')
             ->leftjoin('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
             ->join('users','accioncorrectiva1s.responsable_id','=','users.id')
             ->leftjoin('indicadores','accioncorrectiva1s.indicador_id','=','indicadores.id')
             ->leftjoin('productos','accioncorrectiva1s.producto_id','=','productos.id')
             ->select('accioncorrectiva1s.*','productos.nombre as productonombre','procesos.proceso as procesonombre','users.nombre as usernombre','estatuses.nombre as statusnombre','indicadores.nombre as indicadornombre')
             ->where('accioncorrectiva1s.idcompañia','=',$usuarios->id_compania)
             ->get();
         }

        return view('/Principales/accioncorrectiva',compact('producto','proceso','User','accioncorrectiva','estatus','indicador','relaciontabla','area'));

        //return view('/Principales/accioncorrectivaevidencia');
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

    public function guardarevidiencia(Request $request)
    {
        $evidencia = new Evidencia;

        $evidencia->id_accioncorrectiva   =   $request->input('id_accioncorrectiva');
        $evidencia->id_responsable        =   $request->input('creador_id');
        $evidencia->accionarealizar       =   $request->input('accionarealizar');
        $evidencia->descripcion           =   $request->input('descripcion');

        $file1                            = $request->file('archivo1');
        $file2                            = $request->file('archivo2');
        if($file1 != null)
        {
            $extension1                       = strtolower($file1->getclientoriginalextension());
            $nombreunicoarchivo1              = uniqid().'.'.$extension1;
            $evidencia->archivo_html1         = $file1->getClientOriginalName();
            $evidencia->nombreunicoarchivo1    = $nombreunicoarchivo1;
            \Storage::disk('local')->put($nombreunicoarchivo1,  \File::get($file1));
        }

        if($file2 != null)
        {
            $extension2                       = strtolower($file2->getclientoriginalextension());
            $nombreunicoarchivo2              = uniqid().'.'.$extension2;
            $evidencia->archivo_html2         = $file2->getClientOriginalName();
            $evidencia->nombreunicoarchivo2    = $nombreunicoarchivo2;
            \Storage::disk('local')->put($nombreunicoarchivo2,  \File::get($file2));
        }
        $evidencia->save();

        return redirect('/accioncorrectiva');



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $accion = new Accioncorrectiva1;

      //para el primer archivo
      $file1                            = $request->file('archivo1');
      $file2                            = $request->file('archivo2');
      if($file1 != null)
      {
          $extension1                       = strtolower($file1->getclientoriginalextension());
          $nombreunicoarchivo1              = uniqid().'.'.$extension1;
          $accion->porque2                  =$file1->getClientOriginalName();
          $accion->uniquedocumento           = $nombreunicoarchivo1;
          \Storage::disk('accioncorrectiva')->put($nombreunicoarchivo1,  \File::get($file1));
      }
      else {

      }

      if($file2 != null)
      {
            $extension2                 = strtolower($file2->getclientoriginalextension());
            $nombreunicoarchivo2        = uniqid().'.'.$extension2;
            $accion->evidencia          = $file2->getClientOriginalName();
            $accion->uniqueevidencia    = $nombreunicoarchivo2;
            \Storage::disk('accioncorrectiva')->put($nombreunicoarchivo2,  \File::get($file2));
      }

      $accion->fechaalta        =   $request->input('fechaalta');
      $accion->id_proceso       =   $request->input('id_proceso');
      $accion->indicador_id     =   $request->input('indicador_id');
      $accion->id_proceso       =   $request->input('proceso_id');
      $accion->producto_id      =   $request->input('producto_id');
      $accion->documento        =   $request->input('documento');
      $accion->descripcion      =   $request->input('descripcion');
      $accion->responsable_id   =   $request->input('responsable_id');
      $accion->porque1          =   $request->input('analisis');
      $accion->accioncorrectiva =   $request->input('accioncorrectiva');
      $accion->fechaaccion      =   $request->input('fechaaccion');
      $accion->respuestaaccion  =   $request->input('evidenciaaccion');
      $accion->fechacierre      =   $request->input('fechacierre');
      $accion->estatus_id       =   $request->input('estatus_id');
      $accion->creador_id       =   $request->input('creador_id');
      $accion->idcompañia       =   $request->input('id_compania');
      $accion->monto            =   $request->input('monto');
      $accion->area             =   $request->input('id_area');

      $accion->save();

      return redirect('/accioncorrectiva');

    }

    public function subirevidencia ()
    {
        return view('accioncorrectivaevidencia');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
      ///{responsable_id}  $responsable_id
      $acciones = new Accioncorrectiva1;
      $accion = $acciones->where('id',$id)->get();


      $accionrelacion = \DB::table('accioncorrectiva1s')
                               ->select('accioncorrectiva1s.*','users.nombre as nombreresponsable','productos.nombre as nombreproducto','procesos.proceso as nombrep')
                               ->join('users','accioncorrectiva1s.responsable_id','=','users.id')
                               ->join('productos','accioncorrectiva1s.producto_id','=','productos.id')
                               ->join('procesos','accioncorrectiva1s.id_proceso','=','procesos.id')
                               ->where('accioncorrectiva1s.id',$id)->first();

      $accionrelacion2 = \DB::table('accioncorrectiva1s')
                              ->select('accioncorrectiva1s.*','users.nombre as nombrecreador')
                              ->join('users','accioncorrectiva1s.creador_id','=','users.id')
                              ->where('accioncorrectiva1s.id',$id)->first();

      $evidencias = new Evidencia;
      $evidencia  = $evidencias->where('id_accioncorrectiva',$id)->get();
                               /*
      $procesorelacion = \DB::table('accioncorrectiva1s')
                              ->select('accioncorrectiva1s.*','procesos.proceso')
                              ->join('users','accioncorrectiva1s.id_proceso','=','procesos.id')
                              ->where('accioncorrectiva1s.id',$id)->first();
                              */
      //dd($responsable);


      return view('/Principales/accioncorrectivaevidencia',compact('accion','accionrelacion','evidencia','accionrelacion2'));
    }

    public function descargar()
    {

        $fileLocal = storage_path('/58e66b9a4f84c.pdf');

        $fileRemote = '/indexFTP.html';

        $mode = 'FTP_BINARY';
        \FTP::connection()->downloadFile($fileRemote,$fileLocal,$mode);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
      $accion = Accioncorrectiva1::find($id);

      //para el primer archivo
      $file1                            = $request->file('archivoa');
      if($file1 != null)
      {

        $extension1                       = strtolower($file1->getclientoriginalextension());
        $nombreunicoarchivo1              = uniqid().'.'.$extension1;

        \Storage::disk('accioncorrectiva')->put($nombreunicoarchivo1,  \File::get($file1));

        if (\Storage::disk('accioncorrectiva')->exists($nombreunicoarchivo1)) {
          if (\Storage::disk('accioncorrectiva')->exists($accion->uniquedocumento)) {
            \Storage::disk('accioncorrectiva')->delete($accion->uniquedocumento);
          }
          $accion->porque2              = $file1->getClientOriginalName();
          $accion->uniquedocumento          = $nombreunicoarchivo1;

        }
      }

      $file2                            = $request->file('archivoe');
      if($file2 != null)
      {

        $extension2                 = strtolower($file2->getclientoriginalextension());
        $nombreunicoarchivo2        = uniqid().'.'.$extension2;

        \Storage::disk('accioncorrectiva')->put($nombreunicoarchivo2,  \File::get($file2));

        if (\Storage::disk('accioncorrectiva')->exists($nombreunicoarchivo2)) {
          if (\Storage::disk('accioncorrectiva')->exists($accion->uniqueevidencia)) {
            \Storage::disk('accioncorrectiva')->delete($accion->uniqueevidencia);
          }
          $accion->evidencia          = $file2->getClientOriginalName();
          $accion->uniqueevidencia    = $nombreunicoarchivo2;

        }
      }

      $accion->fechaalta        =   $request->input('efechaalta');
      $accion->indicador_id     =   $request->input('eindicador_id');
      $accion->id_proceso       =   $request->input('eproceso_id');
      $accion->producto_id      =   $request->input('eproducto_id');
      $accion->area             =   $request->input('eid_area');
      $accion->monto            =   $request->input('emonto');
      $accion->documento        =   $request->input('edocumento');
      $accion->descripcion      =   $request->input('edescripcion');
      $accion->responsable_id   =   $request->input('eresponsable_id');
      $accion->porque1          =   $request->input('eanalisis');
      $accion->accioncorrectiva =   $request->input('eaccioncorrectiva');
      $accion->fechaaccion      =   $request->input('efechaaccion');
      $accion->respuestaaccion  =   $request->input('eevidenciaaccion');

      $accion->estatus_id       =   $request->input('eestatus');
      $accion->fechacierre      =   $request->input('efechacierre');

      $accion->save();

      return response()->json([
        'mensaje' => "listo"
      ]);
    }

    public function editM($id){
      $accion = Accioncorrectiva1::find($id);
        return response()->json(
          $accion->toArray()
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
        //
    }
}
