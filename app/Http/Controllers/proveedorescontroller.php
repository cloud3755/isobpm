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
        //
        $compañiaid = $usuario->id_compania;


        $insumos = new insumos;
        $insumo = $insumos->where('idcompañia',$compañiaid)->orderBy('id')->get();
        $cuentainsumo = $insumo->count();

        $proveedores = new proveedores;
        $proveedor = $proveedores->where('id_compania',$compañiaid)->orderBy('id')->get();
        $cuentaproveedor = $proveedor->count();


      return view('Principales/proveedores',compact('cuentainsumo','cuentaproveedor'));

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
      $compañiaid = $usuario->id_compania;

      $insumos = new insumos;
      $insumo = $insumos->where('idcompañia',$compañiaid)->orderBy('id')->get();

      $proveedores = new proveedores;
      $provedor = $proveedores->where('id_compania',$compañiaid)->orderBy('id')->get();

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

    return view('Principales/proveedoreslist',compact('insumo','provedor','insumoprovedor'));
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
      $compañiaid = $usuario->id_compania;



      $idd = DB::table('proveedores')->insertGetId(
          ['id_compania' => $compañiaid,
           'proveedor' => $request->input('proveedor'),
           'email' => $request->input('email'),
           'telefono' =>  $request->input('telefono'),
           'activo' => $request->input('activo'),
           'direccion' => $request->input('direccion'),
           'observaciones' => $request->input('observaciones')
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



      return redirect('/proveedores/mostrar');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $usuario = Auth::user();
      $compañiaid = $usuario->id_compania;
      $provedor = proveedores::findorfail($id);

      return response()->json($provedor->toArray());

    }


    public function show2($id)
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

    public function show3($id)
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



      return redirect('/proveedores/mostrar');
    }
}
