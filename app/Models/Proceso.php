<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    public $timestamps = false;
    protected $fillable = ['id','tipo','proceso','descripcion','usuario_responsable','rev','detalle_de_rev','archivo_html','indicadores','lista_de_distribucion','nombreunicoarchivo','idcompañia'];

    public function procesocompleto(){

    return $this->hasone('App\Models\User','id','usuario_responsable_id');

    }

}
