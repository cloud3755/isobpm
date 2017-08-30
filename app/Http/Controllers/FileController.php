<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection as Collection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Models\archivosproveedores;

class FileController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {

      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;

      foreach($request->file('uarchivo') as $file1)
      {
      //$file1                            = $request->file('uarchivo');
      $extension1                       = strtolower($file1->getclientoriginalextension());
      $nombreunicoarchivo1              = uniqid().'.'.$extension1;
      $bytes                            = \File::size($file1);

      $datosarchivo = new archivosproveedores;

      $datosarchivo->nombre = $file1->getClientOriginalName();
      $datosarchivo->archivo = $file1->getClientOriginalName();
      $datosarchivo->nombreunico = $nombreunicoarchivo1;
      $datosarchivo->size = $bytes;
      $datosarchivo->id_proveedor = $id;
      $datosarchivo->id_user = $usuarios->id;
      $datosarchivo->id_compania = $compañiaid;
      $datosarchivo->save();

      \Storage::disk('provedor')->put($nombreunicoarchivo1,  \File::get($file1));
      }
      return ('Ok');

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;

      $datosarchivo = new archivosproveedores;
      $datafile = $datosarchivo->where('id_proveedor',$id)->get();

      return response()->json($datafile->toArray());

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
      $usuarios = Auth::user();
      $provedor = archivosproveedores::findorfail($id);

      // borramos el archivo zip
      $archivoborrar = $provedor->nombreunico;
      if(\Storage::disk('provedor')->exists($archivoborrar)){
        \Storage::disk('provedor')->delete($archivoborrar);
             }

      $provedor-> delete();
      return redirect('/proveedores/mostrar');

    }

    public function ver($id){
      $usuarios = Auth::user();
      $documento = archivosproveedores::find($id);
      $cadena = $documento->nombreunico;
      if (\Storage::disk('provedor')->exists($cadena)) {
        $response = Response::make(File::get("storage/uploadproveedores/".$documento->nombreunico));

        if(ends_with($cadena,'docx')){
          $response->header('Content-Type', "application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        }elseif (ends_with($cadena,'txt')) {
          $response->header('Content-Type', 'text/plain');
        }else{
          $content_types = File::mimeType("storage/uploadproveedores/".$documento->nombreunico);
          $response->header('Content-Type', $content_types);
        }
      }else {
          $response = "Archivo no encontrado";
      }

      // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)

      return $response;
    }




}
