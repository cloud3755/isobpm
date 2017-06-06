<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accioncorrectiva extends Model
{
  public $timestamps = false;
  protected $fillable = ['fechaalta','creador_id','producto','id_proceso','criterio','descripcion','responsable_id','porque1'.'porque2','accioncorrectiva'];
}
