<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Productos;
use App\Models\Clientes;
use App\Models\User;
use App\Models\Areas;
use App\Models\Empresas;
use App\Models\Status;
use App\Models\Plans;
use App\Models\Documentos;
use App\Models\Documentoseliminados;
use App\Models\Noticias;
use App\Models\Pendientes;
use App\Models\lista_eventos;
use App\Models\EventModel;
use App\Models\lista_noticias;
use App\Models\LinksInteres;
use App\Models\puestos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class AdministradosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //  $Users = Auth::user();

      //$usuario = \Illuminate\Support\Collection::make(DB::table('users')
    //  ->join('areas','areas.id','=','users.id_area')
    //  ->select('users.*','areas.nombre as area')
    //  ->where('users.id',3)
    //  ->get());

    $Users = Auth::user();

    $compañiaid = $Users->id_compania;

    $usuario = DB::table('users')
    ->leftjoin('areas','areas.id','=','users.id_area')
    ->select('users.*','areas.nombre as area')
    ->where('users.id_compania',$Users->id_compania)
    ->where('perfil','!=','1')
    ->get();

    $archivos = DB::table('userfiles')
    ->where('id_compania','=',$compañiaid)
    ->where('id_user','=',$Users->id)
    ->get();


      return view('/Principales/perfil',compact('Users','usuario','archivos'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function documentos()
    {
      $usuarios = Auth::user();
      if ($usuarios->perfil != 4) {
        $documentos = new Documentos;
        $documento = $documentos->where('id_compania',$usuarios->id_compania)->where('status','!=',1)->get();

        return view('/Principales/admindoc', compact('documento'));
      }else {
        return redirect('bienvenida');
      }
    }


    public function doceliminados()
    {
      $usuarios = Auth::user();
      if ($usuarios->perfil != 4) {
        $documento = $mejorasid = \DB::table('documentoseliminados')
                     ->leftjoin('users','documentoseliminados.id_user','=','users.id')
                     ->select('documentoseliminados.*', 'users.nombre as responsable')
                     ->where('documentoseliminados.id_compania',$usuarios->id_compania)
                     ->get();

        return view('/Principales/doceliminados', compact('documento'));
      }else {
        return redirect('bienvenida');
      }
    }



    //Funciones para los Productos y servicios
    public function productos()
    {
      $Users = Auth::user();
      $productos = new Productos;
      $producto = $productos->where('idcompañia',$Users->id_compania)->get();


      return view('/Principales/productos', compact('producto'));
    }


    public function productostore(Request $request)
    {
      $usuarios = Auth::user();
      $productos = new Productos;

      $productos->codigo = $request->input('codigo');
      $productos->nombre = $request->input('nombre');
      $productos->descripcion = $request->input('descripcion');
      $productos->idcompañia =  $usuarios->id_compania;

      $productos->save();

      return redirect('/productos');
    }

    public function productosdestroy($id)
    {
      $productos = Productos::findorfail($id);
      $productos-> delete();
      return Redirect('/productos');
    }

    public function productosedit($id,Request $request)
    {
      $productos = Productos::findorfail($id);

      $productos->codigo = $request->input('codigo');
      $productos->nombre = $request->input('nombre');
      $productos->descripcion = $request->input('descripcion');

      $productos->save();

      return Redirect('/productos');


    }


      //Funciones para los clientes

      public function clientes()
      {
        $Users = Auth::user();

        $clientes = new Clientes;
        $cliente = $clientes->where('id_compania',$Users->id_compania)->get();


        return view('/Principales/clientes', compact('cliente'));
      }


      public function clientestore(Request $request)
      {
        $usuarios = Auth::user();
        $clientes = new Clientes;

        $clientes->nombre = $request->input('nombre');
        $clientes->correo = $request->input('correo');
        $clientes->telefono = $request->input('telefono');
        $clientes->direccion = $request->input('direccion');
        $clientes->id_compania =  $usuarios->id_compania;
        $clientes->save();

        return redirect('/clientes');
      }

      public function clientesdestroy($id)
      {
        $clientes = Clientes::findorfail($id);
        $clientes-> delete();
        return Redirect('/clientes');
      }

      public function clientesedit($id,Request $request)
      {
        $clientes = Clientes::findorfail($id);

        $clientes->nombre = $request->input('nombre');
        $clientes->correo = $request->input('correo');
        $clientes->telefono = $request->input('telefono');
        $clientes->direccion = $request->input('direccion');

        $clientes->save();

        return redirect('/clientes');


      }

      //Funciones para las Areas

      public function areas()
      {
        $Users = Auth::user();

        $areas = new Areas;
        $area = $areas->where('id_compania',$Users->id_compania)->get();
        return view('/Principales/areas', compact('area'));
      }

      public function areastore(Request $request)
      {
        $usuarios = Auth::user();
        $areas = new Areas;
        $areas->nombre = $request->input('nombre');
        $areas->id_compania = $usuarios->id_compania;
        $areas->save();
        return redirect('/areas');
      }

      public function areasdestroy($id)
      {
        $areas = Areas::findorfail($id);
        $areas-> delete();
        return Redirect('/areas');
      }

      public function areasedit($id,Request $request)
      {
        $areas = Areas::findorfail($id);
        $areas->nombre = $request->input('nombre');
        $areas->save();
        return redirect('/areas');
      }

      //Funciones para las Empresas
      public function empresas()
      {
        $user = Auth::user();
        if($user->perfil == 1){
          $empresas = new Empresas;
          $empresa = $empresas->all();
        }else {
          $empresas = new Empresas;
          $empresa = $empresas->where('id_creador',$user->id)->get();
        }
        $status = new Status;
        $statuses = $status->all();
        $plans = new Plans;
        $plan = $plans->all();
        return view('/Principales/empresas', compact('empresa','statuses','plan'));
      }
      //protected $fillable = ['id_plan','razonSocial','domicilio','correo','telefono','rubro','uso','codigo','fecha','status_id','cuota_usada','img'];
      public function empresastore(Request $request)
      {
        $date = Carbon::now();
        $user = Auth::user();


        $idd = DB::table('empresas')->insertGetId(
            ['id_plan' => $request->input('id_plan'),
             'razonSocial' => $request->input('razonSocial'),
             'domicilio' => $request->input('domicilio'),
             'correo' => $request->input('correo'),
             'telefono' => $request->input('telefono'),
             'rubro' => $request->input('rubro'),
             'uso' => $request->input('uso'),
             'codigo' => 'Campo unico',
             'fecha' => $date->toDateTimeString(),
             'status_id' => $request->input('status_id'),
             'cuota_usada' => '1',
             'img' => $request->input('img'),
             'id_creador' => $user->id,
             ]);


        $puestos = new puestos;
        $puestos->nombrepuesto = $request->input('razonSocial');
        $puestos->id_compania = $idd;
        $puestos->cadenadescendencia = "";
        $puestos->nivel = 0;
        $puestos->save();

        return redirect('/empresas');
      }

      public function empresasdestroy($id)
      {
        $empresas = Empresas::findorfail($id);
        $empresas-> delete();

       DB::table('puestos')->where('id_compania', '=', $id)->delete();

        return Redirect('/empresas');
      }

      public function empresasedit($id,Request $request)
      {
        $date = Carbon::now();
        $empresas = Empresas::findorfail($id);
        $empresas->id_plan = $request->input('id_plan');
        $empresas->razonSocial = $request->input('razonSocial');
        $empresas->domicilio = $request->input('domicilio');
        $empresas->correo = $request->input('correo');
        $empresas->telefono = $request->input('telefono');
        $empresas->rubro = $request->input('rubro');
        $empresas->uso = $request->input('uso');
        $empresas->codigo = 'Campo unico';
        $empresas->fecha = $date->toDateTimeString();
        $empresas->status_id = $request->input('status_id');
        $empresas->cuota_usada = '1';
        $empresas->img = $request->input('img');
        $empresas->save();

        return redirect('/empresas');
      }



      //Funciones para las Usuarios
      public function usuarios()
      {
        $Users = Auth::user();

        $usuario = DB::table('users')
        ->leftjoin('areas','areas.id','=','users.id_area')
        ->select('users.*','areas.nombre as area')
        ->where('users.id_compania',$Users->id_compania)
        ->where('perfil','!=','1')
        ->get();

        $empresas = new Empresas;
        $empresa = $empresas->get();
        $status = new Status;
        $statuses = $status->all();
        $areas = new Areas;
        $area = $areas->where('id_compania',$Users->id_compania)->get();

        $puestos = DB::table('puestos')
                            ->where('id_compania',$Users->id_compania)
                            ->get();


        return view('/Principales/usuarios', compact('usuario','empresa','statuses','area','puestos'));
      }
      //protected $fillable = ['id_plan','razonSocial','domicilio','correo','telefono','rubro','uso','codigo','fecha','status_id','cuota_usada','img'];
      public function usuariostore(Request $request)
      {

        $user = Auth::user();
        $usuarios = new User;

        $empresa = new Empresas;

        if($user->perfil == 1){
          $empresas = $empresa->where('id',$request->input('id_compania'))->first();
          $usuarios->id_compania = $request->input('id_compania');
          $usuarios->empresa = $empresas->razonSocial;
        }else{
          $empresas = $empresa->where('id', $user->id_compania)->first();
          $usuarios->id_compania = $user->id_compania;
          $usuarios->empresa = $empresas->razonSocial;
        }
        //No se para que este campo
        $usuarios->usuario = $request->input('email');
        //Campos normales
        $usuarios->password = bcrypt($request->input('password'));
        $usuarios->nombre = $request->input('nombre');
        $usuarios->perfil = $request->input('perfil');
        $usuarios->email = $request->input('email');
        $usuarios->telefono = $request->input('telefono');
        $usuarios->status = $request->input('status');
        //No se como se llenan estos
        $usuarios->quota = 0;
        $usuarios->num_com = 1;
        //Nunca se llenan
        $usuarios->direccion = '';
        $usuarios->descripcion = '';
        $usuarios->id_area = $request->input('id_area');
        $usuarios->id_puesto = $request->input('puestoalta');
        $usuarios->id_jefe = $request->input('id_jefe');
        //Falta agregar el area
        $usuarios->save();
        return redirect('/usuarios');
      }

      public function usuariosdestroy($id)
      {
        $usuarios = User::findorfail($id);
        $usuarios-> delete();
        return Redirect('/usuarios');
      }

      public function usuarioseditM($id){
        $Usuarios = User::find($id);
          return response()->json(
            $Usuarios->toArray()
          );
      }

      public function usuariosedit($id,Request $request)
      {
        $user = Auth::user();
        $usuarios = User::findorfail($id);

        $empresa = new Empresas;

        if($user->perfil == 1){
          $empresas = $empresa->where('id',$request->input('eid_compania'))->first();
          $usuarios->id_compania = $request->input('eid_compania');
          $usuarios->empresa = $empresas->razonSocial;
        }else{
          $empresas = $empresa->where('id', $user->id_compania)->first();
          $usuarios->id_compania = $user->id_compania;
          $usuarios->empresa = $empresas->razonSocial;
        }
        //No se para que este campo
        $usuarios->usuario = $request->input('eemail');
        //Campos normales
        if ($request->input('epassword') != null) {
          $usuarios->password = bcrypt($request->input('epassword'));
        }


        $usuarios->nombre = $request->input('enombre');
        $usuarios->perfil = $request->input('eperfil');
        $usuarios->email = $request->input('eemail');
        $usuarios->telefono = $request->input('etelefono');
        $usuarios->status = $request->input('estatus');
        //No se como se llenan estos
        $usuarios->quota = 0;
        $usuarios->num_com = 1;
        //Nunca se llenan
        $usuarios->direccion = '';
        $usuarios->descripcion = '';
        $usuarios->id_area = $request->input('id_area2');
        $usuarios->id_puesto = $request->input('puestoedit');
        
        $usuarios->save();
        return redirect('/usuarios');
      }


      public function usuariospuestos($idarea)
      {
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        $puestos = DB::table('puestos')
                                 ->leftjoin('descriptorpuesto','puestos.id','=','descriptorpuesto.id_puesto')
                                 ->select('puestos.id','puestos.nombrepuesto')
                                 ->where('puestos.id_compania','=',$compañiaid)
                                 ->where('descriptorpuesto.id_area','=',$idarea)
                                 ->get();

        return response()->json($puestos);
      }

      public function jefesmostrar($idpuesto)
      {
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        $jefes1 = DB::table('puestos')
                                 ->select('puestos.parentId')
                                 ->where('puestos.id_compania','=',$compañiaid)
                                 ->where('puestos.id','=',$idpuesto)
                                 ->first();

         $jefes = DB::table('users')
                                  ->select('users.id','users.nombre')
                                  ->where('users.id_compania','=',$compañiaid)
                                  ->where('users.id_puesto','=',$jefes1->parentId)
                                  ->get();


        return response()->json($jefes);
      }

      public function usuariospuestosjefes($idpuesto)
      {
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;

        $jefes1 = DB::table('puestos')
                                 ->select('puestos.parentId')
                                 ->where('puestos.id_compania','=',$compañiaid)
                                 ->where('puestos.id','=',$idpuesto)
                                 ->first();

         $jefes = DB::table('users')
                                  ->select('users.id','users.nombre')
                                  ->where('users.id_compania','=',$compañiaid)
                                  ->where('users.id_puesto','=',$jefes1->parentId)
                                  ->get();


        return response()->json($jefes);
      }





      public function usuariosdesempeno($id,$periodo)
      {
        $usuarios = Auth::user();

        $compañiaid = $usuarios->id_compania;

        $iduser = $usuarios->id;


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
                                 ->where('users.id','=',$id)
                                 ->where(DB::raw('substring( resultados.mes,1,7 )'),'=',$periodo)
                                 ->groupby('indicadores.nombre',DB::raw('substring( resultados.mes,1,7)'),'puestoindicadores.ponderacion','logicas.simbolo','indicadores.meta')
                              //   ->groupby('indicadores.nombre','resultados.mes','puestoindicadores.ponderacion','logicas.simbolo','indicadores.meta')
                                 ->get('resultados.valor');


        return response()->json($desempeño);
      }



      //functiones para las noticias
      public function noticiastore(Request $request)
      {
      //dd($request->input('listaAreasSeleccionadas'));
       $user = Auth::user();
       $noticia = new Noticias;
       $date = date("Y-m-d");
       $empresa = new Empresas;
        if($user->perfil != 4){
          $noticia->id_empresa = $user->id_compania;
          $noticia->id_UsuarioCreo = $user->id;
          $noticia->fecha_creacion=$date;
          $noticia->titulo = $request->input('titulonoticia');
          $noticia->Noticia = $request->input('descripcionNoticia');
          $noticia->fecha_hasta = $request->input('fecha_hasta');
          $acces=$request->input('nlistaAreasSeleccionadas');
          $noticia->save();

          for ($i=0;$i<count($acces);$i++)
          {
          $acce = new lista_noticias;
          $acce ->id_area = $acces[$i];
          $acce ->id_noticia = $noticia->id;
          $acce ->save();
          }
          return Redirect('/bienvenida');
        }else{
          return Redirect('/');
        }
      }

      public function noticiadelete($id, Request $request)
      {
        $noticia = Noticias::findorfail($id);
        $listnoticia = DB::table('lista_noticias')->where('id_noticia', $id)->delete();
        $noticia-> delete();
        return Redirect('/bienvenida');
      }

      public function eventodelete($id, Request $request)
      {
        $evento = EventModel::findorfail($id);
        $listeven = DB::table('lista_eventos')->where('id_evento', $id)->delete();
        $evento-> delete();
        return Redirect('/bienvenida');
      }

      public function editM($id){
        $noticia = Noticias::find($id);
          return response()->json(
            $noticia->toArray()
          );
      }

      public function pendienteStore(Request $request)
      {
       $user = Auth::user();
       $pendiente = new Pendientes;
       $date = date("Y-m-d");

        if($user->perfil != 4){
          $pendiente->id_UsuarioCreo = $user->id;
          $pendiente->id_UsuarioAsignado = $request->input('id_UsuarioAsignado');
          $pendiente->terminado = false;
          $pendiente->pendiente = $request->input('Pendiente');
          $pendiente->fecha_creacion=$date;
          $pendiente->fecha_limite=$request->input('fechalimite');
          $pendiente->save();
          return Redirect('/bienvenida');
        }else{
          return Redirect('/bienvenida');
        }
      }
      public function LinkStore(Request $request)
      {
       $user = Auth::user();
       $Link= new LinksInteres;
        if($user->perfil != 4){

          $Link->id_UsuarioCreo = $user->id;
          $Link->id_empresa = $user->id_compania;
          $Link->Nombrecorto = $request->input('NombreCorto');
          $Link->URL = $request->input('Url');
          $Link->save();
          return Redirect('/bienvenida');
        }else{
          return Redirect('/bienvenida');
        }
      }

      //funcion guardar imagen de user

      public function imageUserStore(Request $request)
      {
        $user = Auth::user();
        $file1                            = $request->file('imagen');
        $extension1                       = strtolower($file1->getclientoriginalextension());
        $nombreunicoarchivo1              = uniqid().'.'.$extension1;
        $user->nombreimagen               = $file1->getClientOriginalName();
        $user->nombreunicoimagen          = $nombreunicoarchivo1;
        $user->save();
        //Cambiar tamanio de la imagen para ahorrar espacio
        $imagen = Image::make($file1->getRealPath())->resize(80,80)->save($nombreunicoarchivo1);
        //Guardad imagen
       \Storage::disk('imagenesusuarios')->put($nombreunicoarchivo1,  $imagen);
       return Redirect('/perfil');
      }

      public function fileUserStore1(Request $request)
      {
        $usuarios = Auth::user();
        $compañiaid = $usuarios->id_compania;

        $filet = $request->file('fileusr');

        if (count($filet[0]) == 0)
        {
          Session::flash('flash_message', 'No se envio ningun archivo');
          return redirect('/perfil');

        }
        else {
          // alta de archivos

               foreach($request->file('fileusr') as $file1)
               {

             //   $file1                            = $request->file('archivo');
                $extension1                       = strtolower($file1->getclientoriginalextension());
                $nombreunicoarchivo1              = uniqid().'.'.$extension1;
                $bytes                            = \File::size($file1);

                DB::table('userfiles')->insert(
                    ['nombre' =>  $file1->getClientOriginalName(),
                     'archivo' =>  $file1->getClientOriginalName(),
                     'nombreunico' => $nombreunicoarchivo1,
                     'size' =>  $bytes,
                     'id_user' => $usuarios->id,
                     'id_compania' => $compañiaid,
                     ]);


                \Storage::disk('userfile')->put($nombreunicoarchivo1,  \File::get($file1));
                }
        }

   Session::flash('flash_message', 'Se guardaronlos archivos');
       return Redirect('/perfil');
      }


      public function perfildestroy($id)
      {

      $fileperfil = DB::table('userfiles')->where('id', '=', $id)->first();


      $archivoborrar = $fileperfil->nombreunico;
      if($archivoborrar!='No se cargo archivo'){
        \Storage::disk('userfile')->delete($archivoborrar);
             }

      DB::table('userfiles')->where('id', '=', $id)->delete();

      Session::flash('flash_message', 'Se elimino el archivo');

      return Redirect('/perfil');

      }


      public function perfilverfile($id)
      {


      $usuarios = Auth::user();
      $documento = DB::table('userfiles')->where('id', '=', $id)->first();

      $cadena = $documento->nombreunico;
      if (\Storage::disk('userfile')->exists($cadena)) {
        $response = Response::make(File::get("storage/userfile/".$documento->nombreunico));

        if(ends_with($cadena,'docx')){
          $response->header('Content-Type', "application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        }elseif (ends_with($cadena,'txt')) {
          $response->header('Content-Type', 'text/plain');
        }else{
          $content_types = File::mimeType("storage/userfile/".$documento->nombreunico);
          $response->header('Content-Type', $content_types);
        }
      }else {
          $response = "Archivo no encontrado";
      }

      // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)

      return $response;

//      return Redirect('/perfil');

      }


}
