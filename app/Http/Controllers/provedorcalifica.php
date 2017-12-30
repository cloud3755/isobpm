<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\insumos;
use App\Models\proveedores;
use App\Models\provedorinsumo;
use App\Models\User;
use App\Models\proveedorcalifica;
use App\Models\Areas;
use App\Models\proyecto;
use App\Models\insumoscalificados;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;


class provedorcalifica extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;

      $proveedores = new proveedores;
      $proveedor = $proveedores->where('id_compania',$compañiaid)->where('proveedores.activo','Activo / aprobado')->orderBy('id')->get();

      $areas = new Areas;
      $area = $areas->where('id_compania',$compañiaid)->orderBy('id')->get();

      $proyecto = new proyecto;
      $proyect = $proyecto->where('id_compania',$compañiaid)->get();

      return view('/Secundarias/provedorcalifica',compact('proveedor','area','proyect'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexinsumo($id)
    {
      $usuarios = Auth::user();

      $listainsumo = DB::table('provedorinsumos')
                               ->join('insumos','provedorinsumos.idinsumo','=','insumos.id')
                               ->select('provedorinsumos.id as id','insumos.Producto_o_Servicio as Producto_o_Servicio','insumos.id as idinsumo')
                               ->where('provedorinsumos.idproveedor','=',$id)
                               ->get();



      return ($listainsumo);

    }


    public function indexarea()
    {
      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;

      $area = DB::table('areas')
                               ->select('*')
                               ->where('areas.id_compania','=',$compañiaid)
                               ->get();

      return response()->json($area);

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

      $compañiaid = $usuarios->id_compania;
      $iduser = $usuarios->id;



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


      $fecha = $request->input('fechacalificacion');


      $idd = DB::table('proveedorcalifica')->insertGetId([
           'idproveedor' => $request->input('proveedorid'),
           'pedido' =>  $request->input('pedido'),
           'tiempo' => $request->input('Tiempo'),
           'calidad' => $request->input('calidad'),
           'servicio' => $request->input('servicio'),
           'costo' => $request->input('costo'),
           'idautor'=> $iduser,
           'idarea' => $request->input('area'),
           'idcompania' => $compañiaid,
           'archivo' => $archivo,
           'nombreunico' => $nombreunicoarchivo1 ,
           'size' => $bytes ,
           'fechacalificacion' => $fecha,
           'comentarioevaluacion' => $request->input('evalcomnt'),
           'obstiempo' => $request->input('obstiempo'),
           'obscalidad' => $request->input('obscalidad'),
           'obsservicio' => $request->input('obsservicio'),
           'obscosto' => $request->input('obscosto'),
           'proyecto_id' => $request->input('proyecto'),
           ]);




           $ins=$request->input('elistaSeleccionada');


           for ($i=0;$i<count($ins);$i++)
           {
             $inscal = new insumoscalificados;
             $inscal->idcalificacion = $idd;
             $inscal->idinsumo = $ins[$i];
             $inscal->idcompañia = $compañiaid;
             $inscal->idautor = $iduser;
             $inscal->idarea = $request->input('area');
             $inscal->save();
           }



           if (!\Input::file('archivo'))
           {

           }
               else {
                 \Storage::disk('calificaproveedor')->put($nombreunicoarchivo1,  \File::get($file1));
               }

        Session::flash('flash_message', 'Se guardo la evaluacion');

        return redirect('/proveedores');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function resultadoindex()
     {
       $usuarios = Auth::user();
       $compañiaid = $usuarios->id_compania;

/// obtenemos los distintos proveedores que ya han sido calificados
       $proveedor = DB::table('proveedorcalifica')
                                ->join('proveedores','proveedores.id','=','proveedorcalifica.idproveedor')
                                ->select('proveedorcalifica.idproveedor','proveedores.proveedor')
                                ->distinct()
                                ->where('proveedorcalifica.idcompania','=',$compañiaid)
                                ->where('proveedores.activo','Activo / aprobado')
                                ->get();

//      return(dd($proveedor));


$proyecto = new proyecto;
$proyect = $proyecto->where('id_compania',$compañiaid)->get();


       $yesterday = Carbon::yesterday();

       $tomorrow = Carbon::tomorrow('Europe/London');


       return view('/Secundarias/provedorcalificaresultado',compact('proveedor','tomorrow','yesterday','proyect'));
     }




    public function showresult(Request $request)
    {
        //
        $usuarios = Auth::user();
        $compañiaid = $usuarios->id_compania;

        $insumos = $request->elistaSeleccionada;
        $prueba='';
//return(dd($insumos));
foreach($insumos as $x => $x_value) {
$prueba = $prueba.','.$x_value;

}
//substr($prueba,1,strlen($prueba))))

$array = array(substr($prueba,1,strlen($prueba)));

//return(dd($arr));

$t = "t";
//return(dd($request->area));
if ($request->area == $t && $request->proyecto == $t)
{
        $calificacion = DB::table('proveedorcalifica')
                                 ->join('proveedores','proveedores.id','=','proveedorcalifica.idproveedor')
                                 ->join('insumoscalificados','insumoscalificados.idcalificacion','=','proveedorcalifica.id')
                                 ->join('insumos','insumoscalificados.idinsumo','=','insumos.id')
                                 ->select('proveedorcalifica.*','insumoscalificados.idinsumo','proveedores.proveedor','insumos.Producto_o_Servicio')
                                 ->where('proveedorcalifica.idcompania','=',$compañiaid)
                                 ->where('proveedorcalifica.idproveedor','=',$request->proveedor)
                                 ->wherein('insumoscalificados.idinsumo',$array)//$insumoid)
                                 ->wherebetween('fechacalificacion', [$request->fech, $request->fecha2])
                                 ->orderby('fechacalificacion')
                                 ->get();

}
else if ($request->area != $t && $request->proyecto == $t)
{

         $calificacion = DB::table('proveedorcalifica')
                                  ->join('proveedores','proveedores.id','=','proveedorcalifica.idproveedor')
                                  ->join('insumoscalificados','insumoscalificados.idcalificacion','=','proveedorcalifica.id')
                                  ->join('insumos','insumoscalificados.idinsumo','=','insumos.id')
                                  ->select('proveedorcalifica.*','insumoscalificados.idinsumo','proveedores.proveedor','insumos.Producto_o_Servicio')
                                  ->where('proveedorcalifica.idcompania','=',$compañiaid)
                                  ->where('proveedorcalifica.idproveedor','=',$request->proveedor)
                                  ->wherein('insumoscalificados.idinsumo',$array)//$insumoid)
                                  ->where('proveedorcalifica.idarea','=',$request->area)
                                  ->wherebetween('fechacalificacion', [$request->fech, $request->fecha2])
                                  ->orderby('fechacalificacion')
                                  ->get();

}

else if ($request->area == $t && $request->proyecto != $t)
{

         $calificacion = DB::table('proveedorcalifica')
                                  ->join('proveedores','proveedores.id','=','proveedorcalifica.idproveedor')
                                  ->join('insumoscalificados','insumoscalificados.idcalificacion','=','proveedorcalifica.id')
                                  ->join('insumos','insumoscalificados.idinsumo','=','insumos.id')
                                  ->select('proveedorcalifica.*','insumoscalificados.idinsumo','proveedores.proveedor','insumos.Producto_o_Servicio')
                                  ->where('proveedorcalifica.idcompania','=',$compañiaid)
                                  ->where('proveedorcalifica.idproveedor','=',$request->proveedor)
                                  ->wherein('insumoscalificados.idinsumo',$array)//$insumoid)
                                  ->where('proveedorcalifica.proyecto_id','=',$request->proyecto)
                                  ->wherebetween('fechacalificacion', [$request->fech, $request->fecha2])
                                  ->orderby('fechacalificacion')
                                  ->get();

}

else {

           $calificacion = DB::table('proveedorcalifica')
                                    ->join('proveedores','proveedores.id','=','proveedorcalifica.idproveedor')
                                    ->join('insumoscalificados','insumoscalificados.idcalificacion','=','proveedorcalifica.id')
                                    ->join('insumos','insumoscalificados.idinsumo','=','insumos.id')
                                    ->select('proveedorcalifica.*','insumoscalificados.idinsumo','proveedores.proveedor','insumos.Producto_o_Servicio')
                                    ->where('proveedorcalifica.idcompania','=',$compañiaid)
                                    ->where('proveedorcalifica.idproveedor','=',$request->proveedor)
                                    ->wherein('insumoscalificados.idinsumo',$array)//$insumoid)
                                    ->where('proveedorcalifica.proyecto_id','=',$request->proyecto)
                                    ->where('proveedorcalifica.idarea','=',$request->area)
                                    ->wherebetween('fechacalificacion', [$request->fech, $request->fecha2])
                                    ->orderby('fechacalificacion')
                                    ->get();
}





//return(dd($calificacion));

  $result[] = ['Fecha : pedido','Tiempo','Calidad','Servicio','Costo','Promedio'];
  foreach ($calificacion as $key => $value) {
      $time = (int)$value->tiempo;
      $quality = (int)$value->calidad;
      $service = (int)$value->servicio;
      $cost = (int)$value->costo;
      $avg = (( $time + $quality + $service +$cost)/4);
      $result[++$key] = [$value->fechacalificacion.' : '.(string)$value->pedido , (int)$value->tiempo, (int)$value->calidad, (int)$value->servicio, (int)$value->costo,$avg];
  }
                                 return response()->json($result);


    }


    public function tabla(Request $request)
    {
        //
        $usuarios = Auth::user();
        $compañiaid = $usuarios->id_compania;

        $insumos = $request->elistaSeleccionada;
        $prueba='';
//return(dd($insumos));
foreach($insumos as $x => $x_value) {
$prueba = $prueba.','.$x_value;

}
//substr($prueba,1,strlen($prueba))))

$array = array(substr($prueba,1,strlen($prueba)));

//return(dd($arr));

$t = "t";

if ($request->area == $t && $request->proyecto == $t)
{
        $calificacion = DB::table('proveedorcalifica')
                                 ->join('proveedores','proveedores.id','=','proveedorcalifica.idproveedor')
                                 ->join('insumoscalificados','insumoscalificados.idcalificacion','=','proveedorcalifica.id')
                                 ->join('insumos','insumoscalificados.idinsumo','=','insumos.id')
                                 ->select('proveedorcalifica.*','insumoscalificados.idinsumo','proveedores.proveedor','insumos.Producto_o_Servicio')
                                 ->where('proveedorcalifica.idcompania','=',$compañiaid)
                                 ->where('proveedorcalifica.idproveedor','=',$request->proveedor)
                                 ->wherein('insumoscalificados.idinsumo',$array)//$insumoid)
                                 ->wherebetween('fechacalificacion', [$request->fech, $request->fecha2])
                                 ->orderby('fechacalificacion')
                                 ->get();

}
else if ($request->area != $t && $request->proyecto == $t)
{

         $calificacion = DB::table('proveedorcalifica')
                                  ->join('proveedores','proveedores.id','=','proveedorcalifica.idproveedor')
                                  ->join('insumoscalificados','insumoscalificados.idcalificacion','=','proveedorcalifica.id')
                                  ->join('insumos','insumoscalificados.idinsumo','=','insumos.id')
                                  ->select('proveedorcalifica.*','insumoscalificados.idinsumo','proveedores.proveedor','insumos.Producto_o_Servicio')
                                  ->where('proveedorcalifica.idcompania','=',$compañiaid)
                                  ->where('proveedorcalifica.idproveedor','=',$request->proveedor)
                                  ->wherein('insumoscalificados.idinsumo',$array)//$insumoid)
                                  ->where('proveedorcalifica.idarea','=',$request->area)
                                  ->wherebetween('fechacalificacion', [$request->fech, $request->fecha2])
                                  ->orderby('fechacalificacion')
                                  ->get();

}

else if ($request->area == $t && $request->proyecto != $t)
{

         $calificacion = DB::table('proveedorcalifica')
                                  ->join('proveedores','proveedores.id','=','proveedorcalifica.idproveedor')
                                  ->join('insumoscalificados','insumoscalificados.idcalificacion','=','proveedorcalifica.id')
                                  ->join('insumos','insumoscalificados.idinsumo','=','insumos.id')
                                  ->select('proveedorcalifica.*','insumoscalificados.idinsumo','proveedores.proveedor','insumos.Producto_o_Servicio')
                                  ->where('proveedorcalifica.idcompania','=',$compañiaid)
                                  ->where('proveedorcalifica.idproveedor','=',$request->proveedor)
                                  ->wherein('insumoscalificados.idinsumo',$array)//$insumoid)
                                  ->where('proveedorcalifica.proyecto_id','=',$request->proyecto)
                                  ->wherebetween('fechacalificacion', [$request->fech, $request->fecha2])
                                  ->orderby('fechacalificacion')
                                  ->get();

}

else {

           $calificacion = DB::table('proveedorcalifica')
                                    ->join('proveedores','proveedores.id','=','proveedorcalifica.idproveedor')
                                    ->join('insumoscalificados','insumoscalificados.idcalificacion','=','proveedorcalifica.id')
                                    ->join('insumos','insumoscalificados.idinsumo','=','insumos.id')
                                    ->select('proveedorcalifica.*','insumoscalificados.idinsumo','proveedores.proveedor','insumos.Producto_o_Servicio')
                                    ->where('proveedorcalifica.idcompania','=',$compañiaid)
                                    ->where('proveedorcalifica.idproveedor','=',$request->proveedor)
                                    ->wherein('insumoscalificados.idinsumo',$array)//$insumoid)
                                    ->where('proveedorcalifica.proyecto_id','=',$request->proyecto)
                                    ->where('proveedorcalifica.idarea','=',$request->area)
                                    ->wherebetween('fechacalificacion', [$request->fech, $request->fecha2])
                                    ->orderby('fechacalificacion')
                                    ->get();
}

//return(dd($calificacion));

                                 return response()->json($calificacion);


    }


    public function showresultgeneral(Request $request)
    {
        //
        $usuarios = Auth::user();
        $compañiaid = $usuarios->id_compania;


        $calificacion = DB::table('proveedorcalifica')
                                 ->join('proveedores','proveedores.id','=','proveedorcalifica.idproveedor')
                                 ->join('insumoscalificados','insumoscalificados.idcalificacion','=','proveedorcalifica.id')
                                 ->select('proveedorcalifica.*','insumoscalificados.idinsumo')
                                 ->where('proveedorcalifica.idcompania','=',$compañiaid)
                                 ->where('proveedorcalifica.idproveedor','=',$provedorid)
                                 ->where('insumoscalificados.idinsumo','=',$insumoid)
                                 ->where('proveedorcalifica.idarea','=',$areaid)
                                 ->wherebetween('fechacalificacion', [$fech, $fecha2])
                                 ->get();


//return(dd($calificacion));

         $result[] = ['Fecha - pedido','Tiempo','Calidad','Servicio','Costo','Promedio'];
         foreach ($calificacion as $key => $value) {
             $time = (int)$value->tiempo;
             $quality = (int)$value->calidad;
             $service = (int)$value->servicio;
             $cost = (int)$value->costo;
             $avg = (( $time + $quality + $service +$cost)/4);
             $result[++$key] = [$value->fechacalificacion.' - '.(string)$value->pedido , (int)$value->tiempo, (int)$value->calidad, (int)$value->servicio, (int)$value->costo,$avg];
         }
                                 return response()->json($result);


    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function llenaareas($id,Request $request)
    {
      // obtiene las areas que han calificado al proveedor este query debe realizarse al elegir proveedor
      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;

      $area = DB::table('proveedorcalifica')
                               ->join('areas','areas.id','=','proveedorcalifica.idarea')
                               ->select('proveedorcalifica.idarea','areas.nombre')
                               ->distinct()
                               ->where('proveedorcalifica.idcompania','=',$compañiaid)
                               ->where('proveedorcalifica.idproveedor','=',$id)
                               ->get();

//      return(dd($area));
                                 return response()->json($area);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function llenaproyectos($id,Request $request)
    {
      // obtiene las areas que han calificado al proveedor este query debe realizarse al elegir proveedor
      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;

      $proyecto = DB::table('proveedorcalifica')
                               ->join('proyectos','proyectos.id','=','proveedorcalifica.proyecto_id')
                               ->select('proveedorcalifica.proyecto_id','proyectos.nombre')
                               ->distinct()
                               ->where('proveedorcalifica.idcompania','=',$compañiaid)
                               ->where('proveedorcalifica.idproveedor','=',$id)
                               ->get();

      //return(dd($));
                                 return response()->json($proyecto);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function llenainsumos($id,Request $request)
    {
      // obtiene los insumos que se han calificado al proveedor este query debe realizarse al elegir proveedor
      $usuarios = Auth::user();
      $compañiaid = $usuarios->id_compania;

      $insumo = DB::table('proveedores')
                               ->join('provedorinsumos','provedorinsumos.idproveedor','=','proveedores.id')
                               ->join('insumos','insumos.id','=','provedorinsumos.idinsumo')
                               ->select('provedorinsumos.idinsumo','insumos.Producto_o_Servicio')
                               ->distinct()
                               ->where('proveedores.id_compania','=',$compañiaid)
                               ->where('proveedores.id','=',$id)
                               ->get();

     //return(dd($insumo));
                               return response()->json($insumo);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ver($id)
    {

      $usuarios = Auth::user();


      $documento = DB::table('proveedorcalifica')
                               ->select('proveedorcalifica.*')
                               ->where('proveedorcalifica.id','=',$id)
                               ->first();

      $cadena = $documento->nombreunico;
      //return(dd($cadena));

      if (\Storage::disk('calificaproveedor')->exists($cadena)) {
        $response = Response::make(File::get("storage/uploadcalificaproveedor/".$documento->nombreunico));

        if(ends_with($cadena,'docx')){
          $response->header('Content-Type', "application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        }elseif (ends_with($cadena,'txt')) {
          $response->header('Content-Type', 'text/plain');
        }else{
          $content_types = File::mimeType("storage/uploadcalificaproveedor/".$documento->nombreunico);
          $response->header('Content-Type', $content_types);
        }
      }else {
          $response = "Archivo no encontrado";
      }

      // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)

      return $response;

      return redirect('/proveedores');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $procalifica = DB::table('proveedorcalifica')->where('id', $id)->get();
      if (count($procalifica) != 0)
      {
        if (\Storage::disk('calificaproveedor')->exists($procalifica[0]->nombreunico)) {
          \Storage::disk('calificaproveedor')->delete($procalifica[0]->nombreunico);
        }
      }
      $procalifica = DB::table('proveedorcalifica')->where('id', $id)->delete();

      return redirect('/proveedores');
    }
}
