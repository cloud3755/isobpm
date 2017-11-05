<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\puestos;
use App\Models\descriptorpuesto;
use Carbon\Carbon;

class personalcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuarios = Auth::user();


        if ($usuarios->perfil != 4) {

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        $puestos = DB::table('puestos')
                                 ->select('id','parentId','nombrepuesto')
                                 ->where('puestos.id_compania','=',$compañiaid)
                                 ->get();

      return view('/Principales/personalinicio',compact('puestos'));

                               }

      else {
              return redirect('/bienvenida');
           }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showorganigrama()
    {
        //
       $usuarios = Auth::user();

       $compañiaid = $usuarios->id_compania;

       $iduser = $usuarios->id;

       $orga = DB::table('puestos')
                                ->select('id','parentId','nombrepuesto')
                                ->where('puestos.id_compania','=',$compañiaid)
                                ->get();

       return response()->json($orga);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function personaldescriptorpuesto($id)
    {
        //
         $usuarios = Auth::user();

         if ($usuarios->perfil != 4) {

         $compañiaid = $usuarios->id_compania;

         $iduser = $usuarios->id;


         $areas = DB::table('areas')
                                  ->select('areas.id','areas.nombre')
                                  ->where('areas.id_compania','=',$compañiaid)
                                  ->get();

         $descriptorpuesto = DB::table('descriptorpuesto')
                                  ->leftjoin('puestos','descriptorpuesto.id_puesto','=','puestos.id')
                                  ->leftjoin('puestos as reportaa','descriptorpuesto.reportaa','=','reportaa.id')
                                  ->leftjoin('areas','descriptorpuesto.id_area','=','areas.id')
                                  ->select('descriptorpuesto.*','puestos.nombrepuesto as nombrepuesto','reportaa.nombrepuesto as reportaa','areas.nombre as areanombre')
                                  ->where('descriptorpuesto.id_empresa','=',$compañiaid)
                                  ->where('descriptorpuesto.id_puesto','=',$id)
                                  ->first();

          $perfilpuesto = DB::table('perfilpuesto')
                                   ->join('puestos','perfilpuesto.id_puesto','=','puestos.id')
                                   ->select('*')
                                   ->where('perfilpuesto.id_compania','=',$compañiaid)
                                   ->where('perfilpuesto.id_puesto','=',$id)
                                   ->first();

           $puestoindicadores = DB::table('puestoindicadores')
                                    ->join('puestos','puestoindicadores.id_puesto','=','puestos.id')
                                    ->join('indicadores','puestoindicadores.id_indicadores','=','indicadores.id')
                                    ->select('puestoindicadores.id','indicadores.nombre','puestoindicadores.ponderacion')
                                    ->where('puestoindicadores.id_compania','=',$compañiaid)
                                    ->where('puestoindicadores.id_puesto','=',$id)
                                    ->get();


          $indicadorescompania = DB::table('indicadores')
                                           ->join('objetivos','indicadores.objetivo_id','=','objetivos.id')
                                           ->wherenotIn('indicadores.id',function ($query) use ($id) {
                                                                       $query->select('puestoindicadores.id_indicadores')->from('puestoindicadores')
                                                                             ->where('puestoindicadores.id_puesto','=',$id);
                                                                               })
                                           ->where('objetivos.id_compania','=',$compañiaid)
                                           ->select('indicadores.id','indicadores.nombre')
                                           ->get();

             $sumaponderado = DB::table('puestoindicadores')
                                      ->join('puestos','puestoindicadores.id_puesto','=','puestos.id')
                                      ->join('indicadores','puestoindicadores.id_indicadores','=','indicadores.id')
                                      ->where('puestoindicadores.id_compania','=',$compañiaid)
                                      ->where('puestoindicadores.id_puesto','=',$id)
                                      ->sum('ponderacion');


        return view('/Principales/personaldescriptorpuesto',compact('areas','descriptorpuesto','perfilpuesto','puestoindicadores','indicadorescompania','sumaponderado'));

                 }

      else {
              return redirect('/bienvenida');
           }


    }


    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editorganigrama($id, Request $request)
    {
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        $puestos = puestos::findorfail($id);
        $puestos->nombrepuesto = $request->input('txtName');
        $puestos->save();

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function insertorganigrama($id,Request $request)
    {
        //txtName

        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        $stringdesdencia = DB::table('puestos')
                            ->select('cadenadescendencia','nivel')
                            ->where('id_compania','=',$compañiaid)
                            ->where('id', $id)
                            ->first();

       $nuevonivel = intval($stringdesdencia->nivel) + 1;

       if ($stringdesdencia->cadenadescendencia == "")
       {
         $nuevacadena = $id;
       }
       else {
         $nuevacadena = $stringdesdencia->cadenadescendencia .','.$id;
       }


       $idd = DB::table('puestos')->insertGetId(
           [
            'parentid' => $id,
            'nombrepuesto' =>  $request->input('txtName'),
            'id_compania' => $compañiaid,
            'cadenadescendencia' => $nuevacadena,
            'nivel' => $nuevonivel,
            ]);

       $idd2 =  DB::table('descriptorpuesto')->insertGetId(
           [
            'id_puesto' => $idd,
            'id_empresa' =>  $compañiaid,
            'id_area' => "0",
            'personalacargo' =>"0",
            'reportaa' => $id,
            'montovalores' => "",
            'mision' => "",
            'funciones' => "",
            'responsabilidades' => "",
            'mision' => "",
            'funciones' => "",
            'responsabilidades' => "",
            'autoridades' => "",
            'capacitacion' => "",
            'herramientas' => "",
            'softwareactivos' => "",
            ]);


       $idd2 =  DB::table('perfilpuesto')->insertGetId(
           [
            'id_puesto' => $idd,
            'rangoedad' => "",
            'sexo' => "0",
            'otrosreq' => "",
            'conocimientos' => "",
            'educacion' => "",
            'formacion' => "",
            'habilidades' => "",
            'experiencias' => "",
            'id_compania' =>  $compañiaid,
            ]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteorganigrama($id)
    {

      $usuarios = Auth::user();

      $compañiaid = $usuarios->id_compania;

      $iduser = $usuarios->id;

      $cadenadesc = DB::table('puestos')
                          ->select('cadenadescendencia')
                          ->where('id_compania','=',$compañiaid)
                          ->where('id', $id)
                          ->first();

      $cadenadescreal = $cadenadesc->cadenadescendencia.','.$id;

      $largo = strlen($cadenadescreal);

      $descendencia =  puestos::select('*')->where('id_compania','=',$compañiaid)->where(DB::raw('substr(cadenadescendencia, 1,'.$largo.')'),$cadenadescreal)->delete();

      $puestos = DB::table('puestos')->where('id', $id)->delete();

      return response()->json("Registro Elminado");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function validadeleteorganigrama($id)
    {
        //
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        $orga = DB::table('puestos')
                                 ->select('id','parentId','nombrepuesto')
                                 ->where('puestos.id_compania','=',$compañiaid)
                                 ->where('id','=',$id)
                                 ->first();

        return response()->json($orga);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function personaldescriptoredit($id, Request $request)
    {
        //
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        DB::table('descriptorpuesto')
                    ->where('id_puesto', $id)
                    ->update([
                    'id_area' => $request->input('area'),
                    'personalacargo' => $request->input('personalACargo'),
                    'montovalores' => $request->input('monto'),
                    'mision' => $request->input('misionPuesto'),
                    'funciones' => $request->input('funcionPuesto'),
                    'responsabilidades' => $request->input('responsabilidadPuesto'),
                    'autoridades' => $request->input('autoridadesPuesto'),
                    'capacitacion' => $request->input('capacitacionPuesto'),
                    'herramientas' => $request->input('herramientasdetrabajo'),
                    'softwareactivos' => $request->input('softwareactivosinformacion'),
                  ]);

/*
        $descript = descriptorpuesto::findorfail($id);
        $descript->id_area = $request->input('area');
        $descript->personalacargo = $request->input('personalACargo');
        $descript->reportaa = $request->input('reportaA');
        $descript->montovalores = $request->input('monto');
        $descript->mision = $request->input('misionPuesto');
        $descript->funciones = $request->input('funcionPuesto');
        $descript->responsabilidades = $request->input('responsabilidadPuesto');
        $descript->autoridades = $request->input('autoridadesPuesto');
        $descript->capacitacion = $request->input('capacitacionPuesto');
        $descript->herramientas = $request->input('herramientasdetrabajo');
        $descript->softwareactivos = $request->input('softwareactivosinformacion');
        $descript->save();
*/
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function personalperfiledit($id, Request $request)
    {
        //
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        DB::table('perfilpuesto')
                    ->where('id_puesto', $id)
                    ->update([
                    'rangoedad' => $request->input('rangoedad'),
                    'sexo' => $request->input('sexo'),
                    'otrosreq' => $request->input('otrosRequisitos'),
                    'conocimientos' => $request->input('conocimientosgenerales'),
                    'educacion' => $request->input('educacion'),
                    'formacion' => $request->input('formacion'),
                    'habilidades' => $request->input('habilidades'),
                    'experiencias' => $request->input('experiencias'),
                  ]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function indicadorpersonaldestroy($id)
    {
        //
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;


        DB::table('puestoindicadores')
                    ->where('id', $id)
                    ->where('id_compania', $compañiaid)
                    ->delete();

       return response()->json("true");

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function indicadorpersonaltable($id)
    {
        //
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        $puestoindicadores = DB::table('puestoindicadores')
                                 ->join('puestos','puestoindicadores.id_puesto','=','puestos.id')
                                 ->join('indicadores','puestoindicadores.id_indicadores','=','indicadores.id')
                                 ->select('puestoindicadores.id','indicadores.nombre','puestoindicadores.ponderacion')
                                 ->where('puestoindicadores.id_compania','=',$compañiaid)
                                 ->where('puestoindicadores.id_puesto','=',$id)
                                 ->get();

       return response()->json($puestoindicadores);

    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function indicadorpersonalindicadores($id)
    {
        //
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        $indicadorescompania = DB::table('indicadores')
                                 ->join('objetivos','indicadores.objetivo_id','=','objetivos.id')
                                 ->wherenotIn('indicadores.id',function ($query) use ($id) {
                                                             $query->select('puestoindicadores.id_indicadores')->from('puestoindicadores')
                                                                   ->where('puestoindicadores.id_puesto','=',$id);
                                                                     })
                                 ->where('objetivos.id_compania','=',$compañiaid)
                                 ->select('indicadores.id','indicadores.nombre')
                                 ->get();

       return response()->json($indicadorescompania);


    }





/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function indicadorpersonalponderacion($id)
{
    //
    $usuarios = Auth::user();

    $compañiaid = $usuarios->id_compania;

    $iduser = $usuarios->id;

    $sumaponderado = DB::table('puestoindicadores')
                             ->join('puestos','puestoindicadores.id_puesto','=','puestos.id')
                             ->join('indicadores','puestoindicadores.id_indicadores','=','indicadores.id')
                             ->where('puestoindicadores.id_compania','=',$compañiaid)
                             ->where('puestoindicadores.id_puesto','=',$id)
                             ->sum('ponderacion');

   return response()->json($sumaponderado);


}



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function agregaindicadorperfil($idpuesto,$idindicador,$ponderador)
    {
        //
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

       DB::table('puestoindicadores')->insert(
            [
             'id_puesto' => $idpuesto,
             'id_indicadores' => $idindicador,
             'ponderacion' => $ponderador,
             'id_compania' => $compañiaid,
             ]);

       return response()->json("true");

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modificaindicadorpuesto($idpuestoindicador,$ponderador)
    {
        //
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

       DB::table('puestoindicadores')
                 ->where('id', $idpuestoindicador)
                 ->where('id_compania', $compañiaid)
                 ->update(
                   [
                   'ponderacion' => $ponderador,
                   ]);

       return response()->json("true");

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexview()
    {
        //
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        $puestos = DB::table('puestos')
                                 ->select('id','parentId','nombrepuesto')
                                 ->where('puestos.id_compania','=',$compañiaid)
                                 ->get();

      return view('/Principales/personalinicioview',compact('puestos'));


    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function personaldescriptorpuestoview($id)
    {
        //
         $usuarios = Auth::user();


         $compañiaid = $usuarios->id_compania;

         $iduser = $usuarios->id;


         $areas = DB::table('areas')
                                  ->select('areas.id','areas.nombre')
                                  ->where('areas.id_compania','=',$compañiaid)
                                  ->get();

         $descriptorpuesto = DB::table('descriptorpuesto')
                                  ->leftjoin('puestos','descriptorpuesto.id_puesto','=','puestos.id')
                                  ->leftjoin('puestos as reportaa','descriptorpuesto.reportaa','=','reportaa.id')
                                  ->leftjoin('areas','descriptorpuesto.id_area','=','areas.id')
                                  ->select('descriptorpuesto.*','puestos.nombrepuesto as nombrepuesto','reportaa.nombrepuesto as reportaa','areas.nombre as areanombre')
                                  ->where('descriptorpuesto.id_empresa','=',$compañiaid)
                                  ->where('descriptorpuesto.id_puesto','=',$id)
                                  ->first();

          $perfilpuesto = DB::table('perfilpuesto')
                                   ->join('puestos','perfilpuesto.id_puesto','=','puestos.id')
                                   ->select('*')
                                   ->where('perfilpuesto.id_compania','=',$compañiaid)
                                   ->where('perfilpuesto.id_puesto','=',$id)
                                   ->first();

           $puestoindicadores = DB::table('puestoindicadores')
                                    ->join('puestos','puestoindicadores.id_puesto','=','puestos.id')
                                    ->join('indicadores','puestoindicadores.id_indicadores','=','indicadores.id')
                                    ->select('puestoindicadores.id','indicadores.nombre','puestoindicadores.ponderacion')
                                    ->where('puestoindicadores.id_compania','=',$compañiaid)
                                    ->where('puestoindicadores.id_puesto','=',$id)
                                    ->get();


          $indicadorescompania = DB::table('indicadores')
                                           ->join('objetivos','indicadores.objetivo_id','=','objetivos.id')
                                           ->wherenotIn('indicadores.id',function ($query) use ($id) {
                                                                       $query->select('puestoindicadores.id_indicadores')->from('puestoindicadores')
                                                                             ->where('puestoindicadores.id_puesto','=',$id);
                                                                               })
                                           ->where('objetivos.id_compania','=',$compañiaid)
                                           ->select('indicadores.id','indicadores.nombre')
                                           ->get();


             $sumaponderado = DB::table('puestoindicadores')
                                      ->join('puestos','puestoindicadores.id_puesto','=','puestos.id')
                                      ->join('indicadores','puestoindicadores.id_indicadores','=','indicadores.id')
                                      ->where('puestoindicadores.id_compania','=',$compañiaid)
                                      ->where('puestoindicadores.id_puesto','=',$id)
                                      ->sum('ponderacion');


        return view('/Principales/personaldescriptorpuestoview',compact('areas','descriptorpuesto','perfilpuesto','puestoindicadores','indicadorescompania','sumaponderado'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function personalresults()
    {
        //
         $usuarios = Auth::user();


         $compañiaid = $usuarios->id_compania;

         $iduser = $usuarios->id;

         $users = DB::table('users')
                           ->select('id','nombre')
                           ->where('users.empresa','=',$compañiaid)
                           ->get();

/*
         $areas = DB::table('areas')
                                  ->select('areas.id','areas.nombre')
                                  ->where('areas.id_compania','=',$compañiaid)
                                  ->get();

         $descriptorpuesto = DB::table('descriptorpuesto')
                                  ->leftjoin('puestos','descriptorpuesto.id_puesto','=','puestos.id')
                                  ->leftjoin('puestos as reportaa','descriptorpuesto.reportaa','=','reportaa.id')
                                  ->leftjoin('areas','descriptorpuesto.id_area','=','areas.id')
                                  ->select('descriptorpuesto.*','puestos.nombrepuesto as nombrepuesto','reportaa.nombrepuesto as reportaa','areas.nombre as areanombre')
                                  ->where('descriptorpuesto.id_empresa','=',$compañiaid)
                                  ->where('descriptorpuesto.id_puesto','=',$id)
                                  ->first();

          $perfilpuesto = DB::table('perfilpuesto')
                                   ->join('puestos','perfilpuesto.id_puesto','=','puestos.id')
                                   ->select('*')
                                   ->where('perfilpuesto.id_compania','=',$compañiaid)
                                   ->where('perfilpuesto.id_puesto','=',$id)
                                   ->first();

           $puestoindicadores = DB::table('puestoindicadores')
                                    ->join('puestos','puestoindicadores.id_puesto','=','puestos.id')
                                    ->join('indicadores','puestoindicadores.id_indicadores','=','indicadores.id')
                                    ->select('puestoindicadores.id','indicadores.nombre','puestoindicadores.ponderacion')
                                    ->where('puestoindicadores.id_compania','=',$compañiaid)
                                    ->where('puestoindicadores.id_puesto','=',$id)
                                    ->get();


            $indicadorescompania = DB::table('indicadores')
                                     ->join('users','indicadores.creador_id','=','users.id')
                                     ->wherenotIn('indicadores.id',function ($query) use ($id) {
                                                                 $query->select('puestoindicadores.id_indicadores')->from('puestoindicadores')
                                                                       ->where('puestoindicadores.id_puesto','=',$id);
                                                                         })
                                     ->where('users.id_compania','=',$compañiaid)
                                     ->select('indicadores.id','indicadores.nombre')
                                     ->get();


             $sumaponderado = DB::table('puestoindicadores')
                                      ->join('puestos','puestoindicadores.id_puesto','=','puestos.id')
                                      ->join('indicadores','puestoindicadores.id_indicadores','=','indicadores.id')
                                      ->where('puestoindicadores.id_compania','=',$compañiaid)
                                      ->where('puestoindicadores.id_puesto','=',$id)
                                      ->sum('ponderacion');
*/

        return view('/Principales/personalresultado',compact('users'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function personalresultsfiltro(Request $request)
    {
        //
      $usuarios = Auth::user();

      $compañiaid = $usuarios->id_compania;

      $iduser = $usuarios->id;

      // $today = Carbon::now(-5)->subMonth();


      if(strlen($request->fech) <> 7)
      {
        return (dd([]));
      }

      if(strlen($request->fecha2) <> 7)
      {
        return (dd([]));
      }

      $inicio =   Carbon::createFromDate(substr ($request->fech, 0,4 ), substr ($request->fech, 5,2 ), 1)->startOfDay();
      $final = Carbon::createFromDate(substr ($request->fecha2, 0,4 ), substr ($request->fecha2, 5,2 ), 1)->endOfDay()->addmonth()->subday();



      if($inicio > $final)
      {
        return (dd([]));
      }

      else
      {
        //return(dd($final));

         $desempeño = DB::table('users')
                                  ->leftjoin('puestoindicadores','puestoindicadores.id_puesto','=','users.id_puesto')
                                  ->leftjoin('indicadores','puestoindicadores.id_indicadores','=','indicadores.id')
                                  ->leftjoin('resultados','resultados.indicador_id','=','indicadores.id')
                                  ->leftjoin('frecuencias','frecuencias.id','=','indicadores.frecuencia_id')
                                  ->leftjoin('unidades','unidades.id','=','indicadores.unidad')
                                  ->leftjoin('logicas','logicas.id','=','indicadores.logica')
                               //   ->select('indicadores.nombre as indicador','resultados.mes as periodo','puestoindicadores.ponderacion','logicas.simbolo as logica','indicadores.meta',DB::raw('AVG( resultados.valor )'))
                                  ->select('indicadores.nombre as indicador',DB::raw('substring( resultados.mes,1,7 ) as periodo'),'puestoindicadores.ponderacion','logicas.simbolo as logica','indicadores.meta',DB::raw('AVG( resultados.valor ) as resultado'))
                               //   ->select('*')
                                  ->where('users.id_compania','=',$compañiaid)
                                  ->where('users.id','=',$request->usuario)
                                  ->whereBetween('resultados.mes',[$inicio,$final])
                                  ->groupby('indicadores.nombre',DB::raw('substring( resultados.mes,1,7)'),'puestoindicadores.ponderacion','logicas.simbolo','indicadores.meta');
                               //   ->groupby('indicadores.nombre','resultados.mes','puestoindicadores.ponderacion','logicas.simbolo','indicadores.meta')

         //return (dd($desempeño));

        $other = DB::table( DB::raw("({$desempeño->toSql()}) as sub") )->select(
                                  //  'indicador',
                                  'periodo',
                                  //'ponderacion',
                                  //'logica',
                                  //'meta',
                                  //'resultado',
                                  DB::raw("sum(case when logica = '=' then case when resultado = meta then ponderacion else 0.00 end when logica = '<>' then case when resultado <> meta then ponderacion else 0.00 end when logica = '<' then case when resultado < meta then ponderacion else 0.00 end when logica = '>' then case when resultado > meta then ponderacion else 0.00 end when logica = '>=' then case when resultado >= meta then ponderacion else 0.00 end when logica = '<=' then case when resultado <= meta then ponderacion else 0.00 end end) as resultadofinal")
                                  )->mergeBindings($desempeño)
                                  ->groupby('periodo')
                                  ->orderby('periodo')
                                  ->get();

//return(dd($other));



//        return response()->json($desempeño);

       $result[] = ['Periodo','Resultado'];
       foreach ($other as $key => $value) {
          $result[++$key] = [$value->periodo , $value->resultadofinal];
      }

      return response()->json($result);
      }
      }






      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function personalresultsdetail()
      {
          //
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        $users = DB::table('users')
                          ->select('id','nombre')
                          ->where('users.empresa','=',$compañiaid)
                          ->get();


        $today = Carbon::now(-5);


        $inicio =  Carbon::now(-5)->startOfMonth()->todatestring();
        $final = Carbon::now(-5)->endOfMonth();

        $iniciostr = substr($inicio,0,7);
        $finalstr =  substr($final,0,7);

        $desempeño = DB::table('users')
                                 ->leftjoin('areas','users.id_area','=','areas.id')
                                 ->leftjoin('puestos','users.id_puesto','=','puestos.id')
                                 ->leftjoin('puestoindicadores','puestoindicadores.id_puesto','=','users.id_puesto')
                                 ->leftjoin('indicadores','puestoindicadores.id_indicadores','=','indicadores.id')
                                 ->leftjoin('resultados','resultados.indicador_id','=','indicadores.id')
                                 ->leftjoin('frecuencias','frecuencias.id','=','indicadores.frecuencia_id')
                                 ->leftjoin('unidades','unidades.id','=','indicadores.unidad')
                                 ->leftjoin('logicas','logicas.id','=','indicadores.logica')
                              //   ->select('indicadores.nombre as indicador','resultados.mes as periodo','puestoindicadores.ponderacion','logicas.simbolo as logica','indicadores.meta',DB::raw('AVG( resultados.valor )'))
                                 ->select('areas.nombre as area','puestos.nombrepuesto','users.nombre','indicadores.nombre as indicador',DB::raw('substring( resultados.mes,1,7 ) as periodo'),'puestoindicadores.ponderacion','logicas.simbolo as logica','indicadores.meta',DB::raw('AVG( resultados.valor ) as resultado'))
                              //   ->select('*')
                                 ->where('users.id_compania','=',$compañiaid)
                              //   ->where('users.id','=',$request->usuario)
                                 ->whereBetween('resultados.mes',[$inicio,$final])
                                 ->groupby('areas.nombre','puestos.nombrepuesto','users.nombre','indicadores.nombre',DB::raw('substring( resultados.mes,1,7)'),'puestoindicadores.ponderacion','logicas.simbolo','indicadores.meta');
                              //   ->groupby('indicadores.nombre','resultados.mes','puestoindicadores.ponderacion','logicas.simbolo','indicadores.meta')

    //    return (dd($desempeño));

       $other = DB::table( DB::raw("({$desempeño->toSql()}) as sub") )->select(
                                 'sub.*',

                                 DB::raw("(case when logica = '=' then case when resultado = meta then ponderacion else 0.00 end when logica = '<>' then case when resultado <> meta then ponderacion else 0.00 end when logica = '<' then case when resultado < meta then ponderacion else 0.00 end when logica = '>' then case when resultado > meta then ponderacion else 0.00 end when logica = '>=' then case when resultado >= meta then ponderacion else 0.00 end when logica = '<=' then case when resultado <= meta then ponderacion else 0.00 end end) as obtenido")
                                 )->mergeBindings($desempeño)
                              //   ->groupby('periodo')
                              ->orderby('nombre')
                              ->orderby('periodo')
                              ->orderby('area')
                              ->orderby('nombrepuesto')
                              ->orderby('indicador')
                                 ->get();

// return (dd($other));

        return view('/Principales/personalresultadodetail',compact('other','iniciostr','finalstr','users'));
        }



        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function personalresultsdetailfiltro(Request $request)
        {
            //
    //      return(dd($request));
          $usuarios = Auth::user();

          $compañiaid = $usuarios->id_compania;

          $iduser = $usuarios->id;

          $users = DB::table('users')
                            ->select('id','nombre')
                            ->where('users.empresa','=',$compañiaid)
                            ->get();



          if(strlen($request->fech) <> 7)
          {
            return (dd([]));
          }

          if(strlen($request->fecha2) <> 7)
          {
            return (dd([]));
          }



          $inicio =   Carbon::createFromDate(substr ($request->fech, 0,4 ), substr ($request->fech, 5,2 ), 1)->startOfDay();
          $final = Carbon::createFromDate(substr ($request->fecha2, 0,4 ), substr ($request->fecha2, 5,2 ), 1)->endOfDay()->addmonth()->subday();


          if($inicio > $final)
          {
            return (dd([]));
          }

          else
          {


          $desempeño = DB::table('users')
                                   ->leftjoin('areas','users.id_area','=','areas.id')
                                   ->leftjoin('puestos','users.id_puesto','=','puestos.id')
                                   ->leftjoin('puestoindicadores','puestoindicadores.id_puesto','=','users.id_puesto')
                                   ->leftjoin('indicadores','puestoindicadores.id_indicadores','=','indicadores.id')
                                   ->leftjoin('resultados','resultados.indicador_id','=','indicadores.id')
                                   ->leftjoin('frecuencias','frecuencias.id','=','indicadores.frecuencia_id')
                                   ->leftjoin('unidades','unidades.id','=','indicadores.unidad')
                                   ->leftjoin('logicas','logicas.id','=','indicadores.logica')
                                //   ->select('indicadores.nombre as indicador','resultados.mes as periodo','puestoindicadores.ponderacion','logicas.simbolo as logica','indicadores.meta',DB::raw('AVG( resultados.valor )'))
                                   ->select('areas.nombre as area','puestos.nombrepuesto','users.nombre','indicadores.nombre as indicador',DB::raw('substring( resultados.mes,1,7 ) as periodo'),'puestoindicadores.ponderacion','logicas.simbolo as logica','indicadores.meta',DB::raw('AVG( resultados.valor ) as resultado'))
                                //   ->select('*')
                                   ->where('users.id_compania','=',$compañiaid)
                                //   ->where('users.id','=',$request->usuario)
                                   ->whereBetween('resultados.mes',[$inicio,$final])
                                   ->groupby('areas.nombre','puestos.nombrepuesto','users.nombre','indicadores.nombre',DB::raw('substring( resultados.mes,1,7)'),'puestoindicadores.ponderacion','logicas.simbolo','indicadores.meta');
                                //   ->groupby('indicadores.nombre','resultados.mes','puestoindicadores.ponderacion','logicas.simbolo','indicadores.meta')

      //    return (dd($desempeño));

         $other = DB::table( DB::raw("({$desempeño->toSql()}) as sub") )->select(
                                   'sub.*',

                                   DB::raw("(case when logica = '=' then case when resultado = meta then ponderacion else 0.00 end when logica = '<>' then case when resultado <> meta then ponderacion else 0.00 end when logica = '<' then case when resultado < meta then ponderacion else 0.00 end when logica = '>' then case when resultado > meta then ponderacion else 0.00 end when logica = '>=' then case when resultado >= meta then ponderacion else 0.00 end when logica = '<=' then case when resultado <= meta then ponderacion else 0.00 end end) as obtenido")
                                   )->mergeBindings($desempeño)
                                //   ->groupby('periodo')
                                   ->orderby('nombre')
                                   ->orderby('periodo')
                                   ->orderby('area')
                                   ->orderby('nombrepuesto')
                                   ->orderby('indicador')
                                   ->get();

    // return (dd($other));

            return response()->json($other);
          }
       }


}
