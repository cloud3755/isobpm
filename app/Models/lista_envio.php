<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lista_envio extends Model
{

        public $timestamps = false;
        protected $fillable = ['id','id_usuario','id_proceso'];

}
