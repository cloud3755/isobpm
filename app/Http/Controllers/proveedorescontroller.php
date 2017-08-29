<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\insumos;
use App\Models\proveedores;
use App\Models\provedorinsumo;
use Illuminate\Support\Facades\DB;
use App\Models\archivosproveedores;




class proveedorescontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        $usuario = Auth::user();
        $iduser = $usuario->id;
        //
        $compañiaid = $usuario->id_compania;


        $insumos = new insumos;
        $insumo = $insumos->where('idcompañia',$compañiaid)->orderBy('id')->get();
        $cuentainsumo = $insumo->count();



  //      if($usuario->perfil == 4)
  //        {
            $arreglo1 = \DB::table('proveedores')
            ->select('proveedores.*')
            ->where('proveedores.activo','Activo / aprobado')
            ->where('id_compania',$compañiaid);

            $provedor = \DB::table('proveedores')
            ->where('id_compania',$compañiaid)
            ->where('idautor',$iduser)
            ->union($arreglo1)
            ->get();
  /*        }
          else {

            $provedor = \DB::table('proveedores')
            ->where('id_compania',$compañiaid)
            ->get();
          }
*/
      $cuentaproveedor = count($provedor);


      return view('Principales/proveedores',compact('usuario','cuentainsumo','cuentaproveedor'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrar()
    {
      $usuario = Auth::user();
      //
      $iduser = $usuario->id;
      $compañiaid = $usuario->id_compania;

      $insumos = new insumos;
      $insumo = $insumos->where('idcompañia',$compañiaid)->orderBy('id')->get();


      $proveedores = new proveedores;
      $provedor = $proveedores->where('id_compania',$compañiaid)->orderBy('id')->get();


      //      if($usuario->perfil == 4)
      //        {
                $arreglo1 = \DB::table('proveedores')
                ->select('proveedores.*')
                ->where('proveedores.activo','Activo / aprobado')
                ->where('id_compania',$compañiaid);

                $provedor = \DB::table('proveedores')
                ->where('id_compania',$compañiaid)
                ->where('idautor',$iduser)
                ->union($arreglo1)
                ->get();
      /*        }
              else {

                $provedor = \DB::table('proveedores')
                ->where('id_compania',$compañiaid)
                ->get();
              }
    */



      $relinsumoproveedor = new provedorinsumo;
      $insumoprovedor = $relinsumoproveedor->where('id_compania',$compañiaid)->orderBy('id')->get();


/*
      $listainsumo = \DB::table('provedorinsumos')
                               ->leftjoin('insumos','provedorinsumos.idinsumo','=','insumos.id')
                               ->select('provedorinsumos.id as id','insumos.Producto_o_Servicio as Producto_o_Servicio','insumos.id as idinsumo')
                               ->where('provedorinsumos.idproveedor','=',$id)
                               ->get();


return(dd($listainsumo));
*/

      if(Session::has('flash_message'))
      {
      Session::flash('flash_message', Session::get('flash_message'));
      }

    return view('Principales/proveedoreslist',compact('usuario','insumo','provedor','insumoprovedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $usuario = Auth::user();
      $iduser = $usuario->id;
      $compañiaid = $usuario->id_compania;


    //  return(dd($request));


      $idd = DB::table('proveedores')->insertGetId(
          ['id_compania' => $compañiaid,
           'proveedor' => $request->input('proveedor'),
           'email' => $request->input('email'),
           'telefono' =>  $request->input('telefono'),
           'activo' => $request->input('activo'),
           'direccion' => $request->input('direccion'),
           'observaciones' => $request->input('observaciones'),
           'idautor' => $iduser,
           'comentariorechazo' => ''
           ]);


           $ins=$request->input('listaSeleccionada');


           for ($i=0;$i<count($ins);$i++)
           {
             $insprov = new provedorinsumo;
             $insprov->idinsumo = $ins[$i];
             $insprov->idproveedor = $idd;
             $insprov->id_compania = $compañiaid;
             $insprov->save();
           }




    if (!\Input::file('archivo'))
           {
             Session::flash('flash_message', 'Se guardo el proveedor: '.$request->input('proveedor'));
             return redirect('/proveedores/mostrar');

           }
           else {
             // alta de archivos

                  foreach($request->file('archivo') as $file1)
                  {

                //   $file1                            = $request->file('archivo');
                   $extension1                       = strtolower($file1->getclientoriginalextension());
                   $nombreunicoarchivo1              = uniqid().'.'.$extension1;
                   $bytes                            = \File::size($file1);

                   $datosarchivo = new archivosproveedores;

                   $datosarchivo->nombre = $file1->getClientOriginalName();
                   $datosarchivo->archivo = $file1->getClientOriginalName();
                   $datosarchivo->nombreunico = $nombreunicoarchivo1;
                   $datosarchivo->size = $bytes;
                   $datosarchivo->id_proveedor = $idd;
                   $datosarchivo->id_user = $usuario->id;
                   $datosarchivo->id_compania = $compañiaid;
                   $datosarchivo->save();

                   \Storage::disk('provedor')->put($nombreunicoarchivo1,  \File::get($file1));
                   }
           }

      Session::flash('flash_message', 'Se guardo el proveedor: '.$request->input('proveedor'));
    //  return(dd($Session));
//return(dd(Session::get('flash_message')));
      return redirect('/proveedores/mostrar');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)  // muestra datos del proveedor
    {
      $usuario = Auth::user();
      $compañiaid = $usuario->id_compania;
      $provedor = proveedores::findorfail($id);

      return response()->json($provedor->toArray());

    }


    public function show2($id) // muestra insumos relacionados al proveedor
    {
      $usuario = Auth::user();
      $compañiaid = $usuario->id_compania;

      $listainsumo = DB::table('provedorinsumos')
                               ->join('insumos','provedorinsumos.idinsumo','=','insumos.id')
                               ->select('provedorinsumos.id as id','insumos.Producto_o_Servicio as Producto_o_Servicio','insumos.id as idinsumo')
                               ->where('provedorinsumos.idproveedor','=',$id)
                               ->get();

                               return response()->json(
                                 $listainsumo
                               );

    }

    public function show3($id)  // muestra insumos no relacionados a proveedor potencialmente elegibles
    {
      $usuario = Auth::user();
      $compañiaid = $usuario->id_compania;

      $listadisp=DB::table('insumos')
                     ->wherenotIn('id',function ($query) use ($id) {
                                                           $query->select('insumos.id')->from('insumos')
                                                                 ->Join('provedorinsumos','insumos.id','=','provedorinsumos.idinsumo')
                                                                 ->where('idproveedor','=',$id);
                                                                   })
                      ->where('idcompañia','=',$compañiaid )
                      ->select('insumos.id','insumos.Producto_o_Servicio')
                                                   ->get();


                               return response()->json(
                                   $listadisp
                               );

    }

    public function show4($id) // muestra archivos relacionados a proveedor
    {
      $usuario = Auth::user();
      $compañiaid = $usuario->id_compania;


      $datosarchivo =DB::table('archivosproveedores')
                         ->where('id_proveedor','=',$id)
                         ->select('id','archivo','nombreunico')
                         ->get();

                               return response()->json(
                                   $datosarchivo
                               );

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;

      $provedor = proveedores::findorfail($id);
      $provedor->proveedor = $request->input('eproveedor');
      $provedor->email = $request->input('eemail');
      $provedor->telefono = $request->input('etelefono');
      $provedor->activo = $request->input('eactivo');
      $provedor->direccion = $request->input('edireccion');
      $provedor->observaciones = $request->input('eobservaciones');
      $provedor->id_compania = $compañiaid;
      $provedor->comentariorechazo = '';
      $provedor->save();

      $ins=$request->input('elistaSeleccionada');

      //Se borran
      $insprovborra = provedorinsumo::where('idproveedor', $id)->delete();

      for ($i=0;$i<count($ins);$i++)
      {
        $insprov = new provedorinsumo;
        $insprov->idinsumo = $ins[$i];
        $insprov->idproveedor = $id;
        $insprov->id_compania = $compañiaid;
        $insprov->save();
      }

Session::flash('flash_message', 'Se modifico el proveedor');

return redirect('/proveedores/mostrar');

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
      $provedor = proveedores::findorfail($id);
      $provedor-> delete();
      $insprovborra = provedorinsumo::where('idproveedor', $id)->delete();

// bprrar archvos del proveedor
    //  $provedor = archivosproveedores::findorfail($id);

      // borramos el archivo zip
  //    $archivoborrar = $provedor->nombreunico;
  //    if(!empty($archivoborrar)){
  //      \Storage::disk('provedor')->delete($archivoborrar);
  //           }

  //    $provedor-> delete();

Session::flash('flash_message', 'Se elimino el proveedor');

      return redirect('/proveedores/mostrar');
    }

    /**
     * Disables the specified resource from table.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disabled($id)
    {
      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;

      $provedor = proveedores::findorfail($id);
      $provedor->activo = 'Inactivo';
      $provedor->save();

      Session::flash('flash_message', 'Se deshabilito el proveedor');

      return redirect()->action('proveedorescontroller@adminshow');
    }




    /**
     * Disables the specified resource from table.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adminshow()
    {
      // cambiar para mostrar proveedores pendientes de habilitadr
      $usuario = Auth::user();
      //
      $iduser = $usuario->id;
      $compañiaid = $usuario->id_compania;

      $insumos = new insumos;
      $insumo = $insumos->where('idcompañia',$compañiaid)->orderBy('id')->get();


      $proveedores = new proveedores;
      $provedor = $proveedores->where('id_compania',$compañiaid)->orderBy('id')->get();



      if($usuario->perfil != 4)
        {
        $provedor = \DB::table('proveedores')
        ->select('proveedores.*')
        ->where('id_compania',$compañiaid)
        ->where('proveedores.activo','!=','Activo / aprobado')
        ->get();
         }
       else {
         $arreglo1 = \DB::table('proveedores')
         ->select('proveedores.*')
         ->where('proveedores.activo','Activo / aprobado')
         ->where('id_compania',$compañiaid);

         $provedor = \DB::table('proveedores')
         ->where('id_compania',$compañiaid)
         ->where('idautor',$iduser)
         ->union($arreglo1)
         ->get();
       }

      $relinsumoproveedor = new provedorinsumo;
      $insumoprovedor = $relinsumoproveedor->where('id_compania',$compañiaid)->orderBy('id')->get();

      if(Session::has('flash_message'))
      {
      Session::flash('flash_message', Session::get('flash_message'));
      }


    return view('Principales/proveedoreslistadmin',compact('usuario','insumo','provedor','insumoprovedor'));
    }





    /**
     * Disables the specified resource from table.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function aprobartodo()
    {
      // cambiar para mostrar proveedores pendientes de habilitadr
      $usuario = Auth::user();
      //
      $iduser = $usuario->id;
      $compañiaid = $usuario->id_compania;

      if($usuario->perfil != 4)
        {
      proveedores::where('id_compania',$compañiaid)
      ->where('activo','En espera de aprobacion')
      ->update(['activo' => 'Activo / aprobado']);
        }

      Session::flash('flash_message', 'Se aprobaron los proveedores');
     return redirect()->action('proveedorescontroller@adminshow');
    }

    public function aprobar(Request $request)
    {

      // cambiar para mostrar proveedores pendientes de habilitadr
      $usuario = Auth::user();
      //
      $iduser = $usuario->id;
      $compañiaid = $usuario->id_compania;

      if($usuario->perfil != 4)
        {
      proveedores::where('id_compania',$compañiaid)
      ->where('id',$request->input('aprueboid'))
      ->update(['activo' => 'Activo / aprobado']);
        }

     Session::flash('flash_message', 'Se aprobo el proveedor');
     return redirect()->action('proveedorescontroller@adminshow');
    }


    public function rechazo(Request $request)
    {

      // cambiar para mostrar proveedores pendientes de habilitadr
      $usuario = Auth::user();
      //
      $iduser = $usuario->id;
      $compañiaid = $usuario->id_compania;

      if($usuario->perfil != 4)
        {
      proveedores::where('id_compania',$compañiaid)
      ->where('id',$request->input('rid'))
      ->update(['activo' => 'Rechazado',
                'comentariorechazo' => $request->input('rcomt')]);
        }

      Session::flash('flash_message', 'Se envio el mensaje de rechazo al proveedor');

     return redirect()->action('proveedorescontroller@adminshow');
    }


}
