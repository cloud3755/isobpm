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



    public function show($id)
    {
        //
    }



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
        //obtenemos el campo file definido en el formulario
        $file = $request->file('file');
        if  ($file == null)
        {
          $proceso->archivo_html = $request->input('filetext');

        }
        else
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
        $paraindicador = $proceso->indicadores;
        //obtenemos un id para relacionar la lista de envio
        $paralista = $proceso->lista_de_distribucion;

        $proceso->save();

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

        return Redirect('/procesos/visual');

        //return('proxiamente edicion $id');

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
}
