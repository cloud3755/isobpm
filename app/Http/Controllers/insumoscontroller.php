<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\insumos;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class insumoscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuario = Auth::user();
        //
        $compañiaid = $usuario->id_compania;



        $insumos = new insumos;
        $insumo = $insumos->where('idcompañia',$compañiaid)->orderBy('id')->get();

        return view('Secundarias/insumos',compact('usuario','insumo'));
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

        $Users = Auth::user();
        $compañiaid = $Users->id_compania;




        if (!\Input::file('archivo'))
        {
                   $archivo = 'No se cargo archivo';
                   $nombreunicoarchivo1 = 'No se cargo archivo';
                   $bytes = 0;
        }
        else {
                  $file1                            = $request->file('archivo');
                  $extension1                       = strtolower($file1->getclientoriginalextension());
                  $nombreunicoarchivo1              = uniqid().'.'.$extension1;
                  $bytes                            = \File::size($file1);
                  $archivo = $file1->getClientOriginalName();
        }


        $insumos= new insumos;
        $insumos->producto_o_servicio = $request->input('producto');
        $insumos->descripcion = $request->input('descripcion');
        $insumos->tipo = $request->input('tipo');
        $insumos->idcompañia = $compañiaid;
        $insumos->archivo = $archivo;
        $insumos->nombreunico = $nombreunicoarchivo1;
        $insumos->size = $bytes;
        $insumos->save();

if (!\Input::file('archivo'))
{

}
    else {
      \Storage::disk('insumo')->put($nombreunicoarchivo1,  \File::get($file1));
    }

        return Redirect('/insumos');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

      public function show($id){
        $Users = Auth::user();
        $insumo = insumos::findorfail($id);
          return response()->json($insumo->toArray());
        }



    public function edit($id,Request $request)
    {
      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;

      if (!\Input::file('earchivo'))
      {
        $insumo = insumos::findorfail($id);
        $insumo->producto_o_servicio = $request->input('eproducto');
        $insumo->descripcion = $request->input('edescripcion');
        $insumo->tipo = $request->input('etipo');
        $insumo->idcompañia = $compañiaid;
        $insumo->save();
        return response()->json([
          'mensaje' => "listo"
        ]);

      }
     else
     {
       $insumo = insumos::findorfail($id);

       $file1                            = $request->file('earchivo');
       $extension1                       = strtolower($file1->getclientoriginalextension());
       $nombreunicoarchivo1              = uniqid().'.'.$extension1;
       $bytes                            = \File::size($file1);
       $archivo = $file1->getClientOriginalName();

      // borrar archivo
       $archivoborrar = $insumo->nombreunico;
       if($archivoborrar!='No se cargo archivo'){
         //return(dd($archivoborrar));
         \Storage::disk('insumo')->delete($archivoborrar);
              }

      // guardar archivo
      \Storage::disk('insumo')->put($nombreunicoarchivo1,  \File::get($file1));

       $insumo->producto_o_servicio = $request->input('eproducto');
       $insumo->descripcion = $request->input('edescripcion');
       $insumo->tipo = $request->input('etipo');
       $insumo->idcompañia = $compañiaid;
       $insumo->archivo = $archivo;
       $insumo->nombreunico = $nombreunicoarchivo1;
       $insumo->size = $bytes;
       $insumo->save();
       return response()->json([
         'mensaje' => "listo"
       ]);
     }
    }

    public function ver($id){
      $usuarios = Auth::user();
      $documento = insumos::find($id);

      $cadena = $documento->nombreunico;
      if (\Storage::disk('insumo')->exists($cadena)) {
        $response = Response::make(File::get("storage/uploadinsumos/".$documento->nombreunico));

        if(ends_with($cadena,'docx')){
          $response->header('Content-Type', "application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        }elseif (ends_with($cadena,'txt')) {
          $response->header('Content-Type', 'text/plain');
        }else{
          $content_types = File::mimeType("storage/uploadinsumos/".$documento->nombreunico);
          $response->header('Content-Type', $content_types);
        }
      }else {
          $response = "Archivo no encontrado";
      }

      // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)

      return $response;
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
      $insumo = insumos::findorfail($id);

      $archivoborrar = $insumo->nombreunico;
      if($archivoborrar!='No se cargo archivo'){
        \Storage::disk('insumo')->delete($archivoborrar);
             }

      $insumo-> delete();
      return Redirect('/insumos');
    }
}
