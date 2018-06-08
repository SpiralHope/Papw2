<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    //
    use softDeletes;

    public function producto(){
    	return $this->belongsTo('App\Producto', 'id_producto', 'id');
    }

    public function usuario(){
    	return $this->belongsTo('App\User', 'id_usuario', 'id');
    }
}
