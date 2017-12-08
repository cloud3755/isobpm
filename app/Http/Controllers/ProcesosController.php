<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Proceso;
use App\Models\User;
use App\Models\tipoproceso;
use App\Models\Indicadores;
use App\Models\lista_envio;
use App\Models\lista_indicadores_proceso;
use App\Models\lista_puestos_procesos;
use App\Models\lista_insumos_procesos;
use App\Models\lista_documentos_procesos;
use App\Models\lista_activos_procesos;
use App\Models\Sipoc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

class ProcesosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('Procesos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $procesos = new Proceso;
        $proceso = $procesos->all();
    //    $procesos = $procesos->paginate();

        $Users = new User;
        $User = $Users->all();

        $tipoprocesos = new tipoproceso;
        $tipoproceso = $tipoprocesos->all();
        //dd($objetivos->all());
        //return view('CreateProceso',compact('proceso','user')); //=> $proceso->toArray()], User);
        return View('CreateProceso', compact('proceso','User','tipoproceso'));
    }

/*
PHP . INI
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 100
max_input_time = 60
memory_limit = 10M
*/
    public function store(Request $request)
    {
      $Users = Auth::user();
      $data = \Request::all();

      // $rules = array('proceso'=>'required',
      //                'usuario_responsable_id'=>'required');

        // $v = \Validator::make($data,$rules);
        //
        // if ($v->fails())
        // {
        //
        //   return redirect()->back()
        //          ->withErrors($v->errors())
        //          ->withInput(\Request::all());
        // }

// para guardar a BD el registro del proceso
      $proceso= new Proceso;
      $proceso->tipo = $request->input('tipo');
      $proceso->descripcion = $request->input('descripcion');
      $proceso->proceso = $request->input('proceso');
      $proceso->usuario_responsable_id = $request->input('usuario_responsable_id');
      $proceso->rev = $request->input('rev');
      $proceso->detalle_de_rev = $request->input('detalle_de_rev');
      //obtenemos el campo file definido en el formulario
      $file = $request->file('file');

      if($file != null)
      {
          $extension = strtolower($file->getclientoriginalextension());
          $nombreunicoarchivo = uniqid('proc_').'.'.$extension;
          $proceso->archivo_html = $file->getClientOriginalName();
          $proceso->nombreunicoarchivo = $nombreunicoarchivo;
          $nombre = $file->getClientOriginalName();
          \Storage::disk('local')->put($nombreunicoarchivo,  \File::get($file));
      }
//      $proceso->lista_de_distribucion = $request->input('lista_de_distribucion');
      //obtenemos un id para relacionar la lista de envio
      $paralista = uniqid('list_');
      $proceso->lista_de_distribucion = $paralista;
      $paraindicador = uniqid('ind_');
      $proceso->indicadores = $paraindicador;

      $proceso->idcompañia = $Users->id_compania;
      $proceso->creador_id = $Users->id;
      $proceso->save();

//    guardamos archivo

//    guardamos lista de indicadores
$indi=$request->input('indicadores'); //$_POST["lista_de_distribucion"];
for ($i=0;$i<count($indi);$i++)
{
  $ind = new lista_indicadores_proceso;
  $ind ->id_indicador = $indi[$i];
  $ind ->id_proceso = $paraindicador;
  $ind ->save();
}


//    guardanmos lista de envio
$envio=$request->input('lista_de_distribucion'); //$_POST["lista_de_distribucion"];
for ($i=0;$i<count($envio);$i++)
{
  $lista = new lista_envio;
  $lista->id_usuario = $envio[$i];
  $lista->id_proceso = $paralista;
  $lista->save();
}


      return Redirect('/procesos/visual');
    //  return response()->json($proceso)

    }

    public function save(Request $request)
    {

           //obtenemos el campo file definido en el formulario
           $file = $request->file('file');

           //obtenemos el nombre del archivo
           $nombre = $file->getClientOriginalName();

           //indicamos que queremos guardar un nuevo archivo en el disco local
           \Storage::disk('local')->put($nombre,  \File::get($file));

    }





    /**
    * guarda un archivo en nuestro directorio local.
    *
    * @return Response
    */




    public function edit($id,Request $request)
    {
        // para editar registro
        $proceso = Proceso::findOrFail($id);
        $proceso->tipo = $request->input('tipo');
        $proceso->proceso = $request->input('proceso');
        $proceso->descripcion = $request->input('descripcion');
        $proceso->usuario_responsable_id = $request->input('usuario_responsable_id');
        $proceso->rev = $request->input('rev');
        $proceso->detalle_de_rev = $request->input('detalle_de_rev');
        $proceso->tipoarchivo = $request->input('tipoarchivo');

        //obtenemos el campo file definido en el formulario
        $file = $request->file('file');
        if  ($file != null)
        {
          $archivoborrar = $proceso->nombreunicoarchivo;
          $file2 = $request->input('filetext');
    // borramos el archivo zip
          if  ($file2 != null)
          {
            \Storage::disk('local')->delete($archivoborrar);
          }

          $file = $request->file('file');

          $extension = strtolower($file->getclientoriginalextension());
          $nombreunicoarchivo = uniqid('proc_').'.'.$extension;
          $proceso->archivo_html = $file->getClientOriginalName();
          $proceso->nombreunicoarchivo = $nombreunicoarchivo;
          $nombre = $file->getClientOriginalName();
          \Storage::disk('local')->put($nombreunicoarchivo,  \File::get($file));
        }
        $proceso->save();
    }

    public function edit2($id,Request $request)
    {
        // para editar registro
        $proceso = Proceso::findOrFail($id);

        $paraindicador = $proceso->indicadores;
        //obtenemos un id para relacionar la lista de envio
        $paralista = $proceso->lista_de_distribucion;

        //    borramos lista de envio

        DB::table('lista_envios')->where('id_proceso',$paralista)->delete();

        //    guardamos la nueva lista de envio
        $envio=$request->input('lista_de_distribucion'); //$_POST["lista_de_distribucion"];
        for ($i=0;$i<count($envio);$i++)
        {
          $lista = new lista_envio;
          $lista->id_usuario = $envio[$i];
          $lista->id_proceso = $paralista;
          $lista->save();
        }


        DB::table('lista_indicadores_procesos')->where('id_proceso',$paraindicador)->delete();

        //    guardamos lista de indicadores
        $indi=$request->input('indicadores'); //$_POST["lista_de_distribucion"];
        for ($i=0;$i<count($indi);$i++)
        {
          $ind = new lista_indicadores_proceso;
          $ind ->id_indicador = $indi[$i];
          $ind ->id_proceso = $paraindicador;
          $ind ->save();
        }

        $parapuestos = $proceso->puestos;
        DB::table('lista_puestos_procesos')->where('id_proceso',$parapuestos)->delete();

        $proceso->puestos = uniqid('pue_');
        $parapuestos = $proceso->puestos;
        //    guardamos lista de indicadores
        $indi=$request->input('Puestos'); //$_POST["lista_de_distribucion"];
        for ($i=0;$i<count($indi);$i++)
        {
          $ind = new lista_puestos_procesos;
          $ind ->id_puesto = $indi[$i];
          $ind ->id_proceso = $parapuestos;
          $ind ->save();
        }

        $parainsumos = $proceso->insumos;
        DB::table('lista_insumos_procesos')->where('id_proceso',$parainsumos)->delete();

        $proceso->insumos = uniqid('insu_');
        $parainsumos = $proceso->insumos;
        //    guardamos lista de indicadores
        $indi=$request->input('Insumos'); //$_POST["lista_de_distribucion"];
        for ($i=0;$i<count($indi);$i++)
        {
          $ind = new lista_insumos_procesos;
          $ind ->id_insumo = $indi[$i];
          $ind ->id_proceso = $parainsumos;
          $ind ->save();
        }

        $paradocumento = $proceso->documento;
        DB::table('lista_documentos_procesos')->where('id_proceso',$paradocumento)->delete();

        $proceso->documento = uniqid('doc_');
        $paradocumento = $proceso->documento;
        //    guardamos lista de indicadores
        $indi=$request->input('Doculist'); //$_POST["lista_de_distribucion"];
        for ($i=0;$i<count($indi);$i++)
        {
          $ind = new lista_documentos_procesos;
          $ind ->id_documento = $indi[$i];
          $ind ->id_proceso = $paradocumento;
          $ind ->save();
        }

        $paraactivo = $proceso->activo;
        DB::table('lista_activos_procesos')->where('id_proceso',$paraactivo)->delete();

        $proceso->activo = uniqid('act_');
        $paraactivo = $proceso->activo;
        //    guardamos lista de indicadores
        $indi=$request->input('Activos'); //$_POST["lista_de_distribucion"];
        for ($i=0;$i<count($indi);$i++)
        {
          $ind = new lista_activos_procesos;
          $ind ->id_activo = $indi[$i];
          $ind ->id_proceso = $paraactivo;
          $ind ->save();
        }

        $proceso->save();

    }

    public function edit3($id,Request $request)
    {
        // para editar registro
        $proceso = Proceso::findOrFail($id);

        $proceso->demandamen = $request->input('demandamen');
        $proceso->diasmes = $request->input('diasmes');
        $proceso->turnosdia = $request->input('turnosdia');
        $proceso->turnoshora = $request->input('turnoshora');
        $proceso->horades = $request->input('horades');
        $proceso->Tiemposeg = $request->input('Tiemposeg');
        $proceso->Tiempomin = $request->input('Tiempomin');
        $proceso->Takt = $request->input('Takt');
        $proceso->taktseg = $request->input('taktseg');


        $proceso->Yield = $request->input('Yield');
        $proceso->RTY = $request->input('RTY');
        $proceso->DPMO = $request->input('DPMO');
        $proceso->Sigma = $request->input('Sigma');
        $proceso->Persona = $request->input('Persona');
        $proceso->Maquina = $request->input('Maquina');
        $proceso->dinero = $request->input('dinero');
        $proceso->SLA1 = $request->input('SLA1');
        $proceso->SLA2 = $request->input('SLA2');
        $proceso->SLA3 = $request->input('SLA3');
        $proceso->Mes = $request->input('Mes');

        $proceso->save();
    }




    public function destroy($id)
    {

      $proceso = Proceso::findorfail($id);

      // borramos el archivo zip
      $archivoborrar = $proceso->nombreunicoarchivo;
      if(!empty($archivoborrar)){
        \Storage::disk('local')->delete($archivoborrar);
      }

      // borramos la lista de envios
      $paralista = $proceso->lista_de_distribucion;
      DB::table('lista_envios')->where('id_proceso',$paralista)->delete();

      // borramos la lista de indicadores
      $paralista = $proceso->indicadores;
      DB::table('lista_indicadores_procesos')->where('id_proceso',$paralista)->delete();


      //  storage::delete($rutacompleta);
      // borramos el registro de la tabla
      $proceso-> delete();
      return Redirect('/procesos/visual');
      //  return dd($rutacompleta);
    }


      public function editsipoc($id){

        $Sipoc = Sipoc::find($id);
        return response()->json(
          $Sipoc->toArray()
        );
      }

      public function sipocdestroy($id)
      {
        $usuarios = Auth::user();
        $Sipoc = Sipoc::findorfail($id);
        $Sipoc-> delete();

      }

      public function sipocstore(Request $request)
      {
        $usuarios = Auth::user();
        $Sipoc = new Sipoc;

        $Sipoc->S = $request->input('S');
        $Sipoc->I = $request->input('I');
        $Sipoc->P = $request->input('P');
        $Sipoc->O = $request->input('O');
        $Sipoc->C = $request->input('C');
        $Sipoc->id_proceso = $request->input('porceso_id');

        $Sipoc->save();

        return redirect()->action('ProcesosControllerVisual@show', [$request->input('porceso_id')]);
      }

      public function sipocedit($id,Request $request)
      {
        $usuarios = Auth::user();
        $Sipoc = Sipoc::findorfail($id);
        $Sipoc->S = $request->input('eS');
        $Sipoc->I = $request->input('eI');
        $Sipoc->P = $request->input('eP');
        $Sipoc->O = $request->input('eO');
        $Sipoc->C = $request->input('eC');

        $Sipoc->save();

        return response()->json([
          'mensaje' => "listo"
        ]);
      }


}
