<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class procesostmps extends Model
{
  public $timestamps = false;
  protected $fillable = ['id','tipo','proceso','descripcion','usuario_responsable','rev','detalle_de_rev','archivo_html','indicadores','puestos','insumos','documento','activo','lista_de_distribucion','nombreunicoarchivo','idcompañia','creador_id','Takt','Yield','RTY','DPMO','Sigma','Persona','Maquina','dinero','SLA1','SLA2','SLA3','Mes','tipoarchivo','demandamen','diasmes','turnosdia','turnoshora','horades','Tiemposeg','Tiempomin','taktseg','status'];

  public function procesocompleto(){

  return $this->hasone('App\Models\User','id','usuario_responsable_id');

  }
}
