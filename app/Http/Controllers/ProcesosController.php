<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Proceso;
use App\Models\procesostmps;
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

      $proceso= new Proceso;
      $proceso->tipo = $request->input('tipo');
      $proceso->proceso = $request->input('proceso');
      $proceso->descripcion = $request->input('descripcion');
      $proceso->usuario_responsable_id = $request->input('usuario_responsable_id');
      $proceso->rev = $request->input('rev');
      $proceso->detalle_de_rev = $request->input('detalle_de_rev');
      $proceso->tipoarchivo = $request->input('tipoarchivo');
      $proceso->idcompañia = $Users->id_compania;
      $proceso->creador_id = $Users->id;

      if ($Users->perfil == 4) {
        $proceso->status = 1;
      }else {
        $proceso->status = 0;
      }

      //obtenemos el campo file definido en el formulario
      $file = $request->file('file');
      if  ($file != null)
      {

        $file = $request->file('file');
        $extension = strtolower($file->getclientoriginalextension());
        $nombreunicoarchivo = uniqid('proc_').'.'.$extension;
        $proceso->archivo_html = $file->getClientOriginalName();
        $proceso->nombreunicoarchivo = $nombreunicoarchivo;
        $nombre = $file->getClientOriginalName();
        \Storage::disk('local')->put($nombreunicoarchivo,  \File::get($file));
      }
      $proceso->save();
      return $proceso->id;
    }

    public function store2(Request $request, $id)
    {
      $Users = Auth::user();
      // para editar registro
      $proceso = Proceso::findOrFail($id);

      //obtenemos un id para relacionar la lista de envio
      $proceso->indicadores = uniqid('ind_');
      $paraindicador = $proceso->indicadores;

      //    guardamos lista de indicadores
      $indi=$request->input('indicadores'); //$_POST["lista_de_distribucion"];
      for ($i=0;$i<count($indi);$i++)
      {
        $ind = new lista_indicadores_proceso;
        $ind ->id_indicador = $indi[$i];
        $ind ->id_proceso = $paraindicador;
        $ind ->save();
      }

      //Procesos lista
      $proceso->puestos = uniqid('pue_');
      $parapuestos = $proceso->puestos;
      //    guardamos lista de Procesos
      $indi=$request->input('Puestos'); //$_POST["lista_de_distribucion"];
      for ($i=0;$i<count($indi);$i++)
      {
        $ind = new lista_puestos_procesos;
        $ind ->id_puesto = $indi[$i];
        $ind ->id_proceso = $parapuestos;
        $ind ->save();
      }

      //Insumos id
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

      //Documentos id
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

      //Activos id
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

    public function save(Request $request)
    {

           //obtenemos el campo file definido en el formulario
           $file = $request->file('file');

           //obtenemos el nombre del archivo
           $nombre = $file->getClientOriginalName();

           //indicamos que queremos guardar un nuevo archivo en el disco local
           \Storage::disk('local')->put($nombre,  \File::get($file));

    }


      public function aprobar(Request $request, $id){
        $proceso = Proceso::find($id);
        if ($proceso->status == 1) {
          $proceso->status = 0;
          $proceso->save();
        }elseif ($proceso->status == 2) {
          $proceso-> delete();
        }else {
          $paralista = $proceso->indicadores;
          DB::table('lista_indicadores_procesos')->where('id_proceso',$paralista)->delete();
          $paralista = $proceso->puestos;
          DB::table('lista_puestos_procesos')->where('id_proceso',$paralista)->delete();
          $paralista = $proceso->insumos;
          DB::table('lista_insumos_procesos')->where('id_proceso',$paralista)->delete();
          $paralista = $proceso->documento;
          DB::table('lista_documentos_procesos')->where('id_proceso',$paralista)->delete();
          $paralista = $proceso->activo;
          DB::table('lista_activos_procesos')->where('id_proceso',$paralista)->delete();

          $proceso2 = procesostmps::where('procesoOrigen', $id)->first();

          $proceso->tipo = $proceso2->tipo;
          $proceso->proceso = $proceso2->proceso;
          $proceso->descripcion = $proceso2->descripcion;
          $proceso->usuario_responsable_id = $proceso2->usuario_responsable_id;
          $proceso->rev = $proceso2->rev;
          $proceso->detalle_de_rev = $proceso2->detalle_de_rev;
          $proceso->tipoarchivo = $proceso2->tipoarchivo;
          $proceso->archivo_html = $proceso2->archivo_html;
          $proceso->nombreunicoarchivo = $proceso2->nombreunicoarchivo;
          $proceso->indicadores = $proceso2->indicadores;
          $proceso->puestos = $proceso2->puestos;
          $proceso->insumos = $proceso2->insumos;
          $proceso->documento = $proceso2->documento;
          $proceso->activo = $proceso2->activo;

          $proceso->demandamen = $proceso2->demandamen;
          $proceso->diasmes = $proceso2->diasmes;
          $proceso->turnosdia = $proceso2->turnosdia;
          $proceso->turnoshora = $proceso2->turnoshora;
          $proceso->horades = $proceso2->horades;
          $proceso->Tiemposeg = $proceso2->Tiemposeg;
          $proceso->Tiempomin = $proceso2->Tiempomin;
          $proceso->Takt = $proceso2->Takt;
          $proceso->taktseg = $proceso2->taktseg;

          $proceso->Yield = $proceso2->Yield;
          $proceso->RTY = $proceso2->RTY;
          $proceso->DPMO = $proceso2->DPMO;
          $proceso->Sigma = $proceso2->Sigma;
          $proceso->Persona = $proceso2->Persona;
          $proceso->Maquina = $proceso2->Maquina;
          $proceso->dinero = $proceso2->dinero;
          $proceso->SLA1 = $proceso2->SLA1;
          $proceso->SLA2 = $proceso2->SLA2;
          $proceso->SLA3 = $proceso2->SLA3;
          $proceso->Mes = $proceso2->Mes;


          $proceso->status = 0;
          $proceso->save();
          $proceso2-> delete();
        }
        return Redirect('/procesosadmin');
      }


    public function denegar($id){
      $proceso = Proceso::find($id);
      if ($proceso->status == 1) {
        $this->destroy($id);
      }elseif ($proceso->status == 2) {
        $proceso->status = 0;
        $proceso->save();
      }else {
        $proceso->status = 0;
        $proceso->save();
        $proceso = procesostmps::where('procesoOrigen', $id)->first();
        $paralista = $proceso->indicadores;
        DB::table('lista_indicadores_procesos')->where('id_proceso',$paralista)->delete();
        $paralista = $proceso->puestos;
        DB::table('lista_puestos_procesos')->where('id_proceso',$paralista)->delete();
        $paralista = $proceso->insumos;
        DB::table('lista_insumos_procesos')->where('id_proceso',$paralista)->delete();
        $paralista = $proceso->documento;
        DB::table('lista_documentos_procesos')->where('id_proceso',$paralista)->delete();
        $paralista = $proceso->activo;
        DB::table('lista_activos_procesos')->where('id_proceso',$paralista)->delete();
        $proceso-> delete();
      }
      return Redirect('/procesosadmin');
    }



    public function edit($id,Request $request)
    {
      $User = Auth::user();
        // para editar registro
        if ($User->perfil == 4) {
          $procesoOrigen = Proceso::findOrFail($id);
          if ($procesoOrigen->status != 0) {
            return "false";
          }
          $procesoOrigen->status = 3;
          $procesoOrigen->save();
          $proceso = new procesostmps;
          $proceso->procesoOrigen = $id;
          $proceso->status = 0;
          $proceso->creador_id = $procesoOrigen->creador_id;
          $proceso->idcompañia = $procesoOrigen->idcompañia;
        }else {
          $proceso = Proceso::findOrFail($id);
        }


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
        return "true";
    }

    public function edit2($id,Request $request)
    {
      $User = Auth::user();
        // para editar registro
        if ($User->perfil == 4) {
          $proceso = procesostmps::where('procesoOrigen', $id)->first();
        }else {
          $proceso = Proceso::findOrFail($id);
        }

        $paraindicador = $proceso->indicadores;
        DB::table('lista_indicadores_procesos')->where('id_proceso',$paraindicador)->delete();

        $proceso->indicadores = uniqid('indi_');
        $paraindicador = $proceso->indicadores;
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
      $User = Auth::user();
        // para editar registro
        $proceso = Proceso::findOrFail($id);
        $validar = "admin";
        if ($proceso->status == 3) {
          $proceso = procesostmps::where('procesoOrigen', $id)->first();
          $validar = "usuario";
        }

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
        return $validar;
    }




    public function destroy($id)
    {
      $Users = Auth::user();
      $proceso = Proceso::findorfail($id);

      if ($Users->perfil == 4) {
        if ($procesoOrigen->status != 0) {
          return "false";
        }else {
          $proceso->status = 2;
          $proceso->save();
          return "true";
        }
      }else {
        // borramos el archivo zip
        $archivoborrar = $proceso->nombreunicoarchivo;
        if(!empty($archivoborrar)){
          \Storage::disk('local')->delete($archivoborrar);
        }

        // borramos la lista de indicadores
        $paralista = $proceso->indicadores;
        DB::table('lista_indicadores_procesos')->where('id_proceso',$paralista)->delete();
        // borramos la lista de indicadores
        $paralista = $proceso->puestos;
        DB::table('lista_puestos_procesos')->where('id_proceso',$paralista)->delete();

        $paralista = $proceso->insumos;
        DB::table('lista_insumos_procesos')->where('id_proceso',$paralista)->delete();

        $paralista = $proceso->documento;
        DB::table('lista_documentos_procesos')->where('id_proceso',$paralista)->delete();

        $paralista = $proceso->activo;
        DB::table('lista_activos_procesos')->where('id_proceso',$paralista)->delete();
        //  storage::delete($rutacompleta);
        // borramos el registro de la tabla
        $proceso-> delete();
      }

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
