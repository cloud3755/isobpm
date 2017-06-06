<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
  public $timestamps = false;
  protected $fillable = ['id_accioncorrectiva','id_responsable'.'accionarealizar','descripcion','archivo_html1','archivo_html2','nombreunicoarchivo1','nombreunicoarchivo2'];
}
