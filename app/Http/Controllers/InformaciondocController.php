<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection as Collection;
use App\Models\Typedocuments;
use App\Models\Documentos;
use App\Models\Documentostmp;
use App\Models\User;
use App\Models\informacion_accesos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class InformaciondocController extends Controller
{

  public function mostrar($id)
  {

    $usuarios = Auth::user();

    $typedocuments = new Typedocuments;
    $datos = $typedocuments->where('id',$id)->first();

    $documentos = new Documentos;


    if($usuarios->perfil == 4)
      {
        $arreglo1 = \DB::table('documentos')
        ->join('informacion_accesos','documentos.acceso','=','informacion_accesos.id_documento')
        ->select('documentos.*')
        ->where('documentos.Status',1)
        ->where('informacion_accesos.id_usuario',$usuarios->id)
        ->where('id_tipo',$id);

        $documento = \DB::table('documentos')
        ->where('id_user',$usuarios->id)
        ->union($arreglo1)
        ->get();



      //  dd($documento);
      }

    // if($usuarios->perfil == 4)
    //   {
    //     $documento = $documentos
    //     ->where('id_tipo',$id)
    //     ->where('id_compania',$usuarios->id_compania)
    //     ->where('id_user',$usuarios->id)
    //     ->where('Status',1)->get();
    //   }

    if($usuarios->perfil <= 3)
    {
      $documento = $documentos
      ->where('id_tipo',$id)
      ->where('id_compania',$usuarios->id_compania)
      ->where('Status',1)->get();
    }
    $Users = new User;
    $User = $Users->where('id_compania',$usuarios->id_compania)->where('perfil',4)->get();

    if(is_null($datos) ){
      return redirect('/infdocumentada');
    }

    $listaaccesos = \DB::table('users')
                      ->leftjoin('informacion_accesos','users.id', '=', 'informacion_accesos.id_usuario')
                      ->select('informacion_accesos.id_documento','users.id','users.usuario')
                      ->leftjoin('documentos','informacion_accesos.id_documento','=','documentos.acceso')
                      ->get();
                    //  return dd($listaaccesos);
    //return view('/Principales/Documentada/docmostrar');

    return view('/Principales/Documentada/docmostrar',compact('datos','documento','User','listaaccesos','accesosactuales'));
  }

  public function store(Request $request)
  {
    $usuarios = Auth::user();
    $documentos = new Documentos;

    $documentos->id_tipo = $request->input('id_tipo');
    $documentos->nombre = $request->input('nombre');
    $documentos->descripcion = $request->input('descripcion');
    $documentos->id_user = $usuarios->id;
    $documentos->id_compania = $usuarios->id_compania;
    $documentos->review = 1;
    if ($usuarios->perfil != 4) {
      $documentos->status = 1;
    }else {
      $documentos->status = 0;
    }
    //Para lista de accesos
    $paralista = uniqid('infac_');
    $documentos->acceso = $paralista;

    //Todo para el Archivo

    $file1                            = $request->file('archivo');
    $extension1                       = strtolower($file1->getclientoriginalextension());
    $nombreunicoarchivo1              = uniqid().'.'.$extension1;
    $bytes                            = \File::size($file1);
    $documentos->size                 = $bytes;
    $documentos->archivo              = $file1->getClientOriginalName();
    $documentos->nombreunico          = $nombreunicoarchivo1;


    $documentos->save();

    //Guardad documento
    \Storage::disk('documentos')->put($nombreunicoarchivo1,  \File::get($file1));


    //Se guarda la lista de accesos
    $acces=$request->input('lista_de_accesos'); //$_POST["lista_de_distribucion"];
  //  return(dd($request->input('lista_de_accesos')));
    for ($i=0;$i<count($acces);$i++)
    {
      $acce = new informacion_accesos;
      $acce ->id_usuario = $acces[$i];
      $acce ->id_documento = $paralista;
      $acce ->save();
    }

    return redirect()->action('InformaciondocController@mostrar', [$documentos->id_tipo]);
  }



  public function destroy($id)
  {
    $usuarios = Auth::user();
    $documentos = Documentos::findorfail($id);

    if ($usuarios->perfil != 4) {
      $documentos-> delete();
      \Storage::disk('documentos')->delete($documentos->nombreunico);
    }else {
      $documentos->status = 2;
      $documentos->save();
    }

    return redirect()->action('InformaciondocController@mostrar', [$documentos->id_tipo]);

  }

  public function editM($id,Request $request)
  {
    $usuarios = Auth::user();
    $documentos = Documentos::findorfail($id);
    if ($usuarios->perfil != 4) {
      //nombre del archivo
      $file                              = $request->file('aarchivo');
      //se valida que no este vacio el archivo

      if(!empty($file))
      {
        $extension                        = strtolower($file->getclientoriginalextension());
        $nombreunicoarchivo               = uniqid().'.'.$extension;
        \Storage::disk('documentos')->put($nombreunicoarchivo,  \File::get($file));

        if (\Storage::disk('documentos')->exists($nombreunicoarchivo)) {
          if (\Storage::disk('documentos')->exists($documentos->nombreunico)) {
            \Storage::disk('documentos')->delete($documentos->nombreunico);
          }
          $documentos->archivo              = $file->getClientOriginalName();
          $documentos->nombreunico          = $nombreunicoarchivo;
          $bytes                            = \File::size($file);
          $documentos->size                 = $bytes;
          $documentos->review = $documentos->review + 1;
        }
      }else {
        if (!\Storage::disk('documentos')->exists($documentos->nombreunico)) {
          $documentos->archivo              = "";
          $documentos->nombreunico          = "";
          $documentos->size                 = 0;
        }
      }
      $documentos->id_tipo = $request->input('id_tipo');
      $documentos->nombre = $request->input('enombre');
      $documentos->descripcion = $request->input('edescripcion');
      $documentos->id_user = $usuarios->id;
      $documentos->id_compania = $usuarios->id_compania;
      $documentos->status = 1;

      $documentos->save();

      //Se borran
      $accesos = informacion_accesos::where('id_documento', $documentos->acceso)->delete();

      //Se guarda la lista de accesos
      $acces = $request->input('elista_de_accesos'); //$_POST["lista_de_distribucion"];
      for ($i=0;$i<count($acces);$i++)
      {
        $acce = new informacion_accesos;
        $acce ->id_usuario = $acces[$i];
        $acce ->id_documento = $documentos->acceso;
        $acce ->save();
      }
      //return redirect()->action('InformaciondocController@mostrar', [$documentos->id_tipo]);
    }else {
      $document = new Documentostmp;
      $document->id_documento = $documentos->id;
      $document->id_tipo = $request->input('id_tipo');
      $document->nombre = $request->input('enombre');
      $document->descripcion = $request->input('edescripcion');
      $document->id_user = $usuarios->id;
      $document->id_compania = $usuarios->id_compania;
      $document->review = $documentos->review + 1;
      $document->status = 1;
      //Para lista de accesos
      $paralista = uniqid('infac_');
      $document->acceso = $paralista;

      //Todo para el Archivo

      $file1                            = $request->file('aarchivo');
      if(!empty($file1))
      {
        $extension1                       = strtolower($file1->getclientoriginalextension());
        $nombreunicoarchivo1              = uniqid().'.'.$extension1;
        $bytes                            = \File::size($file1);
        $document->size                 = $bytes;
        $document->archivo              = $file1->getClientOriginalName();
        $document->nombreunico          = $nombreunicoarchivo1;
        //Guardad documento
        \Storage::disk('documentos')->put($nombreunicoarchivo1,  \File::get($file1));
      }

      $document->save();



      //Se guarda la lista de accesos
      $acces=$request->input('elista_de_accesos'); //$_POST["lista_de_distribucion"];
      for ($i=0;$i<count($acces);$i++)
      {
        $acce = new informacion_accesos;
        $acce ->id_usuario = $acces[$i];
        $acce ->id_documento = $paralista;
        $acce ->save();
      }
      $documentos->status = 3;
      $documentos->save();

    }

    return response()->json([
      'mensaje' => "listo"
    ]);
  }

  public function edit($id){
    $documentos = Documentos::find($id);
    if ($documentos->status == 3) {
      $document = Documentostmp::where('id_documento', $id)->first();
      return response()->json(
        $document->toArray()
      );
    }else {
      return response()->json(
        $documentos->toArray()
      );
    }
  }

  public function edit2($id){
    $documentos = Documentos::find($id);
    if ($documentos->status == 3) {
      $docum = Documentostmp::where('id_documento', $id)->first();
      $document = DB::table('users')
      ->join('informacion_accesos', 'users.id', '=', 'informacion_accesos.id_usuario')
      ->select('users.*')
      ->where('informacion_accesos.id_documento', $docum->acceso)
      ->get();
      return response()->json(
        $document
      );
    }else {
      $document = DB::table('users')
      ->join('informacion_accesos', 'users.id', '=', 'informacion_accesos.id_usuario')
      ->select('users.*')
      ->where('informacion_accesos.id_documento', $documentos->acceso)
      ->get();
      return response()->json(
        $document
      );
    }
  }


  public function edit23($id){
    $users = Auth::user();
    $documentos = Documentos::find($id);
    if ($documentos->status == 3) {
      $docum = Documentostmp::where('id_documento', $id)->first();
      $lista = $docum->acceso;
      $document = DB::table('users')
      ->leftJoin('informacion_accesos', function($join) use ($lista)
        {
            $join->on('users.id', '=', 'informacion_accesos.id_usuario');
            $join->on(function($query) use ($lista)
            {
              $query->on('informacion_accesos.id_documento', '=', DB::raw("'".$lista."'"));
            });
        })
      ->select('users.*')
      ->where('users.id_compania',$users->id_compania)
      ->WhereNull('informacion_accesos.id_documento')
      ->where('users.perfil',4)
      ->get();
      return response()->json(
        $document
      );
    }else {
      $lista = $documentos->acceso;
      $document = DB::table('users')
      ->leftJoin('informacion_accesos', function($join) use ($lista)
        {
            $join->on('users.id', '=', 'informacion_accesos.id_usuario');
            $join->on(function($query) use ($lista)
            {
              $query->on('informacion_accesos.id_documento', '=', DB::raw("'".$lista."'"));
            });
        })
      ->select('users.*')
      ->where('users.id_compania',$users->id_compania)
      ->WhereNull('informacion_accesos.id_documento')
      ->where('users.perfil',4)
      ->get();
      return response()->json(
        $document
      );
    }
  }



  public function aprobar(Request $request, $id){
    $documentoe = Documentos::find($id);
    if ($documentoe->status == 0) {
      $documentoe->status = 1;
      $documentoe->save();
    }elseif ($documentoe->status == 2) {
      $documentoe-> delete();
      \Storage::disk('documentos')->delete($documentoe->nombreunico);
    }else {
      $usuarios = Auth::user();
      $document = Documentostmp::where('id_documento', $id)->first();
      $documentos = Documentos::find($document->id_documento);

      if ($document->archivo != null) {
        \Storage::disk('documentos')->delete($documentos->nombreunico);
        $documentos->archivo              = $document->archivo;
        $documentos->nombreunico          = $document->nombreunico;
        $documentos->size                 = $document->size;
      }

      $documentos->review = $document->review;
      $documentos->id_tipo = $document->id_tipo;
      $documentos->nombre = $document->nombre;
      $documentos->descripcion = $document->descripcion;
      $documentos->id_user = $document->id_user;
      $documentos->id_compania = $document->id_compania;
      $documentos->status = 1;

      $accesos = informacion_accesos::where('id_documento', $documentos->acceso)->delete();

      $documentos->acceso = $document->acceso;
      $documentos->save();
      //Se borran el edit
      $document-> delete();
    }


      return Redirect('/documentada');
//    return response()->json(
  //    $documentos->toArray()
    //);
  }

  public function aprobartodo(){
    $usuarios = Auth::user();
    //$documentoe = Documentos::where('id_compania', $usuarios->id_compania)->first();
    $documento = new Documentos;
    $documentoe = $documento->where('id_compania', $usuarios->id_compania)->where('status', '!=', 1)->get();
    //return dd($documentoe[$i]->nombre);
    for ($i=0;$i<count($documentoe);$i++)
    {
      if ($documentoe[$i]->status == 0) {
        $documentoe[$i]->status = 1;
        $documentoe[$i]->save();
      }elseif ($documentoe[$i]->status == 2) {
        $documentoe[$i]-> delete();
        \Storage::disk('documentos')->delete($documentoe[$i]->nombreunico);
      }else {
        $usuarios = Auth::user();
        $document = Documentostmp::where('id_documento', $documentoe[$i]->id)->first();
        $documentos = Documentos::find($document->id_documento);

        if ($document->archivo != null) {
          \Storage::disk('documentos')->delete($documentos->nombreunico);
          $documentos->archivo              = $document->archivo;
          $documentos->nombreunico          = $document->nombreunico;
          $documentos->size                 = $document->size;
        }

        $documentos->review = $document->review;
        $documentos->id_tipo = $document->id_tipo;
        $documentos->nombre = $document->nombre;
        $documentos->descripcion = $document->descripcion;
        $documentos->id_user = $document->id_user;
        $documentos->id_compania = $document->id_compania;
        $documentos->status = 1;

        $accesos = informacion_accesos::where('id_documento', $documentos->acceso)->delete();

        $documentos->acceso = $document->acceso;
        $documentos->save();
        //Se borran el edit
        $document-> delete();
      }
    }
      return Redirect('/documentada');
//    return response()->json(
  //    $documentos->toArray()
    //);
  }

  public function denegar($id){
    $documentoe = Documentos::find($id);

    if ($documentoe->status == 0) {
      $documentoe-> delete();
      \Storage::disk('documentos')->delete($documentoe->nombreunico);
    }elseif ($documentoe->status == 2) {
      $documentoe->status = 1;
      $documentoe->save();
    }else {
      $documentoe->status = 1;
      $documentoe->save();
      $document = Documentostmp::where('id_documento', $id)->first();
      $document-> delete();
      if ($document->nombreunico != null) {
        \Storage::disk('documentos')->delete($document->nombreunico);
      }
    }

    return Redirect('/documentada');
  }

  public function ver($id){
    $documento = Documentos::find($id);
    $cadena = $documento->nombreunico;
    if (\Storage::disk('documentos')->exists($cadena)) {
      $response = Response::make(File::get("storage/documentos/".$documento->nombreunico));

      if(ends_with($cadena,'docx')){
        $response->header('Content-Type', "application/vnd.openxmlformats-officedocument.wordprocessingml.document");
      }elseif (ends_with($cadena,'txt')) {
        $response->header('Content-Type', 'text/plain');
      }else{
        $content_types = File::mimeType("storage/documentos/".$documento->nombreunico);
        $response->header('Content-Type', $content_types);
      }
    }else {
        $response = "Archivo no encontrado";
    }

    // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)

    return $response;
  }

}
