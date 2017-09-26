<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\puestos;
use App\Models\descriptorpuesto;

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

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        $puestos = DB::table('puestos')
                                 ->select('id','parentId','nombrepuesto')
                                 ->where('puestos.id_compania','=',$compañiaid)
                                 ->get();


      return view('\Principales\personalinicio',compact('puestos'));


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
                                    ->select('*')
                                    ->where('puestoindicadores.id_compania','=',$compañiaid)
                                    ->where('puestoindicadores.id_puesto','=',$id)
                                    ->get();

//return(dd($perfilpuesto));
        return view('\Principales\personaldescriptorpuesto',compact('areas','descriptorpuesto','perfilpuesto','puestoindicadores'));
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





}
