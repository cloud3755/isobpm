<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abcriesgos extends Model
{
    public $timestamps = false;
    protected $fillable = ['tipo_riesgo_id','nombre','descripcion','id_compania'];

    public function abccompleto(){

    return $this->hasone('App\Models\Tiporiesgos','id','tipo_riesgo_id');

    }


}
