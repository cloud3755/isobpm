<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class provedorinsumo extends Model
{
    //  protected $fillable = ['id','idinsumo','idproveedor','id_compania'];

      public function insumos()
      {

          return $this->belongsto('App\Models\insumos','idinsumo');
      }

}
