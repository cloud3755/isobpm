<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lista_acceso extends Model
{
  public $timestamps = false;
  protected $fillable = ['id','id_usuario','id_indicador'];
}
