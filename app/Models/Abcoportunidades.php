<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abcoportunidades extends Model
{
  public $timestamps = false;
  protected $fillable = ['tipo_oportunidad_id','nombre','descripcion','id_compania'];

  public function abccompleto(){

  return $this->hasone('App\Models\Tipooportunidades','id','tipo_oportunidad_id');

  }

}
