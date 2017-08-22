<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class proveedorcalifica extends Model
{
     protected $fillable = ['id','idproveedor','pedido','tiempo','calidad','servicio','costo','idautor','idarea','idcompañia','archivo','nombreunico','size','fechacalificacion'];

}
