<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MenuinfController extends Controller
{
  // Funciones principales
  public function infdocumentos()
  {

    return View('submenu/informacion/documentos');
  }

  public function infestrategia()
  {

    return View('submenu/informacion/estrategias');
  }

  public function infprocesos()
  {

    return View('submenu/informacion/procesos');
  }

  public function infriesgos()
  {

    return View('submenu/informacion/riesgos');
  }

  public function infrecursos()
  {

    return View('submenu/informacion/recursos');
  }

  public function infoperacion()
  {

    return View('submenu/informacion/operaciones');
  }

  public function operacioninf()
  {

    return View('submenu/informacion/menusextras/operacion');
  }

  public function infevaluacion()
  {

    return View('submenu/informacion/evaluaciones');
  }

  public function infmejora()
  {

    return View('submenu/informacion/mejoras');
  }


  //sub menus de Recursos
  public function recpersonal()
  {

    return View('submenu/informacion/menusextras/personal');
  }

  public function recinfraestructura()
  {

    return View('submenu/informacion/menusextras/infraestructura');
  }

  public function recmedicion()
  {

    return View('submenu/informacion/menusextras/medicion');
  }

  //sub menus de Evaluacion
  public function evacontrol()
  {

    return View('submenu/informacion/menusextras/planes');
  }
  public function evaincidentes()
  {

    return View('submenu/informacion/menusextras/incidentes');
  }
  public function evainternas()
  {

    return View('submenu/informacion/menusextras/auditorias');
  }

}
