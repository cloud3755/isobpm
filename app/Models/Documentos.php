<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
  protected $fillable = ['id_tipo','nombre','archivo','nombreunico','size','descripcion','id_user','id_compania','review','status','accesos'];

}
