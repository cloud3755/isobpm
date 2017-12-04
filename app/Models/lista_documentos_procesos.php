<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lista_documentos_procesos extends Model
{
  public $timestamps = false;
  protected $fillable = ['id','id_documento','id_proceso'];
}
